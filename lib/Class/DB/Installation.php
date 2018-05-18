<?php require_once __DIR__ . '/../Configuration.php';

require_once 'User.php';
require_once 'Gateway.php';

require_once 'Installation/BusinessSector.php';
require_once 'Installation/Energy.php';
require_once 'Installation/Technology.php';

require_once 'Installation/Solar.php';
require_once 'Installation/Element.php';

class Installation {

    /**
     * @param int|User $user
     * @param int|Gateway $gateway
     * @return int|false
     */
    public static function link($user, $gateway) {
        if (is_array(Configuration::DB()->execute("INSERT INTO tblInstallation (inst_userId, inst_gwId) VALUES (:user, :gw);", [
            "user" => $user instanceof User ? $user->getId() : $user,
            "gw" => $gateway instanceof Gateway ? $gateway->getId() : $gateway
        ])))
            return Configuration::DB()->lastInsertId();
        return false;
    }

    /**
     * Return installation(s) by the User
     * @param int|User $userId
     * @return Installation[]
     */
    public static function getByUser($userId) {
        $sth = Configuration::DB()->prepare("SELECT _id FROM tblInstallation WHERE inst_userId = :id");
        $sth->execute(["id" => $userId instanceof User ? $userId->getId() : $userId]);

        $i = [];
        while ($d = $sth->fetch())
            $i[] = new Installation($d["_id"]);
        return $i;
    }

    /**
     * Return an installation by the gateway
     * @param int|Gateway $gwId
     * @return Installation|false
     */
    public static function getByGateway($gwId) {
        $data = Configuration::DB()->execute("SELECT _id FROM tblInstallation WHERE inst_gwId = :id",
            ["id" => $gwId instanceof Gateway ? $gwId->getId() : $gwId]);
        return !empty($data) ? new Installation($data[0]["_id"]) : false;
    }

    private $_id = -1;
    private $_user = -1;
    private $_gateway = -1;

    private $facturation = true;
    private $buisSector = -1;

    private $heat = null;
    private $hotwater = null;
    private $solar = null;

    private $city = "";
    private $npa = "";
    private $address = "";
    private $note = "";

    /**
     * Return the id of the installation
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Return the user of the installation
     * @return User
     */
    public function getUser() {
        if (!$this->_user instanceof User)
            $this->_user = new User($this->_user);
        return $this->_user;
    }

    /**
     * Return the gateway of the installation
     * @return Gateway
     */
    public function getGateway() {
        if (!$this->_gateway instanceof Gateway)
            $this->_gateway = new Gateway($this->_gateway);
        return $this->_gateway;
    }

    public function getBuisinessSector() {
        if (!$this->$this->buisSector instanceof BusinessSector)
            $this->buisSector = new BusinessSector($this->buisSector);
        return $this->buisSector;
    }


    public function Heat() {
        return $this->heat;
    }

    public function Hotwater() {
        return $this->hotwater;
    }

    public function getCity() {
        return $this->city;
    }

    public function getNPA() {
        return $this->npa;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getNote() {
        return $this->note;
    }

    public function update() {
        // To DO
    }

    /**
     * Installation constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblInstallation WHERE _id = :id", ["id" => $id]);

        if (!empty($data)) {
            $data = $data[0];
            $this->_id = intval($data["_id"]);
            $this->_user = $data["inst_userId"];
            $this->_gateway = $data["inst_gwId"];

            $this->buisSector = $data["buisSector"];
            $this->heat = new Element("heat", $data);
            $this->hotwater = new Element("hotwater", $data);
            $this->solar = new Solar($data);

            $this->facturation = boolval($data["facturation"]);

            $this->city = $data["city"];
            $this->npa = $data["npa"];
            $this->address = $data["address"];
            $this->note = $data["note"];
        }
    }
}