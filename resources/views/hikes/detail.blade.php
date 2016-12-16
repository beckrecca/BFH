@extends('layouts.master')

@section('title')
    {{ $hike->name }}
@stop

@section('head')
  <link rel="stylesheet" href="/src/css/swipebox.css">
  <link rel="stylesheet" href="/lib/themes/default.css" id="theme_base">
  <link rel="stylesheet" href="/lib/themes/default.date.css" id="theme_date">
  <link rel="stylesheet" href="/lib/themes/default.time.css" id="theme_time">
  <link rel="stylesheet" href="/css/hike.css" />
@stop

@section('content')
	<div class="container">
    <div id="hike-info">
      <h1>{{ $hike->name }}</h1>
      <h3>{{ $hike->city }}, MA</h3>
      <div class="row">
        <ul id="features">
          <li>Features:</li>
          @foreach ($tags as $tag)
            <li><a href='/tags/{{ $tag->id }}'>{{ $tag->name }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="row hidden-xs visible-sm visible-md visible-lg" id="gallery">
        @foreach ($images as $image)
          <a data-rel="gallery" href="/img/hikes/{{ $hike->path_name }}/{{ $hike->path_name }}{{ $image->file }}" class="swipebox" title="{{ $image->title }}"><img src="/img/hikes/{{ $hike->path_name}}/thumbnails/{{ $hike->path_name}}{{ $image->file }}" height="96" alt="{{ $image->alt}}"/></a>
        @endforeach
      </div>
      <div class="row" id="description">
        <a href='{{ $hike->web }}' id='website' target="_blank"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Website</a>
        <span class="visible-xs hidden-sm hidden-md hidden-lg pull-right" id="camera"><a href="#" id="open-gallery"><span class="glyphicon glyphicon-camera" aria-hidden="true"></span> {{ $images->count() }} photos</a></span>
        <p><span>Description:</span> {{ $hike->description }}</p>
        <p><span>Climb:</span> <a href="/hikes/climb/{{ $hike->climb }}" id="climb">{{ $hike->climb }}</a></p>
        @foreach ($tags as $tag)
            @if ($tag->message != '')
            <p><span>{{ ucfirst($tag->name) }} Notice:</span> {{ $tag-> message }} <a href="{{ $tag->link }}" target="_blank">More Information</a>
            @endif
        @endforeach
      </div>
    </div>
    <div id="directions-form">
      <h2>Transit Directions</h2> 
      <p>This directions service will only work for addresses with access to public transportation in the Greater Boston area.</p>
      <form class="form-horizontal" id="form">
        <div class="form-group">
          <label for="start" class="control-label">User location: </label>
          <input type="text" class="form-control" id="start" name="start" placeholder="Enter your location" size="40" />
        </div>
        <div class="form-group">
          <label for="end" class="control-label">Select Hike Entrance:</label>
          <select class="form-control" name="end" id="end">
          <?php 
            // index the markers
            $index = 0;
            ?>
          @foreach ($markers as $marker)
            <option value='{{ $index++ }}' id="marker_{{ $marker->id }}">{{ $marker->name }}</option>
          @endforeach
          </select>
        </div>
        <div id="more-options">
          <div class="form-group">
            <label class="sr-only" for="transitOptions">Optionally select leaving or arriving</label>
            <select class="form-control" name="transitOptions" id="transitOptions">
                <option value="departureTime">Leaving at (optional)</option>
                <option value="arrivalTime">Arriving by (optional)</option>
            </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="date">Optionally select date leaving or arriving</label>
            <input class="datepicker form-control" id="date" name="date" type="text" placeholder="Date (optional)">
          </div>
          <div class="form-group">
            <label class="sr-only" for="time">Optionally select date leaving or arriving</label>
          	<input class="timepicker form-control" id="time" name="time" type="text" placeholder="Time (optional)">
          </div>
          <div class="form-group">
            <label class="sr-only" for="transitMode">Optionally select transit mode</label>
            <select class="form-control" name="transitMode" id="transitMode">
              <option value="0">Mode (optional)</option>
              <option value="BUS">Bus</option>
              <option value="RAIL">Commuter Rail</option>
              <option value="TRAM">T</option>
            </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="transitRoutePreference">Optionally select route preference</label>
            <select class="form-control" name="transitRoutePreference" id="transitRoutePreference">
              <option value="0">Route preference (optional)</option>
              <option value="FEWER_TRANSFERS">Fewer transfers</option>
              <option value="LESS_WALKING">Less walking</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <a href="#directions-form" id="toggle-options" class="btn btn-notice">More options</a>
          <button type="submit" id="submit" class="btn btn-primary">Submit</button>
          <a href="#directions-form" id="reverse" class="btn btn-notice hidden">Reverse Directions <span class="glyphicon glyphicon-refresh"></span></a>
          <button class="btn btn-primary hidden" id="newWindow"></button>
        </div>
      </form>
    </div>
  </div>
  <div id="directionsPanelContainer">
    <ul id="lines">
      <li>MBTA Lines near <span id="entrance-name"></span>:</li>
      <?php
          // index each marker to coordinate with map
          $class = 0; 
        ?>
      @foreach ($markers as $marker)
        <?php 
          // get the lines for this entrance marker
          $lines = $marker->lines;
          ?>
        @foreach ($lines as $line)
          <li class='hidden marker_{{ $class }}'><a href='/lines/{{ $line->id }}'>{{ $line->name }}</a></li>
        @endforeach
        <?php $class++; ?>
      @endforeach
    </ul>
    <div id="directionsContainer">
      <h4 class="hidden-xs visible-sm visible-md visible-lg" id="directionsHeader">Directions Panel</h4>
      <div id="errors"></div>
      <div id="timing"></div>
      <div id="directionsPanel"></div>
    </div>
  </div>
  <h3><span class="glyphicon glyphicon-map-marker"></span>Map of MBTA-friendly Entrance<?php if($markers->count() > 1)echo('s');?> for {{ $hike->name }}</h3>
  <div id="hike-map"></div>
@stop

@section('body')
  <!-- convert PHP to JSON for map data -->
   <script>
    var markerData = <?php echo json_encode($markers) ?>;
   </script>
   <!-- user address cookie -->
   <script src="/js/usercookie.js"></script>
   <!-- selected entrance cookie -->
   <script src="/js/entrancecookie.js"></script>
   <!-- directions panel code -->
   <script src="/js/directions.js"></script>
   <script>
      // get the address cookie
      var address = readAddress();
      // if there is an address cookie
      if (address != null) {
        // pre-fill it in the directions form
        $('#start').val(address);
      }
   </script>
   <!-- pickadate.js code below -->
   <script src="/lib/picker.js"></script>
   <script src="/lib/picker.date.js"></script>
   <script src="/lib/picker.time.js"></script>
   <script>
   	  var today = new Date();
      $('.datepicker').pickadate({
        min: today, // min date is today
        format: 'd mmm yyyy' // Day Shortmonth Fullyear
      });
      $('.timepicker').pickatime({
        min: [6,00], // minimum time is 6am
        max: [23,30] // maximum time is 11:30pm
      });
   </script>
    <!-- Swipebox -->
    <script src="/lib/jquery-2.1.0.min.js"></script>
    <script src="/src/js/jquery.swipebox.js"></script>
    <script type="text/javascript">
    ;( function( $ ) {

      $( '.swipebox' ).swipebox({
        removeBarsOnMobile : false
      });

    } )( jQuery );
    </script>
    <script>
    $( '#open-gallery' ).click( function( e ) {
      e.preventDefault();
      $.swipebox( [
        @foreach ($images as $image)
        { href:'/img/hikes/{{ $hike->path_name }}/{{ $hike->path_name }}{{ $image->file }}', title:'{{ $image->title }}' },
        @endforeach
      ],
      {
        removeBarsOnMobile: false
      } );
    } );
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
      async defer></script>
    <!-- directions panel styling -->
    <link rel="stylesheet" type="text/css" href="/css/directionspanel.css"/>
    <!-- GOOGLE MAPS API -->
    <!-- handle Google Maps error -->
    <script>
      if (typeof initMap != 'function') {
        $('#errors').html("Something went wrong. Please refresh the page!");
      }
    </script>
@stop