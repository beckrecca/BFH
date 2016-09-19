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
            <span>Climb:</span> {{ $hike->climb }} <br />
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
  <!-- Google Maps Javascript API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
    async defer></script>
  <!-- convert PHP to JSON for map data -->
   <script>
    var markerData = <?php echo json_encode($markers) ?>;
    var hikeData = <?php echo json_encode($hikes) ?>;
   </script>
  <script src="js/map.js"></script>
  <script src="js/haversine.js"></script>
  <link rel="stylesheet" href="/css/infowindow.css" />
@stop