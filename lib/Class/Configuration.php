<?php

class DB {
    private $_db;

    public function __construct($user, $pass, $name, $host, $port = 3306) {
        try {
            $this->_db = new PDO(sprintf('mysql:dbname=%s;host=%s;port=%d', $name, $host, $port), $user, $pass);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Return the PDO object
     * @return PDO
     */
    public function getDb() {
        return $this->_db;
    }

    public function query($query) {
        return $this->_db->query($query);
    }

    public function prepare($sql) {
        return $this->_db->prepare($sql);
    }

    /**
     * Delete a row in a table
     * @param string $field
     * @param int $id
     */
    public function delete($field, $id) {
        $this->_db->query(sprintf('DELETE FROM tbl%s WHERE %sId = %d', ucfirst($field), $field, $id));
    }

    public function lastInsertId() {
        return $this->_db->lastInsertId();
    }
}

class Configuration {
    private static $db_name = "goFlexDb";
    private static $db_host = "localhost";
    private static $db_port = "3306";
    private static $db_user = "root";
    private static $db_pass = "";

    private static $DB = null;

    public static function getDB() {
        if (self::$DB == null)
            self::$DB = new DB(self::$db_user, self::$db_pass, self::$db_name, self::$db_host, self::$db_port);
        return self::$DB;
    }
}