<?php

Class Tradesman extends User {
    private $tId;
    private $tradeType;
    private $location;
    private $hourlyRate;
    private $skills;

    public function getTId() {
        return $this->tId;

    }
    public function setTradeType($var1) {
        $this->tradeType = $var1;
    }
    public function getTradeType() {
        return $this->tradeType;

    }
    public function setLocation($var1) {
        $this->location = $var1;
    }
    public function getLocation() {
        return $this->location;

    }
    public function setHourlyRate($var1) {
        $this->hourlyRate = $var1;
    }
    public function getHourlyRate() {
        return $this->hourlyRate;

    }
    public function setSkills($var1) {
        $this->skills = $var1;
    }
    public function getSkills() {
        return $this->skills;

    }

    public function createProfile() {
        //1. insert into users table
        //2. get userid
        //3. insert into tradesman table with userid as FK.

    }
    public function updateProfile($tId) {

    }

    public function deleteProfile($tId) {

    }
    public function searchTradesmen($tradeType, $location, $date) {

    }
    public function searchByPin($tId) {

    }
}
?>