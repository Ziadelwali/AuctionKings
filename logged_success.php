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
	<div class="container-fluid" id="mainwrapper">
		<div class="container-fluid" id="content">
			<form><h4>Congratulations <? echo $_SESSION['username'] ?>.<br/>You are logged in! <br/><br/>
				<img src="img/giphy.gif" alt="Smiley bear" height="100" width="100">
			<br/>Navigate through the website at the navigation bar in the top of the page!</h4></form>
		</div>
	</div>
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
