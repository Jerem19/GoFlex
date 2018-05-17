<?php require_once __DIR__ . '/../Configuration.php';

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
            $sth = Configuration::DB()->query("SELECT _id FROM tblStatus;");
            while ($d = $sth->fetch())
                self::$statutes[] = new Status($d["_id"]);
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
        $data = Configuration::DB()->execute("SELECT * FROM tblStatus WHERE _id = :id", ["id" => $id]);
        if(!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }
}