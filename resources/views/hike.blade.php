<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Hike</title>
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
    
      <link rel="stylesheet" href="css/template.css" />
      <!-- CUSTOMIZATION -->
      <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css"/ >
      <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
      <link rel="stylesheet" href="css/hike.css" />
      <!-- END CUSTOMIZATION -->

   </head>
   <body>
    <!-- NAVIGATION -->

    <!-- CONTENT -->
    <div class="container">
      
      <h1>{{ $hike->name }}</h1>
      <p>{{ $hike->description }}</p>

    </div>
    
    <!-- CONTENT -->
    
    <!-- FOOTER -->

   <!-- JQuery -->
   <script type="text/javascript" src="js/jquery-1.12.2.min.js"> </script>
   <!-- Google Maps API -->
   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfIWxFiTBaolXUvFobvatofTwGKuEYaKA&callback=initMap"
    async defer></script>
   <!-- CUSTOMIZATION -->
   <script src="js/directions.js"></script>
   <script src="js/jquery.datetimepicker.full.min.js"></script>
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
    <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".fancybox").fancybox();
      });
    </script>
    <link rel="stylesheet" type="text/css" href="css/directionspanel.css"/ >
    <!-- END CUSTOMIZATION -->
   </body>
</html>