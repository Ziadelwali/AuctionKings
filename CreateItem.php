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
	    
	    echo 'Logged in as : '.$_SESSION['username'];
	    
	    switch ($_SERVER['REQUEST_METHOD'])
	    {
	    	case 'GET':
	    
?>
<center><form method='POST' enctype="multipart/form-data">
	<fieldset>
		<legend><h1>Add item details</h1></legend>
		<div class="container">
		<h2>Categories:</h2>
		<?php 
		
	$select_stmt = $dbcon->query("SELECT id_category, cat_name, cat_description FROM category");
		
			echo '<select name="Categories">'; // Open your drop down box
			
			// Loop through the query results, outputing the options one by one
		while ($row = mysqli_fetch_array($select_stmt)) {
			echo '<option value="'.$row['id_category'].'">'.$row['cat_name'].'</option>';
		}
		
		echo '</select>';// Close your drop down box	
			
			// Frees the memory associated with a result
		//	$select_stmt->free();
		
		
		?>
			<br><h2>Title: </h2> <input type='text' name='title'
				value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"><br>
			<br> <h2>Description:</h2>
			<textarea name="description" rows="6" cols="40"
				value="<?php echo isset($_POST['description']) ? $_POST['description'] : '' ?>"></textarea>
			<br> <br> <h2>Starting price:</h2><input type='number'
				name='minPrice' min="0"
				value="<?php echo isset($_POST['minPrice']) ? $_POST['minPrice'] : '' ?>"><br>
			<br> <h2>Image: </h2><input name="imagefile" type="file"<br> <br>
		</div>
		<br><input type='submit' value='Submit'>
	</fieldset>
</form></center>

<?php


break;
case 'POST':
	
	if (isset($_POST['title'])&&($_POST['description'])&&($_POST['minPrice'])&&($_POST['Categories']))
	{
		$user_id = $_SESSION['user_id'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$startPrice = $_POST['minPrice'];
		$category = $_POST['Categories'];
	
		$fileName = $_FILES['imagefile']['name'];
		$temp  = $_FILES['imagefile']['tmp_name'];
		$fileSize = $_FILES['imagefile']['size'];
		$fileType = $_FILES['imagefile']['type'];
		
		$newfilename = time().$fileName;
		//Saves image file to the folder and the path to database
		move_uploaded_file($temp, "img/".$newfilename);
		
		
		$query= "CALL create_auction (?,?,?,?,?,?)";
		
		//the form has been posted, so save it
		if ($insert_stmt = $dbcon->prepare($query))
		{
			$insert_stmt->bind_param('issisi', $user_id, $title, $description, $startPrice, $newfilename, $category);
		
			// Execute the prepared query.
			$insert_stmt->execute();
		
			//Success
			//header("Location: homepage.php?catSuccess=1");
			echo "Auction item successfully created";
		}
		else
		{
			//something went wrong, display the error
			//header("Location: homepage.php?catError=3");
			echo 'something went wrong';
			exit;
		}	
	}
	else
	{
		echo "All fields except image are mandatory.";
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