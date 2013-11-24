<?php
include('top.php');
?>
<style>
        html,
        body,
        #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0%;
        }
</style>
<title>fishOn</title>
<script src="jquery-ui-timepicker-addon.js"></script>

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
                    '<p><b>Email:  </b><input type="text" id ="email" name="email"  maxlength="100"  onfocus="this.select()"  tabindex="33"/>' +
                    '<p><b>Date:   </b><input type="text" id="datepicker"></p>' +
                    '<p><b>Time:   </b><input type="text" id="timepicker"</p>' +
                    '<p><b>Fish:   </b><select id ="fish"><option>Striper</option><option>Fluke</option></select></p>' +
                    '<p><b>Tide:   </b><select id ="tide"><option>Incoming</option><option>Outgoing</option></select></p>' +
                    '<p><b>Shore:  </b><select id ="shore"><option>On Shore</option><option>Off Shore</option></select></p>' +
                    '<p><b>Bait:   </b><input type="text"  id ="bait" name="bait" size="10" maxlength="20" value="" onfocus="this.select()"  tabindex="33"/>' +
                    '<p><b>Length: </b><input type="text" id ="length" name="txtLength"' +
                    '                size="5" maxlength="20" value="" onfocus="this.select()"  tabindex="33"/> Inches</p>' +
                    '<p><b>Weight: </b><input type="text"  id ="weight" name="txtWeight" size="5" maxlength="20" value="" onfocus="this.select()"  tabindex="33"/> Pounds</p>' +
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
            google.maps.event.addListener(infoWindow, 'domready', function() {
              $('#datepicker').datepicker({ dateFormat: "yy-mm-dd" });                   
            }); 
            google.maps.event.addListener(infoWindow, 'domready', function() {
              $('#timepicker').timepicker({
                  timeFormat: 'hh:mm tt',
                  stepHour: 1,
                  stepMinute: 15     
                  })    
            }); 
        }

        function saveData() {
              var email = escape(document.getElementById("email").value);
              var date = escape(document.getElementById("datepicker").value);
              var time = escape(document.getElementById("timepicker").value);
              var fish = escape(document.getElementById("fish").value);
              var tide = escape(document.getElementById("tide").value);
              var shore = escape(document.getElementById("shore").value);
              var bait = escape(document.getElementById("bait").value);
              var length = escape(document.getElementById("length").value);
              var weight = escape(document.getElementById("weight").value);
              var latlng = marker.getPosition();
         
              var url = "insert.php?email=" + email + "&lat=" + latlng.lat() + "&lng=" + latlng.lng() + 
                        "&date=" + date + "&time=" + time  + "&fish=" +fish + "&tide=" + tide + "&shore=" + shore +
                        "&bait=" + bait  + "&length=" + length + "&weight=" + weight ;
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
    <?
    include('nav.php');
    ?>
    <div id="map-canvas"></div>
    <div id="message"></div>
</body>