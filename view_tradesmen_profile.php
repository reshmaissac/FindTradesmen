<?php

session_start();
if (
	isset($_SESSION['actor']['first_name']) &&
	isset($_SESSION['actor']['last_name']) &&
	isset($_SESSION['actor']['id'])
) { // if the SESSION 'user_id' is  set...
	$userId = $_SESSION['actor']['id'];
	$page_title = "Welcome {$_SESSION['actor']['first_name']}";
	include('includes/loggedin_header.html');

	echo "You are now logged in, {$_SESSION['actor']['first_name']} {$_SESSION['actor']['last_name']}";

} else {
	include('includes/header.html');
	require('login_tools.php');
	load();

	//include('includes/header.html');
}
?>
<?php
//get loggedin id and retrieve tradesmen profile.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include "classes/tradesman.php";

	if (isset($_POST['view-id'])) {
		$tradesman = new Tradesman();
		$tradesman = $tradesman->retrieveProfile($_POST['view-id']);
		echo "FName = " . $tradesman->getFName() . "<br/>";
		echo "LName = " . $tradesman->getLName() . "<br/>";
		echo "TradeType = " . $tradesman->getTradeType() . "<br/>";
		echo "Location = " . $tradesman->getLocation() . "<br/>";
		echo "HourlyRate = " . $tradesman->getHourlyRate() . "<br/>";
		echo "Skills = " . $tradesman->getSkills() . "<br/>";
		echo "<br/>";


	}
}
?>


<br/>//add view-profile page (html elements) <br />
//if its loggedin user, show rate button, else if its loggedin tradesman, show update/delete profile button.

<form action="register_tradesman.php" method="post" class="form-signin" role="form">
	<h3 class="form-signin-heading">Update Profile</h3>
	<fieldset>
		<legend class="form__legend">Your details</legend>
		<input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name']))
			echo $_POST['first_name']; ?>" placeholder="First Name">
		<input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name']))
			echo $_POST['last_name']; ?>" placeholder="Last Name">
	</fieldset>
	<fieldset>
		<legend class="form__legend">Your contact details</legend>
		<input type="text" name="contact_no" size="50" value="<?php if (isset($_POST['contact_no']))
			echo $_POST['contact_no']; ?>" placeholder="Contact No">
	</fieldset>
	<fieldset>
		<legend class="form__legend">Your trade details</legend>
		<label for="trade_types">Choose your trade:</label>
		<select name="trade_types" id="trade_types">
			<option value="electrician">Electrician</option>
			<option value="plumber">Plumber</option>
			<option value="builder">Builder</option>
			<option value="carpenter">Carpenter</option>
		</select>
		<input type="text" name="location" size="50" value="<?php if (isset($_POST['location']))
			echo $_POST['location']; ?>" placeholder="Your working location">
		<input type="text" name="hourly_rate" size="50" value="<?php if (isset($_POST['hourly_rate']))
			echo $_POST['hourly_rate']; ?>" placeholder="Hourly rate">
		<input type="text" name="skills" size="50" value="<?php if (isset($_POST['skills']))
			echo $_POST['skills']; ?>" placeholder="List your skills (eg. wiring, tiling)">
	</fieldset>
	<p><button class="btn btn-primary" name="submit" type="submit">Create</button></p>
</form>
<?php

include('includes/footer.html');
?>