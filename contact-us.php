<div class="container">

	<?php
	session_start();
	if (isset($_SESSION['user_id'])) { // if the SESSION 'user_id' is  set...
		include('includes/home_header.html');
	} else {
		include('includes/header.html');
	}
	?>

	<div class="form">
		<h3>Contact Sheffield Innovation Centre</h3>

		// ADD PHP CODE HERE //

		<p>Please fill out this form to contact Sheffield Innovation Centre.</p>
		<form action="contact-us.php" method="post" class="form-signin" role="form">
			<table width="60%">
				<tr>
					<td>Name: </td>
					<td><input type="text" name="name" size="30" maxlength="60"
							value="<?php if (isset($_POST['name']))
								echo $_POST['name']; ?>" /></td>
				</tr>
				<tr>
					<td>Email Address: </td>
					<td><input type="text" name="email" size="30" maxlength="80"
							value="<?php if (isset($_POST['email']))
								echo $_POST['email']; ?>" /></td>
				</tr>
				<tr>
					<td>Enquiry: </td>
					<td><textarea name="comments" rows="5"
							cols="30"><?php if (isset($_POST['comments']))
								echo $_POST['comments']; ?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<?php include('includes/footer.html') ?>