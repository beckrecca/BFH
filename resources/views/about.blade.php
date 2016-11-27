@extends('layouts.master')

@section('title')
  About
@stop

@section('head')
  <link rel="stylesheet" href="/css/stickyfooter.css" />
  <link rel="stylesheet" href="/css/extras.css" />
@stop

@section('content')
  <div class="container">
    <h1>About</h1>
    <div id="wrapper">
    <p>
    	My name is Rebecca Doris, and I built this website with the help of 
      Google Maps Javascript APIs and the Laravel framework. 
      <img src="/img/me/me.jpg" class="img img-responsive img-rounded pull-left selfportrait" alt="The website author, Rebecca Doris, stands on a hill in the woods wearing a light pink coat." />
      Boston Fare Hikes  is the capstone project towards the completion of my ALM 
      in Digital Media Design at Harvard University. 
      I live in Somerville, Massachusetts without a car.
    </p>
    <p>
      The seeds of this idea were planted in December 2015, when on an impulse I went
       for a winter walk in Mount Auburn Cemetery guided by 
       <a href="http://www.clarewalkerleslie.com/">Clare Walker Leslie</a>.
    I was struck by Leslie's words on the solace of nature. 
    I often returned to the Mount Auburn Cemetery throughout winter 2016 for peace, 
    comfort, and gentle exercise.
    </p>
    <p>
      <img src="/img/me/boots.jpg" class="img img-responsive img-rounded pull-right selfportrait" alt="My red Bean boots on the ground covered in dead leaves and acorns." />
      When spring approached, I wanted to explore other natural spaces independently. 
      Since I don't own a car, that required some research. I found that the information
       about T-accessible hikes was scarce, scattered, or outdated. Boston Fare Hikes 
       would rectify that. At the end of spring 2016, I submitted my capstone proposal. 
       I spent the entire summer 2015 visiting all of the locations featured on this 
       website, relying entirely on the MBTA!
    </p>
    <p>
      My hope is that Boston Fare Hikes will be a useful resource for car-free 
      Bostonians looking for some active serenity.
    </p>
    </div>
  </div>
@stop