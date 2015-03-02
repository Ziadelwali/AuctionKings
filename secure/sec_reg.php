<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	// Include database connection and functions here.
	include 'db_connect.php';
	include 'functions.php';
	
	//Define variables and set their values, from the form submitted in the html login form (index.php).
	$username = $_POST['regUsername'];
	$email = $_POST['regEmail'];
	$password = $_POST['regPassword'];
	
	//Sanitation goes here.
	function test_input($data) 
	{
		$data = trim($data); // Strip whitespace (or other characters) from the beginning and end of a string.
		$data = stripslashes($data); //stripslashes Un-quotes a quoted string.
		$data = htmlspecialchars($data); // Convert special characters to HTML entities
		return $data;
	}
	// Checks for duplicate username and email at registration.
	function checkDuplicate($db, $checkUsername, $checkEmail) 
	{
		/* Create a prepared statement */
		if($select_stmt = $db -> prepare("SELECT id_account FROM account WHERE username=? OR email=?")) 
		{
			//Bind parameters
			$select_stmt -> bind_param("ss", $checkUsername, $checkEmail);
			
			// Execute it
			$select_stmt -> execute();
			
			// Store result
			$select_stmt->store_result();
			
			$rows = $select_stmt->num_rows;
			
			/* free result */
			$select_stmt->free_result();
			
			/* close statement */
			$select_stmt->close();
			
			return $rows>0;
		}
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if (empty($_POST['regUsername'])) 
		{
			header("Location: ../index.php?regError=4");
			// Make sure that code below does not get executed when we redirect.
			exit;
		} 
		else 
		{
			$username = test_input($_POST['regUsername']);
			// check if name only contains letters and whitespace.
			//preg_match performs a regular expression match, up against the username in this case.
			if (!preg_match("/^[a-zA-Z ]*$/",$username)) 
			{
				header("Location: ../index.php?regError=5");
				// Make sure that code below does not get executed when we redirect.
			exit;
			}
		}
		if (empty($_POST["regEmail"]))
		{
			header("Location: ../index.php?regError=6");
			// Make sure that code below does not get executed when we redirect.
			exit;
		} 
		else 
		{
			$email = test_input($_POST["regEmail"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				header("Location: ../index.php?regError=7");
				// Make sure that code below does not get executed when we redirect.
			exit;
			}
		}
		//password sanitation goes in a js on client side.
		if (empty($_POST["p"])) 
		{
			header("Location: ../index.php?regError=8");
			// Make sure that code below does not get executed when we redirect.
			exit;
		} 
		else 
		{
			// Here it is essentially not needed to use test_input method because the password are hashed.
			$password = test_input($_POST["p"]);
		}
		// End of sanitation.
		
		if (checkDuplicate($dbcon, $username, $email)) 
		{
			header("Location: '../../../?regError=2'");
			// Make sure that code below does not get executed when we redirect.
			exit;
		}
		else 
		{
			// Create a random salt
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
			// Create salted password
			$password = hash('sha512', $password.$random_salt);
			
			//$sql = 'CALL create_account_nodetails (?, ?, ?, ?)';
			
			//if ($insert_stmt = $dbcon->prepare("call create_user (?, ?, ?, ?)")) 
			if ($insert_stmt = $dbcon->prepare("CALL create_account_nodetails (?, ?, ?, ?)")) 
			{
				$insert_stmt->bind_param("ssss", $username, $password, $random_salt, $email);
				
				// Execute the prepared query.
				$insert_stmt->execute();
				header("Location: ../?success=1");
				// Make sure that code below does not get executed when we redirect.
				exit;
			}
			else
			{
				header("Location: ../../../?regError=1");
				// Make sure that code below does not get executed when we redirect.
			exit;
			}
		}
	}
?>