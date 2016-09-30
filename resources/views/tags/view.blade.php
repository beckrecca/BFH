@extends('layouts.master')

@section('title')
    Tag: {{ $tag->name }}
@stop

@section('head')
  <link rel="stylesheet" href="/css/tags.css" />
  <link rel="stylesheet" href="/css/stickyfooter.css" />
@stop

@section('content')
  <div class="wrapper">
    <div class="container">
      
      @if (isset($tag))
      <h1>Hikes with tag: {{ ucfirst($tag->name) }}</h1>
      @if ($tag->message != '')
        <p id="notice"><span>Notice: </span> {{ $tag->message }} <a href="{{ $tag->link }}" target="_blank"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>MBTA</a></p>
      @endif
      
      <ul>
        @if (isset($hikes))
        @foreach ($hikes as $hike)
          <li>
            <a href='/hikes/{{ $hike->path_name }}'>{{ $hike->name }}</a>
          </li>
        @endforeach
        @endif
      @endif
      </ul>
    </div>
    <div class="push"></div>
  </div>
@stop