<?php

require_once 'Configuration.php';
require_once 'Installation.php';

class Status {
    private $_id = -1;
    private $name = "no_" . __CLASS__;

    private static $statutes = null;
    /**
     * Return all status
     * @return Status[]
     */
    public static function Statutes() {
        if (self::$statutes == null) {
            $sth = Configuration::DB()->query("SELECT statusId FROM tblStatus;");
            while ($d = $sth->fetch())
                self::$statutes[] = new Status($d["statusId"]);
        }
        return self::$statutes;
    }

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
     * Status constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblStatus WHERE statusId = :id", ["id" => $id]);
        if(!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["statusId"]);
        }
    }
}



class Gateway {

    /**
     * @param array["mac", "name", ?"status"] $params
     * @return int|false
     */
    public static function create(array $params) {
        if (!isset($params["mac"]) || !isset($params["name"]))
            return false;

        if (!isset($params["status"]))
            $params["status"] = 1;

        Configuration::DB()->execute("INSERT INTO tblGateway (name, mac, gw_status) VALUES (:name, :mac, :status);", $params);
        return Configuration::DB()->lastInsertId();
    }

    private $_id = -1;
    private $name = "no_" . __CLASS__;
    private $mac = "";
    private $status = -1;

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

    /**
     * Return the mac address
     * @return string
     */
    public function getMac() {
        return $this->mac;
    }

    /**
     * Return the status of the gateway
     * @return Status
     */
    public function getStatus() {
        if (!$this->status instanceof Status)
            $this->status = new Status($this->status);
        return $this->status;
    }

    /**
     * Return the installation of the gateway
     * @return false|Installation
     */
    public function getInstallation() {
        return Installation::getByGateway($this);
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Gateway constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblGateway WHERE gatewayId = :id", ["id" => $id]);
        if (!empty($data)) {
            $data = $data[0];
            $this->_id = intval($data["gatewayId"]);
            $this->name = $data["name"];
            $this->mac = $data["mac"];
            $this->status = $data["gw_status"];
        }
    }

}