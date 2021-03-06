<?php
	
	/*
		* @author     Ziad El-Wali <Ziadelwali@gmail.com>
	*/

	//SECURE SESSION START FUNCTION
	function sec_session_start()
	{
        $session_name = 'sec_session_id'; // Set a custom session name
        //$ses_id = session_id();   // Sets the session id to a variable we can check up against.
        $secure = false; // Set to true if using https, else false.
        $httponly = true; // This stops javascript from being able to access the session id.
        ini_set('session.cookie_secure',1); // specifies whether cookies should only be sent over secure connections.
        ini_set('session.cookie_httponly',1); // Makes cookie unreadable for javascript, XSS Protection here.
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one.
	}
	
	//SECURE LOGIN FUNCTION
	function login($email, $password, $dbcon)
    {
    	$sql = "SELECT id_account, username, password, salt, email, status, role_id FROM account WHERE email = ? LIMIT 1";
		// Using prepared Statements means that SQL injection is not possible. 
		if ($stmt = $dbcon->prepare($sql))
        {
			$stmt->bind_param('s', $email); // Bind "$email" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
			$stmt->bind_result($user_id, $username, $db_password, $salt, $email, $status, $role_id); // get variables from result.
			$stmt->fetch();
			$password = hash('sha512', $password.$salt); // The hashed password with the unique salt.
			
            // If the user exists
			if($stmt->num_rows == 1)
            {
				// We check if the account is locked from too many login attempts
				if(checkbrute($user_id, $dbcon) == true)
				{
					// Account is locked
					return false;
				} else
				{
					if($db_password == $password)  // Check if the password in the database matches the password the user submitted.
					{
						// Password is correct!
						$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
						$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
						
                        // preg_replace � Performs a regular expression search and replace
						$user_id = preg_replace("/[^0-9]+/", "", $user_id);
						$_SESSION['user_id'] = $user_id;
						$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
						$_SESSION['username'] = $username;
						$email = preg_replace("/(.+)\+.*(@.+)/", "", $email); // XSS protection as we might print this value
						$_SESSION['email'] = $email;
						$role_id = preg_replace("/[^1-2]+/", "", $role_id);
						$_SESSION['role_id'] = $role_id;
						$status = preg_replace("/[^0-1]+/", "", $status);
						$_SESSION['status'] = $status;
						$_SESSION['login_string'] = hash('sha512', $password.$ip_address.$user_browser);
						
						$timestamp = date('Y-m-d H:i:s');
						$dbcon->query("UPDATE FROM account set lastlogin = $timestamp WHERE id_account = $user_id");
						
						// Login successful.
						return true;
					} else 
					{
						// We record the failed login attempt in the database
						$timestamp = date('Y-m-d H:i:s');
						$dbcon->query("INSERT INTO failed_login_attempts (account_id, time) VALUES ('$user_id', '$timestamp')");
						return false;
					}
				}
				} else {
				// No user exists. 
				return false;
			}
		}
		$dbcon->close();
	}
	
	//Brute force method to ensure several login attempts get registered and bans account.
	
	function checkbrute($user_id, $dbcon)
	{
		// Get time of current time
		$now = time();
		// All login attempts are counted from the past 2 hours.
		$valid_attempts = $now - (2 * 60 * 60);
		
		if ($stmt = $dbcon->prepare("SELECT time FROM failed_login_attempts WHERE account_id = ? AND time > '$valid_attempts'"))
		{
			$stmt->bind_param('i', $user_id); 
			// Execute the prepared query.
			$stmt->execute();
			$stmt->store_result();
			// If there has been more than 5 failed logins
			if($stmt->num_rows > 5) 
			{
				return true;
			} else 
			{
				return false;
			}
		}
		$dbcon->close();
	}
	
	//CREATE LOGIN CHECK FUNCTION - Logged Status
	function login_check($db)
	{
		// Check if all session variables are set
		if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) 
		{
			$user_id = $_SESSION['user_id'];
			$login_string = $_SESSION['login_string'];
			$username = $_SESSION['username'];
			$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
			$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
			
			if ($stmt = $db->prepare("SELECT password FROM account WHERE id_account = ? LIMIT 1"))
			{
				$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
				$stmt->execute(); // Execute the prepared query.
				$stmt->store_result();
				
				if($stmt->num_rows == 1) // If the user exists
				{
					$stmt->bind_result($password); // get variables from result.
					$stmt->fetch();
					$login_check = hash('sha512', $password.$ip_address.$user_browser);
					if($login_check == $login_string)
					{
						// Logged In!!!!
						return true;
					}
					else 
					{
						// Not logged in
						return false;
					}
				}
				else 
				{
					// Not logged in
					return false;
				}
				$dbcon->close();
			}
			
			else 
			{
				// Not logged in
				return false;
			}
		}
		else 
		{
			// Not logged in
			return false;
		}
	}
?>																																					