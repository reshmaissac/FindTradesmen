<?php
require('user.php');
include('previous_work.php');
class Tradesman extends User
{
    private $uId;
    private $tradeType;
    private $location;
    private $hourlyRate;
    private $skills;
    private $availability;

    private $previousWorks = array();
    private $bookedDates = array();

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
    public function addPreviousWorks($desc)
    {
        $this->previousWorks[] = new PreviousWork($desc);
        //add to DB
    }

    public function getPreviousWorks()
    {
        return $this->previousWorks;
    }
    public function addBookedDates($date)
    {
        $this->bookedDates[] = new Schedule($date);
        //add to DB
        //get user id from session
    }
   
    public function getAvailability()
    {
        return $this->availability;
    }

    public function setAvailability($availability): self
    {
        $this->availability = $availability;
        return $this;
    }
    public function createProfile()
    {
        //1. insert into users table
        //2. get userid
        //3. insert into tradesman table with userid as FK.
        if ($this->createAccount()) {
            $id = mysqli_insert_id($this->getDbc());
            $this->setUId($id);
            $tId = $id;
            $tType = $this->getDbc()->real_escape_string($this->getTradeType());
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
    public function retrieveProfile($tId)
    {

    }
    public function updateProfile($tId)
    {

    }

    public function deleteProfile($tId)
    {

    }
    public function searchTradesmen($tradeType, $location, $date)
    {
        $inner = "";
        if (!empty($tradeType) && !empty($location)) {

            $condition = "trade_type = \"$tradeType\" AND location= \"$location\" ";
        } else if (!empty($tradeType)) {
            $condition = "trade_type = \"$tradeType\" ";

        } else if (!empty($location)) {
            $condition = "location = \"$location\" ";

        }
        if (!empty($date)) {
           // $inner = " AND t.user_id NOT IN (SELECT * FROM schedule s WHERE CAST(s.booked_date AS CHAR(10)) != $date)";
           $isAvailable = checkAvailability($date);
        } else {
            $isAvailable = true;
        }

        $q = "SELECT t.trade_type,t.location,t.hourly_rate, t.skills,u.first_name,u.last_name,u.email 
        FROM  tradesmen t JOIN  users u  ON t.user_id = u.user_id WHERE $condition $inner ;";
        echo $q;
        $result = mysqli_query($this->getDbc(), $q);
        
        $tradesmen_array = array();
        if (null != $result && $result->num_rows > 0) {


            while ($row = $result->fetch_assoc()) {
                $tradesman = new Tradesman();
                $tradesman->setFName($row['first_name']);
                $tradesman->setLName($row['last_name']);
                $tradesman->setEmail($row['email']);
                $tradesman->setTradeType($row['trade_type']);
                $tradesman->setLocation($row['location']);
                $tradesman->setHourlyRate($row['hourly_rate']);
                $tradesman->setSkills($row['skills']);
               
                $tradesman->setAvailability($isAvailable);
                $tradesmen_array[] = $tradesman;

            }
        }

        // $this->dbc->close();
        return $tradesmen_array;
    }
    public function searchByPin($tId)
    {

    }
private function checkAvailability($date) {
    //sql query to find dates booked
    $isAvailable = false;
    return $isAvailable;
}

}
?>