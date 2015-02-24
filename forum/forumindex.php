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

		if ($_SESSION['user_level'] == 1)
		{
			switch ($_SERVER['REQUEST_METHOD'])
			{
				case 'GET':
			?>
			<!--the form hasn't been posted yet, display it-->
			<form method='post' action='forumindex.php'>
				<center>Category name: <input type='text' name='cat_name' />
				Category description: <textarea name='cat_description' /></textarea>
			<input type='submit' value='Add category' /></center>
			
			<!-- If creation was successful -->
			<? if(isset($_GET['catSuccess'])) {?>
				<p>You have successfully created a new category!</p>
			<? }?>
			<!-- if category creation had error show this -->
			<p>
				<?php 
					if(isset($_GET['catError']))
					{
						switch ($_GET['catError']) 
						{
							case 1:
							echo "Only letters and white space allowed!";
							break;
							
							case 2:
							echo "Category has to have a name!";
							break;
							
							case 3:
							echo "Database error!";
							break;
							
							case 4:
							echo "Category doesn't exist!";
							break;
							
							default:
							echo "Unknown error!";
						}
					}
				?>
			</p>
		</form>
		<?php	break;
			case 'POST':
			
			function test_input($data) 
			{
				$data = trim($data); // Strip whitespace (or other characters) from the beginning and end of a string.
				$data = stripslashes($data); //stripslashes Un-quotes a quoted string.
				$data = htmlspecialchars($data); // Convert special characters to HTML entities
				return $data;
			}
			// Sanitation for input
			if (empty($_POST['cat_name']))
			{
				header("Location: forumindex.php?catError=2");
				exit;
			}
			else
			{
				$categoryName = test_input($_POST['cat_name']);
				// check if category name only contains letters and whitespace.
				//preg_match performs a regular expression match, up against the categoryName in this case.
				if (!preg_match("/^[a-zA-Z ]*$/",$categoryName))
				{
					header("Location: forumindex.php?catError=1");
					exit;
				}
			}
			// "mysqli_real_escape_string" escapes special characters in a string.
			$categoryName = mysqli_real_escape_string($dbcon, $_POST['cat_name']);
			$categoryDescription = mysqli_real_escape_string($dbcon, $_POST['cat_description']);

			//the form has been posted, so save it
			if ($insert_stmt = $dbcon->prepare("INSERT INTO categories set cat_name = ?, cat_description = ?"))
			{
            $insert_stmt->bind_param('ss', $categoryName, $categoryDescription);

				// Execute the prepared query.
				$insert_stmt->execute();

				//Success
				header("Location: forumindex.php?catSuccess=1");
				exit;
			}
			else
			{
				//something went wrong, display the error
				header("Location: forumindex.php?catError=3");
				exit;
			}
		}
	}
	if ($_SESSION['user_level'] == 0)
	{
		echo '<p>You have to contact an admin in order to create a new category!</p>';
	}
	if ($_SESSION['user_level'] == 1 or $_SESSION['user_level'] == 0)
	{
		// Table showing categories and their descriptions.
		// Select queries return a resultset
		if ($select_stmt = $dbcon->query("SELECT cat_id, cat_name, cat_description FROM categories ORDER BY cat_name")) 
		{
			echo '<center><table border="1">';
			echo '<tr>';
			echo '<th><h4>Category</h4></th>';
			echo '<th><h4>Description</h4></th>';
			echo '</tr>';
			while($row = $select_stmt->fetch_assoc()) 
			{
				// Use "htmlentities" to protect against persistent xss.
				echo '<tr>';
				echo '<td><h1><a href="topic.php?id='.$row["cat_id"].'">'.htmlentities($row["cat_name"],ENT_QUOTES, "UTF-8").'</a></h1></td>';
				echo '<td><h4>'.htmlentities($row["cat_description"],ENT_QUOTES, "UTF-8").'</h4></td>';
				echo '</tr>';
			}  
			echo '</table></center>';
			// Frees the memory associated with a result
			$select_stmt->free();
		}	
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