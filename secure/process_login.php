<?php
	
/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/
	
	include 'db_connect.php';
	include 'functions.php';
	sec_session_start(); // Our custom secure way of starting a php session. 
	
	//Define variables and set their values, from the form submitted in the html login form (index.php).
	$email = $_POST['loginEmail'];
	$password = $_POST['p']; // The hashed password.
	
	//Put sanitation for login here.
	
	function test_input($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		
		if (empty($_POST["loginEmail"])) 
		{
			//$emailErr = "Email is required";
			header("Location: '../../../?logError=3");
			exit;
		} else
		{
			$email = test_input($_POST["loginEmail"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				//$emailErr = "Invalid email format"; 
				header("Location: '../../../?logError=4");
			exit;
			}
		}
		
		if (empty($_POST["p"])) 
		{
			header("Location: '../../../?logError=2");
			exit;
		}
		
		if(isset($_POST['loginEmail'], $_POST['p'])) 
		{
			if(login($email, $password, $dbcon) == true) 
			{
				// Login success
				header("Location: '../../../homepage.php");
				exit;
			} else 
			{
				// Login failed
				header("Location: '../../../?logError=1");
				exit;
			}
		}
		else 
		{
			// The correct POST variables were not sent to this page.
			echo 'Invalid Request';
		}
	}
?>					