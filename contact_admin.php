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
	    
	    echo 'Logged in as : '.$_SESSION['username'].'<br><br>';
	    
	    switch ($_SERVER['REQUEST_METHOD'])
	    {
	    	case 'GET':
	    
?>
<center>
	<form method='POST'>
		<textarea name="admin_message" rows="6" cols="40"
			value="<?php echo isset($_POST['admin_message']) ? $_POST['admin_message'] : '' ?>"></textarea>
		<br>
		<input type='submit' value='Submit'>
	</form>
</center>

<?php

break;
case 'POST':
	if (isset($_POST['admin_message']))
	{
		$admin_message = $_POST['admin_message'];
		
		$query= "INSERT INTO admincontact (admin_message) VALUES (?)";
		
		//the form has been posted, so save it
		if ($insert_stmt = $dbcon->prepare($query))
		{
			$insert_stmt->bind_param('s', $admin_message);
		
			// Execute the prepared query.
			$insert_stmt->execute();
		
			//Success
			//header("Location: homepage.php?catSuccess=1");
			echo "Message has been sent to admin";
		}
		else
		{
			//something went wrong, display the error
			//header("Location: homepage.php?catError=3");
			echo 'something went wrong';
			exit;
		}
		
	}
	}
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