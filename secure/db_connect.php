
<?php
// Connection data (server_address, database, name, poassword)
$hostdb = 'localhost';
$namedb = 'auctionking';
$userdb = 'sec_user';
$passdb = 'eKcGZr59zAa2BEWU';

try
{
  // Connect and create the PDO object
  $dbcon = new PDO("mysql:host=$hostdb; dbname=$namedb", $userdb, $passdb);
  $dbcon->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8

  $dbcon = null;        // Disconnect
}
catch(PDOException $e)
{
  echo $e->getMessage();
}
?>