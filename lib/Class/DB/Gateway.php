<?php require_once __DIR__ . '/../Configuration.php';

require_once 'Installation.php';
require_once 'Status.php';

class Gateway {

    private static $gateways = null;

    /**
     * Return all the gateways
     * @return Gateway[]
     */
    public static function getAll() {
        if (self::$gateways == null) {
            $sth = Configuration::DB()->query("SELECT _id FROM tblGateway;");
            while ($g = $sth->fetch())
                self::$gateways[] = new Gateway($g["_id"]);
        }
        return self::$gateways;
    }

    /**
     * Return if a gateway exists
     * @param string $name
     * @return bool
     */
    public static function exists(string $name) {
        foreach (self::getAll() as $gw)
            if ($gw->getName() == $name)
                return true;
        return false;
    }

    /**
     * @param array["name", ?"status"] $params
     * @return int|false
     */
    public static function create(array $params) {
        if (!isset($params["name"]))
            return false;

        if (!isset($params["status"]))
            $params["status"] = 1;

        $ok = is_array(Configuration::DB()->execute("INSERT INTO tblGateway (name, gw_status) VALUES (:name, :status);", $params));
        return $ok ? Configuration::DB()->lastInsertId() : false;
    }


    private $_id = -1;
    private $name = "no_" . __CLASS__;
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
        $data = Configuration::DB()->execute("SELECT * FROM tblGateway WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $data = $data[0];
            $this->_id = intval($data["_id"]);
            $this->name = $data["name"];
            $this->status = $data["gw_status"];
        }
    }
}