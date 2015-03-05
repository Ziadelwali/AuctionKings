<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
     border: 1px solid black;
}
#myDiv 
{
height:100px;
width:100px;
}
#myDiv img
{
max-width:100%; 
max-height:100%;
margin:auto;
display:block;
}
</style>
</head>
<body>
<?php
	
	/*
		* @author     Casper Madsen <iliketurtels@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	
	$sql = "SELECT ID, Title, Picture, Higestbid, Timeend, Description, Bids FROM auctionking.view_all_auctions";
	$result = $dbcon->query($sql);

	if ($result->num_rows > 0) {
     echo "<table><tr><th>ID</th><th>Title</th><th>Picture</th><th>Higest Bid</th><th>Auction ends</th><th>Description</th><th>Bids</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo '<tr><td>' . $row["ID"]. '</td><td>' . $row["Title"]. '</td><td><div id="myDiv"><img src="img/' . $row["Picture"]. '"></div></td><td>' . $row["Higestbid"]. '</td><td>' . $row["Timeend"]. '</td><td>' . $row["Description"]. '</td><td>' . $row["Bids"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "0 results";
}

$dbcon->close();
	
?>

</body>
</html>