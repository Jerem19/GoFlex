<?php
require_once 'Technology.php';
require_once 'Energy.php';

require_once __DIR__ . '/../Picture.php';

class Element {

    private $ener = -1;
    private $tech = -1;
    private $sensors = 0;
    private $tempSensors = 0;
    private $note = "";

    private $_picsId = [];
    private $pictures = null;

    /**
     * Return the energy
     * @return Energy
     */
    public function getEnergy() {
        if (!$this->ener instanceof Energy)
            $this->ener = new Energy($this->ener);
        return $this->ener;
    }

    /**
     * Set the Energy
     * @param Energy|int $ener (int not verified)
     */
    public function setEnergy($ener) {
        $this->ener = $ener instanceof Energy ? $ener->getId() : $this->ener;
    }


    /**
     * Return the used technology
     * @return Technology
     */
    public function getTechnology() {
        if (!$this->tech instanceof Technology)
            $this->tech = new Technology($this->tech);
        return $this->tech;
    }

    /**
     * Set the used technology
     * @param Technology|int $tech (int not verified)
     */
    public function setTechnology($tech) {
        $this->tech = $tech instanceof Technology ? $tech->getId() : $tech;
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
    public function setSensors(int $count){
        $this->sensors = $count;
    }

    /**
     * Return the count of Temperature sensors
     * @return int
     */
    public function getTemperatureSensors() {
        return $this->tempSensors;
    }

    /**
     * Set the count of Temperature sensors
     * @param int $count
     */
    public function setTemperatureSensors(int $count){
        $this->tempSensors = $count;
    }

    /**
     * Return the note
     * @return string
     */
    public function getNote() {
        return $this->note;
    }


    /**
     * @return Picture[]
     */
    public function getPictures() {
        if ($this->pictures == null) {
            $this->pictures = [];
            foreach ($this->_picsId as $picId)
                $this->pictures[] = new Picture($picId);
        }
        return $this->pictures;
    }

    /**
     * @return int[]
     */
    public function getPicturesId() {
        return $this->_picsId;
    }

    /**
     * Set a note for the element
     * @param string $note
     */
    public function setNote(string $note) {
        $this->note = $note;
    }

    public function __construct($prefix, $params) {
        $this->ener = intval($params[$prefix . "Ener"]);
        $this->tech = intval($params[$prefix . "Tech"]);
        $this->sensors = intval($params[$prefix . "Sensors"]);
        $this->tempSensors= intval($params[$prefix . "TempSensors"]);
        $this->note = $params[$prefix . "Note"];

        $this->_picsId = json_decode($params[$prefix . "Pictures"], true);

        if (!isset($this->_picsId)) $this->_picsId = [];
    }
}
