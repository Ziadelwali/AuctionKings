<?php
	include 'secure/db_connect.php';

{
		
	$username = "test";
	$password="pass";
	$salt="asdasdasdsad";
	$email="mail@mail.com";
	
		$dbcon->query("SET @1  = " . "'" . $dbcon->real_escape_string($username) . "'");
			$dbcon->query("SET @2   = " . "'" . $dbcon->real_escape_string($password) . "'");
			$dbcon->query("SET @3  = " . "'" . $dbcon->real_escape_string($salt) . "'");
			$dbcon->query("SET @4  = " . "'" . $dbcon->real_escape_string($email) . "'");

			if($dbcon->query("CALL create_account_nodetails(@1, @2, @3, @4)"))
			{
			echo 'hejsa';
			}
}
		
	
?>