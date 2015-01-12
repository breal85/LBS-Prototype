<?php
	//initialize session
	session_start();
	//include database connection settings

	include('connectionvars.php');


	// Retrieve username and password from database according to user's input
	$login = mysql_query("SELECT * FROM user WHERE (username = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . mysql_real_escape_string(md5($_POST['password'])) . "')");

	// Check username and password match
	if (mysql_num_rows($login) == 1) {
	// Set username session variable
		$_SESSION['username'] = $_POST['username'];
		// Jump to secured page
		header('Location: securedpage.php');
	}
	else {
			// Jump to login page
			header('Location: index.php');
		}

?>
