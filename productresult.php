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
              Product Information is below:</p>');
          }
            ?>
                </section>

              <section id="productList">
        	<form>
            	<input type="button" value="Back" onClick="history.go(-1);return true;" class="button_form">
            </form>
            <?php

            //check if post array is empty
            $post = (!empty($_POST)) ? true : false;

            //if post array is not empty execute  
            if($post)

            {
               //create POST array to collect data from the add products form
              //confirm first whether the data has been set before assigning it a variable
               if(isset($_POST['business_name'])){$selected_business = $_POST['business_name'];}
  
            }
            

						if(isset($_POST['viewProduct_button']))
						{
						$queryProductInfo = "SELECT products.Product_Name, products.Product_Price, products.Product_Details, product_category.Category_Name FROM products, product_category WHERE products.BusinessID = $selected_business AND products.Category_ID = product_category.Category_ID";
								
                $productInfo = mysql_query($queryProductInfo) or die($queryProductInfo."<br/><br/>".mysql_error());

								while ($rowProductInfo = mysql_fetch_array($productInfo))
								{
									?>
                    <div class="product_info">
                    <table class="product_table">
                    <tr>
                        <td><label class="product_label">Product Name:</label></td>
                        <td><p><?php echo $rowProductInfo['Product_Name']?></p></td>
                    </tr>
                        <td><label class="product_label">Category:</label></td>
                        <td><p><?php echo $rowProductInfo['Category_Name']?></p></td>
                    <tr>    
                        <td><label class="product_label">Product Price:</label></td>
                        <td><p><?php echo $rowProductInfo['Product_Price']?></p></td>
                   </tr>
                   <tr>
                        <td><label class="product_label">Product Details:</label></td>
                        <td><p><?php echo $rowProductInfo['Product_Details']?></p></td>
                   </tr>
                    </table>
                    </div>
									<?php
                	}
						}
						else
						{
							echo '<p class="error">Unable to get product info</p>';
						}
            ?>                     
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