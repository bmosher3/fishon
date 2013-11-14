<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css" media="screen">
    <title>fishOn</title>
    <style>
        html,
        body,
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>


    <script>
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
                var marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
                var form = '<div id="report">' +
                    '<h1 id="firstHeading" class="firstHeading">Add Report</h1>' +
                    '<form id="reportForm">' +
                    '<p><b>Date:   </b><input type="text" id="datepicker" /></p>' +
                    '<p><b>5:00 PM</b></p>' +
                    '<p><b>Fish:   </b><select><option>Striper</option><option>Fluke</option></select></p>' +
                    '<p><b>Tide:   </b><select><option>Incoming</option><option>Outgoing</option></select></p>' +
                    '<p><b>Bait:   </b><input id ="txtBait" name="txtBait" class="element text medium<?php if ($firstNameERROR) echo '
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/>' +
                    '<p><b>Length: </b><input id ="txtLength" name="txtLength" class="element text medium<?php if ($firstNameERROR) echo '
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Inches</p>' +
                    '<p><b>Weight: </b><input id ="txtWeight" name="txtWeight" class="element text medium<?php if ($firstNameERROR) echo '
                mistake '; ?>" type="text" maxlength="100" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="33"/> Pounds</p>' +
                    '<p><input id ="submitButton" type = "button" value=Submit></input>' +
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
    </script>
</head>

<body>
    <div id="map-canvas"></div>
</body>