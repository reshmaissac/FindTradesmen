<?php
require('includes/connect_db.php');
class User extends DBConnection
{
    private $userId;
    private $fName;
    private $lName;
    private $email;
    private $contactNo;
    private $password;
    private $isTradesman;
    private $dbc;

    public function getDbc()
    {
        return $this->dbc;
    }

    function __construct()
    {
        $this->dbc = $this->getConnection();
    }

    public function getUserId()
    {
        return $this->userId;

    }
    public function setFName($var1)
    {
        $this->fName = $var1;
    }
    public function getFName()
    {
        return $this->fName;

    }
    public function setLName($var1)
    {
        $this->lName = $var1;
    }
    public function getLName()
    {
        return $this->lName;

    }
    public function setEmail($var1)
    {
        $this->email = $var1;
    }
    public function getEmail()
    {
        return $this->email;

    }
    public function setContactNo($var1)
    {
        $this->contactNo = $var1;
    }
    public function getContactNo()
    {
        return $this->contactNo;

    }
    public function setPassword($var1)
    {
        $this->password = $var1;
    }
    public function getPassword()
    {
        return $this->password;

    }

    public function createAccount()
    {
        $isTrdman = $this->dbc->real_escape_string($this->getIsTradesman());
        $fname = $this->dbc->real_escape_string($this->getFName());
        $lname = $this->dbc->real_escape_string($this->getLName());
        $e = $this->dbc->real_escape_string($this->getEmail());
        $contact = $this->dbc->real_escape_string($this->getContactNo());
        $pswd = $this->dbc->real_escape_string($this->getPassword());
        $q = "INSERT INTO users (first_name, last_name, email, contact_no, pass, is_tradesman, reg_date) 
						 VALUES ('$fname', '$lname', '$e', '$contact', SHA1('$pswd'),$isTrdman, NOW() )";
        $r = $this->dbc->query($q);

        return $r;
    }
    public function checkIfUserExists()
    {
        $e = $this->dbc->real_escape_string($this->getEmail());
        $q = "SELECT user_id FROM users WHERE email='$e'";
        $r = $this->dbc->query($q);
        return $r;
    }

    public function login($e, $p)
    {
        $errors = array();
        $e = $this->dbc->real_escape_string($e);
        $p = $this->dbc->real_escape_string($p);
        $q = "SELECT user_id, first_name, last_name, is_tradesman 
        FROM users 
        WHERE email='$e' AND pass=SHA1('$p')";

        $r = $this->dbc->query($q);
        if ($r->num_rows == 1) {
            $row = $r->fetch_array(MYSQLI_ASSOC);
            return array(true, $row);
        } else {

            $errors[] = 'Email address and password not found.';
            return array(false, $errors);
        }
    }

    /**
     * @return mixed
     */
    public function getIsTradesman()
    {
        return $this->isTradesman;
    }

    /**
     * @param mixed $isTradesman 
     * @return self
     */
    public function setIsTradesman($isTradesman): self
    {
        $this->isTradesman = $isTradesman;
        return $this;
    }

    public function getAllUsers()
    {
        $q = "SELECT * FROM users";

        $result = $this->dbc->query($q);
        $users_array = array();
        if (null != $result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $user = new User();
                $user->setFName($row['first_name']);
                $user->setLName($row['last_name']);
                $user->setEmail($row['email']);
                $user->setContactNo($row['contact_no']);
                $user->setIsTradesman($row['is_tradesman']);

                $users_array[] = $user;

            }
        }
        return $users_array;
    }


}
?>