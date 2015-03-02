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

		//Headline
		echo '<h4>Welcome to your profile settings page for the username : <u>'.$_SESSION['username'].'</u></br></h4>';
		//Edit username link
		echo '</br></br><p>Your current username is : '.$_SESSION['username'].'<p>';
		echo '<p>To edit your username, press the link: <a href="updateusername.php">Update username</a></p>';
		//Edit email adress link
		echo '</br></br><p>Your current email adress are : '.$_SESSION['email'].'<p>';
		echo '<p>To edit your username, press the link: <a href="updatemail.php">Update email</a></p>';
		//Edit password link
		echo '</br></br><p>To edit your password, press the link : <a href="updatepassword.php">Update password</a></p>';
        //Delete profile
		echo '</br></br><p>To delete your profile, press the link : <a href="delete_profile.php">Delete profile</a></p>';

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