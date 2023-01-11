<?php
include_once('includes/connect_db.php');
class Rating extends DBConnection
{
    private $userId;
    private $tId;
    private $rating;
    private $review;
    private $dbc;
    public function getDbc()
    {
        return $this->dbc;
    }

    function __construct()
    {
        $this->dbc = $this->getConnection();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId 
     * @return self
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTId()
    {
        return $this->tId;
    }

    /**
     * @param mixed $tId 
     * @return self
     */
    public function setTId($tId): self
    {
        $this->tId = $tId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating 
     * @return self
     */
    public function setRating($rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param mixed $review 
     * @return self
     */
    public function setReview($review): self
    {
        $this->review = $review;
        return $this;
    }


    public function rateTradesman()
    {

        $userId = $this->getDbc()->real_escape_string($this->getUserId());
        $tradesmanId = $this->getDbc()->real_escape_string($this->getTId());
        $rating = $this->getDbc()->real_escape_string($this->getRating());
        $review = $this->getDbc()->real_escape_string($this->getReview());
        $q = "INSERT INTO rating 
        (user_id, tradesman_user_id, rating, description, date) 
        VALUES ($userId, $tradesmanId, $rating, '$review', NOW())";

        $r = mysqli_query($this->getDbc(), $q);
        return $r;
    }

    public function retrieveAvgRatings()
    {
        $average_rating = 0;
        $total_user_rating = 0;
        $rating_count = 0;
        $tradesmanId = $this->getDbc()->real_escape_string($this->getTId());
        $query = "SELECT * FROM rating WHERE tradesman_user_id = $tradesmanId";
        $result = mysqli_query($this->getDbc(), $query);
        if ($result->num_rows > 0) {
            foreach ($result as $row) {
                $total_user_rating = $total_user_rating + $row["rating"];
                $rating_count++;
            }
            $average_rating = $total_user_rating / $rating_count;
        }
        return $average_rating;
    }
}

?>