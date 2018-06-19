<?php require_once __DIR__ . '/../Configuration.php';

require_once 'Role.php';
require_once 'Installation.php';

class User {

    private static $all = null;
    /**
     * Return all Users
     * @return User[]
     */
    public static function getAll() {
        if (self::$all == null) {
            self::$all = [];
            $sth = Configuration::DB()->query("SELECT _id FROM tblUser;");
            while ($d = $sth->fetch())
                self::$all[] = new User($d["_id"]);
        }
        return self::$all;
    }

    /**
     * Return all the users whose the role is client
     * @return User[]
     */
    public static function getAllClient() {
        $users = [];
        foreach (self::getAll() as $user)
            if ($user->getRole() == Role::getAll()["client"])
                $users[] = $user;
        return $users;
    }

    /**
     * Return all the users who has a gateway
     * @return User[]
     */
    public static function getAllLinked() {
        $users = [];
        foreach (self::getAll() as $user) {
            if (isset($user->getInstallations()[0])
                && $user->getInstallations()[0]->getGateway()->getStatus() == Status::getAll()[1])
                    $users[] = $user;
        }
        return $users;
    }

    /**
     * Test if a user exists by username, token
     * @param string $search
     * @return bool
     */
    public static function exists(string $search) {
        $users = self::getAll();
        foreach ($users as $user)
            if ($user->getUsername() == $search || $user->getToken() == $search)
                return true;
        return false;
    }

    /**
     * Return a user by his token
     * @param string $token
     * @return User|false
     */
    public static function getByToken(string $token) {
        foreach (self::getAll() as $user)
            if ($user->getToken() == $token)
                return $user;
        return false;
    }

    public static function getByEmail(string $email) {
        foreach (self::getAll() as $user)
            if ($user->getEMail() == $email)
                return $user;
        return false;
    }

    /**
     * Test login username and password
     * @param string $user
     * @param string $pass
     * @return User|false
     */
    public static function login(string $user, string $pass) {
        $u = Configuration::DB()->execute("SELECT _id, password FROM tblUser WHERE username = :user;", [":user" => $user]);
        if (empty($u)) return false;
        return password_verify("Go" . $pass . "Flex", $u[0]["password"]) ? new User($u[0]["_id"], $pass) : false; // Improve if user is disable (error msg?)
    }

    /**
     * @param array $params
     * @return int|false
     * @throws Exception
     */
    static public function create(array $params) {
        if (!isset($params["email"]) || !isset($params["username"]))
            return false;
        $user = $params["username"];
        if (!isset($params["role"]))
            $params["role"] = 4;
        $params["password"] = md5(random_bytes(25)); // temporar Password
        $params["token"] = bin2hex(random_bytes(50 - strlen($user)) . $user);

        $ok = is_array(Configuration::DB()->execute("INSERT INTO tblUser (firstname, lastname, phone, username, password, email, token, user_role) VALUES (:firstname, :lastname, :phone, :username, :password, :email, :token, :role);", $params));

        return $ok ? Configuration::DB()->lastInsertId() : false;
    }

    private $_id = -1;
    private $username = "no_" . __CLASS__;
    private $password = "";
    private $role = -1;
    private $firstname = "";
    private $lastname = "";
    private $phone = "";
    private $email = "";
    private $token = "";
    private $active = false;
    private $_installations = null;

    /**
     * Return the Id
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Return the username
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    public function setPassword(string $password) {
        return is_array(Configuration::DB()->execute("UPDATE tblUser SET password = :password WHERE _id = :id", [
            "password" => password_hash("Go" . $password . "Flex", PASSWORD_DEFAULT, [ "cost" => rand(8,15)]),
            "id" => $this->_id
        ]));
    }

    /**
     * Return the token
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Return the firstname
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Return the lastname
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Return the phone
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return bool
     */
    public function setPhone(string $phone) {
        $ok = is_array(Configuration::DB()->execute("UPDATE tblUser SET phone = :phone WHERE _id = :id;)", [":phone" => $phone, ":id" => $this->getId()]));
        if ($ok) $this->phone = $phone;
        return $ok;
    }

    /**
     * Return the email
     * @return string
     */
    public function getEMail() {
        return $this->email;
    }

    /**
     * Return or set if the user is Activate
     * @param null|bool active
     * @return bool
     */
    public function isActive($active = null) {
        return $active != null ?
            is_array(Configuration::DB()->execute("UPDATE tblUser SET active = :active WHERE _id = :id;)", [
                ":active" => $active, ":id" => $this->getId()])) :
            $this->active;
    }

    /**
     * Active the user
     * @return bool
     */
    public function setActive() {
        return $this->isActive(true);
    }

    /**
     * disable the user
     * @return bool
     */
    public function setInactive() {
        return $this->isActive(false);
    }

    /**
     * Return the role
     * @return Role
     */
    public function getRole() {
        if (!$this->role instanceof Role)
            $this->role = new Role($this->role);
        return $this->role;
    }

    public function __toString() {
        $return = $this->firstname . ' ' . $this->lastname;
        return $return === " " ? $this->username : $return;
    }

    /**
     * Return the installations of this user
     * @return Installation[]
     */
    public function getInstallations() {
        if ($this->_installations == null)
            $this->_installations = Installation::getByUser($this);
        return $this->_installations;
    }

    /**
     * User constructor
     * @param int $id
     * @param string $password
     */
    public function __construct(int $id, string $password = "") {
        $data = Configuration::DB()->execute("SELECT * FROM tblUser WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $data = $data[0];
            $this->_id = intval($data["_id"]);
            $this->username = $data["username"];
            $this->password = $password;
            $this->token = $data["token"];
            $this->firstname = $data["firstname"];
            $this->lastname = $data["lastname"];
            $this->phone = $data["phone"];
            $this->email = $data["email"];
            $this->role = $data['user_role'];
            $this->active = (bool) $data['active'];
        }
    }

    /**
     * Test if the user is still correct (username, and password)
     * @return bool
     */
    public function isCorrect() {
        return self::login($this->username, $this->password) instanceof User;
    }
}