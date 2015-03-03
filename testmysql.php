<?php
$mysqli = new mysqli("localhost", "root", "", "auctionking");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$a="test123123";
$b="Test123";
$c="testsalt";
$d="test234234@mail.dk";

$query= "CALL create_account_nodetails (?,?,?,?)"; 
$stmt = $mysqli->prepare($query); 
$stmt->bind_param("ssss", $a, $b, $c, $d); 
$stmt->execute(); 

?>					