<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet"
          href="style.css"
          type="text/css"
          media="screen">
    <title>Info windows</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
    <script>

function initialize() {
  var myLatlng = new google.maps.LatLng(41.615442, -71.315231);
  var mapOptions = {
    zoom: 10,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var contentString = '<div id="report">'+
      '<h1 id="firstHeading" class="firstHeading">Add Report</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Date:   </b><input type="text" id="datepicker" /></p>'+
      '<p><b>5:00 PM</b></p>'+
      '<p><b>Fish:   </b><select><option>Striper</option><option>Fluke</option></select></p>'+
      '<p><b>Tide:   </b><select><option>Incoming</option><option>Outgoing</option></select></p>'+
      '<p><b>Bait:   </b><input id ="txtBait" name="txtBait" class="element text medium<?php if ($firstNameERROR) echo ' mistake'; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/>'+
      '<p><b>Length: </b><input id ="txtLength" name="txtLength" class="element text medium<?php if ($firstNameERROR) echo ' mistake'; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Inches</p>'+
      '<p><b>Weight: </b><input id ="txtWeight" name="txtWeight" class="element text medium<?php if ($firstNameERROR) echo ' mistake'; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Pounds</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Striped Bass'
  });
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

