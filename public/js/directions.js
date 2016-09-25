// bounds sets the bounds for our map
var bounds;
// The Directions Display generates the directions panel
var directionsDisplay;
// The Directions Service retrieves the directions
var directionsService;
// The Geocoder finds GPS coordinates for the user's address
var geocoder;
var defaultIcon = '/img/markers/blue-dot.png';
var map;
var markers = []; 
var markedIcon = '/img/markers/orange-dot.png';
// keep track of which entrance was just selected
var previousSelected;
// the selected entrance defaults to 0
var selected = 0;
/*
* initMap() is called by the Google Maps API key script.
* It initializes the map and directions panel.
*/
function initMap() {
  // create a new directions panel
  directionsDisplay = new google.maps.DirectionsRenderer();
  // create a directions service to obtain the directions
  directionsService = new google.maps.DirectionsService();
  // on mobile, map is not draggable
  var dragOption = false;
  // if the screen size is larger than 767px
  if (window.innerWidth > 767) {
    // the map is draggable
    dragOption = true;
    // set panning
    draggable: dragOption
  }
  // set the map to the designated div
  map = new google.maps.Map(document.getElementById('hike-map'), {
    // disable scroll zoom
    scrollwheel: false,
    // set panning
    draggable: dragOption
  });
  // associate the directions display with our map
  directionsDisplay.setMap(map);
  // set the directions panel to the designated div
  directionsDisplay.setPanel(document.getElementById("directionsPanel"));
  // initialize bounds for our map
  bounds =  new google.maps.LatLngBounds();
  // create a marker for each entrance
  for (var i = 0; i < markerData.length; i++) {
    var marker = new google.maps.Marker({
      position: {lat: parseFloat(markerData[i].lat), lng: parseFloat(markerData[i].lng)},
      map: map,
      title: markerData[i].name,
      // Infowindow content
      content: panelContent(markerData[i].name, markerData[i].address, markerData[i].distance_to_mbta),
      // marker color
      icon: defaultIcon,
      // animates when dropped on the map
      animation: google.maps.Animation.DROP,
      // keep the marker from overlaying the directions markers
      zIndex: 1,
      // set its id
      id: i
    });
    // remember this marker
    markers[i] = marker;
    // add this marker to the map's bounds
    bounds.extend(new google.maps.LatLng(parseFloat(markerData[i].lat), parseFloat(markerData[i].lng)));
    // create an information window for this marker
    var infoWindow = new google.maps.InfoWindow();
    // add a listener to the marker for actions on click
    google.maps.event.addListener(marker, 'click', function () {
      // set the info window content
      infoWindow.setContent(this.content);
      // set the info window to open on click
      infoWindow.open(this.getMap(), this);
      // change the entrance selection to this marker
      $('#end').val(this.id);
      // show selected entrance's lines
      displayLines($('#end').val());
    });
  }
  // if we have more than one marker, set the bounds around them
  if (markerData.length > 1) {
    map.fitBounds(bounds);
    map.panToBounds(bounds);
    // add a window resize listener to create a responsive map
    google.maps.event.addDomListener(window, "resize", function() {
      google.maps.event.trigger(map, "resize");
      // keep the markerData within the map's bounds
      map.fitBounds(bounds);
      map.panToBounds(bounds);
      // if the window is enlarged to greater than mobile size,
      if (window.innerWidth > 767) {
        // set map to draggable
        map.setOptions({ draggable: true });
      }
    });
  }
  // otherwise, if only one or two, center and zoom appropriately
  else if (markerData.length < 2) {
    map.setCenter(bounds.getCenter());
    map.setZoom(13);
    var center = map.getCenter();
    // add a window resize listener to create a responsive map
    google.maps.event.addDomListener(window, "resize", function() {
      // keep the map centered
      map.setCenter(center);
      // if the window is enlarged to greater than mobile size,
      if (window.innerWidth > 767) {
        // set map to draggable
        map.setOptions({ draggable: true });
      }
    });
  }
  // If the user selects a different entrance,
  $('#end').change(function () {
    // display that marker's lines
    displayLines($('#end').val());
  });
  // When the form is submitted, calculate the route
  $('form').submit(function(e) {
    // prevent form submission
    e.preventDefault();
    // clear the directions panel in case it is already displayed
    $("#directionsPanel").html(" ");
    // clear the timing display
    $("#timing").html(" ");
    // clear any errors that might be displayed
    $("#errors").html(" ");
    // calculate the route and display directions
    calcRoute();
  });
  // display lines & distance for default marker
  displayLines(selected);
  // toggle more options for directions form
  $("#toggle-options").click(function() {
    $("#more-options").toggle();
  });
}

