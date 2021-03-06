<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
        <script src="js/customer_map.js"></script>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<title>Product Search</title>
</head>

<body onload="load()">
	<div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Product Search</h1>
            </header>
    </div>
	<article>
		<!--Map Section-->
		<section id="map_section">
    		<div id="map" style="width: 500px; height: 300px"></div>
		</section>
	</article>
	<!--Footer section-->
	<div class="footer-container">
            <footer class="wrapper">
                <h3>&COPY;<?php echo date("Y") ?> LBS Prototype</h3>
            </footer>
        </div>
</body>
</html>
