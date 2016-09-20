@extends('layouts.master')

@section('title')
  @if (isset($climb)) {{ ucfirst($climb) }} @endif
  Hikes
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
@stop

@section('content')
  <div class="wrapper">
    <div class="container">
      
      <h1>All @if (isset($climb)) {{ ucfirst($climb) }} @endif Hikes</h1>
      
      <ul id="explore">
        @foreach ($hikes as $hike)
          <li>
            <a href='/hikes/{{ $hike->path_name }}'>{{ $hike->name }}</a>
          </li>
        @endforeach
      </ul>
    </div>
    <div class="push"></div>
  </div>
@stop