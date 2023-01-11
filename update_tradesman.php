<div class="container">

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
		require('login_tools.php');
		load();
	}
	?>
	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include "classes/tradesman.php";
		$errors = array();
		$tradesman = new Tradesman();
		$tradesman->setIsTradesman(1);
		$userId = $_SESSION['actor']['id'];

		if (empty($_POST['trade_type'])) {
			$errors[] = 'Enter your trade type.';
		} else {
			$tradesman->setTradeType(trim($_POST['trade_type']));

		}
		if (empty($_POST['location'])) {
			$errors[] = 'Enter your location.';
		} else {
			$tradesman->setLocation(trim($_POST['location']));

		}
		if (empty($_POST['hour_rate'])) {
			$errors[] = 'Enter your hourly rate.';
		} else {
			$tradesman->setHourlyRate(trim($_POST['hour_rate']));
		}
		if (empty($_POST['skills'])) {
			$errors[] = 'Enter your skills.';
		} else {
			$tradesman->setSkills(trim($_POST['skills']));

		}

		//if no errors, update tradesman table
		if (empty($errors)) {
			
			if ($tradesman->updateProfile($userId)) {
				echo '<h1>Profile Updated!</h1>';
				echo '<a href="view_tradesmen_profile.php">
      				<input class="css-input-btn-login" type="submit" value="View Profile"/>
  					</a>';
			}

			include('includes/footer.html');
			exit();
		} else {
			echo '<h1>Error!</h1>
			 <p id="err_msg">The following error(s) occurred:<br>';
			foreach ($errors as $msg) {
				echo " - $msg<br>";
			}
			echo 'Please try again.</p>';

		}






	}
	?>
</div>