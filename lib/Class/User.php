<?php
require_once 'Configuration.php';
require_once 'Installation.php';
require_once 'Gateway.php';
class Role {

    private static $roles = null;
    /**
     * Return all status
     * @return Role[]
     */
    public static function Roles() {
        if (self::$roles == null) {
            $sth = Configuration::DB()->query("SELECT roleId, name FROM tblRole;");
            while ($d = $sth->fetch())
                self::$roles[$d["name"]] = new Role($d["roleId"]);
        }
        return self::$roles;
    }
    private $_id = -1;
    private $name = "no_" . __CLASS__;
    /**
     * Return the id
     * @return int
     */
    public function getId() {
        return $this->_id;
    }
    /**
     * Return the name
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    public function __toString() {
        return strval($this->name);
    }
    /**
     * Role constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblRole WHERE roleId = :id", ["id" => $id]);
        if(!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["roleId"]);
        }
    }
}
class User {
    /**
     * @param array $params
     * @return string|false
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
        Configuration::DB()->execute("INSERT INTO tblUser (firstname, lastname, phone, username, password, email, token, user_role) VALUES (:firstname, :lastname, :phone, :username, :password, :email, :token, :role);", $params);
        return Configuration::DB()->lastInsertId();
    }
    /**
     * @param string $user
     * @param string $pass
     * @return int|false
     */
    static public function isExisting(string $user, string $pass) {
        $u = Configuration::DB()->execute("SELECT userId, password FROM tblUser WHERE username = :user;", [":user" => $user]);
        return password_verify("Go" . $pass . "Flex", $u[0]["password"]) ? $u[0]["userId"] : false; // Improve if user is disable (error msg?)
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
     * Return the email
     * @return string
     */
    public function getEMail() {
        return $this->email;
    }

    /**
     * Return if the user is Activate
     * @return bool
     */
    public function isActive() {
        return $this->active;
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
        $data = Configuration::DB()->execute("SELECT * FROM tblUser WHERE userId = :id", ["id" => $id]);
        if (!empty($data)) {
            $data = $data[0];
            $this->_id = intval($data["userId"]);
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
    public function isCorrect() {
        return self::isExisting($this->username, $this->password);
    }
}