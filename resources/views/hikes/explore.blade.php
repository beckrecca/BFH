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
        <label for="climb" class="control-label"><a href="#" id="climbPopover" rel="popover" data-content="This rating refers to the incline of the terrain for each hike." data-original-title="Difficulty of Climb" data-trigger="hover">Climb</a>: </label> 
        <label for="flat"><input class="trigger" type="checkbox" name="climbs[]" id="flat" value="flat" @if (isset($checked)) @if (in_array("flat", $checked)) checked @endif @endif /> Flat</label>
        <label for="easy"><input class="trigger"  type="checkbox" name="climbs[]" id="easy" value="easy" @if (isset($checked)) @if (in_array("easy", $checked)) checked @endif @endif /> Easy</label>
        <label for="easy-to-moderate"><input type="checkbox" class="trigger"  name="climbs[]" id="easy-to-moderate" value="easy-to-moderate" @if (isset($checked)) @if (in_array("easy-to-moderate", $checked)) checked @endif @endif /> Easy-to-moderate</label>
        <label for="moderate"><input class="trigger"  type="checkbox" name="climbs[]" id="moderate" value="moderate" @if (isset($checked)) @if (in_array("moderate", $checked)) checked @endif @endif/> Moderate</label>
        <label for="moderate-to-intense"><input class="trigger"  type="checkbox" name="climbs[]" id="moderate-to-intense" value="moderate-to-intense" @if (isset($checked)) @if (in_array("moderate-to-intense", $checked)) checked @endif @endif /> Moderate-to-intense</label>
        <label for="intense"><input class="trigger"  type="checkbox" name="climbs[]" id="intense" value="intense" @if (isset($checked)) @if (in_array("intense", $checked)) checked @endif @endif/> Intense</label> 
      </div>
      <div class="form-group">
        <label id="distance-label" for="distance">Distance to closest <a href="#" id="mbta" rel="popover" data-content="All of these hiking locations are accessible by public subway, bus, or commuter rail." data-original-title="Massachusetts Bay Transportation Authority" data-trigger="hover">MBTA</a> station/stop: </label> 
        <select class="dropdownTrigger" id="distance" class="form-control" name="distance">
          <option value="2"></option>
          <option value="0.25" @if (isset($selected)) @if ($selected == 0.25) selected @endif @endif) >within .25 mi </option>
          <option value="0.5" @if (isset($selected)) @if ($selected == 0.5) selected @endif @endif>within .5 mi </option>
          <option value="1" @if (isset($selected)) @if ($selected == 1) selected @endif @endif>within 1 mi </option>
        </select>
      </div>
      <div class="form-group">
        <label for="service">Service(s) Nearby: </label>
        <label for="bus"><input class="trigger" type="checkbox" name="services[]" id="bus" value="bus" @if (isset($checked)) @if (in_array("bus", $checked)) checked @endif @endif /> Bus</label>
        <label for="commuter rail"><input class="trigger" type="checkbox" name="services[]" id="commuter rail" value="commuter rail" @if (isset($checked)) @if (in_array("commuter rail", $checked)) checked @endif @endif /> Commuter Rail</label>
        <label for="subway"><input class="trigger" type="checkbox" name="services[]" id="subway" value="subway" @if (isset($checked)) @if (in_array("subway", $checked)) checked @endif @endif /> Subway</label>
      </div>
      <div class="form-group">
        @if (isset($sizes))
          <label for="size" class="control-label">Size: </label>
          @foreach ($sizes as $size)
            <label for="{{ $size->name }}"><input class="trigger" type="radio" name="tags[]" id="{{ $size->name }}" value="{{ $size->name }}" />{{ ucfirst($size->name)}}</label>
          @endforeach
        @endif
      </div>
      <div class="form-group" id="tags-buttons">
        <div class="col-sm-3 col-xs-6">
          @if (isset($features))
          <label for="features"><a href="#" id="features" class="btn btn-notice toggle"><span id="features-down" class="glyphicon glyphicon-chevron-down"></span><span id="features-up" class="glyphicon glyphicon-chevron-up"></span> Features</a> </label>
          <ul class="tags-input-list" id="features-input">
            @foreach ($features as $feature)
            <li><label for="{{ $feature->name }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ $feature->name }}" value="{{ $feature->name }}" @if (isset($checked)) @if (in_array($feature->name, $checked)) checked @endif @endif /> {{ ucfirst($feature->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($activities))
          <label for="activities"><a href="#" id="activities" class="btn btn-notice toggle"><span id="activities-down" class="glyphicon glyphicon-chevron-down"></span><span id="activities-up" class="glyphicon glyphicon-chevron-up"></span> Activities</a> </label>
          <ul class="tags-input-list" id="activities-input">
            @foreach ($activities as $activity)
            <li><label for="{{ $activity->name }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ $activity->name }}" value="{{ $activity->name }}" @if (isset($checked)) @if (in_array($activity->name, $checked)) checked @endif @endif /> {{ ucfirst($activity->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($facilities))
          <label for="facilities"><a href="#" id="facilities" class="btn btn-notice toggle"><span id="facilities-down" class="glyphicon glyphicon-chevron-down"></span><span id="facilities-up" class="glyphicon glyphicon-chevron-up"></span> Facilities</a> </label>
          <ul class="tags-input-list" id="facilities-input">
            @foreach ($facilities as $facility)
            <li><label for="{{ $facility->name }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ $facility->name }}" value="{{ $facility->name }}" @if (isset($checked)) @if (in_array($facility->name, $checked)) checked @endif @endif /> {{ ucfirst($facility->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
        <div class="col-sm-3 col-xs-6">
          @if (isset($sceneries))
          <label for="scenery"><a href="#" id="scenery" class="btn btn-notice toggle"><span id="scenery-down" class="glyphicon glyphicon-chevron-down"></span><span id="scenery-up" class="glyphicon glyphicon-chevron-up"></span> Scenery</a> </label>
          <ul class="tags-input-list" id="scenery-input">
            @foreach ($sceneries as $scenery)
            <li><label for="{{ $scenery->name }}"><input class="trigger" type="checkbox" name="tags[]" id="{{ $scenery->name }}" value="{{ $scenery->name }}" @if (isset($checked)) @if (in_array($scenery->name, $checked)) checked @endif @endif /> {{ ucfirst($scenery->name)}}</label></li>
            @endforeach
          </ul>
        @endif
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <!-- RESULTS LIST -->
    @if (isset($hikes))
      <ul id="explore">
        <h2> @if (isset($count)) {{ $count }} Results @endif </h2>
        @if (isset($count)) @if ($count > 0) <h3 class="firstPage">Showing 1-{{ count($hikes->forPage(1,10))}} @else No results found. @endif</h3> @endif
        <!-- FIRST TEN RESULTS -->
        @foreach ($hikes->forPage(1,10) as $hike)
        <?php 
          # grab the tags for this hike
          $single_hikes_tags = $hike->tags->sortBy('name');
          # grab the lines for this hike
          $lines = \App\Line::byHikes($hike->id)->sortBy('name');
        ?>
          <li class="firstPage thumbnail row">
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
              @foreach ($lines as $line)
                <a href="lines/{{ $line->id }}">@if ($line->service == "bus") Bus @endif {{ $line->name }} @if ($line->service == "subway") Line @elseif ($line->service == "commuter rail") Commuter Rail Line @endif </a> <span class="glyphicon glyphicon-tree-conifer"></span>
              @endforeach
            </div>
          </li>
        @endforeach
        @if (isset($count)) 
        <!-- PAGINATION OF POSTED RESULTS -->
        <!-- NEXT TEN RESULTS -->
          @if ($count > 10)
          <h3 class="secondPage">Showing 11-{{ 10 + count($hikes->forPage(2,10))}}</h3> 
            @foreach ($hikes->forPage(2,10) as $hike)
            <?php 
              # grab the tags for this hike
              $single_hikes_tags = $hike->tags->sortBy('name');
              # grab the lines for this hike
              $lines = \App\Line::byHikes($hike->id)->sortBy('name');
            ?>
              <li class="secondPage thumbnail row">
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
                  @foreach ($lines as $line)
                    <a href="lines/{{ $line->id }}">@if ($line->service == "bus") Bus @endif {{ $line->name }} @if ($line->service == "subway") Line @elseif ($line->service == "commuter rail") Commuter Rail Line @endif </a> <span class="glyphicon glyphicon-tree-conifer"></span>
                  @endforeach
                </div>
              </li>
            @endforeach
          @endif
          <!-- NEXT TEN RESULTS -->
          @if ($count > 20)
          <h3 class="thirdPage">Showing 21-{{ 20 + count($hikes->forPage(3,10))}}</h3> 
            @foreach ($hikes->forPage(3,10) as $hike)
            <?php 
              # grab the tags for this hike
              $single_hikes_tags = $hike->tags->sortBy('name');
              # grab the lines for this hike
              $lines = \App\Line::byHikes($hike->id)->sortBy('name');
            ?>
              <li class="thirdPage thumbnail row">
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
                  @foreach ($lines as $line)
                    <a href="lines/{{ $line->id }}">@if ($line->service == "bus") Bus @endif {{ $line->name }} @if ($line->service == "subway") Line @elseif ($line->service == "commuter rail") Commuter Rail Line @endif </a> <span class="glyphicon glyphicon-tree-conifer"></span>
                  @endforeach
                </div>
              </li>
            @endforeach
          @endif
        @endif
      </ul>
      @if (isset($count))
      <!-- PAGINATION LINKS FOR POSTED COLLECTION RESULTS -->
      <ul class="pagination">
        <li id="prev" class="pageTurn disabled"><span>&laquo;</span></li> 
        <li id="first" class="pageNum active"><a href="#prev">1</a></li>
        @if ($count > 10) <li id="second" class="pageNum"><a href="#prev">2</a></li> @endif
        @if ($count > 20) <li id="third" class="pageNum"><a href="#prev">3</a></li> @endif
        @if ($count > 10) <li id="next" class="pageTurn"><a href="#prev" rel="next">&raquo;</a></li>
        @else <li id="next" class="pageTurn disabled"><span>&raquo;</span></li> @endif
      </ul>
      @endif
    @endif
  </div>
  <!-- Submit form with input changes -->
  <script>
    // If the user clicks a checkbox or radio button on the form
    $('.trigger').click(function() {
      // submit the form
      $('form').submit();
    });
    // If the user makes a dropdown selection
    $('.dropdownTrigger').change(function() {
      // submit the form
      $('form').submit();
    });
  </script>
  <!-- Toggle Tags Checkbox Inputs Visibility -->
  <script>
    $(".toggle").click(function (e) {
      $("#" + e.target.id + "-input").toggle();
      $("#" + e.target.id + "-down").toggle();
      $("#" + e.target.id + "-up").toggle();
    });
  </script>
  <!-- popovers -->
  <script>
    $(function () {
      $('#mbta').popover();
    });
    $(function () {
      $('#climbPopover').popover();
    });
  </script>
  <!-- Toggle Pagination -->
  <script>
    // If any page number is clicked,
    $(".pageNum").click(function (e) {
      // Get the ID of the page number clicked
      var selectedId = $(this).attr("id");
      // Get the ID of the active page
      var activeId = $(".active").attr("id");
      // Toggle the visibility of the active page
      $("." + activeId + "Page").toggle();
      // Remove active class from active page list item
      $("#" + activeId).removeClass("active");
      // Toggle the visibility of the selected page
      $("." + selectedId + "Page").toggle();
      // Add active class to the selected list item
      $("#" + selectedId).addClass("active");
      togglePageTurns();
    });
    // If a page turning button is selected
    $(".pageTurn").click(function (e) {
      // get active page
      var activeId = $(".active").attr("id");
      // if user clicked "next"
      if ($(this).attr("id") == "next") {
        // if the first page is active
        if (activeId == "first" && $("#second").length) {
          // deactivate first page button
          $("#first").removeClass("active");
          // toggle first page visibility
          $(".firstPage").toggle();
          // activate second page button
          $("#second").addClass("active");
          // toggle second page visibility
          $(".secondPage").toggle();
        }
        // if the second page is active
        if (activeId == "second" && $("#third").length) {
          // deactivate second page button
          $("#second").removeClass("active");
          // toggle second page visibility
          $(".secondPage").toggle();
          // activate third page button
          $("#third").addClass("active");
          // toggle third page visibility
          $(".thirdPage").toggle();
        }
      }
      // if user clicked "previous"
      else if ($(this).attr("id") == "prev") {
        // if the second page is active
        if (activeId == "second") {
          // deactivate second page button
          $("#second").removeClass("active");
          // toggle second page visibility
          $(".secondPage").toggle();
          // activate first page button
          $("#first").addClass("active");
          // toggle first page visibility
          $(".firstPage").toggle();
        }
        // if the third page is active
        if (activeId == "third") {
          // deactivate third page button
          $("#third").removeClass("active");
          // toggle third page visibility
          $(".thirdPage").toggle();
          // activate second page button
          $("#second").addClass("active");
          // toggle second page visibility
          $(".secondPage").toggle();
        }
      }
      togglePageTurns();
    });
    function togglePageTurns() {
      // If the first page is not the active page,
      if ($(".active").attr("id") != "first") {
        // the previous button is enabled
        $("#prev").removeClass("disabled").html('<a href="#prev" rel="prev">&laquo;</a>');
      }
      else {
        // otherwise, it is disabled
        $("#prev").addClass("disabled").html('<span>&laquo;</span>');
      }
      // if the third page or second and last possible page is active
      if ($(".active").attr("id") == "third" || ($(".active").attr("id") == "second") <?php if (isset($count)) {if ($count < 21) echo("&& true"); else echo("&& false");} ?> ) {
        // the next button is disabled
        $("#next").addClass("disabled").html('<span>&raquo;</span>');
      }
      else {
        // otherwise, it is enabled
        $("#next").removeClass("disabled").html('<a href="#prev" rel="next">&raquo;</a>');
      }
    }
  </script>
@stop