@extends('layouts.master')

@section('title')
  Suggest or Correct a Hike
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  <style>
    #wrapper {
      margin-bottom: 70px;
    }
  </style>
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
                <input type="text" class="form-control" id="name" name="name" placeholder="Location Name" />
              </div>
            </div>
            <div class="form-group">
              <label for="address" class="col-sm-2 control-label">Location Address</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" placeholder="Location Address" />
              </div>
            </div>
            <div class="form-group">
              <label for="climb" class="col-sm-2 control-label" />Difficulty of Climb</label>
              <div class="col-sm-10">
                <select id="difficulty" name="difficulty" class="form-control">
                  <option value="flat">Flat</option>
                  <option value="easy">Easy</option>
                  <option value="easy-to-moderate">Easy-to-moderate</option>
                  <option value="moderate">Moderate</option>
                  <option value="moderate-to-intense">Moderate-to-intense</option>
                  <option value="intense">Intense</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="distance" class="col-sm-2 control-label">Distance to MBTA (in miles)</label>
              <div class="col-sm-10">
                <input type="number" step="any" class="form-control" id="distance" name="distance" placeholder="Distance in miles" />
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Description (optional)</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="web" class="col-sm-2 control-label">Website (optional)</label>
              <div class="col-sm-10">
                <input type="url" class="form-control" id="web" name="web" placeholder="URL" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
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
                <select id="name" name="name" class="form-control">
                  @foreach ($hikes as $hike)
                    <option value="{{ $hike->name }}">{{ $hike->name }}</option>
                  @endforeach
                </select>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Correction:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="correction" name="correction" placeholder="Correction"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
@stop