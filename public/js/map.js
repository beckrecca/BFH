var map;
// for maintaining the map's focus
var bounds;
// for geocoding the user's address
var geocoder;
// for remembering the markers before form submission results
var oldMarkers = [];
// for remembering the most recently clicked marker
var previousClick;
// for remembering the previous user marker(s)
var previousUserMarker
/*
* initMap() is called by the Google Maps Javascript API callback function.
* It initiales the Google Map on the page.
*/
function initMap() {
  // initialize the map
  map = new google.maps.Map(document.getElementById('map'), {
    // disable scroll zoom
    scrollwheel: false
  });
  // set all the markers on the map
  createMultipleMarkers(markerData);
  // add a window resize listener to the map to make it responsive
  google.maps.event.addDomListener(window, "resize", function() {
    // if the window is resized,
    google.maps.event.trigger(map, "resize");
    // refit the map to the bounds
    map.fitBounds(bounds);
    // rezoom the map to the bounds
    map.panToBounds(bounds);
  });
  // handle the form submission
  $('form').submit(function (e) {
    // prevent form from posting
    e.preventDefault();
    // if a user position was previously set,
    if (previousUserMarker != null) {
      // clear it from the map
      previousUserMarker.setMap(null);
    }
    // set the user's position
    nearestHikes();
  });
}
/*
* nearestHikes() is called by initMap()
* It gets the user's submitted address values and geocodes them
* into GPS coordinates in order to create a marker. If it
* successfully geocodes, the relevant markers per the form parameters
* are displayed on the map and listed. If it does not successfully geocode,
* the page displays an error.
*/
function nearestHikes() {
  // initialize a new Geocoder object
  geocoder = new google.maps.Geocoder();
  // get the user address input
  var userAddress = $('#user').val();
  // geocode the address
  geocoder.geocode( { 'address': userAddress}, function(results, status) {
    // if it successfully geocodes
    if (status == google.maps.GeocoderStatus.OK) {
      // create a new marker on the map for the user
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          icon: '/img/markers/green-dot.png',
          title: 'You'
      });
      // remember this marker so we can clear it on future form submissions
      previousUserMarker = marker;
      // get the user's GPS coordinates
      var userLat = parseFloat(results[0].geometry.location.lat());
      var userLng = parseFloat(results[0].geometry.location.lng());
      var userPoint = {
        lat: userLat,
        lng: userLng
      }
      // get the form's radius selection
      var radius = parseFloat($('#radius').val());
      // find and all the markers within the selected radius
      var markersWithinRadius = findRadius(userPoint, radius);
      for (var i = 0; i < markersWithinRadius; i++) {
      }
      // clear the map of all the old markers
      clearMarkers();
      // repopulate map with results
      createMultipleMarkers(markersWithinRadius, userPoint);
    } else if (userAddress == "") {
      $("#errors").html("Please provide an address.");
    }
    else {
      $("#errors").html("Geocode was not successful for the following reason: " + status);
    }
  });
}
/*
* createMultipleMarkers() is called initMap()
* It accepts an array of markers and optionally accepts the user's GPS position.
* It sets all of the markers on the map and sets the map's boundaries
* around the markers and the user position if provided.
*/
function createMultipleMarkers(markers, userPosition) {
  // initialize a new LatLngBounds object
  bounds =  new google.maps.LatLngBounds();
  // iterate over all of the markers passed
  for (var i = 0; i < markers.length; i++) {
    // get the hike id for this marker
    var hike_id = markers[i].hike_id - 1;
    // create a new marker object
    var marker = new google.maps.Marker({
      // set the GPS coordinates
      position: {lat: parseFloat(markers[i].lat), lng: parseFloat(markers[i].lng)},
      // set it to the map
      map: map,
      // set the title to this marker's hike's name
      title: hikeData[hike_id].name,
      // set the marker's info window content
      content: setContent(markers[i], hike_id),
      // set a drop animation when the map loads
      animation: google.maps.Animation.DROP,
      // set the icon to blue
      icon: '/img/markers/blue-dot.png',
      // set URL to view accompanying thumbnail
      url: '#hike_' + (hike_id + 1)
    });
    // create a new info window
    var infoWindow = new google.maps.InfoWindow();
    // add an event listener to the info window on click
    google.maps.event.addListener(marker, 'click', function () {
      // set the content of the info window
      infoWindow.setContent(this.content);
      // if the screen size is larger than 767px
      if (window.innerWidth > 767) {
        // go to hike thumbnail anchor on click
        window.location.href = this.url;
      }
      // set the info window to open on click
      infoWindow.open(this.getMap(), this);
      // highlight icon to be orange
      this.setIcon('/img/markers/orange-dot.png');
      // if a different  marker was previously clicked
      if (previousClick != null && previousClick != this) {
      // reset that marker to blue
        previousClick.setIcon('img/markers/blue-dot.png');
      }
      // remember this marker as having just been clicked
      previousClick = this;
    });
    // extend the boundaries of the map around this marker
    bounds.extend(new google.maps.LatLng(parseFloat(markers[i].lat), parseFloat(markers[i].lng)));
    // remember this marker as having been previously submitted
    oldMarkers[i] = marker;
  }
  // if a user position is provided
  if (userPosition!= null) {
    // extend the boundaries of the map around the user
    bounds.extend(new google.maps.LatLng(userPosition));
  }
  // fit the map to the boundaries
  map.fitBounds(bounds);
  // zoom the map appropriately around the boundaries
  map.panToBounds(bounds);
}
/*
* clearMarkers()
* It loops through the oldMarkers array, that were previously
* displayed on the map before form submission, and it clears them
* from the map. 9
*/
function clearMarkers() {
  // clear the old hike markers
  for (var i = 0; i < oldMarkers.length; i++) {
    oldMarkers[i].setMap(null);
  }
}
/*
* setContent() is called by createMultipleMarkers()
* It accepts as parameters the marker's hike id and its 
* index in the markerData array.
* It produces the HTML content of the marker's info window and
* returns it as a string.
*/
function setContent(marker, hike_id) {
  var link = "<a href='/hikes/" + hikeData[hike_id].path_name + "'>" + hikeData[hike_id].name + "</a>";
  var entranceName = marker.name;
  var address = "<span>" + marker.address + "</span>";
  var dist = "<span class='distance'>Distance to MBTA:</span> " + marker.distance_to_mbta + " mi";
  var lines = "<span>Lines Nearby:</span> " + setLines(marker.id);
  var br = "<br />";
  return link + br + entranceName + br + address + br + dist + br + lines;
}
function setLines(id) {
  var linesList = "";
  // we are looking at the lines for given marker id
  var list = lines[id - 1];
  // loop through all the lines at this id
  for (var i = 0; i < list.length; i++) {
    linesList = linesList + list[i].name + ", ";
  }
  // remove final comma
  linesList = linesList.substring(0, (linesList.length - 2));
  return linesList;
}