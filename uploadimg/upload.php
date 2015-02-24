<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	include '/../secure/db_connect.php';
	include '/../secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"]))
        {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
				} else
                {
				header("Location: upload_image.php?upload=7");
             $uploadOk = 0;
                exit;
			}
		}
        // This check essentially doesnt need to be run because we use microtime as filename and will therefore never be equal.
		// Check if file already exists
		if (file_exists($target_file))
        {
			header("Location: upload_image.php?upload=6");
             $uploadOk = 0;
                exit;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2000000)
        {
             header("Location: upload_image.php?upload=5");
             $uploadOk = 0;
                exit;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" )
        {
             header("Location: upload_image.php?upload=4");
             $uploadOk = 0;
                exit;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0)
        {
            header("Location: upload_image.php?upload=3");
                exit;
			// if everything is ok, try to upload file
		} else
        {
            // Change the whole filename at upload to have a filename equal to the microtime at the upload.
            $target_file = explode(".",$_FILES["fileToUpload"]["name"]);
            $newfilename = microtime() . '.' .end($target_file);
			if
            (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "uploads/" . $newfilename))
            {
                header("Location: upload_image.php?upload=1");
                exit;

			} else
            {
                header("Location: upload_image.php?upload=2");
                exit;
			}
		}
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