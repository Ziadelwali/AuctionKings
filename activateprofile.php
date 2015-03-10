<?php

include 'secure/db_connect.php';
include 'secure/functions.php';


	//include_once 'analyticstracking.php';

sec_session_start(); // Our custom secure way of starting a php session.

if(login_check($dbcon) == true)
{


// Activation
switch ($_SERVER['REQUEST_METHOD'])
{
	case 'GET':
		?>
<!--the form hasn't been posted yet, display it-->
<p>
<center><h4>Notice... If you activate your profile you will be redirected to
	login page and your profile will be activated.</h4>
</p>


	<form method='post' action='activateprofile.php'>
		<input type='submit' value='Activate profile' />
	</form>
</center>
<?php
                            break;
                            case 'POST':
            
                            $newstat = 0;
                            
                            if ($upd_stmt = $dbcon->prepare("UPDATE account set status = ? WHERE id_account=".$_SESSION['user_id'].""))
            			{
            
            				$upd_stmt->bind_param('i', $newstat);
            
            				// Execute the prepared query.
            				$upd_stmt->execute();
            
            				//Success
            				header("Location: index.php?logError=7");
            				exit;
            			}
            			else
            			{
            				//something went wrong, display the error
            				echo 'Something went wrong';
            				exit;
            			}
                            break;
                        }
            
}                
                        
?>