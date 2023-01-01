<?php
require('user.php');
class Tradesman extends User
{
    private $uId;
    private $tradeType;
    private $location;
    private $hourlyRate;
    private $skills;

    public function setUId($var1)
    {
        $this->uId = $var1;
    }
    public function getUId()
    {
        return $this->uId;

    }
    public function setTradeType($var1)
    {
        $this->tradeType = $var1;
    }
    public function getTradeType()
    {
        return $this->tradeType;

    }
    public function setLocation($var1)
    {
        $this->location = $var1;
    }
    public function getLocation()
    {
        return $this->location;

    }
    public function setHourlyRate($var1)
    {
        $this->hourlyRate = $var1;
    }
    public function getHourlyRate()
    {
        return $this->hourlyRate;

    }
    public function setSkills($var1)
    {
        $this->skills = $var1;
    }
    public function getSkills()
    {
        return $this->skills;

    }

    public function createProfile()
    {
        //1. insert into users table
        //2. get userid
        //3. insert into tradesman table with userid as FK.
        if ($this->createAccount()) {
            $id = mysqli_insert_id($this->getDbc());
            echo $id;
            $this->setUId($id);
            $tId = $id;
            echo "rrr" . $this->getUserId() . "dfdf----------";
            $tType = $this->getDbc()->real_escape_string($this->getTradeType());
            echo $this->getTradeType();
            $loc = $this->getDbc()->real_escape_string($this->getLocation());
            $hrRate = $this->getDbc()->real_escape_string($this->getHourlyRate());
            $skill = $this->getDbc()->real_escape_string($this->getSkills());
            $q = "INSERT INTO tradesmen (trade_type, location, hourly_rate, skills, user_id) 
            VALUES ('$tType', '$loc', '$hrRate', '$skill', '$tId')";
            $r = $this->getDbc()->query($q);

            // $this->dbc->close();
            return $r;
        }
    }
    public function updateProfile($tId)
    {

    }

    public function deleteProfile($tId)
    {

    }
    public function searchTradesmen($tradeType, $location, $date)
    {

    }
    public function searchByPin($tId)
    {

    }
}
?>