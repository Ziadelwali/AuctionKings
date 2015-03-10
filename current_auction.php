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
	
	
	<h2>old vase</h2>
	<a href="logIn.html"><img src="vase3.jpg" alt="The picture could not be found" style="width:304px;height:228px"></a>
	<p>
		The vase's is very old. Hurry up to bit.
	</p>
	<!--The dates will I suggest php should handle.-->
	<p>
		Start date:  20-02-2015. ----->  End date 25-02-2015
	</p>
	<p>
		Shipping detail: Buyer pays.
	</p>
	<p>
		Auction ends in: x hour
	</p>
	<br></br>
	<p>
		Current price: DKK 450
	</p>
	<p>
		Your bid:
		<input type="number" name="quantity" min="1" ><br></br>
	</p>
	<input type="submit" value="Submit">
	
	<br></br>
	<input type="submit" value="Follow auction">
	
	
	
	
	
	
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