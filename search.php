<?php
include("includes/header.html");
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
                <th scope="col"> </th>
            </tr>
        </thead>
        <tbody>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                include "classes/tradesman.php";

                $errors = array();
                $tradesmen = new Tradesman();
                if ((empty($_GET['trade']) && empty($_GET['location'])) && isset($_GET['work_date'])) {
                    $errors[] = 'Enter trade type or location to find a trader';
                }
                if (isset($_GET['trade'])) {

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
                            
                            $tardesman = $resultList[$i];
                            echo '<tr>'
                                . '<td>' . $tardesman->getFName() . '</td>'
                                . '<td>' . $tardesman->getLName() . '</td>'
                                . '<td>' . $tardesman->getEmail() . '</td>'
                                . '<td>' . $tardesman->getTradeType() . '</td>'
                                . '<td>' . $tardesman->getHourlyRate() . '</td>'
                                . '<td>' . $tardesman->getSkills() . '</td>';
                            if ($tardesman->getAvailability() == 1) {
                                echo '<td><button class="available" type="button" disabled>Available</button></td>';
                            } else {

                                echo '<td><button class="not-available" type="button" disabled>Booked</button></td>';
                            }
                            
                            echo '<td>'
                            .'<form action="view_tradesmen_profile.php" method="post">'
                            .'<button name="view-id" type="submit" value="'.$tardesman->getUId().'">View</button>'
                            .'</form>'
                            .'</td>';
                            //echo '<td>' . $tardesman->getAvailability() . '</td>'
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