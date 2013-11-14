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




            $(document).ready(function () {
                $.ajax({
                    type: 'get',
                    url: 'retrieve.php',
                    data: {},
                    success: function (data) {
                        response = jQuery.parseJSON(data);
                        console.log(response);



                        for (var i = 0; i < response.length; i++) {
                            var name = response[i]["fkEmail"];
                            var date = response[i]["fldDate"];
                            var bait = response[i]["fldBait"];
                            var desc = response[i]["fldDescription"];
                            var loc = response[i]["fldLocationName"];
                            var time = response[i]["fldTime"];
                            var shore = response[i]["fldShore"];
                            var tide = response[i]["fldTide"];
                            var point = new google.maps.LatLng(
                                parseFloat(response[i]["fldLat"]),
                                parseFloat(response[i]["fldLong"]));
                            var contentString = '<p><b>Date:</b>' + date + '</p>' +
                                '<p><b>Time:</b>' + time + '</p>' +
                                '<p><b>Location:</b>' + loc + '</p>' +
                                '<p><b>On/Off Shore:</b>' + shore + '</p>' +
                                '<p><b>Bait:</b>' + bait + '</p>' +
                                '<p><b>Description:</b>' + desc + '</p>' +
                                '<p><b>Tide:</b>' + tide + '</p>';


                            var infoWindow = new google.maps.InfoWindow;
                            var marker = new google.maps.Marker({
                                position: point,
                                map: map
                            });
                            bindInfoWindow(marker, map, infoWindow, contentString);
                        }
                    }
                });
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
    <script>
    </script>
</head>

<body>
    <div id="map-canvas"></div>
</body>

</html>