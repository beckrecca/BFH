// sets the bounds for our map
var bounds;
// generates the directions panel
var directionsDisplay;
// retrieves the directions
var directionsService;
// finds GPS coordinates for the user's address
var geocoder;
var map;
// create a dummy marker so we can add multiple information windows
var previousMarker;

/*
* initMap() is called by the Google Maps API key script.
* It initializes a map and a directions panel.
*/
function initMap() {
  // create a new directions panel
  //directionsDisplay = new google.maps.DirectionsRenderer();

  // create a directions service to obtain the directions
  //directionsService = new google.maps.DirectionsService();

  // set the map to the designated div
  map = new google.maps.Map(document.getElementById('hike-map'));

  // associate the directions display with our map
  //directionsDisplay.setMap(map);

  // set the directions panel to the designated div
  //directionsDisplay.setPanel(document.getElementById("directionsPanel"));

  // initialize bounds for our map
  bounds =  new google.maps.LatLngBounds();

  // create a marker for each entrance
  for (var i = 0; i < markers.length; i++) {
    var marker = new google.maps.Marker({
      position: {lat: parseFloat(markers[i].lat), lng: parseFloat(markers[i].lng)},
      map: map,
      title: markers[i].name,
      content: panelContent(markers[i].name, markers[i].address)
    });
    // add this marker to the map's bounds
    bounds.extend(new google.maps.LatLng(parseFloat(markers[i].lat), parseFloat(markers[i].lng)));
    // create an information window for this marker
    var infoWindow = new google.maps.InfoWindow();
    // add a listener to the marker to open the info window on click
    google.maps.event.addListener(marker, 'click', function () {
      infoWindow.setContent(this.content);
      infoWindow.open(this.getMap(), this);
    });
  }

  // if we have more than one marker, set the bounds around them
  if (markers.length > 1) {
    map.fitBounds(bounds);
    map.panToBounds(bounds);
  }
  // otherwise, if only one or two, center and zoom appropriately
  else if (markers.length <= 2) {
    map.setCenter(bounds.getCenter());
    map.setZoom(13);
  }
  /** 
  
  var infoContent = '<p>' + $('#title').val() + '<br/>' + $('#address').val(); + '</p>';
  var infowindow = new google.maps.InfoWindow({
    content: infoContent
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
  
  $('form').submit(function(e) {
    e.preventDefault();
    // marker.setMap(null);
    // calcRoute();
  });
  // responsive map
  google.maps.event.addDomListener(window, "resize", function() {
    var center = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(center); 
  });
    **/
}

/* 
function calcRoute() {
  var start = $('#start').val();
  var end = $('#address').val();
  var dateTime = new Date();
  var timeOptions = {};
  var going = "Leaving at "
  if ($("#datetimepicker").val() != null && $("#datetimepicker").val() != "") {
    dateTime = new Date($("#datetimepicker").val());
    if ($('#transitOptions').val() == "arrivalTime") {
      timeOptions = {
        arrivalTime: dateTime
      };
      going = "Arriving by ";
    }
    else {
      timeOptions = {
        departureTime: dateTime
      };
    }
  }

  // create directions request
  var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.TRANSIT,
    transitOptions: timeOptions
  };
  // draw the directions & create directions panel display
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      $("#timing").html(going + convertDateTime(dateTime));
    }
  });
}
*/

/*
* panelContent() is called by initMap()
* It generates content for each marker's information window.
*/
function panelContent(name, address) {
  return "<span style='font-weight: bold'>" + name + "</span><br/>" + address;
}

function convertDateTime(d) {
  var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  return convertTime(d) + " on " + week[d.getDay()] + " " + month[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
}
function convertTime(d) {
  var h = d.getHours();
  var mer = "am";
  if (h > 12) {
    h = h - 12;
    mer = "pm";
  }
  var min = d.getMinutes();
  if (min < 10) { min = "0" + min };
  return h + ":" + min + mer;
}
