@extends('layouts.master')

@section('title')
    {{ $hike->name }}
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/ >
    <link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="/lib/themes/default.css" id="theme_base">
    <link rel="stylesheet" href="/lib/themes/default.date.css" id="theme_date">
    <link rel="stylesheet" href="/lib/themes/default.time.css" id="theme_time">
    <link rel="stylesheet" href="/css/hike.css" />
@stop

@section('content')
	<div class="container">
    <h1>{{ $hike->name }}</h1>
    <div class="row">
      <ul id="features">
        <li>Features:</li>
        <li><a href="#">Historic</a></li>
        <li><a href="#">Theater</a></li>
        <li><a href="#">Landmark</a></li>
        <li><a href="#">Entertainment</a></li>
      </ul>
    </div>
    <div class="row" id="gallery">
      <p><span class="glyphicon glyphicon-camera" aria-hidden="true" id="camera"></span> {{ $images->count() }} photos</p>
      @foreach ($images as $image)
        <a class="fancybox" rel="group" href="/img/hikes/{{ $hike->path_name }}/{{ $hike->path_name }}{{ $image->file }}" title="{{ $image->title }}"><img src="/img/hikes/{{ $hike->path_name}}/thumbnails/{{ $hike->path_name}}{{ $image->file }}" width="128px" alt="{{ $hike->alt}}"/></a>
      @endforeach
    </div>
    <div class="row" id="description">
      <p>{{ $hike->description }}<br />
      <a href='{{ $hike->web }}' id='website' target="_blank"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Website</a></p>
      
    </div>
    <h2>Directions</h2> 
    <form class="form-inline">
      <label class="sr-only" for="start">User address</label>
      <input type="text" class="form-control" id="start" name="start" placeholder="Enter your address" size="40" />
      <label class="sr-only" for="end">Select destination</label>
      <select class="form-control" name="end" id="end">
        <?php 
          // index the markers
          $index = 0;
          ?>
        @foreach ($markers as $marker)
          <option value='{{ $index++ }}'>{{ $marker->name }}</option>
        @endforeach
      </select>
      <label class="sr-only" for="transitOptions">Optionally select leaving or arriving</label>
      <select class="form-control" name="transitOptions" id="transitOptions">
          <option value="departureTime">Leaving at (optional)</option>
          <option value="arrivalTime">Arriving by (optional)</option>
      </select>
      <label class="sr-only" for="date">Optionally select date leaving or arriving</label>
      <input class="datepicker form-control" id="date" name="date" type="text" placeholder="Date (optional)">
      <label class="sr-only" for="time">Optionally select date leaving or arriving</label>
    	<input class="timepicker form-control" id="time" name="time" type="text" placeholder="Time (optional)">
      <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

    <div id="directionsPanelContainer">
      <div id="timing"></div>
      <div id="directionsPanel"></div>
    </div>
    <div id="hike-map"></div>
@stop

@section('body')
	<!-- GOOGLE MAPS API -->
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
    async defer></script>
   <script>
    var markerData = <?php echo json_encode($markers) ?>;
   </script>
   <script src="/js/directions.js"></script>
   <script src="/lib/picker.js"></script>
   <script src="/lib/picker.date.js"></script>
   <script src="/lib/picker.time.js"></script>
   <script>
   	  var today = new Date();
      $('.datepicker').pickadate({
        min: today, // min date is today
        format: 'd mmm yyyy'
      });
      $('.timepicker').pickatime({
        min: [6,00], // minimum time is 6am
        max: [23,30] // maximum time is 11:30pm
      });
   </script>
    </script>
    <script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".fancybox").fancybox();
      });
    </script>
    <link rel="stylesheet" type="text/css" href="/css/directionspanel.css"/ >
@stop