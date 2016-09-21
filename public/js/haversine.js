/**
*
* Credit to Dan Harper for the Haversine formula
* URL: http://jsfiddle.net/danharper/Nve8Q/
*
**/

// convert numeric degrees to radians
toRad = function(value) {
  return value * Math.PI / 180;
}

Haversine = function(point1, point2) {
  var R = 3959; // earth radius in mi
  var dLat = toRad(point2.lat - point1.lat);
  var dLng = toRad(point2.lng - point1.lng);
  var lat1 = toRad(point1.lat);
  var lat2 = toRad(point2.lat);

  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.sin(dLng / 2) * Math.sin(dLng / 2) *
    Math.cos(lat1) * Math.cos(lat2);

  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return (R * c).toFixed(2);
};
/*
* findDistances() is called by findClosest()
* It accepts an array of the user's latitude and longitude
* and compares it with the latitude and longitude of each 
* marker on the map. It finds the distance between each and
* stores it in an array. It returns this array.
*/
function findDistances(userPoint) {
  // initialize the array of distances
  var distances = [];
  // loop through the markers finding the GPS points for each
  for (i = 0; i < markerData.length; i++) {
    var pointLat = parseFloat(markerData[i].lat);
    var pointLng = parseFloat(markerData[i].lng);
    var markerPoint = {
      lat: pointLat,
      lng: pointLng
    }
    // calculate the distance between user and each point
    distances[i] = Haversine(userPoint, markerPoint);
  }
  return distances;
}
/*
* findRadius()
* Given the radius selected by the user and the user's
* GPS coordinates, it calls findDistances() to find only
* the markers within that radius. It returns those markers
* as an array.
*/
function findRadius(userPoint, radius) {
  // find the distances between the user and each marker
  var distances = findDistances(userPoint);
  // initialize the array of closest markers
  var closest = [];
  // count the indexes of the closest array
  var j = 0;
  // loop through the array of distances
  for (var i = 0; i < distances.length; i++) {
    // if the distance is within the radius
    if (distances[i] <= radius) {
      // add its corresponding marker to the closest array
      closest[j] = markerData[i];
      // increment the closest array counter
      j++;
    }
  }
  // return all the closest markers
  return closest;
}