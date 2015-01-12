<?php
include("connection.php");//connect to database server and file by including the connection file
error_reporting (E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>View Result</title>
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
              <section id="productResult">
              <?php
        		$getProductID = $_GET['id'];
				$getBusinessID = $_GET['b_id'];
// Select all the rows that have the specific product id number in the product table
$query = "SELECT small_business.Business_Name,products.ProductID,products.Product_Name,products.Product_Price, products.Product_Details, product_category.Category_Name FROM product_category, products, small_business WHERE small_business.BusinessID = '$getBusinessID' AND products.ProductID = '$getProductID' AND products.Category_ID = product_category.Category_ID LIMIT 1";
				//$result = mysql_safe_query($query);
				/*if(!mysql_num_rows($result)) {
					echo 'Product #'.$getProductID.' not found';
					exit;
				}*/
				$result = mysql_query($query) or die($query."<br/><br/>".mysql_error());
				
				$row = mysql_fetch_assoc($result);
?>
				 <div class="product_info">
                 <input type="button" value="Back" onClick="history.go(-1);return true;" class="button_form">
                 <table class="product_table">
                 <tr>
                        <td><label class="product_label">Business Name:</label></td>
                        <td><p><?php echo $row['Business_Name']?></p></td>
                 </tr>
                 <tr>
                        <td><label class="product_label">Product Name:</label></td>
                        <td><p><?php echo $row['Product_Name']?></p></td>
                 </tr>
                 <tr>
                        <td><label class="product_label">Category:</label></td>
                        <td><p><?php echo $row['Category_Name']?></p></td>
                 </tr>      
                        <td><label class="product_label">Product Price:</label></td>
                        <td><p><?php echo $row['Product_Price']?></p></td>
                 <tr>      
                        <td><label class="product_label">Product Details:</label></td>
                        <td><p><?php echo $row['Product_Details']?></p></td>
                 </tr>
                  </table>
                        <?php echo '<hr/>'; ?>
                 </div>
                <!-- comment form-->
                 <div id="comment_section">
                 	<?php
					//comment output
					$resultComments = mysql_safe_query('SELECT * FROM customer_feedback WHERE Product_ID=%s AND BusinessID=%s ORDER BY Date ASC', $_GET['id'],$_GET['b_id']);
					echo '<ol id="comments">';
while($row = mysql_fetch_assoc($resultComments)) {
	echo '<div class="comment_box">';
    echo '<li id="product-'.$row['Feedback_ID'].'">';
    echo ('<strong>'.$row['Name'].'</strong><br/>');
    //echo ' (<a href="comment_delete.php?id='.$row['id'].'&post='.$_GET['id'].'">Delete</a>)<br/>';
    echo '<small>'.date('j-M-Y g:ia', $row['Date']).'</small><br/>';
    echo nl2br($row['Feedback']);
    echo '</li>';
	echo '</div>';
	echo '<hr/>';
}
echo '</ol>';
echo <<<HTML
<form method="post" action="comment_add.php?id={$getProductID}&b_id={$getBusinessID}">
    <table>
        <tr>
            <td><label for="name">Name:</label></td>
            <td><input name="name" id="name" value="{$_COOKIE['name']}"/></td>
        </tr>
        <tr>
            <td><label for="email">Email:</label></td>
            <td><input name="email" id="email" value="{$_COOKIE['email']}"/></td>
        </tr>
        <tr>
            <td><label for="content">Comments:</label></td>
            <td><textarea name="content" id="content"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Post Comment" class="button_form"/></td>
        </tr>
    </table>
</form>
HTML;
?>
                 </div>
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