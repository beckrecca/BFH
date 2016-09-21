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
      
      @if (isset($hikes))
        <h1>All @if (isset($climb)) {{ ucfirst($climb) }} @endif Hikes</h1>
        
        <ul id="explore">
          @foreach ($hikes as $hike)
            <li>
              <a href='/hikes/{{ $hike->path_name }}'>{{ $hike->name }}</a>
            </li>
          @endforeach
        </ul>
      @else
        <p>Whoops! Nothing here.</p>
      @endif

      @if (isset($climb))
        <h2>Climb Levels Explained</h2>
        <ul>
          <li><a href="/hikes/climb/flat">Flat</a>: Terrain is flat.</li>
          <li><a href="/hikes/climb/easy">Easy</a>: Terrain is mostly flat, but there are some inclines.</li>
          <li><a href="/hikes/climb/moderate">Moderate</a>: Terrain can be hilly or rocky with some inclines.</li>
          <li><a href="/hikes/climb/flat">Intense</a>: Terrain is mostly hilly or rocky with some steep inclines.</li>
        </ul>
      @endif
    </div>
    <div class="push"></div>
  </div>
@stop