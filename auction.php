<style>
table, th, td {
	border: 1px solid black;
}
</style>
<?php
	
	/*
		* @author     Casper M Madsen <iliketurtels@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	
	$auctionid = $_GET['id'];
	$sql = "SELECT ID, Title, Picture, Higestbid, Timeend, Description, Bids FROM auctionking.view_all_auctions WHERE ID = $auctionid;";
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
		 
		echo '<tr><td>' . $id. '</td><td>' . $title. '</td><td><div id="myDiv"><a href=auction.php?id='.$id.'><img src="img/' . $pic. '"></a></div></td><td>' . $higestbid. '</td><td>' . $timeleft. '</td><td>' . $desc. '</td><td>' . $bids. "</td></tr>";
		 
        // echo '<tr><td>' . $row["ID"]. '</td><td>' . $row["Title"]. '</td><td><div id="myDiv"><a href="?id=$id"><img src="img/' . $row["Picture"]. '"></a></div></td><td>' . $row["Higestbid"]. '</td><td>' . $row["Timeend"]. '</td><td>' . $row["Description"]. '</td><td>' . $row["Bids"]. "</td></tr>";
	 }
     echo "</table>";
} else {
     echo "0 results";
}

$dbcon->close();

function placebid()
{
	echo "1";
	if(isset($_POST['bidinput']))
	{
		echo "2";
	$amount = $_POST['bidinput'];
	
	$query= "CALL create_bid (?,?,?)";
		
	if ($insert_stmt = $dbcon->prepare($query))
	{
		$insert_stmt->bind_param('iii', $amount, $user_id, $auctionid);
	
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
</br>
</br>
<table>
	<tr>
		<td>Enter your bid</td>
		<td><input id="bidinputid" name="bidinput" type="number" min="0.1"></td>
		<td><input id="bidbtn" name="bidbtn" type="submit" value="Place Bid"
			onclick="placebid()"></td>
	</tr>
</table>
