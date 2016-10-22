@extends('layouts.master')

@section('title')
  Explore Boston Fare Hikes
@stop

@section('head')
  <link rel="stylesheet" href="/css/explore.css" />
@stop

@section('content')
  <div class="container">
    <h2>Explore Hikes</h2>
    <div id="errors">
    @if (isset($errors))
      @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      @endif
    @endif
    </div>
    <form class="form-horizontal" method="POST" action="/explore">
      {{ csrf_field() }}
      <div class="form-group" id="climb">
        <label for="climb" class="control-label">Climb: </label> 
        <label for="flat"><input type="checkbox" name="climbs[]" id="flat" value="flat" /> Flat</label>
        <label for="easy"><input type="checkbox" name="climbs[]" id="easy" value="easy" /> Easy</label>
        <label for="moderate"><input type="checkbox" name="climbs[]" id="moderate" value="moderate" /> Moderate</label>
        <label for="intense"><input type="checkbox" name="climbs[]" id="intense" value="intense" /> Intense</label> 
      </div>
      <div class="form-group">
        <label id="distance-label" for="distance" class="control-label">Distance to closest MBTA station/stop: </label>
        <select id="distance" class="form-control" name="distance">
          <option value="2"></option>
          <option value="0.25">&lt; .25 mi </option>
          <option value="0.5">&lt; .5 mi </option>
          <option value="1">&lt; 1 mi </option>
        </select>
      </div>
      <div class="form-group">
        <label for="service">Service(s) Nearby: </label>
        <label for="bus"><input type="checkbox" name="services[]" id="bus" value="bus" /> Bus</label>
        <label for="commuter rail"><input type="checkbox" name="services[]" id="commuter rail" value="commuter rail" /> Commuter Rail</label>
        <label for="subway"><input type="checkbox" name="services[]" id="subway" value="subway" /> Subway</label>
      </div>
      <div class="form-group">
        @if (isset($sizes))
          <label for="size" class="control-label">Size: </label>
          @foreach ($sizes as $size)
            <label for="{{ $size->name }}"><input type="checkbox" name="tags[]" id="{{ $size->name }}" value="{{ $size->name }}" /> {{ ucfirst($size->name)}}</label>
          @endforeach
        @endif
      </div>
      <div class="form-group">
        <div class="col-sm-3 col-xs-6">
          @if (isset($features))
          <label for="features"><a href="#" id="features" class="btn btn-notice toggle">Features</a> </label>
          <ul class="tags-input-list" id="features-input">
            @foreach ($features as $feature)
            <li><label for="{{ $feature->name }}"><input type="checkbox" name="tags[]" id="{{ $feature->name }}" value="{{ $feature->name }}" /> {{ ucfirst($feature->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($activities))
          <label for="activities"><a href="#" id="activities" class="btn btn-notice toggle">Activities</a> </label>
          <ul class="tags-input-list" id="activities-input">
            @foreach ($activities as $activity)
            <li><label for="{{ $activity->name }}"><input type="checkbox" name="tags[]" id="{{ $activity->name }}" value="{{ $activity->name }}" /> {{ ucfirst($activity->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($facilities))
          <label for="facilities"><a href="#" id="facilities" class="btn btn-notice toggle">Facilities</a> </label>
          <ul class="tags-input-list" id="facilities-input">
            @foreach ($facilities as $facility)
            <li><label for="{{ $facility->name }}"><input type="checkbox" name="tags[]" id="{{ $facility->name }}" value="{{ $facility->name }}" /> {{ ucfirst($facility->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($sceneries))
          <label for="scenery"><a href="#" id="scenery" class="btn btn-notice toggle">Scenery</a> </label>
          <ul class="tags-input-list" id="scenery-input">
            @foreach ($sceneries as $scenery)
            <li><label for="{{ $scenery->name }}"><input type="checkbox" name="tags[]" id="{{ $scenery->name }}" value="{{ $scenery->name }}" /> {{ ucfirst($scenery->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
      </div>
      <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
    @if (isset($hikes))
      <ul id="explore">
        @foreach ($hikes as $hike)
        <?php $single_hikes_tags = $hike->tags->sortBy('name'); ?>
          <li class="thumbnail row">
            <div class="col-sm-12">
              <h2><a href="/hikes/{{ $hike->path_name }}">{{ $hike->name }}</a></h2>
            </div>
            <div class="col-sm-4">
            <?php $img = $hike->images->random() ?>
              <a href="/hikes/{{ $hike->path_name }}"><img src="/img/hikes/{{ $hike->path_name}}/thumbnails/{{ $hike->path_name}}{{ $img->file}}" class="thumbnail" alt="{{ $img->alt }}" width="170px" /></a>
            </div>
            <div class="col-sm-8">
              <span>Description:</span> {{ substr($hike->description, 0, strpos($hike->description, ".")) }}.... <br />
              <span>Climb:</span> <a href="/hikes/climb/{{ $hike->climb }}">{{ $hike->climb }}</a><br />
              <span>Features:</span> 
                @foreach ($single_hikes_tags as $list_tag)
                <a href="/tags/{{ $list_tag->id }}">{{ $list_tag->name }}</a> <span class="glyphicon glyphicon-asterisk"></span> 
                @endforeach
            </div>
          </li>
        @endforeach
      </ul>
      @if (method_exists($hikes,'links'))
      {{ $hikes->links() }}
      @endif
    @else
      <p>Whoops! Nothing here.</p>
    @endif
  </div>
  <!-- Toggle Tags Checkbox Inputs Visibility -->
  <script>
    $(".toggle").click(function (e) {
      $("#" + e.target.id + "-input").toggle();
    });
  </script>
@stop