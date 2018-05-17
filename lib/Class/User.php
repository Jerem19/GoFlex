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

        $gatewayname = $params['gatewayname'];
        unset($params['gatewayname']);


        Configuration::DB()->execute("INSERT INTO tblUser (firstname, lastname, phone, username, password, email, token, user_role) VALUES (:firstname, :lastname, :phone, :username, :password, :email, :token, :role);", $params);
        Configuration::DB()->execute("INSERT INTO tblGateway (gw_status, name) VALUES (1, :gatewayname);", [":gatewayname"=> $gatewayname]);

        return Configuration::DB()->lastInsertId();
    }

    static public function linkUserGateway(array $params)
    {

        //Active the client account
        $userId = $params['clientNumber'];
        Configuration::DB()->execute("UPDATE tblUser SET active = 1 WHERE userId = :userId;", [":userId"=>$userId]);

        //Modify the gateway status
        $gatewayId = $params['boxNumber'];
        Configuration::DB()->execute("UPDATE tblGateway SET gw_status = 2 WHERE gatewayId = :gatewayId;", [":gatewayId"=>$gatewayId]);

        $facturation = $params['facturation'];

        Configuration::DB()->execute("INSERT INTO tblinstallation(installationId, inst_userId, inst_gwId, facturation, businessSector, energyHeat, technologyHeat, consommationHeatSensor, insideTemperatureSensor, heatNotePosition, pictureHeat, energyHotWater, technologyHotWater, consommationHotwaterSensor, boilerTemperatureSensor, hotwaterNotePosition, pictureHotwater, solarPanel, productionSensor, solarPanelNotePosition, address, npa, ville, generalNote)
                                      VALUES (:clientNumber, :boxNumber, :facturation, :businessSector, :energyHeat, :technoHeat, :consommationHeatSensor, :insideTemperatureSensor, :heatNotePosition, :pictureHeat, :energyHotWater, :technoHotWater, :consommationHotwaterSensor, :boilerTemperatureSensor, :hotwaterNotePosition, :pictureHotwater, :solarPanel, :productionSensor, :solarPanelNotePosition, :address, :npa, :city, :generalNote);", $params);
        return Configuration::DB()->lastInsertId();
    }

/* DEBUT UPLOAD
    public function upload($index, $destination, $maxsize=FALSE, $extensions=FALSE)
    {
        //Fichier correctement uploadé
        if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
        //Taille limite
        if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
        //Rxtension
        $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
        if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;

        return move_uploaded_file($_FILES[$index]['tmp_name'],$destination);
    }
*/

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

    public function getAllInactiveUser()
    {
        return Configuration::DB()->execute("SELECT username, userid FROM tblUser WHERE user_role = 4 AND active = 0");
    }

    public function getAllUser()
    {
        return Configuration::DB()->execute("SELECT username, userid FROM tblUser WHERE user_role = 4");
    }

    //TODO : Voir avec hugo pour deplacer cette methode dans gateway.php
    public function getAllGateway()
    {
        //Status 1 = ready to install
        return Configuration::DB()->execute("SELECT name, gatewayId FROM tblGateway WHERE gw_status = 1");
    }





    public function setPhone(string $phone) {
        return is_array(Configuration::DB()->execute("UPDATE tblUser SET phone = :phone WHERE userId = :userId;)", [":phone" => $phone, ":userId"=>$this->getId()]));
    }

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