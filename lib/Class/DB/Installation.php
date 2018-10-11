<?php require_once __DIR__ . '/../Configuration.php';

require_once 'User.php';
require_once 'Gateway.php';

require_once 'Installation/BusinessSector.php';
require_once 'Installation/Energy.php';
require_once 'Installation/DelegatedControl.php';
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
    private $egidNumber = "";
    private $constructionYear = "";
    private $renovationYear = "";
    private $sreArea = "";
    private $inhabitants = "";
    private $housingType = null;
    private $_control = -1;

    private $heatProduction = -1;
    private $heatDistribution = -1;
    private $heatServiceYear = "";
    private $heatPowerMeter = -1;
    private $ambiantTemperature = -1;
    private $heatRelay = -1;

    private $watterHeatProduction = -1;
    private $watterServiceYear = "";
    private $boilerVolume = "";
    private $watterPowerMeter = -1;
    private $boilerTemperature = -1;
    private $watterRelay = -1;

    private $photovoltaic = -1;
    private $thermal = -1;
    private $solarPowerMeter = -1;


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
     * @return string
     */
    public function getEgidNumber(): string
    {
        return $this->egidNumber;
    }
    /**
     * @return string
     */
    public function getConstructionYear(): string
    {
        return $this->constructionYear;
    }

    /**
     * @return string
     */
    public function getRenovationYear(): string
    {
        return $this->renovationYear;
    }

    /**
     * @return string
     */
    public function getSreArea(): string
    {
        return $this->sreArea;
    }

    /**
     * @return string
     */
    public function getInhabitants(): string
    {
        return $this->inhabitants;
    }

    /**
     * @return null
     */
    public function getHousingType()
    {
        return $this->housingType;
    }

    /**
     * @return DelegatedControl
     */
    public function getDelegatedControl() {
        if (!$this->_control instanceof DelegatedControl)
            $this->_control = new DelegatedControl($this->_control);
        return $this->_control;
    }

    /**
     * @return int
     */
    public function getHeatProduction(): int
    {
        return $this->heatProduction;
    }

    /**
     * @return int
     */
    public function getHeatDistribution(): int
    {
        return $this->heatDistribution;
    }

    /**
     * @return string
     */
    public function getHeatServiceYear(): string
    {
        return $this->heatServiceYear;
    }

    /**
     * @return int
     */
    public function getHeatPowerMeter(): int
    {
        return $this->heatPowerMeter;
    }

    /**
     * @return int
     */
    public function getAmbiantTemperature(): int
    {
        return $this->ambiantTemperature;
    }

    /**
     * @return int
     */
    public function getHeatRelay(): int
    {
        return $this->heatRelay;
    }

    /**
     * @return int
     */
    public function getWatterHeatProduction(): int
    {
        return $this->watterHeatProduction;
    }

    /**
     * @return string
     */
    public function getWatterServiceYear(): string
    {
        return $this->watterServiceYear;
    }

    /**
     * @return string
     */
    public function getBoilerVolume(): string
    {
        return $this->boilerVolume;
    }

    /**
     * @return int
     */
    public function getWatterPowerMeter(): int
    {
        return $this->watterPowerMeter;
    }

    /**
     * @return int
     */
    public function getBoilerTemperature(): int
    {
        return $this->boilerTemperature;
    }

    /**
     * @return int
     */
    public function getWatterRelay(): int
    {
        return $this->watterRelay;
    }

    /**
     * @return int
     */
    public function getPhotovoltaic(): int
    {
        return $this->photovoltaic;
    }

    /**
     * @return int
     */
    public function getThermal(): int
    {
        return $this->thermal;
    }

    /**
     * @return int
     */
    public function getSolarPowerMeter(): int
    {
        return $this->solarPowerMeter;
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
            "egidNumber" => $this->getEgidNumber(),
            "constructionYear" => $this->getConstructionYear(),
            "renovationYear" => $this->getRenovationYear(),
            "sreArea" => $this->getSreArea(),
            "inhabitants" => $this->getInhabitants(),
            "housingType" => $this->getHousingType(),
            "inst_dcId" => $this->getDelegatedControl()->getId(),

            //heat
            "heatProduction" => $this->getHeatProduction(),
            "heatDistribution" => $this->getHeatDistribution(),
            "heatServiceYear" => $this->getHeatServiceYear(),
            "heatPowerMeter" => $this->getHeatPowerMeter(),
            "ambiantTemperature" => $this->getAmbiantTemperature(),
            "heatRelay" => $this->getHeatRelay(),

            //Watter
            "watterHeatProduction" => $this->getWatterHeatProduction(),
            "watterServiceYear" => $this->getWatterServiceYear(),
            "boilerVolume" => $this->getBoilerVolume(),
            "watterPowerMeter" => $this->getWatterPowerMeter(),
            "boilerTemperature" => $this->getBoilerTemperature(),
            "watterRelay" => $this->getWatterRelay(),

            //Solar
            "photovoltaic" => $this->getPhotovoltaic(),
            "thermal" => $this->getThermal(),
            "solarPowerMeter" => $this->getSolarPowerMeter(),


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
            $this->egidNumber = $data["egidNumber"];
            $this->constructionYear = $data["constructionYear"];
            $this->renovationYear = $data["renovationYear"];
            $this->sreArea = $data["sreArea"];
            $this->inhabitants = $data["inhabitants"];
            $this->housingType = $data["housingType"];
            $this->_control = $data["inst_dcId"];

            // Heat
            $this->heatProduction = $data["heatProduction"];
            $this->heatDistribution = $data["heatDistribution"];
            $this->heatServiceYear = $data["heatServiceYear"];
            $this->heatPowerMeter = $data["heatPowerMeter"];
            $this->ambiantTemperature = $data["ambiantTemperature"];
            $this->heatRelay = $data["heatRelay"];

            //Watter
            $this->watterHeatProduction = $data["watterHeatProduction"];
            $this->watterServiceYear = $data["watterServiceYear"];
            $this->boilerVolume = $data["boilerVolume"];
            $this->watterPowerMeter = $data["watterPowerMeter"];
            $this->boilerTemperature = $data["boilerTemperature"];
            $this->watterRelay= $data["watterRelay"];

            //Solar
            $this->photovoltaic = $data["photovoltaic"];
            $this->thermal = $data["thermal"];
            $this->solarPowerMeter= $data["solarPowerMeter"];


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
        if (!isset($params["egidNumber"]))
            $params["egidNumber"] = $this->getEgidNumber();
        if (!isset($params["constructionYear"]))
            $params["constructionYear"] = $this->getConstructionYear();
        if (!isset($params["renovationYear"]))
            $params["renovationYear"] = $this->getRenovationYear();
        if (!isset($params["sreArea"]))
            $params["sreArea"] = $this->getSreArea();
        if (!isset($params["inhabitants"]))
            $params["inhabitants"] = $this->getInhabitants();
        if (!isset($params["housingType"]))
            $params["housingType"] = $this->getHousingType();
        if (!isset($params["noteAdmin"]))
            $params["noteAdmin"] = $this->getAdminNote();
        if (!isset($params["inst_dcId"]))
            $params["inst_dcId"] = $this->getDelegatedControl()->getId();

        //Heat
        if (!isset($params["heatProduction"]))
            $params["heatProduction"] = $this->getHeatProduction();
        if (!isset($params["heatDistribution"]))
            $params["heatDistribution"] = $this->getHeatDistribution();
        if (!isset($params["heatServiceYear"]))
            $params["heatServiceYear"] = $this->getHeatServiceYear();
        if (!isset($params["heatPowerMeter"]))
            $params["heatPowerMeter"] = $this->getHeatPowerMeter();
        if (!isset($params["ambiantTemperature"]))
            $params["ambiantTemperature"] = $this->getAmbiantTemperature();
        if (!isset($params["heatRelay"]))
            $params["heatRelay"] = $this->getHeatRelay();

        //Watter
        if (!isset($params["watterHeatProduction"]))
            $params["watterHeatProduction"] = $this->getWatterHeatProduction();
        if (!isset($params["watterServiceYear"]))
            $params["watterServiceYear"] = $this->getWatterServiceYear();
        if (!isset($params["boilerVolume"]))
            $params["boilerVolume"] = $this->getBoilerVolume();
        if (!isset($params["watterPowerMeter"]))
            $params["watterPowerMeter"] = $this->getWatterPowerMeter();
        if (!isset($params["boilerTemperature"]))
            $params["boilerTemperature"] = $this->getBoilerTemperature();
        if (!isset($params["watterRelay"]))
            $params["watterRelay"] = $this->getWatterRelay();

        //Solar
        if (!isset($params["photovoltaic"]))
            $params["photovoltaic"] = $this->getPhotovoltaic();
        if (!isset($params["thermal"]))
            $params["thermal"] = $this->getThermal();
        if (!isset($params["solarPowerMeter"]))
            $params["solarPowerMeter"] = $this->getSolarPowerMeter();


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
          facturation = :facturation, businessSector = :businessSector, housingType = :housingType, inst_dcId = :inst_dcId,
          heatEner = :heatEner, heatTech = :heatTech, heatSensors = :heatSensors, heatTempSensors = :heatTempSensors, heatNote = :heatNote, heatProduction = :heatProduction, heatDistribution = :heatDistribution, heatServiceYear = :heatServiceYear, heatPowerMeter = :heatPowerMeter, ambiantTemperature = :ambiantTemperature, heatRelay= :heatRelay,
          hotwaterEner = :hotwaterEner, hotwaterTech = :hotwaterTech, hotwaterSensors = :hotwaterSensors, hotwaterTempSensors = :hotwaterTempSensors, hotwaterNote = :hotwaterNote, watterHeatProduction = :watterHeatProduction, watterServiceYear = :watterServiceYear, boilerVolume = :boilerVolume, watterPowerMeter = :watterPowerMeter, boilerTemperature = :boilerTemperature, watterRelay = :watterRelay,
          solarPanel = :solarPanel, solarSensors = :solarSensors, solarNote = :solarNote, photovoltaic = :photovoltaic, thermal = :thermal, solarPowerMeter = :solarPowerMeter,
          city = :city, npa = :npa, address = :address, note = :note, noteAdmin = :noteAdmin, heatPictures = :heatPictures, hotwaterPictures = :hotwaterPictures, picture = :picture, egidNumber = :egidNumber, constructionYear = :constructionYear, renovationYear = :renovationYear, sreArea = :sreArea, inhabitants = :inhabitants, heatPictures = :heatPictures WHERE _id = :id;", $params));
    }
}