<?php
  include("connection.php");//connect to database server and file by including the connection file
  error_reporting (E_ALL ^ E_NOTICE);
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['Owner_ID'])) 
  {
    if (isset($_COOKIE['Owner_ID']) && isset($_COOKIE['Username'])) 
	   {
        $_SESSION['Owner_ID'] = $_COOKIE['Owner_ID'];
        $_SESSION['Username'] = $_COOKIE['Username'];
      }
  }

                //create a variable to store session for the user that has logged in
                  $sessionUser = $_SESSION['Owner_ID'];//this id will be stored in the small business table

                  //register business details into the table that stores the business info

                  //check if post array is empty
                  $post = (!empty($_POST)) ? true : false;

                  //if post array is not empty execute  
                  if($post)

                  {
                     //create POST array to collect data from the business registration form
                    //confirm first whether the data has been set before assigning it a variable
                     if(isset($_POST['business_name'])){$business_name = $_POST['business_name'];}
                     if(isset($_POST['mobile_number'])){ $mobile_number = $_POST['mobile_number'];}
                     if(isset($_POST['email_business'])){$email_business = $_POST['email_business'];}
                     if(isset($_POST['longitude'])){$longitude = $_POST['longitude'];}
                     if(isset($_POST['latitude'])){$latitude = $_POST['latitude'];}
                  }

                   if (isset($_POST['businessReg_button'])) {

                        //a query for inserting POST array data into database table
                        $query= "INSERT INTO small_business (OwnerID,Business_Name, Mobile_Number, Email_Address, Latitude, Longitude) VALUES ('$sessionUser','$business_name', '$mobile_number', '$email_business', '$longitude', '$latitude')";
                       
                       $result = mysql_query($query) or die ($query."<br/><br/>".mysql_error());//query the database by inserting the values
                       
                       
                       if (!$result)
                        {
							$unsucesss_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/unsuccessful.php';
      						header('Location: ' . $unsucesss_url);
                           //redirect to unsuccessful message html page if query is erroneous
                           //header('Location: http://localhost:83/LBSPrototype/public_html/unsuccessful.html');
                           //echo "Registration not successful";
                        }
                        
                       else
					   {
				$sucesss_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/businesssuccess.php';
				header('Location: ' . $sucesss_url);
						   //header('Location: http://localhost:83/LBSPrototype/public_html/businesssuccess.php');
						   //echo "Registration successful.";
					   }
                       
                       //close database server connection
                       mysql_close($connect);
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
        <title>Business Registration</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css"><!--CSS file for styling the form-->
        <link rel="stylesheet" href="css/map.css"><!--CSS file for styling the map-->
        
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyCAZO7zj9pG9UQ9PGz1f7o7h4oYC2cwOKM&sensor=true"></script>
        <script src="js/maps.js"></script>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <body>
         <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
         <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Register Business</h1>
                <nav>
                </nav>
            </header>
        </div>
         
        <div class="main-container">
            <div class="main wrapper clearfix">
             <article>
             
             <section>
             <?php 
          // Make sure the user is logged in before going any further.
          if (!isset($_SESSION['Owner_ID'])) 
          {
             echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
             exit();
          }
          else 
          {
            echo('<p class="login">Hallo ' . $_SESSION['Username'] . '. <a href="logout.php">Log out</a>.</p><p>
              Please register your business details in the form below:</p>');
          }
            ?>
                </section>

                <section id="businessReg_form">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="businessReg_form">
                    <label for="business_name">Businesss Name:</label>
                    <input name="business_name" type="text" size="30" maxlength="30" id="business_name" required>
                    
                    <label for="mobile_number">Mobile Number:</label>
                    <input name="mobile_number" type="text" size="30" maxlength="30" id="mobile_number" required>
                    
                    <label for="email_business">Email Address:</label>
                    <input name="email_business" type="text" size="30" maxlength="30" id="email_address" required>

                    <label for="longitude">Longitude:</label>
                    <input name="longitude" type="text" size="30" maxlength="30" id="longitude" required>

                    <label for="latitude">Latitude:</label>
                    <input name="latitude" type="text" size="30" maxlength="30" id="latitude" required>
                              
                    <input name="businessReg_button" type="submit" value="Register" class="button_form">
                    
                    <input name="input_lat" type="hidden" value="" id="input_lat">
                    
                    <input name="input_long" type="hidden" value="" id="input_long">
                        
                </form>
              </section>
         
              <section>
                <p><b>The current location of your business:</b></p>
                    <div id="map"></div>
                    <p><b>Address</b>: <span id="address"></span></p>
                    <p><b>Coordinates</b>:</p>
                    <p><span id="lat"></span></p>
                    <p><span id="long"></span></p>
                    <p id="error"></p>
                    
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
         <!--Google Analytics Script-->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>