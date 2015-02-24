<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	include '/../secure/db_connect.php';
	include '/../secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.

	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'upload_header.php';

		// See who is actually logged in
	echo 'You are logged in as : '.$_SESSION['username'].'</br>';
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<center>Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<!--MAX_FILE_SIZE determines the max size for the picture.-->
			<input type="hidden" name="MAX_FILE_SIZE" value="20000"/>
		<input type="submit" value="Upload Image" name="upload"></center>
        <?php
          if(isset($_GET['upload']))
		{
			switch ($_GET['upload'])
			{
				case 1:
				echo "The image has been uploaded.";
				break;

                case 2:
				echo "There was an error uploading your file.";
				break;

                case 3:
				echo "Your file was not uploaded.";
				break;

                case 4:
				echo "Only JPG, JPEG, PNG & GIF files are allowed.";
				break;

                case 5:
				echo "Your file is too large, max 2 MB.";
				break;

                case 6:
				echo "Sorry, file already exists.";
				break;

                case 7:
				echo "File is not an image.";
				break;

				default:
				echo "Unknown error!";
			}
		}
        ?>
	</form>
	<p>Images uploaded to upload folder: </br></p>
	<?php
		// Show the pictures uploaded to the upload folder so far.
		$folder = 'uploads/';
		$filetype = '*.*';
		$files = glob($folder.$filetype);
		$count = count($files);
		echo '<table border="1">';
		echo '<tr>';
		echo '<th>Pictures</th>';
		echo '</tr>';
		for ($i = 0; $i < $count; $i++) {
			echo '<tr><td>';
            // Convert image into a html entity.
			echo '<img src="'.htmlentities($files[$i],ENT_QUOTES, "UTF-8").'" width="200" height="300"/>';
			echo '</td></tr>';
		}
		echo '</table>';

       	include 'upload_footer.php';
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
