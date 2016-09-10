<!DOCTYPE html>
<html lang="en">
   <head>
      <title>{{ $hike->name }}</title>
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
      <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/ >
      <link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
      <link rel="stylesheet" href="/css/hike.css" />
      <!-- END CUSTOMIZATION -->

   </head>
   <body>
    <!-- NAVIGATION -->

    <!-- CONTENT -->
    <div class="container">
      
      <h1>{{ $hike->name }}</h1>
      <div id="gallery">
        @foreach ($images as $image)
          <a class="fancybox" rel="group" href="/img/hikes/{{ $hike->path_name }}/{{ $hike->path_name }}{{ $image->file }}" title="{{ $image->title }}"><img src="/img/hikes/{{ $hike->path_name}}/thumbnails/{{ $hike->path_name}}{{ $image->file }}" width="128px" alt="{{ $hike->alt}}"/></a>
        @endforeach
      </div>
      <p>{{ $hike->description }}</p>
      <p><a href="/hikes">Back</a>

      <form class="form-inline">
        <label class="sr-only" for="start">User address</label>
        <input type="text" class="form-control" id="start" name="start" placeholder="Enter your address" size="40" />
        <label class="sr-only" for="end">Select destination</label>
        <select class="form-control" name="end" id="end">
          <?php 
            // index the markers
            $index = 0;
            ?>
          @foreach ($markers as $marker)
            <option value='{{ $index++ }}'>{{ $marker->name }}</option>
          @endforeach
        </select>
        <label class="sr-only" for="transitOptions">Select leaving/arriving</label>
        <select class="form-control" name="transitOptions" id="transitOptions">
            <option value="departureTime">Leaving at</option>
            <option value="arrivalTime">Arriving by</option>
        </select>
        <label class="sr-only" for="datetimepicker">Select time and date leaving/arriving</label>
        <input class="form-control" id="datetimepicker" name="datetimepicker" type="text" >
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <div id="directionsPanelContainer">
      <div id="timing"></div>
      <div id="directionsPanel"></div>
    </div>
    <div id="hike-map"></div>
    
    <!-- CONTENT -->
    
    <!-- FOOTER -->

   <!-- JQuery -->
   <script type="text/javascript" src="/js/jquery-1.12.2.min.js"> </script>
   <!-- BOOTSTRAP JS -->
   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   

   <!-- CUSTOMIZATION -->
    <!-- GOOGLE MAPS API -->
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
    async defer></script>
   <script>
    var markerData = <?php echo json_encode($markers) ?>;
   </script>
   <script src="/js/directions.js"></script>
   <script src="/js/jquery.datetimepicker.full.min.js"></script>
   <script>
      $('#datetimepicker').datetimepicker({
        minDate: 0,
        allowTimes: [
          '5:30', '6:00', '6:30', '7:00', '7:30', '8:00',
          '8:30', '9:00', '9:30', '10:00', '10:30', '11:00',
          '11:30', '12:00', '12:30', '13:00', '13:30', '14:00',
          '14:30', '15:00', '15:30', '16:00', '16:30', '17:00',
          '17:30', '18:00', '18:30', '19:00', '19:30', '20:00',
          '20:30', '21:00', '21:30', '22:00', '22:30', '23:00',
          '23:30', '0:00', '0:30'
        ],
        formatTime: 'g:iA'
      });
    </script>
    <script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".fancybox").fancybox();
      });
    </script>
    <link rel="stylesheet" type="text/css" href="/css/directionspanel.css"/ >
    <!-- END CUSTOMIZATION -->
   </body>
</html>