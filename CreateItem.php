<!DOCTYPE html>
<html>
<head>
    <title>Create Auction</title>
</head>
<body>
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
</body>
</html>

<?php

		// session_start();
		// require('connect.php');
		// if ($_SESSION['name']){

		// $user = $_SESSION['name'];

		// $query = mysql_query("SELECT id FROM users WHERE username='$user'");

		// $numrows = mysql_num_rows($query);

		// //If the query returns > 0
		// if ($numrows != 0)
		// {
			// while ($row = mysql_fetch_assoc($query))
			// {
				// $id = $row['id'];
			// }


        if (isset($_POST['title'])&&($_POST['description'])&&($_POST['minPrice']))
        {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $startPrice = $_POST['minPrice'];

		
		    $fileName = $_FILES['imagefile']['name'];
            $temp  = $_FILES['imagefile']['tmp_name'];
            $fileSize = $_FILES['imagefile']['size'];
            $fileType = $_FILES['imagefile']['type'];

            //Saves image file to the folder and the path to database
            move_uploaded_file($temp, "uploaded/".$fileName);

            // $query = "INSERT INTO cars (make, model, year, userId, image)
			// VALUES ('$title', '$description', '$startPrice', '$id', '$fileName')";
            // $result = mysql_query($query);

             echo "Auction item successfully created";

        }
        else
        {
            echo "All fields except image are mandatory.";
        }
		
		