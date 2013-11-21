<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" type="text/css" media="screen">
<style>
        html,
        body,
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px;
        }
</style>
<title>fishOn</title>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCtmGk6E6OiFCSxfX_afOJofOHMCTE_EA&sensor=false"></script>
<!link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>
        google.maps.visualRefresh = true;
        var marker;

        function initialize() {
            var mapOptions = {
                center: new google.maps.LatLng(41.615442, -71.315231),
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById("map-canvas"),
                mapOptions);

            google.maps.event.addListener(map, 'rightclick', function (event) {
                var infoWindow = new google.maps.InfoWindow;
                    marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });

                var form = '<div id="report">' +
                    '<h1 id="firstHeading" class="firstHeading">Add Report</h1>' +
                    '<form id="reportForm">' +
                    '<p><b>Email:   </b><input id ="email" name="email" class="element text medium" type="text" maxlength="100"  onfocus="this.select()"  tabindex="33"/>' +
                    '<p><b>Date:   </b><input type="text" id="datepicker" /></p>' +
                    '<p><b>5:00 PM</b></p>' +
                    '<p><b>Fish:   </b><select><option>Striper</option><option>Fluke</option></select></p>' +
                    '<p><b>Tide:   </b><select><option>Incoming</option><option>Outgoing</option></select></p>' +
                    '<p><b>Bait:   </b><input id ="bait" name="bait" class="element text medium<?php if ($firstNameERROR) echo '
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/>' +
                    '<p><b>Length: </b><input id ="length" name="txtLength" class="element text medium<?php if ($firstNameERROR) echo ' +
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Inches</p>' +
                    '<p><b>Weight: </b><input id ="weight" name="txtWeight" class="element text medium<?php if ($firstNameERROR) echo ' +
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Pounds</p>' +
                    '<p><input type="button" value="Save & Close" onclick="saveData()"</p>' +
                    '</form>' +
                    '</div>';
                bindInfoWindow(marker, map, infoWindow, form);
                google.maps.event.trigger(marker, 'click');
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);

        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
            });
        }

        function saveData() {
              var email = escape(document.getElementById("email").value);
              var latlng = marker.getPosition();
         
              var url = "insert.php?email=" + email + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();
              downloadUrl(url, function(data, responseCode) {
                if (responseCode == 200 && data.length <= 1) {
                  infowindow.close();
                  document.getElementById("message").innerHTML = "Location added.";
                }
              });
            }

            function downloadUrl(url, callback) {
              var request = window.ActiveXObject ?
                  new ActiveXObject('Microsoft.XMLHTTP') :
                  new XMLHttpRequest;

              request.onreadystatechange = function() {
                if (request.readyState == 4) {
                  request.onreadystatechange = doNothing;
                  callback(request.responseText, request.status);
                }
              };

              request.open('GET', url, true);
              request.send(null);
            }

            function doNothing() {}
            
</script>
</head>

<body>
    <div id="map-canvas"></div>
    <div id="message"></div>
</body>