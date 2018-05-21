<?php require_once __DIR__ . '/../Configuration.php';

class Role {

    private static $all = null;
    /**
     * Return all status
     * @return Role[]
     */
    public static function getAll() {
        if (self::$all == null) {
            self::$all = [];
            $sth = Configuration::DB()->query("SELECT _id FROM tblRole;");
            while ($d = $sth->fetch())
                self::$all[] = new Role($d["_id"]);
        }
        return self::$all;
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
        $data = Configuration::DB()->execute("SELECT * FROM tblRole WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }
}
