@extends('layouts.master')

@section('title')
  Boston Fare Hikes
@stop

@section('head')
  <link rel="stylesheet" href="/css/map.css" />
@stop

@section('content')
  <div id="map"></div>
  <div id="find-nearest">
    <h1>Find a T-Accessible Hike Near You</h1>
    <form class="form-inline">
      <label class="sr-only" for="user">User address</label>
      <input type="text" class="form-control" id="user" name="user" placeholder="Enter your address"/>
      <label class="sr-only" for="radius">Desired radius</label>
      <select id="radius" class="form-control" name="radius">
        <option value="3">Within 3 miles</option>
        <option value="5">Within 5 miles</option>
        <option value="10">Within 10 miles</option>
      </select>
      <div id="climb">
        <label for="climb">Climb:</label> 
        <label for="flat">Flat <input type="checkbox" name="climb" id="flat" value="flat" /></label>
        <label for="easy">Easy <input type="checkbox" name="climb" id="easy" value="easy" /></label>
        <label for="moderate">Moderate <input type="checkbox" name="climb" id="moderate" value="moderate" /></label>
        <label for="intense">Intense <input type="checkbox" name="climb" id="intense" value="intense" /></label> 
      </div>
      <div id="distance">
        <label for="distance">Distance to MBTA:</label>
        <label for="0.25">&lt; .25 mi <input type="radio" name="distance" id="0.25" value="0.25" /></label>
        <label for="0.5">&lt; .5 mi <input type="radio" name="distance" id="0.5" value="0.5" /></label>
        <label for="1">&lt; 1 mi <input type="radio" name="distance" id="1" value="1" /></label>
      </div>
      <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="errors"></div>
    <ul id="hike-list">
    @foreach ($hikes as $hike)
    <?php $tags = $hike->tags; ?>
      <li class="visible" id="hike_{{ $hike->id }}">
        <div class="thumbnail">
          <h2><a href="/hikes/{{ $hike->path_name }}">{{ $hike->name }}</a></h2>
          <?php $img = $hike->images->random() ?>
          <a href="/hikes/{{ $hike->path_name }}"><img src="/img/hikes/{{ $hike->path_name}}/thumbnails/{{ $hike->path_name}}{{ $img->file}}" alt="{{ $img->alt }}" width="170px" /></a>
          <p>
            <span>Description:</span> {{ substr($hike->description, 0, strpos($hike->description, ".")) }}.... <br />
            <span>Climb:</span> <a href="/hikes/climb/{{ $hike->climb }}">{{ $hike->climb }}</a><br />
            <span>Features:</span> 
              @foreach ($tags as $tag)
              <a href="/tags/{{ $tag->id }}">{{ $tag->name }}</a> <span class="glyphicon glyphicon-asterisk"></span> 
              @endforeach
          </p>
        </div>
      </li>
    @endforeach
    </ul>
  </div>
@stop

@section('body')
  <!-- convert PHP to JSON for map data -->
   <script>
    var markerData = <?php echo json_encode($markers) ?>;
    var hikeData = <?php echo json_encode($hikes) ?>;
    var lines = [];
    // keep count of each marker
    <?php $i = 0; ?>
    // loop through all the markers to get their closest MBTA lines
    @foreach ($markers as $marker)
      <?php 
        // get the lines for this entrance marker
        $lines = $marker->lines;
        ?>
        // add this data to the lines array
        lines[<?php echo $i ?>] = <?php echo json_encode($lines) ?>;
        <?php $i++; ?>
    @endforeach
   </script>
  <!-- Google Map find nearest hike code -->
  <script src="js/map.js"></script>
  <script src="js/haversine.js"></script>
  <!-- Google Maps Javascript API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
    async defer></script>
  <link rel="stylesheet" href="/css/infowindow.css" />
  <!-- handle Google Maps error -->
  <script>
    if (typeof initMap != 'function') {
      $('#errors').html("Something went wrong. Please refresh the page!");
    }
  </script>
@stop