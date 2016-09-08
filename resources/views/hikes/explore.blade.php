<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Explore Boston Fare Hikes</title>
      <meta charset="utf-8"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="A navigation web exhibition of MBTA-accessible hiking locations.">
      <meta name="keywords" content="Boston hiking, Massachusetts hiking, MBTA, public transit, public transportation">
      <meta name="author" content="Rebecca Doris">

      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

      <!-- Google Fonts -->
      <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    
      <link rel="stylesheet" href="/css/template.css" />
      <!-- CUSTOMIZATION -->
      <link rel="stylesheet" href="/css/explore.css" />
      <!-- END CUSTOMIZATION -->

   </head>
   <body>
    <!-- NAVIGATION -->

    <!-- CONTENT -->
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
    
    <!-- CONTENT -->
    
    <!-- FOOTER -->

   <!-- JQuery -->
   <script type="text/javascript" src="/js/jquery-1.12.2.min.js"> </script>
   <!-- BOOTSTRAP JS -->
   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   
   <!-- CUSTOMIZATION -->
    <!-- END CUSTOMIZATION -->
   </body>
</html>