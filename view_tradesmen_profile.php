<?php
session_start();
if (isset($_SESSION['email'])) { 		// if the SESSION 'user_id' is  set...
    $userId = $_SESSION['email'];
} else {
	include('includes/header.html');
}
?>
<?php
//get loggedin id and retrieve tradesmen profile.
?>