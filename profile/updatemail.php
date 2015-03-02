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
		
		echo '<h4>This is where you can change your email, for the username: <u>'.$_SESSION['username'].'</u></br></h4>';
		
		//Updating the email field :
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
		?>
		<!--the form hasn't been posted yet, display it-->
		<center><p>Your current email adress are: <? echo $_SESSION['email']; ?>
		</br>to change your email adress, enter your new email adress in the field below and submit it.</p>
		<form method='post' action='updatemail.php'>
			</br>New email adress: 
			<input type='email' name='email' />
		<input type='submit' value='Change Email'/></center>
		</form>
		<p></br><a href="profile.php">Go back!</a></p>
		<?php
		}
		else
		{
			$updateEmail = mysqli_real_escape_string($dbcon, $_POST['email']);
			//the form has been posted, so save it
			$sql = "UPDATE members SET email='". $updateEmail ."' WHERE id=".$_SESSION['user_id']."";
			$result = mysqli_query($dbcon, $sql);
			// Prepared statements
			/*
				//$userId = $_SESSION['user_id'];
				$updateEmail = mysqli_real_escape_string($mysqli, $_POST['email']);
				$query = "UPDATE members SET email=? WHERE id=".$_SESSION['user_id']."";
				$statement = $mysqli->prepare($query);
				
				//bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
				$results =  $statement->bind_param('s', $updateEmail);
			*/
			
			if(!$result)
			{
				//something went wrong, display the error
				echo 'Error : ' . mysqli_error($dbcon);
			}
			else
			{
				echo 'New email successfully added.</br><a href="profile.php">Go back!</a>';
				$_SESSION['email'] = $updateEmail;
			}
		} //End of updating email field
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