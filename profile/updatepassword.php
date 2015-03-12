<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	include '../secure/db_connect.php';
	include '../secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{

    	include 'profile_header.php';
    	
    	echo 'Logged in as : '.$_SESSION['username'];

		echo '<h4>This is where you can change your password for the username : <u>'.$_SESSION['username'].'</u></br></h4>';
		
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
		?>
		<!--the form hasn't been posted yet, display it-->
		<p></br>to change your password, enter your new password in the field below and submit it.</p>
		<center><form action="updatepassword.php" method="post" name="update_password_form" class="form-horizontal">
			<div class="control-group">
				<h4>Password</h4>
				<div class="controls">
					<input type="password" name="updPassword" id="password" placeholder="Password">
				</div>
			</div>
			<div class="control-group">
				<h4>Retype password</h4>
				<div class="controls">
					<input type="password" name="updPassword2" id="password2" placeholder="Retype Password">
					<input type="hidden" name="p">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<script src="../secure/forms.js"></script>
					<script src="../secure/sha512.js"></script>
					<p>Notice, when you update your password<br> you will be logged out and redirected to login page.</p>
					<input type="submit" class="btn" value="Update here" onclick="return checkAndSubmit2(this.form, this.form.updPassword, this.form.updPassword2);"></input>
					<!-- If update went successfull show everything ok info -->
					<?php if(isset($_GET['success'])) 
						{?>
						<p>You have sucessfully updated your password!</p>
					<?php }?>
					<!-- if update error show this -->
					<?php if(isset($_GET['updatefailed']))
						{?>
						<p>The update of our password did not go right somehow!</p>
					<?php }?>
					
				</div>
			</div>
		</form></center>
		<p></br><a href="profile.php">Go back!</a></p>
	</div>
</div>
<?php
}
else
{
	$password = $_POST['p'];
	// Create a random salt
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	// Create salted password
	$password = hash('sha512', $password.$random_salt);
	
	$userId = $_SESSION['user_id'];
	
	if ($update_stmt = $dbcon->prepare("UPDATE account set password = ?, salt = ? where id_account = ?")) 
	{
		$update_stmt->bind_param('ssi', $password, $random_salt, $userId);
		
		// Execute the prepared query.
		$update_stmt->execute();
		header("Location: ../logout.php");
		exit;
	}
	else
	{
		//echo ("Registration failed");
		header("Location: ?updatefailed=1");
		exit;
	}
}
include 'profile_footer.php';   
}
else if ($_SESSION['status'] == 1)
{
	header("Location: ../index.php?logError=5");
	// Destroy session
	session_destroy();
    exit;
}
else
{
	echo 'You are not authorized to access this page, please login. <br/>';
}

?>