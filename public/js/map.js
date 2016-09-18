var map;
var bounds;
// for geocoding the user's address
var geocoder;
// for remembering the markers before form submission results
var oldMarkers = [];
// for remembering the most recently clicked marker
var previousClick;
/*
* initMap() is called by the Google Maps Javascript API callback function.
* It initiales the Google Map on the page.
*/
function initMap() {
  // initialize the map
  map = new google.maps.Map(document.getElementById('map'));
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
      content: setContent(hike_id, i),
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
      // if a marker was previously clicked
      if (previousClick != null) {
      // reset that marker to blue
        previousClick.setIcon('img/markers/blue-dot.png');
      }
      // remember this marker as having just been clicked
      previousClick = this;
    });
    // extend the boundaries of the map around this marker
    bounds.extend(new google.maps.LatLng(parseFloat(markers[i].lat), parseFloat(markers[i].lng)));
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
* setContent() is called by createMultipleMarkers()
* It accepts as parameters the marker's hike id and its 
* index in the markerData array.
* It produces the HTML content of the marker's info window and
* returns it as a string.
*/
function setContent(hike_id, i) {
  var link = "<a href='/hikes/" + hikeData[hike_id].path_name + "'>" + hikeData[hike_id].name + "</a>";
  var entranceName = markerData[i].name;
  var address = markerData[i].address;
  var climb = "<span class='climb'>Climb:</span> " + hikeData[hike_id].climb;
  var dist = "<span class='distance'>Distance to MBTA:</span> " + markerData[i].distance_to_mbta + " mi";
  var br = "<br />";
  return link + br + entranceName + br + address + br + climb + br + dist;
}