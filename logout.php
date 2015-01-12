<?php
  // If the user is logged in, delete the session vars to log them out
  session_start();
  if (isset($_SESSION['Owner_ID'])) {
    // Delete the session vars by clearing the $_SESSION array
    $_SESSION = array();

    // Delete the session cookie by setting its expiration to an hour ago (3600)
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Destroy the session
    session_destroy();
  }

  // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
  //setcookie('Owner_ID', '', time() - 3600);
  //setcookie('Us out messagername', '', time() - 3600);

  // Redirect to the login page
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
  header('Location: ' . $home_url);
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Logged Out</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
         <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        
         <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Logged Out</h1>
                <nav>
                </nav>
            </header>
        </div>
         
        <div class="main-container">
            <div class="main wrapper clearfix">
             <article>
             <section>
             
          
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