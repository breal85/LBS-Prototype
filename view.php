<?php

require("connection.php");

//check if post array is empty
$post = (!empty($_POST)) ? true : false;

//if post array is not empty execute  
if($post)
{
    if(isset($_POST['product_name'])){$product_name = $_POST['product_name'];}
}

if (isset($_POST['view_results']))
{
    // Select all the rows that have a specific product search criteria in the product table table
    $query = "SELECT small_business.Business_Name, small_business.Latitude,small_business.Longitude,products.Product_Name,products.Product_Price, product_category.Category_Name FROM product_category, products, small_business WHERE small_business.BusinessID = products.BusinessID AND products.Product_Name = '$product_name' AND products.Category_ID = product_category.Category_ID";

    $result = mysql_query($query);

    if (!$result) 
    {
        die('Invalid query: ' . mysql_error());
    }
    
    while ($rowProductInfo = mysql_fetch_array($result))
    {
        
    }
}


?>