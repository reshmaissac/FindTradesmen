<?php
//submit_rating.php
include('classes/rating.php');
require('login_tools.php');
$connect = new PDO("mysql:host=localhost;dbname=findtradesmen", "root", "");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rating = new Rating();
    $rating->setUserId($_POST["user_name"]);
    $rating->setTId($_POST["tradesman_id"]);
    $rating->setRating($_POST["rating_data"]);
    $rating->setReview($_POST["user_review"]);
    //$result = $rating->rateTradesman();
    if ($rating->rateTradesman()) {

        echo "Your Review & Rating Successfully Submitted";
        $avdRate = $rating->retrieveAvgRatings();
        //$_SESSION['avgRate'] = $avdRate;

    }

}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "
	SELECT * FROM review_table 
	ORDER BY review_id DESC
	";

    $result = $connect->query($query, PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $review_content[] = array(
            'user_name' => $row["user_name"],
            'user_review' => $row["user_review"],
            'rating' => $row["user_rating"],
            'datetime' => date('l jS, F Y h:i:s A', $row["datetime"])
        );

        if ($row["user_rating"] == '5') {
            $five_star_review++;
        }

        if ($row["user_rating"] == '4') {
            $four_star_review++;
        }

        if ($row["user_rating"] == '3') {
            $three_star_review++;
        }

        if ($row["user_rating"] == '2') {
            $two_star_review++;
        }

        if ($row["user_rating"] == '1') {
            $one_star_review++;
        }

        $total_review++;

        $total_user_rating = $total_user_rating + $row["user_rating"];

    }

    $average_rating = $total_user_rating / $total_review;

    $output = array(
        'average_rating' => number_format($average_rating, 1),
        'total_review' => $total_review,
        'five_star_review' => $five_star_review,
        'four_star_review' => $four_star_review,
        'three_star_review' => $three_star_review,
        'two_star_review' => $two_star_review,
        'one_star_review' => $one_star_review,
        'review_data' => $review_content
    );

    echo json_encode($output);

}

?>