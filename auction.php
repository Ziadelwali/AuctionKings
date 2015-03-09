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

	    
	    $auctionid = $_GET['id'];
	    $sql = "SELECT ID, Title, Picture, Higestbid, Timestart ,Timeend, Description, Username, Bids FROM auctionking.view_one_auction WHERE ID = $auctionid;";
	    $result = $dbcon->query($sql);
	    
	    if ($result->num_rows > 0) 
	    {
	    	echo "<table><tr><th>ID</th><th>Title</th><th>Picture</th><th>Higest Bid</th><th>Auction started</th><th>Auction ends</th><th>Description</th><th>Created by</th><th>Bids</th></tr>";
	    	// output data of each row
	    	while($row = $result->fetch_assoc()) {
	    		$id = $row["ID"];
	    		$title = $row["Title"];
	    		$pic = $row["Picture"];
	    		$higestbid = $row["Higestbid"];
	    		$timestart = $row["Timestart"];
	    		$timeleft = $row["Timeend"];
	    		$desc = $row["Description"];
	    		$user = $row["Username"];
	    		$bids = $row["Bids"];
	    			
	    		$datetime1 = new DateTime();
	    		$datetime2 = new DateTime($timeleft);
	    		$d1 = $datetime1->format('Y-m-d H:i:s');
	    		$d2 = $datetime2->format('Y-m-d H:i:s');
	    		$timeFirst  = strtotime($d1);
	    		$timeSecond = strtotime($d2);
	    		$differenceInSeconds = $timeSecond - $timeFirst;
	    
	    		echo '<tr><td>' . $id. '</td><td>' . $title. '</td><td><div id="myDiv"><img src="img/' . $pic. '"width="200" height="300"></div></td><td>' . $higestbid. ' $' . '</td><td>' . $timestart. '</td><td><span id="timer">' . '</span></td><td width="400px">' . $desc. '</td><td>' . $user . '</td><td>' . $bids. "</td></tr>";
	    
	    		// echo '<tr><td>' . $row["ID"]. '</td><td>' . $row["Title"]. '</td><td><div id="myDiv"><a href="?id=$id"><img src="img/' . $row["Picture"]. '"></a></div></td><td>' . $row["Higestbid"]. '</td><td>' . $row["Timeend"]. '</td><td>' . $row["Description"]. '</td><td>' . $row["Bids"]. "</td></tr>";
	    	}
	    	echo "</table>";
	    } 
	    else 
	    {
	    	echo "0 results";
	    }
	    
	    if($_SERVER['REQUEST_METHOD'] == 'POST') {
	    	$amount = $_POST['bidinput'];
	    	$user_id = $_SESSION['user_id'];
	    	$call = $dbcon->prepare('CALL create_bid (?,?,?,@sqlstatus)');
	    	$call->bind_param('iii', $amount, $user_id, $auctionid);
	    	$call->execute();
	    	$select = $dbcon->query('SELECT @sqlstatus');
	    	$result = $select->fetch_assoc();
	    	$sqlstatus     = $result['@sqlstatus'];
	    	$dbcon->close();
	    	if ($sqlstatus == 0)
	    	{
	    		echo "Bid Failed!";
	    	}
	    	if ($sqlstatus == 1)
	    	{
	    		echo "Bid Created!";
	    	}
	    	if ($sqlstatus == 2)
	    	{
	    		echo "Bid must be higher than last bid";
	    	}
	    	if ($sqlstatus == 3)
	    	{
	    		echo "You cannot bid on a ended auction";
	    	}
	    	if ($sqlstatus == 4)
	    	{
	    		echo "You cant bid on your own auctions";
	    	}
	    }
	    ?>
</br>
</br>
<div id="myTable">
	<form method="post">
		<table>
			<tr>
				<td>Enter your bid</td>
				<td><input id="bidinputid" name="bidinput" type="number"></td>
				<td><input id="bidbtn" name="bidbtn" type="submit" value="Place Bid"
					onclick="placebidtemp()"></td>
			</tr>
		</table>
	</form>
</div>
</body>
<script>
	    	var countDownTime = "<?php echo $differenceInSeconds; ?>";
	    	function countDownTimer() {
	    		if (countDownTime < 0) {
	    			var result = "Ended";
	    			document.getElementById("timer").innerHTML = result;
	    		}
	    		else if (countDownTime > 0)
	    		{
	    			var days = parseInt( countDownTime / 86400);
	    			var hours = parseInt( countDownTime / 3600 ) % 24;
	    			var minutes = parseInt( countDownTime / 60 ) % 60;
	    			var seconds = countDownTime % 60;
	    			var result = (days < 10 ? "0" + days : days) + ":" + (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
	    			document.getElementById("timer").innerHTML = result;
	    	   		if(countDownTime == 0  ){ countDownTime = 1 }
	    	   		countDownTime = countDownTime - 1;
	    	   		setTimeout(function(){ countDownTimer() }, 1000);
	    		}
	    			}
	    			
	    
	    	countDownTimer();
	    </script>
</html>
<?php 
	    
	    
	    
	    
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
					?>
	