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
    public function createAccount()
    {
        //1. insert into users table
        //2. get userid
        //3. insert into tradesman table with userid as FK.
        if (parent ::createAccount()) {
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
        $q = "SELECT t.trade_type,t.location,t.hourly_rate, t.skills,t.user_id,u.first_name,u.last_name,u.email 
        FROM  tradesmen t JOIN  users u  ON t.user_id = u.user_id WHERE t.user_id = $tId ;";
        //echo $q;
        $result = mysqli_query($this->getDbc(), $q);
        if (null != $result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $this->setValues($this, $row, null);
            }
        }
        return $this;
    }
    public function updateProfile($tId)
    {

    }

    public function deleteProfile($tId)
    {

    }
    private function setValues($tradesman, $row, $isAvailable)
    {
        $tradesman->setUId($row['user_id']);
        $tradesman->setFName($row['first_name']);
        $tradesman->setLName($row['last_name']);
        $tradesman->setEmail($row['email']);
        $tradesman->setTradeType($row['trade_type']);
        $tradesman->setLocation($row['location']);
        $tradesman->setHourlyRate($row['hourly_rate']);
        $tradesman->setSkills($row['skills']);
        if (null != $isAvailable) {

            $tradesman->setAvailability($isAvailable);
        }
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

        $q = "SELECT t.trade_type,t.location,t.hourly_rate, t.skills,t.user_id,u.first_name,u.last_name,u.email 
        FROM  tradesmen t JOIN  users u  ON t.user_id = u.user_id WHERE $condition $inner ;";
        $result = mysqli_query($this->getDbc(), $q);

        $tradesmen_array = array();
        if (null != $result && $result->num_rows > 0) {


            while ($row = $result->fetch_assoc()) {
                $tradesman = new Tradesman();
                if (!empty($date)) {
                    // $inner = " AND t.user_id NOT IN (SELECT * FROM schedule s WHERE CAST(s.booked_date AS CHAR(10)) != $date)";
                    $isAvailable = $this->checkAvailability($date, $row['user_id']);
                } else {
                    $isAvailable = true;
                }
                $this->setValues($tradesman, $row, $isAvailable);

                $tradesmen_array[] = $tradesman;

            }
        }

        // $this->dbc->close();
        return $tradesmen_array;
    }
    public function searchByPin($tId)
    {

    }
    private function checkAvailability($date, $id)
    {
        //sql query to find dates booked
        $q = "SELECT * FROM schedule WHERE user_id = $id AND booked_date = '$date';";
        $result = mysqli_query($this->getDbc(), $q);
        if (null != $result && $result->num_rows > 0) {
            $isAvailable = false;
        } else {

            $isAvailable = true;
        }
        return $isAvailable;
    }

}
?>