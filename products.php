<?php
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
        <title>Manage Products</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css"><!--CSS file for styling the form-->
        
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
    </head>
    <body>
         <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
         <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Manage Products</h1>
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
                if (!isset($_SESSION['Owner_ID'])) {
                   echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
                  exit();
                }
                else {
                  echo('<p class="login">Hallo ' . $_SESSION['Username'] . '. <a href="logout.php">Log out</a>.</p><p>
                    Manage your products</p>');
               }
            ?>
            </section>

            <!--Product Menu Links-->
            <section id="products_menu">
                <a href="addproduct.php" class="button_link">Add Product</a>
                <a href="viewproducts.php" class="button_link">View Products</a>
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