<?php require_once __DIR__ .'/../Configuration.php';

class Picture {

    private static $all = null;
    public static function getAll() {
        if (self::$all == null) {
            $sth = Configuration::DB()->query("SELECT _id FROM tblPicture;");
            while ($d = $sth->fetch())
                self::$all[] = new Picture($d["_id"]);
        }
        return self::$all;
    }


    public static function create(array $params) {
        $name = $params["name"];
        $tmp_name = $params["tmp_name"];
        if (in_array(strtolower(pathinfo($name)["extension"]), ["png", "jpeg", "jpg", "tiff", "gif"])
            && substr(mime_content_type($tmp_name), 0, 5) == "image") {
            $ok = is_array(Configuration::DB()->execute("INSERT INTO tblPicture (name) VALUES (:name);", ["name" => $name]));
            if ($ok) {
                return move_uploaded_file($tmp_name, Configuration::pictures_path . Configuration::DB()->lastInsertId());
            } else return false;
        }

        return false;
    }


    private $_id;
    private $name = "no_" . __CLASS__;

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return Configuration::pictures_path . $this->getId();
    }

    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblPicture WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }
}