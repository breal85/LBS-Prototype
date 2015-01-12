//reverse geocoding
function writeAddressName(latLng)
 {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode(
        {
          "location": latLng
        },
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK)
            document.getElementById("address").innerHTML = results[0].formatted_address;
          else
            document.getElementById("error").innerHTML += "Unable to retrieve your address" + "<br />";
        });
}

function geolocationSuccess(position) 
{
        var lat = position.coords.latitude;
		var long = position.coords.longitude;
		
		//Print latitude and longitude coordinates
		printLatLong(lat,long);
		
		//output latitude and longitude into hidden fields
		sendLatLong(lat, long);
		
        //get center coordinates
		var userLatLng = new google.maps.LatLng(lat, long);

        // Write the formatted location address
		writeAddressName(userLatLng);

        var myOptions = 
        {
          zoom : 16,
          center : userLatLng,
          mapTypeId : google.maps.MapTypeId.ROADMAP
        };
        // Draw the map
        var mapObject = new google.maps.Map(document.getElementById("map"), myOptions);
        // Place the marker
        new google.maps.Marker(
        {
          map: mapObject,
          position: userLatLng
        });
        // Draw a circle around the user position to have an idea of the current localization accuracy
        /*var circle = new google.maps.Circle(
        {
          center: userLatLng,
          radius: position.coords.accuracy,
          map: mapObject,
          fillColor: '#0000FF',
          fillOpacity: 0.4,
          strokeColor: '#0000FF',
          strokeOpacity: 0.8
        });

        mapObject.fitBounds(circle.getBounds());*/
}

function geolocationError(positionError) 
{
        document.getElementById("error").innerHTML += "Error: " + positionError.message + "<br />";
}

//output latitude and longitude
function printLatLong(lat,long){
	document.getElementById("lat").innerHTML += "Latitude: " + lat + "<br/>";
	document.getElementById("long").innerHTML += "Longitude: " + long + "<br/>";
}

//output latitude and longitude into hidden fields
function sendLatLong(lat,long){
	document.getElementById("longitude").value = lat;
	document.getElementById("latitude").value =  long;
}

function geolocateUser()
 {
        // If the browser supports the Geolocation API
        if (navigator.geolocation)
        {
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