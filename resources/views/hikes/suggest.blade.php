@extends('layouts.master')

@section('title')
  Suggest or Correct a Hike
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  <link rel="stylesheet" href="/css/suggest.css" />
@stop

@section('content')
  <div id="wrapper" class="container">
    @if (isset($message))
      <div id="notice">
        {{ $message }}
      </div>
    @endif
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
    <h1>Have We Missed Anything?</h1>
    <div>
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#suggest" aria-controls="suggest" role="tab" data-toggle="tab">Suggest a Hike</a></li>
        <li role="presentation"><a href="#correct" aria-controls="profile" role="tab" data-toggle="tab">Correct Our Mistake</a></li>
      </ul>
      <div class="tab-content">
        <!-- SUGGESTION FORM -->
        <div role="tabpanel" class="tab-pane active" id="suggest">
          <form class="form-horizontal" method="POST" action="/suggest">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Location Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Location Name" value="{{ old('name') }}" />
              </div>
            </div>
            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Location Address</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" placeholder="Location Address" value="{{ old('address') }}" />
              </div>
            </div>
            <div class="form-group">
              <label for="climb" class="col-sm-2 control-label" />Difficulty of Climb</label>
              <div class="col-sm-10">
                <select id="difficulty" name="difficulty" class="form-control">
                  <option value="flat" @if (old('difficulty') == "flat") selected @endif >Flat</option>
                  <option value="easy" @if (old('difficulty') == "easy") selected @endif>Easy</option>
                  <option value="easy-to-moderate" @if (old('difficulty') == "easy-to-moderate") selected @endif >Easy-to-moderate</option>
                  <option value="moderate" @if (old('difficulty') == "moderate") selected @endif >Moderate</option>
                  <option value="moderate-to-intense" @if (old('difficulty') == "moderate-to-intense") selected @endif >Moderate-to-intense</option>
                  <option value="intense" @if (old('difficulty') == "intense") selected @endif >Intense</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="distance" class="col-sm-2 control-label">Distance to MBTA (in miles)</label>
              <div class="col-sm-10">
                <input type="number" step="any" class="form-control" id="distance" name="distance" placeholder="Distance in miles" value="{{ old('distance') }}" />
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Description (optional)</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="web" class="col-sm-2 control-label">Website (optional)</label>
              <div class="col-sm-10">
                <input class="form-control" id="web" name="web" placeholder="URL" value="@if (old('web') == "")http://@endif{{ old('web') }}" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <!-- CORRECTION FORM -->
        <div role="tabpanel" class="tab-pane" id="correct">
          <form class="form-horizontal" method="POST" action="/correct">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Hike Name:</label>
              <div class="col-sm-10">
                @if (isset($hikes))
                <?php $hikes = $hikes->sortBy('name'); ?>
                <select id="correctName" name="correctName" class="form-control">
                  @foreach ($hikes as $hike)
                    <option value="{{ $hike->name }}">{{ $hike->name }}</option>
                  @endforeach
                </select>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label for="wrong[]" class="col-sm-2 control-label">What's Wrong?</label>
              <div class="col-sm-10">
                <ul id="selectWrong">
                  <li><input type="checkbox" name="wrong[]" id="Location Name" value="Location Name"> <label for="Location Name" class="control-label">Location Name</label></li>
                  <li><input type="checkbox" name="wrong[]" id="Entrance Marker Address" value="Location Name"> <label for="Entrance Marker Address" class="control-label">Entrance Marker Address</label></li>
                  <li><input type="checkbox" name="wrong[]" id="Climb" value="Climb"> <label for="Climb" class="control-label">Difficulty of Climb</label></li>
                  <li><input type="checkbox" name="wrong[]" id="Distance" value="Distance"> <label for="Distance" class="control-label">Distance to MBTA</label></li>
                  <li><input type="checkbox" name="wrong[]" id="Description" value="Description"> <label for="Description" class="control-label">Description</label></li>
                </ul>
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Correction Details:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="correction" name="correction" placeholder="Correction Details"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
@stop