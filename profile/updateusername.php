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
		echo '<h4>This is where you can change your username.</br></h4>';
		
		//Updating the username field :
		switch ($_SERVER['REQUEST_METHOD'])
		{
		case 'GET':
		?> 
		<!--the form hasn't been posted yet, display it-->
		<center><p>Your current username is:<b> <?php echo $_SESSION['username']  ?></b>
		</br>to change your username, enter your new username in the field below and submit it.</p>
		<form method='post' action='updateusername.php'>
			</br>New username: 
			<input type='text' name='newUsername' />
		<input type='submit' value='Change username' /></center>
		</form>
		<p></br><a href="profile.php">Go back!</a></p>
		<?php
		break;
		
		case 'POST':
			$UpdateUsername = mysqli_real_escape_string($dbcon, $_POST['newUsername']);
			//the form has been posted, so save it
			$sql = "UPDATE members SET username='". $UpdateUsername ."' WHERE id=".$_SESSION['user_id']."";
			$result = mysqli_query($dbcon, $sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'Error : ' . mysqli_error($dbcon);
			}
			else
			{
				echo 'New username successfully added.</br><a href="profile.php">Go back!</a>';
				$_SESSION['username'] = $UpdateUsername;
			}
			break;
		} //End of updating username field
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