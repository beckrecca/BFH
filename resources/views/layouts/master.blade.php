<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title','Boston Fare Hikes')
    </title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description','A navigation web exhibition of MBTA-accessible hiking locations.')">
    <meta name="keywords" content="Boston hiking, Massachusetts hiking, MBTA, public transit, public transportation">
    <meta name="author" content="Rebecca Doris">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/template.css" />
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
              <img src="/img/logo/sm_logo.png" id="logo" class="img pull-left" alt="Boston Fare Hikes logo depicting the T symbol with a green hill behind the T and a green map marker on the hill."/>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav pull-right">
                <li><a href="#">Map</a></li>
                <li><a href="#">Explore</a></li>
                <li><a href="#">Suggest</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        @yield('content')
        <div class="clearfix"></div>
        <footer>
          <ul class="pull-left" id="footermenu">
            <li><a href="#">About</a></li>
            <li><a href="http://bostonfarehikes.tumblr.com">Blog</a></li>
            <li><a href="#">Disclaimer</a></li>
            <li><a href="#">Link</a></li>
          </ul>
          <span class="pull-right">&copy; 2016 Rebecca Doris</span>
          <div class="clearfix">
        </footer>
       <!-- JQuery -->
       <script type="text/javascript" src="/js/jquery-1.12.2.min.js"> </script>
        @yield('body')
    </body>
</html>