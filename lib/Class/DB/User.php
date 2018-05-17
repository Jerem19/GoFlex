<?php require_once __DIR__ . '/../Configuration.php';

require_once 'Role.php';
require_once 'Installation.php';

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

    /*
    static public function linkUserGateway(array $params)
    {

        //Modify the gateway status
        $gatewayId = $params['boxNumber'];
        Configuration::DB()->execute("UPDATE tblGateway SET gw_status = 2 WHERE gatewayId = :gatewayId;", [":gatewayId"=>$gatewayId]);

        $facturation = $params['facturation'];

        Configuration::DB()->execute("INSERT INTO tblinstallation(installationId, inst_userId, inst_gwId, facturation, businessSector, energyHeat, technologyHeat, consommationHeatSensor, insideTemperatureSensor, heatNotePosition, pictureHeat, energyHotWater, technologyHotWater, consommationHotwaterSensor, boilerTemperatureSensor, hotwaterNotePosition, pictureHotwater, solarPanel, productionSensor, solarPanelNotePosition, address, npa, ville, generalNote)
                                      VALUES (:clientNumber, :boxNumber, :facturation, :businessSector, :energyHeat, :technoHeat, :consommationHeatSensor, :insideTemperatureSensor, :heatNotePosition, :pictureHeat, :energyHotWater, :technoHotWater, :consommationHotwaterSensor, :boilerTemperatureSensor, :hotwaterNotePosition, :pictureHotwater, :solarPanel, :productionSensor, :solarPanelNotePosition, :address, :npa, :city, :generalNote);", $params);
        return Configuration::DB()->lastInsertId();
    }*/

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
        $u = Configuration::DB()->execute("SELECT _id, password FROM tblUser WHERE username = :user;", [":user" => $user]);
        return password_verify("Go" . $pass . "Flex", $u[0]["password"]) ? $u[0]["_id"] : false; // Improve if user is disable (error msg?)
    }

    /**
     * @param string $token
     * @return User|false
     */
    static public function getByToken(string $token) {
        $u = Configuration::DB()->execute("SELECT _id FROM tblUser WHERE token = :token;", [":token" => $token]);
        return isset($u[0]) ? new User($u[0]["_id"]) : false;
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
        return Configuration::DB()->execute("SELECT username, _id FROM tblUser WHERE user_role = 4 AND active = 0");
    }

    public function getAllUser()
    {
        return Configuration::DB()->execute("SELECT username, _id FROM tblUser WHERE user_role = 4");
    }

    //TODO : Voir avec hugo pour deplacer cette methode dans gateway.php
    public function getAllGateway()
    {
        //Status 1 = ready to install
        return Configuration::DB()->execute("SELECT name, gatewayId FROM tblGateway WHERE gw_status = 1");
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
     * Return if the user is Activate
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
     * Inactive the user
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

    public function isCorrect() {
        return self::isExisting($this->username, $this->password);
    }
}