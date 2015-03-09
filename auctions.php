<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
	border: 1px solid green;
		text-align: center;
		background-color: #9FF781;
		width: 1000px
}
th {
background-color: green;
    color: white;
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
		* @author     Casper Maro Madsen <caverhtc@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'header.php';

		include 'footer.php';
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
	
	$sql = "SELECT ID, Title, Picture, Higestbid, Timeend, Description, Bids FROM auctionking.view_all_auctions";
	$result = $dbcon->query($sql);

	if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Title</th><th>Picture</th><th>Higest Bid</th><th>Auction ends</th><th>Description</th><th>Bids</th></tr>";
     // output data of each row
     while($row = $result->fetch_assoc()) {
		 $id = $row["ID"];
		 $title = $row["Title"];
		 $pic = $row["Picture"];
		 $higestbid = $row["Higestbid"];
		 $timeleft = $row["Timeend"];
		 $desc = $row["Description"];
		 $bids = $row["Bids"];
		 
		echo '<tr><td>' . $id. '</td><td>' . $title. '</td><td><div id="myDiv"><a href=auction.php?id='.$id.'><img src="img/' . $pic. '"></a></div></td><td>' . $higestbid. ' $' . '</td><td>' . $timeleft. '</td><td>' . $desc. '</td><td>' . $bids. "</td></tr>";
		 
        // echo '<tr><td>' . $row["ID"]. '</td><td>' . $row["Title"]. '</td><td><div id="myDiv"><a href="?id=$id"><img src="img/' . $row["Picture"]. '"></a></div></td><td>' . $row["Higestbid"]. '</td><td>' . $row["Timeend"]. '</td><td>' . $row["Description"]. '</td><td>' . $row["Bids"]. "</td></tr>";
	 }
     echo "</table>";
} else {
     echo "0 results";
}

$dbcon->close();
?>
</body>
</html>
