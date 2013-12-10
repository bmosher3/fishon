<?php
include('top.php');
require('connect.php');
?>
<style>
        #map-canvas {
            height: 90%;
            width: 92%;
            padding: 0%;
            margin: 0 auto 0 auto; 
        }
</style>

<script src="jquery-ui-timepicker-addon.js"></script>
<?
  $sql  = 'SELECT pkFishID, fldFishSpecies FROM tblFish ORDER BY fldFishSpecies';
  $stmt = $db->prepare($sql);
  $stmt->execute(); 
  $fish = $stmt->fetchAll();
  if (($_SESSION['user'])&&($_SESSION['approved'])&&($_SESSION['confirmed'])) { 
  ?>

<script>
    
        var fishes = (<?php echo json_encode($fish) ?>);
        console.log(fishes);
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

                var form = '<div id="report" style="width:325px; height:380px">' +
                    '<h1 id="firstHeading" class="firstHeading">Add Report</h1>' +
                    '<form id="reportForm">' +
                    '<p><b>Date:   </b><input type="text" id="datepicker"></p>' +
                    '<p><b>Time:   </b><input type="text" id="timepicker"</p>' +
                    '<p><b>Fish:   </b><select id ="fish">';
                    for (key in fishes){
                      var fish = window.fishes[key]["fldFishSpecies"];
                      var fishID = window.fishes[key]["pkFishID"];
                      form+= "<option value =" + fishID+">"+fish+"</option>";

                    }
                    form+= '</select></p>' +
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
              var email = "<?php echo $_SESSION['user']?>";
              var date = escape(document.getElementById("datepicker").value);
              var time = escape(document.getElementById("timepicker").value);
              var fish = escape(document.getElementById("fish").text);
              var fishID = escape(document.getElementById("fish").value);
              var tide = escape(document.getElementById("tide").value);
              var shore = escape(document.getElementById("shore").value);
              var bait = escape(document.getElementById("bait").value);
              var length = escape(document.getElementById("length").value);
              var weight = escape(document.getElementById("weight").value);
              var latlng = marker.getPosition();
         
              var url = "insert.php?email=" + email + "&lat=" + latlng.lat() + "&lng=" + latlng.lng() + 
                        "&date=" + date + "&time=" + time  + "&fishID=" +fishID + "&tide=" + tide + "&shore=" + shore +
                        "&bait=" + bait  + "&length=" + length + "&weight=" + weight ;
              downloadUrl(url, function(data, responseCode) {
                if (responseCode == 200 && data.length <= 1) {
                   document.getElementById("message").innerHTML = "Location added.";
                }
              });
              successContent = "<h1>Report Submitted</h1><p>You can now view your report on the Fish Map page."
              document.getElementById("report").innerHTML = successContent;
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
    <?php }
    else{
      echo("<h1>You must be logged in and confirm your email to view this page</h1>");
    } ?> 
    
    <div id="map-canvas"></div>
    <div id="message"></div>
    
</body>