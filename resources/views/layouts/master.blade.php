<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @yield('title','Boston Fare Hikes')
    </title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description','A navigational web exhibition of MBTA-accessible hiking locations.')">
    <meta name="keywords" content="Boston hiking, Massachusetts hiking, MBTA, public transit, public transportation">
    <meta name="author" content="Rebecca Doris">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/template.css" />
    <style>
      body {
        background: url('/img/backgrounds/bg{{ rand(1,10) }}.gif');
        background-attachment: fixed;
        background-repeat: repeat-x;
      }
    </style>
     <!-- JQuery -->
     <script type="text/javascript" src="/js/jquery-1.12.2.min.js"> </script>
    @yield('head')
</head>
    <body>
      <nav class="navbar navbar-preheader navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="/"><img src="/img/logo/sm_logo.png" id="logo" class="img pull-left" alt="Boston Fare Hikes logo depicting the T symbol with a green hill behind the T and a green map marker on the hill."/></a>
            <div id="brand">Boston Fare Hikes</div>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
              <li><a href="/">Map</a></li>
              <li><a href="/explore">Explore</a></li>
              <li><a href="/suggest">Suggest</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      @yield('content')
      <div class="clearfix"></div>
      <footer>
        <ul id="footermenu">
          <li>&copy; 2016 Rebecca Doris</li>
          <li><a href="/about">About</a><li>
          <li><a href="http://bostonfarehikes.tumblr.com">Blog</a></li>
          <li><a href="/disclaimer">Disclaimer</a></li>
          <li><a href="http://www.mbta.com">MBTA</a></li>
        </ul>
        <div class="clearfix"></div>
      </footer>
       <!-- Bootstrap -->
       <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        @yield('body')
    </body>
</html>