<?php
include("connection.php");//connect to database server and file by including the connection file
error_reporting (E_ALL ^ E_NOTICE);

$expire = time()+60*60*24*30;
setcookie('name', $_POST['name'], $expire, '/');
setcookie('email', $_POST['email'], $expire, '/');

mysql_safe_query('INSERT INTO customer_feedback (Name,Email,Feedback,Product_ID,BusinessID,Date) VALUES (%s,%s,%s,%s,%s,%s)', 
    $_POST['name'], $_POST['email'], $_POST['content'], $_GET['id'], $_GET['b_id'], time());
mysql_safe_query('UPDATE products SET num_comments=num_comments+1 WHERE ProductID=%s LIMIT 1', $_GET['id']);
redirect('productdetails.php?id='.$_GET['id'].'&b_id='.$_GET['b_id'].'#product-'.mysql_insert_id());
?>