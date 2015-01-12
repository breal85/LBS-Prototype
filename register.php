<?php
 include("connection.php");//connect to database server and file

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{

	 //create POST array to collect data from the registration form
	 if(isset($_POST['first_name'])){$first_name = $_POST['first_name'];}
	 if(isset($_POST['last_name'])){ $last_name = $_POST['last_name'];}
	 if(isset($_POST['national_ID'])){$national_ID = $_POST['national_ID'];}
	 if(isset($_POST['email'])){$email = $_POST['email'];}
	 if(isset($_POST['username'])){$username = $_POST['username'];}
	 if(isset($_POST['password'])){$password = $_POST['password'];}
}
 //a query for inserting POST array data into database table
 $query= "INSERT INTO owner (First_Name, Last_Name, National_ID, Username, Email_Address, Password) VALUES ('$first_name', '$last_name', '$national_ID', '$username', '$email', SHA('$password'))";
 
 $result = mysql_query($query) or die ("Error in updating database!");//query the database by inserting the values
 
 
 if (!$result){
     //redirect to unsuccessful message html page if query is erroneous
	 $unsucesss_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/unsuccessful.php';
     header('Location:',$unsucesss_url);
     //echo "Registration not successful";
     }
 	
     else{
         $sucesss_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/success.php';
      	 header('Location: ' . $sucesss_url);
         //echo "Registration successful.";
     }
 
 //close database server connection
 mysql_close($connect);
 
?>