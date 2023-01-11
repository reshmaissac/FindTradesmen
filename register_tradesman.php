<div class="container">

	<?php include "includes/header.html"
		?>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include "classes/tradesman.php";
		$errors = array();
		$tradesman = new Tradesman();
		$tradesman->setIsTradesman(1);

		if (empty($_POST['first_name'])) {
			$errors[] = 'Enter your first name.';
		} else {
			$tradesman->setFName(trim($_POST['first_name']));
			
		}
		if (empty($_POST['last_name'])) {
			$errors[] = 'Enter your last name.';
		} else {
			$tradesman->setLName(trim($_POST['last_name']));

		}
		if (empty($_POST['email'])) {
			$errors[] = 'Enter your email.';
		} else {
			$tradesman->setEmail(trim($_POST['email']));
			
		}
		if (empty($_POST['contact_no'])) {
			$errors[] = 'Enter your contact no.';
		} else {
			$tradesman->setContactNo(trim($_POST['contact_no']));
		}

		if (empty($_POST['trade_types'])) {
			$errors[] = 'Enter your trade type';
		} else {
			$tradesman->setTradeType(trim($_POST['trade_types']));
		}
		if (empty($_POST['location'])) {
			$errors[] = 'Enter your trade location';
		} else {
			$tradesman->setLocation(trim($_POST['location']));
		}
		if (empty($_POST['hourly_rate'])) {
			$errors[] = 'Enter your hourly rate';
		} else {
			$tradesman->setHourlyRate(trim($_POST['hourly_rate']));
		}
		if (isset($_POST['prof_reg_no'])) {
			$tradesman->setProfessionalRegNo(trim($_POST['prof_reg_no']));
		} else {
			$tradesman->setProfessionalRegNo(' ');
		}
		if (empty($_POST['skills'])) {
			$errors[] = 'Enter your trade skills';
		} else {
			$tradesman->setSkills(trim($_POST['skills']));
		}

		//verify password
		if (!empty($_POST['pass1'])) {
			if ($_POST['pass1'] != $_POST['pass2']) {
				$errors[] = 'Passwords do not match.';
			} else {
				$tradesman->setPassword(trim($_POST['pass1']));
			}
		} else {
			$errors[] = 'Enter your password.';
		}
		//check if email exists in db
		if (empty($errors)) {

			$r = $tradesman->checkIfUserExists();
			$rowcount = $r->num_rows;
			if ($rowcount != 0) {
				$errors[] = 'Email address already registered. <a href="login.php">Login</a>';
			}
		}
		//if no errors, insert data to db
		if (empty($errors)) {

			if ($tradesman->createAccount()) {
				echo '<h1>Registered!</h1>
				<p>You are now registered.</p>
				<p><a href="login.php">Login</a></p>';
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
	<!-- ............................................. -->

	<div class="form-style">
		<h1>Sign Up Now!<span>Looking for Works.</span></h1>
		<form action="register_tradesman.php" method="post" class="form-signin" role="form">

			<div class="section"><span>1</span>Your Details</div>
			<div class="inner-wrap">

				<input type="text" name="first_name" size="20" value="<?php if (isset($_POST['first_name']))
					echo $_POST['first_name']; ?>" placeholder="First Name">
				<input type="text" name="last_name" size="20" value="<?php if (isset($_POST['last_name']))
					echo $_POST['last_name']; ?>" placeholder="Last Name">

			</div>

			<div class="section"><span>2</span>Your Contact Details</div>
			<div class="inner-wrap">

				<input type="text" name="email" size="50" value="<?php if (isset($_POST['email']))
					echo $_POST['email']; ?>" placeholder="Email Address">
				<input type="text" name="contact_no" size="50" value="<?php if (isset($_POST['contact_no']))
					echo $_POST['contact_no']; ?>" placeholder="Contact No">
			</div>

			<div class="section"><span>3</span>Your trade Details</div>
			<div class="inner-wrap">

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
				<input type="text" name="prof_reg_no" size="50" value="<?php if (isset($_POST['prof_reg_no']))
					echo $_POST['prof_reg_no']; ?>" placeholder="Professional Registration No (Optional)">
				<input type="text" name="skills" size="50" value="<?php if (isset($_POST['skills']))
					echo $_POST['skills']; ?>" placeholder="List your skills (eg. wiring, tiling)">

			</div>

			<div class="section"><span>4</span>Passwords</div>
			<div class="inner-wrap">

				<input type="password" name="pass1" size="20" value="<?php if (isset($_POST['pass1']))
					echo $_POST['pass1']; ?>" placeholder="Password">
				<input type="password" name="pass2" size="20" value="<?php if (isset($_POST['pass2']))
					echo $_POST['pass2']; ?>" placeholder="Confirm Password">

			</div>

			<div class="button-section">
				<button class="sumit-btn" name="submit" type="submit">Create</button>
			</div>
		</form>

	</div>

	<!-- ............................................. -->
</div>

<?php include "includes/footer.html" ?>