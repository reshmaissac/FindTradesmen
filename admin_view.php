<div class="container">
    <?php
    include_once("session.php");
    loadAdminPermissions();
    ?>

    <div class="grid-container">

        <h3>List of Registered Users<h3>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Is Tradesman?</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            include "classes/user.php";

                            $errors = array();
                            $userObj = new User();

                            $allUsers = $userObj->getAllUsers();
                            if (!$allUsers) {
                                echo "<h2> No results found!</h2>";
                            } else {
                                echo '<table class="table table-bordered">';
                                //loop tradesmen data
                                for ($i = 0; $i < count($allUsers); $i++) {

                                    $user = $allUsers[$i];
                                    echo '<tr>'
                                        . '<td>' . $user->getFName() . '</td>'
                                        . '<td>' . $user->getLName() . '</td>'
                                        . '<td>' . $user->getEmail() . '</td>'
                                        . '<td>' . $user->getContactNo() . '</td>'
                                        . '<td>' . $user->getIsTradesman() . '</td>';

                                    echo '</tr>';
                                }
                                echo '</table>';

                            }


                        }
                        ?>
                    </tbody>
                </table>
    </div>

    <?php
    include("includes/footer.html")
        ?>