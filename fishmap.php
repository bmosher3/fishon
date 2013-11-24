<?php
include('top.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    
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
   
    <script>
        google.maps.visualRefresh = true;

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
                            var email = response[i]["fkEmail"];
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


                            var contentString ='<div id="report" style="width:250px; height:300px">' + '<h1>Report:</h1>';
                                if (date){
                                    contentString += '<p><b>Date: </b>' + date + '</p>' ;
                                }
                                if (time){
                                    contentString += '<p><b>Time: </b>' + time + '</p>' ;
                                }
                                if (loc){
                                    contentString += '<p><b>Location: </b>' + loc + '</p>' ;
                                }
                                if (shore){
                                    contentString += '<p><b>Shore: </b>' + shore + '</p>' ;
                                }
                                if (bait){
                                    contentString += '<p><b>Bait: </b>' + bait + '</p>' ;
                                }
                                if (desc){
                                    contentString += '<p><b>Description: </b>' + desc + '</p>' ;
                                }
                                if (tide){
                                    contentString += '<p><b>Tide: </b>' + tide + '</p>';  
                                }
                                contentString += '</div>'
                                                     


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
    <?
    include('nav.php');
    ?>
    <div id="map-canvas"></div>
</body>

</html>