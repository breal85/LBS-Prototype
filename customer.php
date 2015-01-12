<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Search</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/form.css"><!--CSS file for styling the form-->
        <link rel="stylesheet" href="css/map.css"><!--CSS file for styling the map-->
        
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyCAZO7zj9pG9UQ9PGz1f7o7h4oYC2cwOKM&sensor=true"></script>
        <!--<script src="js/search_map.js"></script>-->
        <script src="js/search_map.js"></script>
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<title>Product Search</title>
</head>

<body>
	<div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">Product Search</h1>
            </header>
    </div>
    <div class="main-container">
            <div class="main wrapper clearfix">
	<article>
    	<!--Map Section-->
		<section id="map_section">
    		<div id="customer_map"></div>
            <p><b>Address</b>: <span id="address"></span></p>
            <p><u><b>Coordinates</b></u></p>
            <p><b>Latitude</b>:<span id="lat"></span></p>
            <p><b>Longitude</b>:<span id="long"></span></p>
            <p id="error"></p>
		</section>
		<!--Form section for inputting product search criteria-->
		<section id="search_section">
        <p>Enter product name and search:</p>
        <form name="product_search_form" action="view_result.php" method="post">
			<input name="product_name" type="text" size="30" maxlength="50" id="product_name" value="">
			<!--<input name="product_search_button" type="submit" value="Search" class="button_form">-->
            <input name="product_search_button" type="button" value="Search" class="button_form" onClick="searchNearLocations()">
            <input name="view_results_button" type="submit" value="View List" class="button_form">
        </form>    
		</section>
	</article>
    </div>
    </div>
	<!--Footer section-->
	<div class="footer-container">
            <footer class="wrapper">
                <h3>&COPY;<?php echo date("Y") ?> LBS Prototype</h3>
            </footer>
    </div>
</body>
</html>
