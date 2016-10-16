@extends('layouts.master')

@section('title')
  Hikes by {{ ucfirst($service) }}
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
@stop

@section('content')
  <div class="container">
    
    @if (isset($hikes) && !empty($hikes))
      <h1>Hikes @if (isset($service)) Accessible by  {{ ucfirst($service) }} @endif</h1>

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
  </div>
@stop