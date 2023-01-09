<?php 
session_start();

if (!isset($_SESSION['actor']['id'])) { 
    require ('login_tools.php');
    load();
}
include ('includes/header.html');
$_SESSION = array();
session_destroy();

echo "<h1>Goodbye!</h1>
    <p>You are now logged out.</p>";

include ('includes/footer.html');

?>
