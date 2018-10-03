<?php require_once __DIR__ . '/../Configuration.php';

require_once 'User.php';
require_once 'Gateway.php';

require_once 'Installation/BusinessSector.php';
require_once 'Installation/Energy.php';
require_once 'Installation/Technology.php';

require_once 'Installation/Solar.php';
require_once 'Installation/Element.php';

require_once 'Picture.php';

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
            return intval(Configuration::DB()->lastInsertId());
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
    private $_buisSector = -1;

    private $_heat = null;
    private $_hotwater = null;
    private $_solar = null;

    private $city = "";
    private $npa = "";
    private $address = "";
    private $note = "";
    private $adminNote = "";

    private $_picture = -1;

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

    /**
     * Ture if < 100Mwh
     * @return bool
     */
    public function getFacturation() {
        return $this->facturation;
    }

    /**
     * @return BusinessSector
     */
    public function getBuisinessSector() {
        if (!$this->_buisSector instanceof BusinessSector)
            $this->_buisSector = new BusinessSector($this->_buisSector);
        return $this->_buisSector;
    }

    /**
     * @return Element
     */
    public function Heat() {
        return $this->_heat;
    }

    /**
     * @return Element
     */
    public function Hotwater() {
        return $this->_hotwater;
    }

    /**
     * @return Solar
     */
    public function Solar() {
        return $this->_solar;
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

    /**
     * Return the admin note
     * @return string
     */
    public function getAdminNote() {
        return $this->adminNote;
    }

    /**
     * @return Picture
     */
    public function getPicture() {
        if (!$this->_picture instanceof Picture)
            $this->_picture = new Picture($this->_picture);
        return $this->_picture;
    }

    /**
     * Return all settings (without user, gateway and pictures)
     * @return array
     */
    public function getJSON() {
        return [
            "facturation" => $this->getFacturation() ? 1 : 0,
            "businessSector" => $this->getBuisinessSector()->getId(),

            "heatEner" => $this->Heat()->getEnergy()->getId(),
            "heatTech" => $this->Heat()->getTechnology()->getId(),
            "heatSensors" => $this->Heat()->getSensorsCount(),
            "heatTempSensors" => $this->Heat()->getTemperatureSensors(),
            "heatNote" => $this->Heat()->getNote(),

            "hotwaterEner" => $this->Hotwater()->getEnergy()->getId(),
            "hotwaterTech" => $this->Hotwater()->getTechnology()->getId(),
            "hotwaterSensors" => $this->Hotwater()->getSensorsCount(),
            "hotwaterTempSensors" => $this->Hotwater()->getTemperatureSensors(),
            "hotwaterNote" => $this->Hotwater()->getNote(),

            "solarPanel" => $this->Solar()->isExistant() ? 1 : 0,
            "solarSensors" => $this->Solar()->getSensorsCount(),
            "solarNote" => $this->Solar()->getNote(),

            "city" => $this->getCity(),
            "npa" => $this->getNPA(),
            "address" => $this->getAddress(),

            "note" => $this->getNote(),
            "adminNote" => $this->getAdminNote()
        ];
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

            $this->_buisSector = $data["businessSector"];
            $this->_heat = new Element("heat", $data);
            $this->_hotwater = new Element("hotwater", $data);
            $this->_solar = new Solar($data);

            $this->facturation = boolval($data["facturation"]);

            $this->city = $data["city"];
            $this->npa = $data["npa"];
            $this->address = $data["address"];
            $this->note = $data["note"];

            $this->adminNote = $data["noteAdmin"];

            // Pictures
            $this->_picture = intval($data["picture"]);
        }
    }

    public function update(array $params = []) {

        if (!isset($params["facturation"]))
            $params["facturation"] = $this->getFacturation();
        else $params["facturation"] = boolval($params["facturation"]) ? 1 : 0;

        if (!isset($params["businessSector"]))
            $params["businessSector"] = $this->getBuisinessSector()->getId();

        if (!isset($params["heatEner"]))
            $params["heatEner"] = $this->_heat->getEnergy()->getId();
        if (!isset($params["heatTech"]))
            $params["heatTech"] = $this->_heat->getTechnology()->getId();
        if (!isset($params["heatSensors"]))
            $params["heatSensors"] = $this->_heat->getSensorsCount();
        if (!isset($params["heatTempSensors"]))
            $params["heatTempSensors"] = $this->_heat->getTemperatureSensors();
        if (!isset($params["heatNote"]))
            $params["heatNote"] = $this->_heat->getNote();

        if (!isset($params["hotwaterEner"]))
            $params["hotwaterEner"] = $this->_hotwater->getEnergy()->getId();
        if (!isset($params["hotwaterTech"]))
            $params["hotwaterTech"] = $this->_hotwater->getTechnology()->getId();
        if (!isset($params["hotwaterSensors"]))
            $params["hotwaterSensors"] = $this->_hotwater->getSensorsCount();
        if (!isset($params["hotwaterTempSensors"]))
            $params["hotwaterTempSensors"] = $this->_hotwater->getTemperatureSensors();
        if (!isset($params["hotwaterNote"]))
            $params["hotwaterNote"] = $this->_hotwater->getNote();

        if (!isset($params["solarPanel"]))
            $params["solarPanel"] = $this->_solar->isExistant() ? 1 : 0;
        else $params["solarPanel"] = boolval($params["solarPanel"]) ? 1 : 0;
        if (!isset($params["solarSensors"]))
            $params["solarSensors"] = $this->_solar->getSensorsCount();
        if (!isset($params["solarNote"]))
            $params["solarNote"] = $this->_solar->getNote();

        if (!isset($params["city"]))
            $params["city"] = $this->getCity();
        if (!isset($params["npa"]))
            $params["npa"] = $this->getNPA();
        if (!isset($params["address"]))
            $params["address"] = $this->getAddress();
        if (!isset($params["note"]))
            $params["note"] = $this->getNote();

        if (!isset($params["noteAdmin"]))
            $params["noteAdmin"] = $this->getAdminNote();


        if (!isset($params["heatPictures"]))
            $params["heatPictures"] = json_encode($this->_heat->getPicturesId());

        if (!isset($params["hotwaterPictures"]))
            $params["hotwaterPictures"] = json_encode($this->_hotwater->getPicturesId());

        if (!isset($params["picture"])) {
            $id = $this->getPicture()->getId();
            $params["picture"] = $id > 0 ? $id : null;
        }

        $params["id"] = $this->getId();
        return is_array(Configuration::DB()->execute("UPDATE tblInstallation SET
          facturation = :facturation, businessSector = :businessSector,
          heatEner = :heatEner, heatTech = :heatTech, heatSensors = :heatSensors, heatTempSensors = :heatTempSensors, heatNote = :heatNote,
          hotwaterEner = :hotwaterEner, hotwaterTech = :hotwaterTech, hotwaterSensors = :hotwaterSensors, hotwaterTempSensors = :hotwaterTempSensors, hotwaterNote = :hotwaterNote,
          solarPanel = :solarPanel, solarSensors = :solarSensors, solarNote = :solarNote,
          city = :city, npa = :npa, address = :address, note = :note, noteAdmin = :noteAdmin, heatPictures = :heatPictures, hotwaterPictures = :hotwaterPictures, picture = :picture WHERE _id = :id;", $params));
    }
}