<?php

session_start();
if (
    isset($_SESSION['actor']['first_name']) &&
    isset($_SESSION['actor']['last_name']) &&
    isset($_SESSION['actor']['id'])
) {
    $page_title = "Welcome {$_SESSION['actor']['first_name']}";
    include('includes/loggedin_header.html');

    echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";

} else {
    include('includes/header.html');

}
?>
<div class="grid-container">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Trade Type</th>
                <th scope="col">Hourly Rate (£)</th>
                <th scope="col">Skills</th>
                <th scope="col">Availability</th>
                <th scope="col">Pro Registration</th>
                <th scope="col">View</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                include "classes/tradesman.php";

                $errors = array();
                $tradesmen = new Tradesman();
                if (((empty($_GET['trade']) || $_GET['trade'] == "Select") && empty($_GET['location'])) && isset($_GET['work_date'])) {
                    $errors[] = 'Enter trade type or location to find a trader';
                }
                if (isset($_GET['trade']) && $_GET['trade'] != "Select") {
                    echo $_GET['trade'];
                    $tradesmen->setTradeType(strtolower(trim($_GET['trade'])));
                }
                if (isset($_GET['location'])) {

                    $tradesmen->setLocation(strtolower(trim($_GET['location'])));
                }
                if (isset($_GET['work_date'])) {
                    $searchDate = $_GET['work_date'];
                }
                if (empty($errors)) {
                    $resultList = $tradesmen->searchTradesmen($tradesmen->getTradeType(), $tradesmen->getLocation(), $searchDate);
                    if (!$resultList) {
                        echo "<h2> No results found!</h2>";
                    } else {
                        echo '<table class="table table-bordered">';
                        //loop tradesmen data
                        for ($i = 0; $i < count($resultList); $i++) {

                            $tradesman = $resultList[$i];
                            echo '<tr>'
                                . '<td>' . $tradesman->getFName() . '</td>'
                                . '<td>' . $tradesman->getLName() . '</td>'
                                . '<td>' . $tradesman->getEmail() . '</td>'
                                . '<td>' . $tradesman->getTradeType() . '</td>'
                                . '<td>' . $tradesman->getHourlyRate() . '</td>'
                                . '<td>' . $tradesman->getSkills() . '</td>';
                            if ($tradesman->getAvailability() == 1) {
                                echo '<td><button class="available" type="button" disabled>Available</button></td>';
                            } else {

                                echo '<td><button class="not-available" type="button" disabled>Booked</button></td>';
                            }
                            echo '<td>' . $tradesman->getProfessionalRegNo() . '</td>';
                            echo '<td>'
                                . '<form action="view_tradesmen_profile.php" method="post">'
                                . '<button name="view-id" type="submit" value="' . $tradesman->getUId() . '">View</button>'
                                . '</form>'
                                . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';

                    }
                } else {
                    foreach ($errors as $msg) {
                        echo " - $msg<br>";
                    }
                }

            }
            ?>
        </tbody>
    </table>
</div>

<?php
include("includes/footer.html");
?>