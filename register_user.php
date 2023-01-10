<?php include "includes/header.html"
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//require ('includes/connect_db.php');
    include "classes/user.php";
	$errors = array();
    $user = new User();
	$user->setIsTradesman(0);

	if (empty($_POST['first_name'])) {
		$errors[] = 'Enter your first name.'; 
	} else {
        $user->setFName(trim($_POST['first_name']));
		// $fn = trim($_POST['first_name']); 
	}
	if (empty($_POST['last_name'])) {
		$errors[] = 'Enter your last name.'; 
	} else {
        $user->setLName(trim($_POST['last_name']));

		//$ln = trim($_POST['last_name']); 
	}
	if (empty($_POST['email'])) {
		$errors[] = 'Enter your email.'; 
	} else {
        $user->setEmail(trim($_POST['email']));
		//$e = $dbc->real_escape_string(trim($_POST['email'])); 
	}
    if (empty($_POST['contact_no'])) {
		$errors[] = 'Enter your contact no.'; 
	} else {
        $user->setContactNo(trim($_POST['contact_no']));
		//$e = $dbc->real_escape_string(trim($_POST['email'])); 
	}
	//verify password
	if (!empty($_POST[ 'pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) { 
				$errors[] = 'Passwords do not match.'; 
			}
			else { 
                $user->setPassword(trim($_POST['pass1']));
				//$p = $dbc->real_escape_string(trim($_POST['pass1']));
			}
	} else 
	{
			$errors[] = 'Enter your password.';
	}
	//check if email exists in db
	if (empty($errors)) {
		$r = $user->checkIfUserExists();
		$rowcount = $r->num_rows;
		if ($rowcount != 0){
			$errors[] = 'Email address already registered. <a href="login.php">Login</a>' ; 
		} 
	}
	//if no errors, insert data to db
	if (empty($errors)) {
		if ($user->createAccount()) { 
			echo '<h1>Registered!</h1>
				<p>You are now registered.</p>
				<p><a href="login.php">Login</a></p>'; 
		}
		//$dbc->close();
		include ('includes/footer.html'); 
		exit();
	}
	else {
		echo '<h1>Error!</h1>
			 <p id="err_msg">The following error(s) occurred:<br>';
		foreach ($errors as $msg) {
			echo " - $msg<br>";
		}
		echo 'Please try again.</p>';
		//$dbc->close();
	}  
	
	
}
?>
<!-- Display body section with sticky form. -->
<form action="register_user.php" method="post" class="form-signin" role="form">
	<h2 class="form-signin-heading">Create an Account</h2>
    <fieldset>
    <legend class="form__legend">Your details</legend>
	<input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" placeholder="First Name"> 
	<input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" placeholder="Last Name">
    </fieldset>
    <fieldset>
    <legend class="form__legend">Your contact details</legend>
	<input type="text" name="email" size="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email Address">
    <input type="text" name="contact_no" size="50" value="<?php if (isset($_POST['contact_no'])) echo $_POST['contact_no']; ?>" placeholder="Contact No">
    </fieldset>
	<input type="password" name="pass1" size="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" placeholder="Password">
	<input type="password" name="pass2" size="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" placeholder="Confirm Password">
	<p><button class="btn btn-primary" name="submit" type="submit">Register</button></p>
</form>


<?php include "includes/footer.html"
?>