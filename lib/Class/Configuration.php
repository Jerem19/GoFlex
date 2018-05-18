<?php

class DB extends PDO {

    public function __construct($user, $pass, $name, $host ="", $port = 3306) {
        parent::__construct(sprintf('mysql:dbname=%s;host=%s;port=%d', $name, $host, $port), $user, $pass);
    }
    /**
     * Delete a row in a table
     * @param string $table
     * @param int $id
     */
    /*public function delete(string $table, int $id) {
        //$this->query(sprintf('DELETE FROM tbl%s WHERE _d = %d', ucfirst($table), $table, $id));
    }*/

    /**
     * @param string $query
     * @param array $attributes
     * @return array|bool
     */
    public function execute(string $query, array $attributes = []){
        $stmt = $this->prepare($query);
        $stmt->execute($attributes);
        $code = $stmt->errorCode();
        return $code!='00000' ? false : $stmt->fetchAll();
    }
}

class Configuration {
    const hostname = "";

    const pictures_path = PUBLIC_FOLDER . '/pics/';

    private static $db_name = "goFlexDb";
    private static $db_host = "localhost";
    private static $db_port = "3306";
    private static $db_user = "root";
    private static $db_pass = "";

    private static $DB = null;

    public static function DB() {
        if (self::$DB == null)
            self::$DB = new DB(self::$db_user, self::$db_pass, self::$db_name, self::$db_host, self::$db_port);
        return self::$DB;
    }
}