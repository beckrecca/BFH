@extends('layouts.master')

@section('title')
    Tag: {{ $tag->name }}
@stop

@section('head')
  
@stop

@section('content')
    <div class="container">
      
      <h1>{{ $tag-> name }}</h1>
      <p>All hikes with the tag "{{ $tag-> name }}":
      
      <ul>
        @foreach ($hikes as $hike)
          <li>
            <a href='/hikes/{{ $hike->path_name }}'>{{ $hike->name }}</a>
          </li>
        @endforeach
      </ul>
    </div>
@stop