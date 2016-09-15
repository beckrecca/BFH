@extends('layouts.master')

@section('title')
    List of All Hikes
@stop

@section('head')
  
@stop

@section('content')
    <div class="container">
      
      <h1>All Hikes</h1>
      
      <ul id="explore">
        @foreach ($hikes as $hike)
          <li>
            <a href='/hikes/{{ $hike->path_name }}'>{{ $hike->name }}</a>
          </li>
        @endforeach
      </ul>
    </div>
@stop