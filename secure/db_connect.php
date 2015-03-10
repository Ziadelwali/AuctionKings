
<?php
// DB Connection the PDO Way

// Connection data (server_address, database, name, poassword)
// $hostdb = 'localhost';
// $namedb = 'auctionking';
// $userdb = 'sec_user';
// $passdb = 'eKcGZr59zAa2BEWU';

// try
// {
//   // Connect and create the PDO object
//   $dbcon = new PDO("mysql:host=$hostdb; dbname=$namedb", $userdb, $passdb);
//   $dbcon->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8

//   $dbcon = null;        // Disconnect
// }
// catch(PDOException $e)
// {
//   echo $e->getMessage();
// }
?>


<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

// DB Connection the MYSQLI Way

	define("HOST", "localhost"); // The host you want to connect to.
	define("USER", "sec_user"); // The database username.
	define("PASSWORD", "eKcGZr59zAa2BEWU"); // The database password. 
	define("DATABASE", "auctionking"); // The database name.
	
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