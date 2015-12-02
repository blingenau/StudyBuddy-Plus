<?php
	$servername = "localhost";
	$d_username = "root";
	$d_password = "";
	$db_name = "studybuddyplus";


	session_start(); // Starting Session
	$error=''; // Variable To Store Error Message
	if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Username or Password is invalid";
		}else {
			// Define $username and $password
			$username=$_POST['username'];
			$password=$_POST['password'];

			// Establishing Connection with Server by passing server_name, user_id and password as a parameter
			$connection = mysql_connect("$servername", "$d_username", "$d_password");

			// To protect MySQL injection for Security purpose
			$username = stripslashes($username);
			$password = stripslashes($password);
			$username = mysql_real_escape_string($username);
			$password = mysql_real_escape_string($password);

			// Selecting Database
			$db = mysql_select_db("$db_name", $connection);

			$salt = mysql_query("SELECT `salt` FROM login WHERE username='$username'", $connection);
			$salt = mysql_fetch_assoc($salt);
			$salt = $salt['salt'];

			$password = hash('sha256', $salt . $password);

			// SQL query to fetch information of registerd users and finds user match.
			$query = mysql_query("SELECT * FROM login WHERE password='$password' AND username='$username'", $connection);
			$rows = mysql_num_rows($query);

			if ($rows == 1) {
				$_SESSION['login_user']=$username; // Initializing Session
				header("location: dashboard.php"); // Redirecting To Other Page
			} else {
				$error = "Username or Password is invalid";
			}
			mysql_close($connection); // Closing Connection
		}
	}
?>