/*
* calcRoute() is called by initMap()
* It calculates the directions for the selected start and end points,
* and it delivers them in a directions panel.
*/
function calcRoute() {
  // Start is the user's address
  var start = $('#start').val();
  // End is the selected destination
  var end = markerData[$('#end').val()].address;
  // Get time from form
  var time = $("#time").val();
  // if no time chosen,
  if (time == "") {
    // use the current time
    time = currentTime();
  } else {
    // otherwise format it to be parseable
    time = formatSubmitTime(time);
  }
  // Get date from form
  var date = $("#date").val();
  // if no date chosen,
  if (date == "") {
    // use the current date
    date = currentDate();
  }
  // set the dateTime of leaving/arriving
  var dateTime = new Date(date + " " + time);
  // Initialize variables for time leaving or arriving
  var arriving = null;
  var leaving = null;
  // Update date and time Leaving at or Arriving by according to user input
  var going = "Leaving at "
  // get date from date input
  // if the user selected Arriving by
  if ($('#transitOptions').val() == "arrivalTime") {
    // update the time arriving variable
    arriving = dateTime;
    going = "Arriving by ";
  }
  // if the user selected Leaving by, do the same with departure time
  else if ($('#transitOptions').val() == "departureTime") {
    leaving = dateTime;
  }
  // transit mode defaults to all
  var mode = ["BUS", "RAIL", "SUBWAY", "TRAIN", "TRAM"]
  // if the user selected a mode
  if ($("#transitMode").val() != 0) {
    // set the mode
    mode = [$("#transitMode").val()];
  }
  // initialize route preference object
  var routePreference = null;
  // if the user selected a route preference
  if ($("#transitRoutePreference").val() != 0) {
    routePreference = $("#transitRoutePreference").val();
  }
  // create directions request
  var request = {
    origin:start,
    destination:end,
    // set travel mode to public transit
    travelMode: google.maps.TravelMode.TRANSIT,
    // set transit options specified above
    transitOptions: {
      arrivalTime: arriving,
      departureTime: leaving,
      modes: mode,
      routingPreference: routePreference
    }
  };
  // draw the directions per the request & create directions panel display
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      // make the timing clear at the top of the directions panel,
      $("#timing").html(going + convertDateTime(dateTime));
    }
      // if the directions service fails
      else if ($("#start").val() == "") {
        $("#errors").html("Please provide a starting address.");
      }
      // if directions service fails even with an address, show error
      else {
        $("#errors").html("No directions available. Please note that the starting address must be MBTA-accessible.");
      }
  });
}

/*
* panelContent() is called by initMap()
* It generates content for each marker's information window
* based on the passed parameters 'name', 'address', and 'distance'
*/
function panelContent(name, address, distance) {
  return "<span style='font-weight: bold'>" + name + "</span><br/>" + distance + " mi from closest station/stop<br/>" + address;
}
/*
* displayLines() is called by initMap() and calcRoute ()
* It displays the lines for the selected entrance in HTML
* based on the parameter 'id'
*/
function displayLines(id) {
  // make current selection's lines visible
  $(".marker_" + id).removeClass("hidden");
  // show the name of the current entrance
  $('#entrance-name').html(markerData[id].name)
  // highlight marker for selected entrance
  highlightMarker(id);
  // if a previous selection has been made and we have more than one marker
  if ((previousSelected != null) && (markerData.length > 1)) {
    if (previousSelected != id) {
      // hide the previous lines and distance info
      $(".marker_" + previousSelected).addClass("hidden");
    }
  }
  // remember previous selection
  previousSelected = id;
}
/*
* highlightMarker() is called by displayLines()
* Given the parameter 'id', it changes that marker's color
* to orange and sets the rest to blue.
*/
function highlightMarker(id){
  // change the current entrance marker's icon to orange and reset the rest to blue
  for (var i = 0; i < markers.length; i++) {
    if (i == id) markers[i].setIcon(markedIcon);
    else markers[i].setIcon(defaultIcon);
  }
  // recenter map
  map.setCenter(markers[id].position);
}
/*
* currentTime() is called by calcRoute()
* It returns the current time in 24-format hours and minutes
*/
function currentTime() {
  var time = new Date();
  var min = time.getMinutes();
  if (min < 10) {
    min = "0" + min;
  }
  return time.getHours() + ":" + min;
}
/*
* currentDate() is called by calcRoute()
* It returns a Date object parsable date without the time
*/
function currentDate() {
  var date = new Date();
  return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
}
/*
* formatSubmitTime() is called by calcRoute()
* It takes the time string from the pickadate.js picker
* and formats it into something parsable in a Date object
*/
function formatSubmitTime(time) {
  if ((time[time.length-2]) == "P") {
    var hour = parseInt(time.substring(0,2));
    if (hour < 12) {
      hour = hour + 12;
    }
    return hour + ":" + time.substring(2,time.length-3);
  }
  else if ((time[time.length-2]) == "A") {
    return time.substring(0, time.length-3);
  }
}
/*
* convertDateTime() is called by calcRoute()
* It converts the full date-time Date object used to calculate the route
* and prints it back into something more pretty for the user.
*/
function convertDateTime(d) {
  var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  return convertTime(d) + " on " + week[d.getDay()] + " " + month[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
}
/*
* convertTime() is called by convertDateTime()
* It converts the full date-time Date object used to calculate the route
* and prints it back into something more pretty for the user.
*/
function convertTime(d) {
  var h = d.getHours();
  var mer = " AM";
  if (h > 12) {
    h = h - 12;
    mer = " PM";
  }
  var min = d.getMinutes();
  if (min < 10) { min = "0" + min };
  return h + ":" + min + mer;
}