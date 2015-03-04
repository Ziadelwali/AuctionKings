<?php
	
	/*
		* @author     Ziad El-Wali <Ziadelwali@gmail.com>
	*/
	
	include 'secure/db_connect.php';
	include 'secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.
	
	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'header.php';
		
		// See who is actually logged in
		echo 'Logged in as : '.$_SESSION['username'].'</br>';
		
		echo $_SESSION[''];
		// Control if the id in the browser address field really is a numeric value.
		$categoryId = $_SESSION['user_id'];
 		if (!is_numeric($categoryId))
 		{
 			header("Location: homepage.php?catError=4");
 			exit;
 		}
		
		
		
		
		
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			
			
			
			$select_stmt = $dbcon->query("SELECT id_category, cat_name, cat_description FROM categories ORDER BY cat_name");
			{
				
				echo '<h4>Category</h4>';
				// Use "htmlentities" to protect against persistent xss.
				echo '<h1><a href="auction_category.php?id='.$row["id_category"].'">'.htmlentities($row["cat_name"],ENT_QUOTES, "UTF-8").'</a></h1>';
			}
		
		
		
		
		
		
		//Display of the topics starts of by selecting queries to return a resultset
		$sql = "SELECT topic_id, topic_subject, topic_date FROM topics WHERE topic_cat = ". $categoryId ." ORDER BY topic_subject";
		if ($result = $dbcon->query($sql))
		{
			
			// Show the table	
			echo '<center></br></br><table border="1">';
			
			echo '<td><h4>topics</h4></td>';
			
			while($row = $result->fetch_assoc()) 
			{
				
				// Use "htmlentities" to protect against persistent xss.
				echo '<tr>';
				echo '<td><h1>'.htmlentities($row["topic_subject"],ENT_QUOTES, "UTF-8").'</h1></td>';
				echo '</tr>';
			}
			echo '</table></center>';
			// Releases the memory associated with a result
			$sql->free();
			}
		}
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