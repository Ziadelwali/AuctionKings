<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	include 'secure/db_connect.php';
	include 'secure/functions.php';
	sec_session_start();
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'header.php';
	?>
	
	
	
	
	
	
	
	
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
