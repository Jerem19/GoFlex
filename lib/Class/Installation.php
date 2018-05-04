<?php

require_once 'Configuration.php';
require_once 'User.php';
require_once 'Gateway.php';

class Installation {

    /**
     * Return installation(s) by the User
     * @param int|User $userId
     * @return Installation[]
     */
    public static function getByUser($userId) {
        $sth = Configuration::DB()->prepare("SELECT installationId FROM tblInstallation WHERE inst_userId = :id");
        $sth->execute(["id" => $userId instanceof User ? $userId->getId() : $userId]);

        $i = [];
        while ($d = $sth->fetch())
            $i[] = new Installation($d["installationId"]);
        return $i;
    }

    /**
     * Return an installation by the gateway
     * @param int|Gateway $gwId
     * @return Installation|false
     */
    public static function getByGateway($gwId) {
        $data = Configuration::DB()->execute("SELECT installationId FROM tblInstallation WHERE inst_gwId = :id",
            ["id" => $gwId instanceof Gateway ? $gwId->getId() : $gwId]);
        return !empty($data) ? new Installation($data[0]["installationId"]) : false;
    }

    private $_id = -1;
    private $_user = -1;
    private $_gateway = -1;

    /**
     * Return the id of the installation
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Return the user of the installation
     * @return User
     */
    public function getUser() {
        if (!$this->_user instanceof User)
            $this->_user = new User($this->_user);
        return $this->_user;
    }

    /**
     * Return the gateway of the installation
     * @return Gateway
     */
    public function getGateway() {
        if (!$this->_gateway instanceof Gateway)
            $this->_gateway = new Gateway($this->_gateway);
        return $this->_gateway;
    }

    /**
     * Installation constructor.
     * @param int $id
     */
    public function __construct($id) {
        $data = Configuration::DB()->execute("SELECT * FROM tblInstallation WHERE installationId = :id", ["id" => $id]);

        if (!empty($data)) {
            $this->_id = intval($data[0]["installationId"]);
            $this->_user = $data[0]["inst_userId"];
            $this->_gateway = $data[0]["inst_gwId"];
        }
    }
}