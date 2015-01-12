var mapObject;
var markers = [];
var infoWindow;

function geolocationError(positionError) {
	document.getElementById("error").innerHTML += "Error: " + positionError.message + "<br />";
}

//get current position of the user
function geolocationSuccess(position) {
        //Print latitude and longitude coordinates
        printLatLong(position.coords.latitude, position.coords.longitude);

        var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        
        // Write the formatted location address
        writeAddressName(userLatLng);

        //create optional parameters for the map
            var myOptions =
               {
                   zoom: 16,
                   center: userLatLng,
                   mapTypeId: google.maps.MapTypeId.ROADMAP
               };

            // Draw the map
            mapObject = new google.maps.Map(document.getElementById('customer_map'), myOptions);
            
            //search for products and show markings
            infoWindow = new google.maps.InfoWindow;

    		// Create the marker for the user's position
    		var cMarker = new google.maps.Marker({
       		position: userLatLng,
        	title: 'Your Location',
        	map: mapObject,
			icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
			shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
    		});

}

function searchLocations() {
    var currentLatCoordinates = document.getElementById('lat').value;
    var currentLongCoordinates = document.getElementById('long').value;

}

function searchNearLocations()
{
    clearLocations();
    var bounds = new google.maps.LatLngBounds();
   
    var productSearch = document.getElementById('product_name').value;
   /* var currentLatCoordinates = document.getElementById('lat').value;//get current latitude of user
    var currentLongCoordinates = document.getElementById('long').value;//get current longitude of user
    var searchURL = 'customer_search.php?product_name=' + productSearch + '?lng=' + currentLongCoordinates + '?lat=' + currentLatCoordinates;
    */
    var searchURL = 'customer_search.php?product_name=' + productSearch;

    downloadUrl(searchURL, function (data) {
        var xml = data.responseXML;
        var markerNodes = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markerNodes.length; i++)
        {
            var business_name = markerNodes[i].getAttribute("business_name");
            var product_name = markerNodes[i].getAttribute("product_name");
            var product_price = markerNodes[i].getAttribute("product_price");
            var product_category = markerNodes[i].getAttribute("category_name");
            var point = new google.maps.LatLng(
                parseFloat(markerNodes[i].getAttribute("latitude")),
                parseFloat(markerNodes[i].getAttribute("longitude")));

            createMarker(point, business_name, product_name, product_price, product_category);
            //bounds.extend(point);
        }
    });
    //mapObject.fitBounds(bounds);
}

//Function for clearing any markers on the map when searching for another product
function clearLocations() {
    infoWindow.close();
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers.length = 0;
}

//function for creating map marker
function createMarker(point, business_name, product_name, product_price, product_category) {
    var html = '<div id="content" style="font-family:9px;"><small>Business Name:<b>' + business_name + '</b></small><br/><small>Product: <b>' + product_name + '</b></small><br /><small>Price(Ksh.): <b>' + product_price + '</b></small><br /><small>Category: <b>' + product_category + '</b></small></div>';
    var marker = new google.maps.Marker({
        map: mapObject,
        position: point
    });

    //CREATE INFO WINDOW WHEN MARKER IS CLICKED
    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(html);
        infoWindow.open(mapObject, marker);
    });
    markers.push(marker);
}
/*
function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
*/
function downloadUrl(url, callback)
{
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

//output latitude and longitude
function printLatLong(lat, long) {
    document.getElementById("lat").innerHTML += lat + "<br/>";
    document.getElementById("long").innerHTML += long + "<br/>";
}

//convert current coordinates into actual location address
function writeAddressName(latLng) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode(
    {
        "location": latLng
    },
    function (results, status) {
        if (status == google.maps.GeocoderStatus.OK)
            document.getElementById("address").innerHTML = results[0].formatted_address;
        else
            document.getElementById("error").innerHTML += "Unable to retrieve your address" + "<br />";
    });
}
function doNothing() { }

//get the user's current position
function geolocateUser() {
    // If the browser supports the Geolocation API
    if (navigator.geolocation) {
        var positionOptions =
        {
            enableHighAccuracy: true,
            timeout: 10 * 1000 // 10 seconds
        };
        //geolocation API
        navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError, positionOptions);
    }
    else
        document.getElementById("error").innerHTML += "Your browser doesn't support the Geolocation API";
}

window.onload = geolocateUser;