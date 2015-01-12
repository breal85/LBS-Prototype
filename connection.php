<?php

	

    $host = "localhost";//local host name of database

    $user = "thekenya_padmin";//username of the database

    $password = "padmin2013";//password of the database

    $database_name ="thekenya_prototype";//name of the database

	

    //pass the above credentials to the database connection code below

    $connect = mysql_connect($host,$user,$password) or die("Unable to connect to database");//get credentials and connect to database server

	

    mysql_select_db($database_name, $connect) or die(mysql_errno() . ": " . mysql_error() . "<br>");//select database

	

	function mysql_safe_string($value) {

		$value = trim($value);

		if(empty($value))           return 'NULL';

		elseif(is_numeric($value))  return $value;

		else                        return "'".mysql_real_escape_string($value)."'";

	}

	

	function mysql_safe_query($query) {

		$args = array_slice(func_get_args(),1);

		$args = array_map('mysql_safe_string',$args);

		return mysql_query(vsprintf($query,$args));

	}

	

	//redirecting function

	function redirect($uri) {

		header('location:'.$uri);

		exit;

	}

?>