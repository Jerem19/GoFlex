<?php
require_once 'Configuration.php';

class Role {
    private $_id;
    private $name;

    public static function getRoles() {
        return Configuration::getDB()->query("SELECT * FROM tblRole;")->fetchAll();
    }

    public function getName() {
        return $this->name;
    }

    public function __toString() {
        return strval($this->name);
    }

    public function __construct($id) {
        $this->_id = $id;
        $data = Configuration::getDB()->query("SELECT * FROM tblRole WHERE roleId = " . $id)->fetchAll();
        if(!empty($data)) {
            $this->name = $data[0]["name"];
        }
    }
}

class User {
    static public function getUser($id) {
        // To do: parameters
        return new User($id);
    }

    static public function createUser($jsonParam) {
        $stat = Configuration::getDB()->prepare(
            "INSERT INTO tblUser (username, password, firstname, lastname, phone, email, user_role) VALUES (
                  :username, :password, :firstname, :lastname, :phone, :email, :user_role
        );");
        $stat->execute($jsonParam);

        return new User(Configuration::getDB()->lastInsertId());
    }

    /**
     * Delete an user in the database
     * @param int $id
     */
    public static function deleteUser($id) {
        Configuration::getDB()->delete('user', $id);
    }

    private $_id = -1;
    private $username = "";
    private $password = "";
    private $role;
    private $firstname = "";
    private $lastname = "";
    private $phone = "";
    private $email = "";

    /**
     * Return the username
     * @return string
     */
    public function getUserName() {
        return $this->username;
    }

    /**
     * Return the firstname
     * @return string
     */
    public function getFirstName() {
        return $this->firstname;
    }

    /**
     * Return the lastname
     * @return string
     */
    public function getLastName() {
        return $this->lastname;
    }

    /**
     * Return the phone
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Return the email
     * @return string
     */
    public function getEMail() {
        return $this->email;
    }

    /**
     * Return the role
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    public function __toString() {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * User constructor.
     * @param int $userId
     */
    public function __construct($userId) {
        $this->_id = $userId;
        $data = Configuration::getDB()->query("SELECT * FROM tblUser WHERE userId = " . $userId)->fetchAll();

        if(!empty($data)) {
            $data = $data[0];
            $this->username = $data["username"];
            $this->password = $data["password"];
            $this->firstname = $data["firstname"];
            $this->lastname = $data["lastname"];
            $this->phone = $data["phone"];
            $this->email = $data["email"];
            $this->role = new Role($data['user_role']);
        }
    }
}