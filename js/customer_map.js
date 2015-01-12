var map;
var markers = [];
var infoWindow;

function clearLocationResults()
{
	infoWindow.close();
  	for (var i = 0; i < markers.length; i++) 
	{
    	markers[i].setMap(null);
  	}
  	
	markers.length = 0;

  	locationSelect.innerHTML = "";
}

function getProductSearch()
{
	//clearLocationResults();
	
	var productSearch = document.getElementById('product_name').value;
	  
	var searchURL = 'customer_search.php?product_name=' + productSearch;
	  	
    downloadUrl(searchURL, function(data)
	{
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) 
		{
			  var business_name = markers[i].getAttribute("business_name");
			  var product_name = markers[i].getAttribute("product_name");
			  var product_price = markers[i].getAttribute("product_price");
			  var product_category = markers[i].getAttribute("category_name");
			  var point = new google.maps.LatLng(
				  parseFloat(markers[i].getAttribute("latitude")),
				  parseFloat(markers[i].getAttribute("longitude")));
			 createMarker(point, business_name, product_name,product_price,product_category);
					  
		}
      });
}

//method for creating marker and info window
function createMarker(point, business_name, product_name,product_price,product_category)
{
	 var html = "<b>" + business_name + "</b> <br/>" + product_name + "<br />"+ product_price +"<br />"+product_category;
  	 var marker = new google.maps.Marker({map: map,position: point,});
	 
   	 google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
  	 markers.push(marker);
}


function load() 
{
      var map = new google.maps.Map(document.getElementById("customer_map"), {
        center: new google.maps.LatLng(-1.29207,36.82195 ),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      var infoWindow = new google.maps.InfoWindow;
}



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

/*function parseXml(str) 
{
      if (window.ActiveXObject) 
	  {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } 
	  else if (window.DOMParser)
	  {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
}*/

function doNothing() {}