@extends('layouts.master')

@section('title')
    Line: {{ $line->name }}
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
@stop

@section('content')
  <div class="wrapper">
    <div class="container">
      
      <h1>@if ($line->service == "bus") Bus @endif {{ $line-> name }} @if ($line->service != "bus") Line @endif</h1>
      <p>Hikes near this {{ $line->service }} line:</p>
      
      <ul>
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