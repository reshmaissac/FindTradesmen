<?php
require ('includes/connect_db.php');
//include "includes/connect_db.php";
Class User extends DBConnection{
    private $userId;
    private $fName;
    private $lName;
    private $email;
    private $contactNo;
    private $password;
    private $dbc;

    function __construct() {
        $this->dbc = $this->getConnection();        
    }

    public function getUserId() {
        return $this->userId;

    }
    public function setFName($var1) {
        $this->fName = $var1;
    }
    public function getFName() {
        return $this->fName;

    }
    public function setLName($var1) {
        $this->lName = $var1;
    }
    public function getLName() {
        return $this->lName;

    }
    public function setEmail($var1) {
        $this->email = $var1;
    }
    public function getEmail() {
        return $this->email;

    }
    public function setContactNo($var1) {
        $this->contactNo = $var1;
    }
    public function getContactNo() {
        return $this->contactNo;

    }
    public function setPassword($var1) {
        $hash = password_hash($var1, PASSWORD_DEFAULT);
        $this->password = $hash;
    }
    public function getPassword() {
        return $this->password;

    }

    public function createAccount() {
        $fname = $this->dbc->real_escape_string($this->getFName());
        $lname = $this->dbc->real_escape_string($this->getLName());
        $e = $this->dbc->real_escape_string($this->getEmail()); 
        $contact = $this->dbc->real_escape_string($this->getContactNo()); 
        $pswd = $this->dbc->real_escape_string($this->getPassword());
        $q = "INSERT INTO users (first_name, last_name, email, contact_no, pass, reg_date) 
						 VALUES ('$fname', '$lname', '$e', '$contact', '$pswd', NOW() )";
		$r = $this->dbc->query($q);
        $this->dbc->close();
        return $r;
    }
    public function checkIfUserExists() {
        echo $this->getEmail();
        $e = $this->dbc->real_escape_string($this->getEmail()); 
        $q = "SELECT user_id FROM users WHERE email='$e'";
        $r = $this->dbc->query($q);
        $this->dbc->close();
        return $r;
    }
    public function login() {

    }
}
?>