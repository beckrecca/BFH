@extends('layouts.master')

@section('title')
  Suggest a Hike
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
@stop

@section('content')
  <div class="container">
    <h1>Have We Missed Anything?</h1>
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
    <form class="form-horizontal" method="POST" action="/suggest">
      {{ csrf_field() }}
      <div class="form-group" id="climb">
      </div>
      <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
@stop