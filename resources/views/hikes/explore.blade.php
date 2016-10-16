@extends('layouts.master')

@section('title')
  Explore Boston Fare Hikes
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  <link rel="stylesheet" href="/css/explore.css" />
@stop

@section('content')
  <div class="wrapper">
    <div class="container">
      <h1>Explore Boston Fare Hikes</h1>
      <form class="form-horizontal">
        <div class="form-group" id="climb">
          <label for="climb" class="control-label">Climb:</label> 
          <label for="flat">Flat <input type="checkbox" name="climb" id="flat" value="flat" /></label>
          <label for="easy">Easy <input type="checkbox" name="climb" id="easy" value="easy" /></label>
          <label for="moderate">Moderate <input type="checkbox" name="climb" id="moderate" value="moderate" /></label>
          <label for="intense">Intense <input type="checkbox" name="climb" id="intense" value="intense" /></label> 
        </div>
        <div class="form-group">
          <label id="distance-label" for="distance" class="control-label">Distance to closest MBTA station/stop: </label>
          <select id="distance" class="form-control" name="distance">
            <option></option>
            <option value="0.25">&lt; .25 mi </option>
            <option value="0.5">&lt; .5 mi </option>
            <option value="1">&lt; 1 mi </option>
          </select>
        </div>
        <div class="form-group">
          <label for="service">Service(s) Nearby:</label>
          <label for="bus">Bus <input type="checkbox" name="service" id="bus" value="bus" /></label>
          <label for="commuter rail">Commuter Rail <input type="checkbox" name="service" id="commuter rail" value="commuter rail" /></label>
          <label for="subway">Subway <input type="checkbox" name="service" id="subway" value="subway" /></label>
        </div>
        <div class="form-group">
          <div class="col-sm-3 col-xs-6">
            <label class="tags-label" for="features">Features: </label>
            @if (isset($features))
            <select class="form-control" name="features" multiple>
              @foreach ($features as $feature)
                <option value="{{ $feature->name }}">{{ ucfirst($feature->name)}}</option>
              @endforeach
            </select>
          @endif
          </div>
          <div class="col-sm-3 col-xs-6">
            <label class="tags-label" for="activities">Activities: </label>
            @if (isset($activities))
            <select class="form-control" name="activities" multiple>
              @foreach ($activities as $activity)
                <option value="{{ $activity->name }}">{{ ucfirst($activity->name)}}</option>
              @endforeach
            </select>
          @endif
          </div>
          <div class="col-sm-3 col-xs-6">
            <label class="tags-label" for="facilities">Facilities: </label>
            @if (isset($facilities))
            <select class="form-control" name="facilities" multiple>
              @foreach ($facilities as $facility)
                <option value="{{ $facility->name }}">{{ ucfirst($facility->name)}}</option>
              @endforeach
            </select>
          @endif
          </div>
          <div class="col-sm-3 col-xs-6">
            <label class="tags-label" for="scenery">Scenery: </label>
            @if (isset($sceneries))
            <select class="form-control" name="scenery" multiple>
              @foreach ($sceneries as $scenery)
                <option value="{{ $scenery->name }}">{{ ucfirst($scenery->name)}}</option>
              @endforeach
            </select>
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
        {{ $hikes->links() }}
      @else
        <p>Whoops! Nothing here.</p>
      @endif
    </div>
    <div class="push"></div>
  </div>
@stop