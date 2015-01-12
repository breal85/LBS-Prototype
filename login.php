<?php
//import file containing variables used to connect to the database
require_once('connectionvars.php');


// Start the session
  session_start();

  // Clear the error message
  $error_msg = "";
	// If the user isn't logged in, try to log them in
  if (!isset($_SESSION['Owner_ID'])) 
  {
		  if (isset($_POST['button_login'])) 
      {// Connect to the database and pass the above credentials to the database connection code below
    		  $connect = mysql_connect($host,$user,$password) or die("Unable to connect to database");//get credentials and connect to database server
	
    		  $dbc = mysql_select_db($database_name, $connect) or die("Unable to select database");

      		// Grab the user-entered log-in data
          //Trim any space and secure it from sql injection
      		$user_username = mysql_real_escape_string(trim($_POST['username_login']));
      		$user_password = mysql_real_escape_string(trim($_POST['password_login'])); 
			
    			if (!empty($user_username) && !empty($user_password))
          {
    					// Look up the username and password in the database and store query in $data variable
      				$query = "SELECT Owner_ID, Username FROM owner WHERE Username = '$user_username' AND Password = SHA('$user_password')";
      				$data = mysql_query($query);
      	
      				if (mysql_num_rows($data) == 1) //check if a row containing the right query has been selected
              {
      					// The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the user's page
      					$row = mysql_fetch_array($data);
      					$_SESSION['Owner_ID'] = $row['Owner_ID'];
      					$_SESSION['Username'] = $row['Username'];
      					setcookie('Owner_ID', $row['Owner_ID'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
      					setcookie('Username', $row['Username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
      					$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/profile.php';
      					header('Location: ' . $home_url);
              }
      				else
              {
      				// The username/password are incorrect so set an error message
      				 $error_msg = 'Sorry, you must enter a valid username and password to log in.';
      				}
      		 		
          }
    		  else 
          {
            // The username/password weren't entered so set an error message
            $error_msg = 'Sorry, you must enter your username and password to log in.';
          }
      } 
  }
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css">
        

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
         <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
         <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Login</h1>
                <nav>
                </nav>
            </header>
        </div>
         
        <div class="main-container">
            <div class="main wrapper clearfix">
             <article>
                    <header>
                        <p>Please enter your username and password</p>
                    </header>    
                <section>
                <?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['Owner_ID'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="login">
                    <label for="username_login">User Name:</label>
                    <input name="username_login" type="text" size="30" maxlength="10" id="username" required value="">
                    
                    <label for="password_login">Password:</label>
                    <input name="password_login" type="password" size="30" maxlength="10" id="password_login" required value="">
                    
                    <input name="button_login" type="submit" value="Login" class="button_form">
                  </form>
<?php
    }
?>
                </section>
                 <section>
                     <p>Not yet registered?</p>
                     <a href="register.html" class="button_link">Register</a>
                     
                 </section>
             </article>
            </div><!--end of main-container-->
        </div><!--end of main wrapper clear fix-->     
        <div class="footer-container">
            <footer class="wrapper">
                <h3>&COPY;<?php echo date("Y") ?> LBS Prototype</h3>
            </footer>
        </div>
         
         <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>