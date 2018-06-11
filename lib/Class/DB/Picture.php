<?php require_once __DIR__ .'/../Configuration.php';

class Picture
{

    private static $all = null;

    public static function getAll()
    {
        if (self::$all == null) {
            $sth = Configuration::DB()->query("SELECT _id FROM tblPicture;");
            while ($d = $sth->fetch())
                self::$all[] = new Picture($d["_id"]);
        }
        return self::$all;
    }


    /**
     * Return all the users whose the role is client
     * @return User[]
     */
    public static function getAllPicsOfInstallation(int $idInstall, string $type) {

        $data = Configuration::DB()->execute("SELECT name FROM tblPictures WHERE install = :idInstall AND type = :type", ["idInstall" => $idInstall, "type" => $type]);

        return $data;
    }


    /**
     * @param array $params
     * @return int|false
     */

    public static function create(array $params) {
        $name = $params["name"];
        $tmp_name = $params["tmp_name"];
        if (in_array(strtolower(pathinfo($name)["extension"]), ["png", "jpeg", "jpg", "tiff", "gif"])
            && substr(mime_content_type($tmp_name), 0, 5) == "image") {
            $ok = is_array(Configuration::DB()->execute("INSERT INTO tblPicture (name) VALUES (:name);", ["name" => $name]));
            if ($ok && move_uploaded_file($tmp_name, Configuration::pictures_path . Configuration::DB()->lastInsertId()))                
                return Configuration::DB()->lastInsertId();
        }

        return false;
    }

    private $_id = -1;
    private $name = "no_" . __CLASS__;
    private $install;

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getInstall() {
        return $this->install;
    }

    public function getPath() {
        return $this->getId() > 0 ? Configuration::pictures_path . $this->getId() : -1;
    }

    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblPicture WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }
}