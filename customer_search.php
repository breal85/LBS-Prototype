<?php
require("connection.php");

//Get parameter from URL
$product_name = $_GET["product_name"];
$c_lat = $_GET["lat"];
$c_lng = $_GET["lng"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Select all the rows that have a specific product search criteria in the product table table
$query = "SELECT small_business.Business_Name, small_business.Latitude,small_business.Longitude,products.Product_Name,products.Product_Price, product_category.Category_Name FROM product_category, products, small_business WHERE small_business.BusinessID = products.BusinessID AND products.Product_Name = '$product_name' AND products.Category_ID = product_category.Category_ID";

/*$query = sprintf("SELECT small_business.Business_Name, small_business.Latitude,small_business.Longitude,products.Product_Name,products.Product_Price, product_category.Category_Name, ( 6371 * acos( cos( radians('%s') ) * cos( radians( small_business.Latitude ) ) * cos( radians( small_business.Longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( small_business.Latitude ) ) ) ) AS distance FROM product_category, products, small_business WHERE small_business.BusinessID = products.BusinessID AND products.Product_Name = '$product_name' AND products.Category_ID = product_category.Category_ID HAVING distance < 30 ORDER BY distance LIMIT 0 , 20",
  mysql_real_escape_string($c_lat),
  mysql_real_escape_string($c_lng),
  mysql_real_escape_string($c_lat));*/

$result = mysql_query($query);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("business_name",$row['Business_Name']);
  $newnode->setAttribute("product_name", $row['Product_Name']);  
  $newnode->setAttribute("product_price", $row['Product_Price']);  
  $newnode->setAttribute("category_name", $row['Category_Name']);
  $newnode->setAttribute("latitude", $row['Latitude']);
  $newnode->setAttribute("longitude", $row['Longitude']);
} 

echo $dom->saveXML();


?>