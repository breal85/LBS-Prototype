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

  //store business ID variable
  //$business_ID = $row['BusinessID'];

  //::::register product details into the table that stores the product info::::

  //check if post array is empty
  $post = (!empty($_POST)) ? true : false;

  //if post array is not empty execute  
  if($post)

  {
     //create POST array to collect data from the add products form
    //confirm first whether the data has been set before assigning it a variable
     if(isset($_POST['business_name'])){$business_name = $_POST['business_name'];}
     if(isset($_POST['product_name'])){$product_name = $_POST['product_name'];}
     if(isset($_POST['category'])){ $category = $_POST['category'];}
     if(isset($_POST['product_price'])){$product_price = $_POST['product_price'];}
     if(isset($_POST['product_details'])){$product_details = $_POST['product_details'];}
  }

   if (isset($_POST['productReg_button'])) 
   {
      //a query for inserting POST array data into database table
      $queryProducts= "INSERT INTO products (BusinessID, Product_Name, Product_Price, Category_ID, Product_Details) VALUES ('$business_name','$product_name','$product_price','$category','$product_details')";
       
      $result = mysql_query($queryProducts) or die (mysql_errno() . ": " . mysql_error() . "<br>");//query the database by inserting the values
         
      if (!$result)
        {
           //redirect to unsuccessful message html page if query is erroneous
           header('Location: http://localhost:83/LBSPrototype/public_html/unsuccessful.html');
           //echo "Registration not successful";
        }
        
       else
       {
           //header('Location: productsuccess.php');\
           $redirect_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/productsuccess.php';
           header('Location: productsuccess.php');
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
        <title>Add Product</title>
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
                <h1 class="title">Add Product</h1>
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
            echo('<p class="login">Hallo <b>'. $_SESSION['Username'] . '</b>. <a href="logout.php">Log out</a>.</p><p>
              Please register your product details in the form below:</p>');
          }
            ?>
                </section>

                <section id="productReg_form">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="businessReg_form">
                      <label>Select The Name of your Business:</label> </br>
                      <?php
                      //query from database for business ID
                        /*create session variable for business ID so that it can be stored
                      in the products table to create a foreign table*/

                      //query small business table if session variable is set
                      if (isset($_SESSION['Owner_ID'])) 
                      {
                        //create a variable to store session for the user that has logged in
                        $sessionUserID = $_SESSION['Owner_ID'];//this id is stored in the small business table

                        //query small business table to get the BusinessID column value
                        $queryBusinessID = "SELECT BusinessID, Business_Name FROM small_business WHERE OwnerID = '$sessionUserID'";
                        $business_data = mysql_query($queryBusinessID);
 
                        while ($row = mysql_fetch_array($business_data))
                        { ?> 
                            
                            <input type="radio" name="business_name" value="<?php echo $row['BusinessID'] ?>" id="b1"/> 
                            <label for="b1"><?php echo $row['Business_Name'] ?></label> </br>
                        <?php 
                        }
                      }
                        else{echo "<p>Unable to get Business ID value</p>";}
                      ?>      
                    <label for="product_name">Product Name:</label>
                    <input name="product_name" type="text" size="30" maxlength="30" id="product_name" required>
                    
                    <label for="category">Category:</label> </br>
                    <input type="radio" name="category" value="1" id="r1" /> 
                    <label for="r1">Electronics</label> </br>
                    <input type="radio" name="category" value="2" id="r2"/> 
                     <label for="r2">Clothing</label> </br>
                    <input type="radio" name="category" value="3" id="r3"/> 
                     <label for="r3">Footwear</label> </br>
                    <input type="radio" name="category" value="4" id="r4"/>
                     <label for="r4">Cosmetics</label> </br>
                    <input type="radio" name="category" value="5" id="r5"/>
                     <label for="r5">Food</label> <br/ >

                    <!--<input name="category" type="text" size="30" maxlength="30" id="category" list="category_list" required>-->
                    <!--<select id = "category">Drop Down List
                      <option value ="1">Electronics</option>
                      <option value ="2">Clothing</option>
                      <option value ="3">Footwear</option>
                      <option value ="4">Cosmetics</option>
                      <option value ="5">Food</option>
                    </select>-->
                    
                    <label for="product_price">Product Price:</label>
                    <input name="product_price" type="text" size="30" maxlength="30" id="product_price" required>

                    <label for="product_details">Product Details:</label>
                    <!--<input name="product_details" type="" size="30" maxlength="30" id="product_details" required>-->
                    <textarea  name="product_details" rows="4" cols="30" id="product_details" required></textarea>

                    <input name="productReg_button" type="submit" value="Add Product" class="button_form">   
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
         <!--Google Analytics Script-->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>