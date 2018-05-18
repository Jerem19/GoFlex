<?php

class Solar {

    private $panel = false;
    private $sensors = 0;
    private $note = "";

    /**
     * Return if there is a solar panel
     * @return bool
     */
    public function isExistant() {
        return $this->panel;
    }

    /**
     * Set if there is a solar panel
     * @param bool $exist
     */
    public function setExistant(bool $exist) {
        $this->panel = $exist;
    }

    /**
     * Return the count of sensors
     * @return int
     */
    public function getSensorsCount() {
        return $this->sensors;
    }

    /**
     * Set the count of sensors
     * @param int $count
     */
    public function setSensorsCount(int $count) {
        $this->sensors = abs($count);
    }

    /**
     * Return the note
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set the note
     * @param string $note
     */
    public function setNote(string $note) {
        $this->$note = $note;
    }

    public function __construct($params) {
        $this->panel = boolval($params["solarPanel"]);
        $this->sensors = intval($params["solarSensors"]);
        $this->note = $params["solarNote"];
    }
}