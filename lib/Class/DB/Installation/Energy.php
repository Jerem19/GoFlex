<?php require_once __DIR__ . '/../../Configuration.php';

class Energy {
    private $_id = -1;
    private $name = "no_" . __CLASS__;

    private static $all= null;

    /**
     * Return all status
     * @return Status[]
    */
    public static function getAll() {
        if (self::$all == null) {
            self::$all = [];
            $sth = Configuration::DB()->query("SELECT _id FROM tblEnergy;");
            while ($d = $sth->fetch())
                self::$all[] = new Energy($d["_id"]);
        }
        return self::$all;
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
        $data = Configuration::DB()->execute("SELECT * FROM tblEnergy WHERE _id = :id", ["id" => $id]);
        if(!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }
}