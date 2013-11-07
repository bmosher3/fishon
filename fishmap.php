

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Info windows</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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
      '<h1 id="firstHeading" class="firstHeading">Striped Bass</h1>'+
      '<div id="bodyContent">'+
      '<p><b>10/23/13</b></p>'+
      '<p><b>5:00 PM</b></p>'+
      '<p><b>Fish:</b> Striped Bass</p>'+
      '<p><b>Tide:</b> Outgoing</p>'+
      '<p><b>Bait:</b> Clam Bellies</p>'+
      '<p><b>Length:</b> 30 Inches</p>'+
      '<p><b>Weight:</b> 25 lbs</p>'+
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

