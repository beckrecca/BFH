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
// keep track of which entrance was just selected
var previousSelected;
// keep track of which entrance is selected (defaults 0)
var selected = 0;
/*
* initMap() is called by the Google Maps API key script.
* It initializes a map and a directions panel.
*/
function initMap() {
  // display lines for the selected entrance
  displayLines(selected);
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
  for (var i = 0; i < markerData.length; i++) {
    var marker = new google.maps.Marker({
      position: {lat: parseFloat(markerData[i].lat), lng: parseFloat(markerData[i].lng)},
      map: map,
      title: markerData[i].name,
      // Infowindow content
      content: panelContent(markerData[i].name, markerData[i].address),
      // marker color
      icon: '/img/markers/blue-dot.png',
      // animates when dropped on the map
      animation: google.maps.Animation.DROP,
      // keep the marker from overlaying the directions markers
      zIndex: 1
    });
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
  if (markerData.length > 1) {
    map.fitBounds(bounds);
    map.panToBounds(bounds);
    // add a window resize listener to create a responsive map
    google.maps.event.addDomListener(window, "resize", function() {
      google.maps.event.trigger(map, "resize");
      // keep the markerData within the map's bounds
      map.fitBounds(bounds);
      map.panToBounds(bounds);
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
    });
  }
  // If the user selects a different entrance, display that marker's lines
  $('#end').change(function () {
    selected = $('#end').val();
    displayLines(selected);
  });
  // When the form is submitted, calculate the route
  $('form').submit(function(e) {
    e.preventDefault();
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
  // Initialize a timeOptions variable for the directions request
  var timeOptions = {};
  // Update date and time Leaving at or Arriving by according to user input
  var going = "Leaving at "
  // get date from date input
  // if the user selected Arriving by
  if ($('#transitOptions').val() == "arrivalTime") {
    // update the timeOptions var to set the arrival time to the selected date and time
    timeOptions = {
      arrivalTime: dateTime
    };
    going = "Arriving by ";
  }
  // if the user selected Leaving by, do the same with departure time
  else if ($('#transitOptions').val() == "departureTime") {
    timeOptions = {
      departureTime: dateTime
    };
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
  // draw the directions per the request & create directions panel display
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
/*
* displayLines() is called by initMap() and calcRoute ()
* It displays the lines for the selected entrance in HTML
*/
function displayLines(selected) {
  // make current selection visible
  $(".marker_" + selected).removeClass("hidden");
  // if a previous selection has been made
  if (previousSelected != null) {
    // make the lines for the previous selection invisble
    $(".marker_" + previousSelected).addClass("hidden");
  }
  previousSelected = selected;
}
function currentTime() {
  var time = new Date();
  var min = time.getMinutes();
  if (min < 10) {
    min = "0" + min;
  }
  return time.getHours() + ":" + min;
}
function currentDate() {
  var date = new Date();
  return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear();
}
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
function convertDateTime(d) {
  var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  return convertTime(d) + " on " + week[d.getDay()] + " " + month[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
}
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