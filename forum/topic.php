<?php

/*
* @author     Ziad El-Wali <Ziadelwali@gmail.com>
*/

	include '/../secure/db_connect.php';
	include '/../secure/functions.php';
	sec_session_start(); // Our custom secure way of starting a php session.

	if(login_check($dbcon) == true AND $_SESSION['status'] == 0)
	{
	    include 'forum_header.php';

		// See who is actually logged in
		echo 'Logged in as : '.$_SESSION['username'].'</br>';
		
		// Control if the id in the browser address field really is a numeric value.
		$categoryId = $_GET["id"];
		if (!is_numeric($categoryId))
		{
			header("Location: forumindex.php?catError=4");
			exit;
		}
		switch ($_SERVER['REQUEST_METHOD'])
		{
			case 'POST':
			
			$topicSubject = mysqli_real_escape_string($dbcon, $_POST["topic_subject"]);
			
			$sql = "INSERT INTO topics (topic_subject, topic_date, topic_cat, topic_by) VALUES('".$topicSubject."', NOW(), ". $categoryId ."," . $_SESSION['user_id'] .")";
			$result = $dbcon->query($sql);
			if(!$result) 
			{
				header("Location: topic.php?id={$categoryId}&topicError=2");
				exit;
			}
			else 
			{
				header("Location: topic.php?id={$categoryId}&topicSuccess=1");
				exit;
			}
			break;
			case 'GET':
			
		?>
		<form method='post' action='topic.php?id=<? echo $categoryId; ?>'>
			<center>Topic : <input type="text" name="topic_subject" value="Topic text!" />
				<input type="submit" value="Create topic" />
			<input type="hidden" name="category_id" value="<? echo $categoryId; ?>"></center>
			
			<!-- If creation was successful -->
			<? if(isset($_GET['topicSuccess'])) {?>
				<p>The topic was created successfully!</p>
			<? }?>
			<!-- if category creation had error show this -->
			<p>
				<?php 
					if(isset($_GET['topicError'])) 
					{
						switch ($_GET['topicError']) 
						{
							case 1:
							echo "Topic has to have a name!";
							break;
							
							case 2:
							echo "Database error!";
							break;
							
							default:
							echo "Unknown error!";
						}
					} 
				?>
			</p>
		</form>
		<?php	break; 
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
				echo '<td><h1><a href="topic_subject.php?id='.$row["topic_id"].'">'.htmlentities($row["topic_subject"],ENT_QUOTES, "UTF-8").'</a></h1></td>';
				echo '</tr>';
			}
			echo '</table></center>';
		}
	    include 'forum_footer.php';
	}
	else if ($_SESSION['status'] == 1)
	{
		header("Location: ../index.php?logError=5");
		// Destroy session
		session_destroy();
        exit;
	}
	else
	{
		echo 'You are not authorized to access this page, please login. <br/>';
	}
?>