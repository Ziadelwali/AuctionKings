<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	define("HOST", "localhost"); // The host you want to connect to.
	define("USER", "sec_user"); // The database username.
	define("PASSWORD", "eKcGZr59zAa2BEWU"); // The database password. 
	define("DATABASE", "auctionkings"); // The database name.
	
	try {
		$dbcon = new mysqli(HOST, USER, PASSWORD, DATABASE);
		// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.
	} catch (Exception $e) 
	{
		exit('Caught exception: '.$e->getMessage());
	}
	/* check connection */
	if (mysqli_connect_errno()) 
	{
		header("Location: '../../../?regError=3");
		exit();
	}
;?>