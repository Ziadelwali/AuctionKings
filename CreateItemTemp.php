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
	
		<h1>Create Auction</h1>
<form method='POST' enctype="multipart/form-data">
    <fieldset>
        <legend>Add item details</legend>
        <div class="container">
            Title: <br><input type='text' name='title'
                        value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"><br><br>
			Description:<br><textarea name="description" rows="6" cols="40"
						value="<?php echo isset($_POST['description']) ? $_POST['description'] : '' ?>"></textarea><br><br>
            Your minimum price: <br><input type='number' name='minPrice' min="0"
                        value="<?php echo isset($_POST['minPrice']) ? $_POST['minPrice'] : '' ?>"><br><br>
            Image: <input name="imagefile" type="file"<br><br>
        </div>
		<br>
        <input type='submit' value='Submit'>
    </fieldset>
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