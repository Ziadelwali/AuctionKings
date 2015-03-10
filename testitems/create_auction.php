<?php
	
	/*
		* @author     Ziad El-Wali <Ziadelwali@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'header.php';
	?>
	
	
	<h1>Create you own auction with buyers from all over the world</h1>
	<a href="uploadimg/upload_image.php">Upload billed<a>
		<br/><br/><br/>
		<form action="action_page.php">
			<textarea name="message" rows="10" cols="30">
				Write here to tell about the item.
			</textarea>
			<br><br>
			<input type="submit" value="Submit">
		</form>
		
		
		
		
		<?php
			include 'footer.php';
		}
		else if ($_SESSION['status'] == 1)
		{
			header("Location: index.php?logError=5");
			// Destroy session
			session_destroy();
			exit;
		}
		else
		{
			echo 'You are not authorized to access this page, please login. <br/>';
		}
	?>	