var directionsDisplay;
var directionsService;
var map;

function initMap() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  directionsService = new google.maps.DirectionsService();
  map = new google.maps.Map(document.getElementById('hike-map'), {
    center: {lat: 42.3600825, lng: -71.05888010000001},
    zoom: 11
  });
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById("directionsPanel"));
  var marker = new google.maps.Marker({
      position: {lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val())},
      map: map,
      title: $('#title').val()
    });
  var infoContent = '<p>' + $('#title').val() + '<br/>' + $('#address').val(); + '</p>';
  var infowindow = new google.maps.InfoWindow({
    content: infoContent
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
  $('form').submit(function(e) {
    e.preventDefault();
    marker.setMap(null);
    calcRoute();
  });
}
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
  var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.TRANSIT,
    transitOptions: timeOptions
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      $("#timing").html(going + convertDateTime(dateTime));
    }
  });
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