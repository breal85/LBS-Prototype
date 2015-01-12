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
?>    
        
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>View Products</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css"><!--CSS file for styling the form-->
        <link rel="stylesheet" href="css/map.css"><!--CSS file for styling the map-->
        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <body>
         <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
         <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">View Products</h1>
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
              Please register your product details in the form below:</p>');
          }
            ?>
                </section>

              <section id="productList">
              	<form action="productresult.php" method="post" name="viewProduct_form">
                      <label>Select The Name of your Business:</label> </br>	
                    <?php
                      //query from small_business and product database
                      if (isset($_SESSION['Owner_ID']))//check if session has been set to owner ID
                      {
                        //create a variable to store session for the user that has logged in
                        $sessionUserID = $_SESSION['Owner_ID'];//this id is stored in the small business table
                        $queryBusinessID = "SELECT BusinessID, Business_Name FROM small_business WHERE OwnerID = '$sessionUserID'";
                        $business_data = mysql_query($queryBusinessID) or die (mysql_errno() . ": " . mysql_error() . "<br>");
                        while ($row = mysql_fetch_array($business_data))
                        { ?>     
                        	<input type="radio" name="business_name" value="<?php echo $row['BusinessID'] ?>" id="b1"/> 
                            <label for="b1"><?php echo $row['Business_Name'] ?></label> </br>
                        <?php 
                        }
                      }
                        else{echo "<p>Unable to get Business ID value</p>";}
                      ?>
                       <input name="viewProduct_button" type="submit" value="View Product" class="button_form">
                  </form>                     
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
    </body>
</html>                      