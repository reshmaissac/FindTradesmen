<div class="website-container">

	<?php include "includes/header.html" ?>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		include "classes/user.php";
		$errors = array();
		$user = new User();
		$user->setIsTradesman(0);

		if (empty($_POST['first_name'])) {
			$errors[] = 'Enter your first name.';
		} else {
			$user->setFName(trim($_POST['first_name']));
		}
		if (empty($_POST['last_name'])) {
			$errors[] = 'Enter your last name.';
		} else {
			$user->setLName(trim($_POST['last_name']));
		}
		if (empty($_POST['email'])) {
			$errors[] = 'Enter your email.';
		} else {
			$user->setEmail(trim($_POST['email']));
		}
		if (empty($_POST['contact_no'])) {
			$errors[] = 'Enter your contact no.';
		} else {
			$user->setContactNo(trim($_POST['contact_no']));
		}
		//verify password
		if (!empty($_POST['pass1'])) {
			if ($_POST['pass1'] != $_POST['pass2']) {
				$errors[] = 'Passwords do not match.';
			} else {
				$user->setPassword(trim($_POST['pass1']));
			}
		} else {
			$errors[] = 'Enter your password.';
		}
		//check if email exists in db
		if (empty($errors)) {
			$r = $user->checkIfUserExists();
			$rowcount = $r->num_rows;
			if ($rowcount != 0) {
				$errors[] = 'Email address already registered. <a href="login.php">Login</a>';
			}
		}
		//if no errors, insert data to db
		if (empty($errors)) {
			if ($user->createAccount()) {
				echo '<h1 class="register-txt">Registered!</h1>
				  <p>You are now registered.</p>
				  <p class="btn-login"><a href="login.php">Login</a></p>';
			}

			/*include('includes/footer.html');*/
			exit();
		} else {
			echo '<h1 class="register-txt">Error!</h1>
			 <p id="err_msg">The following error(s) occurred:<br>';
			foreach ($errors as $msg) {
				echo " - $msg<br>";
			}
			echo 'Please try again.</p>';
		}

	}
	?>

	<!-- Display body section with sticky form. -->

	<div class="form-style">
		<h1>Sign Up Now!<span>Hiring for the Projects.</span></h1>
		<form action="register_user.php" method="post" class="form-signin" role="form">
			<div class="section"><span>1</span>Your details</div>
			<div class="inner-wrap">

				<input type="text" name="first_name" size="20"
					value="<?php if (isset($_POST['first_name']))
						echo $_POST['first_name']; ?>"
					placeholder="First Name">
				<input type="text" name="last_name" size="20"
					value="<?php if (isset($_POST['last_name']))
						echo $_POST['last_name']; ?>" placeholder="Last Name">

			</div>

			<div class="section"><span>2</span>Your contact details</div>
			<div class="inner-wrap">

				<input type="email" name="email" size="50"
					value="<?php if (isset($_POST['email']))
						echo $_POST['email']; ?>" placeholder="Email Address">
				<input type="text" name="contact_no" size="50"
					value="<?php if (isset($_POST['contact_no']))
						echo $_POST['contact_no']; ?>"
					placeholder="Contact No">

			</div>



			<div class="section"><span>3</span>Passwords</div>
			<div class="inner-wrap">

				<input type="password" name="pass1" size="20" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
					title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters"
					value="<?php if (isset($_POST['pass1']))
						echo $_POST['pass1']; ?>" placeholder="Password">
				<input type="password" name="pass2" size="20" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
					title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters"
					value="<?php if (isset($_POST['pass2']))
						echo $_POST['pass2']; ?>" placeholder="Confirm Password">

			</div>

			<div class="button-section">
				<button class="sumit-btn" name="submit" type="submit">Register</button>
			</div>
		</form>

	</div>


	<?php include "includes/footer.html" ?>

</div>