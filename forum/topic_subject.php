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
		echo 'You are logged in as : '.$_SESSION['username'].'</br>';

        $topicId = mysqli_real_escape_string($dbcon, $_GET['id']);

		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{

		    $comments = mysqli_real_escape_string($dbcon, $_POST["comment"]);
		    if ($insert_stmt = $dbcon->prepare("INSERT INTO posts set post_content = ?, post_date = NOW(), post_topic = ?, post_by = ".$_SESSION['user_id'].""))
			{

				$insert_stmt->bind_param('ss', $comments, $topicId);

				// Execute the prepared query.
				$insert_stmt->execute();


				//Success
                echo 'The Post was created succesfully!';
			}
			else
			{
				//something went wrong
                echo 'An error occured';
			}
		}

		$selectTopicSubject = "SELECT topic_subject FROM topics WHERE topic_id = ". $topicId;
		$result = $dbcon->query($selectTopicSubject);
		$topicSubject = "";
		if(!$result)
        {
			//something went wrong, display the error
			echo 'Error : ' . mysqli_error($dbcon);
		}
		else
        {
			$row = $result->fetch_row();
			//Use htmlentities here because we print these topic subjects.
			//$topicSubject = htmlentities($row[0],ENT_QUOTES, "UTF-8");

		}
	?>

	<form name="myform" id="myform" method="post" action="topic_subject.php?id=<? echo $_GET["id"]; ?>">
		<center><h2>Please leave a comment for the topic: <? echo $topicSubject; ?></h2>
			Enter Comment here: <textarea id="comment" name="comment" rows="5"></textarea><br/>
			<br />
		<input type="submit" value="Post Comment"></center>
	</form>

	<?php
		/* Select queries return a resultset */
		$sql = "SELECT p.post_id, p.post_content, p.post_date, m.username FROM posts p JOIN members m ON m.id = p.post_by WHERE post_topic = ". $topicId;
		if ($result = $dbcon->query($sql))
        {
			// Show the table
			echo '<center></br></br><table border="1">';
			echo '<th><h4>Posts</h4></th>';
			echo '<th><h4>Date</h4></th>';
			echo '<th><h4>Author</h4></th>';

			while($row = $result->fetch_assoc())
			{
				echo '<tr>';
				echo '<td>';
				echo '<p>'.htmlentities($row["post_content"],ENT_QUOTES, "UTF-8").'</p>';
				echo '</td>';
				echo '<td>';
				echo '<p>'.htmlentities($row["post_date"],ENT_QUOTES, "UTF-8").'</p>';
				echo '</td>';
				echo '<td>';
				echo '<p>'.htmlentities($row["username"],ENT_QUOTES, "UTF-8").'</p>';
				echo '</td>';
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