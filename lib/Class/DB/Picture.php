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


    /**
     * Test if the image is a real image
     * @param string|array $tmp_name ($_FILE)
     * @param string|null $name
     * @return bool
     */
    public static function test($tmp_name, string $name = null) {
        if (is_array($tmp_name)) {
            $name = $tmp_name["name"];
            $tmp_name = $tmp_name["tmp_name"];
        }
        if ($name == null) $name = basename($tmp_name);

        return in_array(strtolower(pathinfo($name)["extension"]), ["png", "jpeg", "jpg", "tiff", "gif"])
            && substr(mime_content_type($tmp_name), 0, 5) == "image";
    }

    /**
     * @param array $params
     * @return int|false
     */
    public static function create(array $params) {
        if (! file_exists(Configuration::pictures_path))
            mkdir(Configuration::pictures_path);

        $name = $params["name"];
        $tmp_name = $params["tmp_name"];

        if (self::test($tmp_name, $name)) {
            $ok = is_array(Configuration::DB()->execute("INSERT INTO tblPicture (name) VALUES (:name);", ["name" => $name]));
            if ($ok && move_uploaded_file($tmp_name, Configuration::pictures_path . Configuration::DB()->lastInsertId()))                
                return intval(Configuration::DB()->lastInsertId());
        }

        return false;
    }


    /**
     * Remove a picture (Warning to foreign keys)
     * @param int|Picture $id
     * @return bool
     */
    public static function delete($pic) {
        if (is_int($pic) || intval($pic))
            $pic = new Picture($pic);

        if ($pic instanceof Picture) {
            if (is_array(Configuration::DB()->execute("DELETE FROM tblPicture WHERE _id = :id", ["id" => $pic->getId()]))) {
                unlink($pic->getPath()); // can remove from db
                return true;
            }
        }
        return false;
    }


    private $_id = -1;
    private $name = "no_" . __CLASS__;

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->getId() > 0 ? Configuration::pictures_path . $this->getId() : false;
    }

    /**
     * Picture constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblPicture WHERE _id = :id", ["id" => $id]);
        if (!empty($data)) {
            $this->name = $data[0]["name"];
            $this->_id = intval($data[0]["_id"]);
        }
    }

    /**
     * Change the image
     * @param string|array $tmp_name
     * @param string|null $name
     * @return bool
     */
    public function change($tmp_name, string $name = null) {
        if (is_array($tmp_name)) {
            $name = $tmp_name["name"];
            $tmp_name = $tmp_name["tmp_name"];
        }
        if ($name == null) $name = $this->getName();

        if (self::test($tmp_name, $name)) {
            $ok = true;
            if (! $name == $this->getName()) {
                $ok = is_array(Configuration::DB()->execute("UPDATE tblPicture SET name = :name WHERE _id = :id", [
                    "name" => $name,
                    "id" => $this->getId()
                ]));
            }
            if ($ok) $this->name = $name;
            return $ok && move_uploaded_file($tmp_name, Configuration::pictures_path . $this->getId());
        }
        return false;
    }
}