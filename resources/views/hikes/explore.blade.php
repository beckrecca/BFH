@extends('layouts.master')

@section('title')
  Explore Boston Fare Hikes
@stop

@section('head')
  <link rel="stylesheet" href="/css/explore.css" />
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  @if (isset($tagsChecked)) 
    @if ($tagsChecked)
    <style>
      .tags-input-list {
        display: block;
      }
    </style>
    @endif
  @endif
@stop

@section('content')
  <div class="container" id="wrapper">
    <div class="row">
      <div class="col-lg-6">
        <h2>Search MBTA-Accessible Hikes</h2>
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
            <label class="control-label"><a href="#" id="climbPopover" data-rel="popover" data-content="This rating refers to the incline of the terrain for each hike." data-original-title="Difficulty of Climb" data-trigger="hover">Climb</a>: </label> 
            <label for="flat"><input class="trigger" type="checkbox" name="climbs[]" id="flat" value="flat" @if (isset($checked)) @if (in_array("flat", $checked)) checked @endif @endif /> Flat</label>
            <label for="easy"><input class="trigger"  type="checkbox" name="climbs[]" id="easy" value="easy" @if (isset($checked)) @if (in_array("easy", $checked)) checked @endif @endif /> Easy</label>
            <label for="easy-to-moderate"><input type="checkbox" class="trigger"  name="climbs[]" id="easy-to-moderate" value="easy-to-moderate" @if (isset($checked)) @if (in_array("easy-to-moderate", $checked)) checked @endif @endif /> Easy-to-moderate</label>
            <label for="moderate"><input class="trigger"  type="checkbox" name="climbs[]" id="moderate" value="moderate" @if (isset($checked)) @if (in_array("moderate", $checked)) checked @endif @endif/> Moderate</label>
            <label for="moderate-to-intense"><input class="trigger"  type="checkbox" name="climbs[]" id="moderate-to-intense" value="moderate-to-intense" @if (isset($checked)) @if (in_array("moderate-to-intense", $checked)) checked @endif @endif /> Moderate-to-intense</label>
            <label for="intense"><input class="trigger"  type="checkbox" name="climbs[]" id="intense" value="intense" @if (isset($checked)) @if (in_array("intense", $checked)) checked @endif @endif/> Intense</label> 
          </div>
          <div class="form-group">
            <label id="distance-label" for="distance">Distance to closest <a href="#" id="mbta" data-rel="popover" data-content="All of these hiking locations are accessible by public subway, bus, or commuter rail." data-original-title="Massachusetts Bay Transportation Authority" data-trigger="hover">MBTA</a> station/stop: </label> 
            <select class="form-control dropdownTrigger" id="distance" name="distance">
              <option value="2">Distance</option>
              <option value="0.25" @if (isset($selected)) @if ($selected == 0.25) selected @endif @endif >within .25 mi </option>
              <option value="0.5" @if (isset($selected)) @if ($selected == 0.5) selected @endif @endif>within .5 mi </option>
              <option value="1" @if (isset($selected)) @if ($selected == 1) selected @endif @endif>within 1 mi </option>
            </select>
          </div>
          <div class="form-group">
            <label>Service(s) Nearby: </label>
            <label for="bus"><input class="trigger" type="checkbox" name="services[]" id="bus" value="bus" @if (isset($checked)) @if (in_array("bus", $checked)) checked @endif @endif /> Bus</label>
            <label for="commuterrail"><input class="trigger" type="checkbox" name="services[]" id="commuterrail" value="commuter rail" @if (isset($checked)) @if (in_array("commuter rail", $checked)) checked @endif @endif /> Commuter Rail</label>
            <label for="subway"><input class="trigger" type="checkbox" name="services[]" id="subway" value="subway" @if (isset($checked)) @if (in_array("subway", $checked)) checked @endif @endif /> Subway</label>
          </div>
          <div class="form-group">
            @if (isset($sizes))
              <label class="control-label">Size: </label>
              @foreach ($sizes as $size)
                <label for="{{ substr($size->name, 0, strpos($size->name, " ")) }}"><input class="trigger" type="radio" name="tags[]" id="{{ substr($size->name, 0, strpos($size->name, " ")) }}" value="{{ $size->name }}" />{{ ucfirst($size->name)}}</label>
              @endforeach
            @endif
          </div>
          <div class="form-group" id="tags-buttons">
            <div class="col-sm-3 col-xs-6">
              @if (isset($features))
              <label><a href="#" id="features" class="btn btn-notice toggle"><span id="features-down" class="glyphicon glyphicon-chevron-down"></span><span id="features-up" class="glyphicon glyphicon-chevron-up"></span> Features</a> </label>
              <ul class="tags-input-list" id="features-input">
                @foreach ($features as $feature)
                <li><label for="{{ str_replace(' ', '', $feature->name) }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ str_replace(' ', '', $feature->name) }}" value="{{ $feature->name }}" @if (isset($checked)) @if (in_array($feature->name, $checked)) checked @endif @endif /> {{ ucfirst($feature->name)}}</label></li>
                @endforeach
              </ul>
            @endif
            </div>
            <div class="col-sm-3 col-xs-6">
              @if (isset($activities))
              <label><a href="#" id="activities" class="btn btn-notice toggle"><span id="activities-down" class="glyphicon glyphicon-chevron-down"></span><span id="activities-up" class="glyphicon glyphicon-chevron-up"></span> Activities</a> </label>
              <ul class="tags-input-list" id="activities-input">
                @foreach ($activities as $activity)
                <li><label for="{{ str_replace(' ', '', $activity->name) }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ str_replace(' ', '', $activity->name) }}" value="{{ $activity->name }}" @if (isset($checked)) @if (in_array($activity->name, $checked)) checked @endif @endif /> {{ ucfirst($activity->name)}}</label></li>
                @endforeach
              </ul>
            @endif
            </div>
            <div class="col-sm-3 col-xs-6">
              @if (isset($facilities))
              <label><a href="#" id="facilities" class="btn btn-notice toggle"><span id="facilities-down" class="glyphicon glyphicon-chevron-down"></span><span id="facilities-up" class="glyphicon glyphicon-chevron-up"></span> Facilities</a> </label>
              <ul class="tags-input-list" id="facilities-input">
                @foreach ($facilities as $facility)
                <li><label for="{{ str_replace(' ', '', $facility->name) }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ str_replace(' ', '', $facility->name) }}" value="{{ $facility->name }}" @if (isset($checked)) @if (in_array($facility->name, $checked)) checked @endif @endif /> {{ ucfirst($facility->name)}}</label></li>
                @endforeach
              </ul>
            @endif
            </div>
            <div class="col-sm-3 col-xs-6">
              @if (isset($sceneries))
              <label><a href="#" id="scenery" class="btn btn-notice toggle"><span id="scenery-down" class="glyphicon glyphicon-chevron-down"></span><span id="scenery-up" class="glyphicon glyphicon-chevron-up"></span> Scenery</a> </label>
              <ul class="tags-input-list" id="scenery-input">
                @foreach ($sceneries as $scenery)
                <li><label for="{{ str_replace(' ', '', $scenery->name) }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ str_replace(' ', '', $scenery->name) }}" value="{{ $scenery->name }}" @if (isset($checked)) @if (in_array($scenery->name, $checked)) checked @endif @endif /> {{ ucfirst($scenery->name)}}</label></li>
                @endforeach
              </ul>
            @endif
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <!-- RESULTS LIST -->
        @if (isset($hikes))
          <ul id="explore">
            <h2 id="results"> @if (isset($count)) {{ $count }} Results @endif </h2>
            @if (isset($count)) 
              @if ($count > 0) 
               <?php 
                $pages = ($count/10); 
               ?>
               @for ($i = 0; $i < $pages; $i++)
              <h3 class="page{{$i + 1}}">Showing {{ 1 + (10*$i)}}-{{ (10*$i) + count($hikes->forPage(($i+1),10)) }} </h3>  
               @endfor
                @else <h3>No results found.</h3>
              @endif
            @endif
            <!-- RESULTS -->
            <?php $n = 0; ?>
            @foreach ($hikes as $hike)
            <?php 
              # grab the tags for this hike
              $single_hikes_tags = $hike->tags->sortBy('name');
              # grab the lines for this hike
              $lines = \App\Line::byHikes($hike->id)->sortBy('name');
            ?>
              <li class="page{{ floor($n/10) + 1 }} thumbnail row">
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
                    <br/>
                  <span>Closest MBTA Lines:</span>
                  <?php $linesCount = count($lines); $i = 0; ?>
                  @foreach ($lines as $line)
                    <a href="lines/{{ $line->id }}">@if ($line->service == "bus") Bus @endif {{ $line->name }} @if ($line->service == "subway") Line @elseif ($line->service == "commuter rail") Commuter Rail Line @endif</a> @if (++$i !== $linesCount) <span class="glyphicon glyphicon-map-marker"></span> @endif
                  @endforeach
                </div>
              </li>
              <?php $n++; ?>
            @endforeach
          </ul>
          @if (isset($count))
          <!-- PAGINATION LINKS FOR POSTED COLLECTION RESULTS -->
          <ul id="pagination" class="pagination">
            <li id="prev" class="pageTurn disabled"><span>&laquo;</span></li> 
            <li id="1" class="pageNum active"><a href="#pagination">1</a></li>
            @if ($count > 10) <li id="2" class="pageNum"><a href="#pagination">2</a></li> @endif
            @if ($count > 20) <li id="3" class="pageNum"><a href="#pagination">3</a></li> @endif
            @if ($count > 10) <li id="next" class="pageTurn"><a href="#next" rel="next">&raquo;</a></li>
            @else <li id="next" class="pageTurn disabled"><span>&raquo;</span></li> @endif
          </ul>
          @endif
        @endif
      </div>
    </div>
  </div>
  <script type="text/javascript" src="/js/explore.js"></script>
  @if (isset($count))
    <!-- if any results have been turned, jump to that anchor -->
    <script>
    $(function () {
      window.location = '#results';
    });
    </script>
  @endif
@stop