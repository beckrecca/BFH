// sets the bounds for our map
var bounds;
// generates the directions panel
var directionsDisplay;
// retrieves the directions
var directionsService;
// finds GPS coordinates for the user's address
var geocoder;
var map;
// keep track of the previous marker clicked
var previousClick;

/*
* initMap() is called by the Google Maps API key script.
* It initializes a map and a directions panel.
*/
function initMap() {
  // create a new directions panel
  directionsDisplay = new google.maps.DirectionsRenderer();

  // create a directions service to obtain the directions
  directionsService = new google.maps.DirectionsService();

  // set the map to the designated div
  map = new google.maps.Map(document.getElementById('hike-map'));

  // associate the directions display with our map
  directionsDisplay.setMap(map);

  // set the directions panel to the designated div
  directionsDisplay.setPanel(document.getElementById("directionsPanel"));

  // initialize bounds for our map
  bounds =  new google.maps.LatLngBounds();

  // create a marker for each entrance
  for (var i = 0; i < markers.length; i++) {
    var marker = new google.maps.Marker({
      position: {lat: parseFloat(markers[i].lat), lng: parseFloat(markers[i].lng)},
      map: map,
      title: markers[i].name,
      // Infowindow content
      content: panelContent(markers[i].name, markers[i].address),
      // marker color
      icon: '/img/markers/blue-dot.png',
      // animates when dropped on the map
      animation: google.maps.Animation.DROP
    });
    // add this marker to the map's bounds
    bounds.extend(new google.maps.LatLng(parseFloat(markers[i].lat), parseFloat(markers[i].lng)));
    // create an information window for this marker
    var infoWindow = new google.maps.InfoWindow();
    // add a listener to the marker for actions on click
    google.maps.event.addListener(marker, 'click', function () {
      // set the info window content
      infoWindow.setContent(this.content);
      // set the info window to open on click
      infoWindow.open(this.getMap(), this);
      // if this marker is animated, stop animation on click
      if (this.getAnimation() != null) {
        this.setAnimation(null);
      } else {
        // if this marker is not animated, animate it on click
        this.setAnimation(google.maps.Animation.BOUNCE);
        // also change the marker to orange
        this.setIcon('/img/markers/orange-dot.png');
        // if another marker was previously clicked,
        if (previousClick != null) {
          // stop its animation
          previousClick.setAnimation(null);
          // and change it back to blue
          previousClick.setIcon('/img/markers/blue-dot.png');
        }
        // remember this marker as having just been clicked
        previousClick = this;
      }
    });
  }

  // if we have more than one marker, set the bounds around them
  if (markers.length > 1) {
    map.fitBounds(bounds);
    map.panToBounds(bounds);
    // add a window resize listener to create a responsive map
    google.maps.event.addDomListener(window, "resize", function() {
      google.maps.event.trigger(map, "resize");
      // keep the markers within the map's bounds
      map.fitBounds(bounds);
      map.panToBounds(bounds);
    });
  }
  // otherwise, if only one or two, center and zoom appropriately
  else if (markers.length < 2) {
    map.setCenter(bounds.getCenter());
    map.setZoom(13);
    var center = map.getCenter();
    // add a window resize listener to create a responsive map
    google.maps.event.addDomListener(window, "resize", function() {
      // keep the map centered
      map.setCenter(center);
    });
  }
  
  $('form').submit(function(e) {
    e.preventDefault();
    // marker.setMap(null);
    calcRoute();
  });
}

/*
* calcRoute() is called by initMap()
* It find the directions for the selected start and end points,
* and it delivers them in a directions panel.
*/
function calcRoute() {
  // Start is the user's address
  var start = $('#start').val();
  // End is the selected destination
  var end = markers[$('#end').val()].address;

  // Create a new Date to indicate time leaving/arriving
  var dateTime = new Date();

  // Initialize a timeOptions variable for the directions request
  var timeOptions = {};
  // Update date and time Leaving at or Arriving by according to user input
  var going = "Leaving at "
  // If the user selected a date and time leaving
  if ($("#datetimepicker").val() != null && $("#datetimepicker").val() != "") {
    // set the dateTime to the selected date and time
    dateTime = new Date($("#datetimepicker").val());
    // if the user selected Arriving by
    if ($('#transitOptions').val() == "arrivalTime") {
      // update the timeOptions var to set the arrival time to the selected date and time
      timeOptions = {
        arrivalTime: dateTime
      };
      going = "Arriving by ";
    }
    // if the user selected Leaving by, do the same with departure time
    else if ($('#transitOptions').val() == "depatureTime") {
      timeOptions = {
        departureTime: dateTime
      };
    }
  }

  // create directions request
  var request = {
    origin:start,
    destination:end,
    // set travel mode to public transit
    travelMode: google.maps.TravelMode.TRANSIT,
    // set transit options specified above
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