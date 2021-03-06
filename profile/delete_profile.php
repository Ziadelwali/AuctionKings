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

        switch ($_SERVER['REQUEST_METHOD'])
			{
				case 'GET':
                ?>
                <!--the form hasn't been posted yet, display it-->
                <!-- Deletion -->
                <p><h4>Click button to delete profile and be logged out.</h4></p>
			<form method='post' action='delete_profile.php'>
				<center><input type='submit' value='Delete profile' /></center></form>
                <?php
                break;
                case 'POST':

                $stat = 1;

                if ($upd_stmt = $dbcon->prepare("UPDATE account set status = ? WHERE id_account=".$_SESSION['user_id'].""))
			{

				$upd_stmt->bind_param('i', $stat);

				// Execute the prepared query.
				$upd_stmt->execute();

				//Success
				//header("Location: ../testitems/activateprofile.php");		// This is for test automation of the delete profile test case.
				header("Location: ../index.php?logError=6");	// Use this for ordinary use of the site, for deactivation of profile.
				exit;
			}
			else
			{
				//something went wrong, display the error
				echo 'Something went wrong';
				exit;
			}
                break;
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