<?php
require("connect.php");

// Gets data from URL parameters
$email = $_GET['email'];
$date = $_GET['date'];
$time = $_GET['time'];
$fish = $_GET['fish'];
$tide = $_GET['tide'];
$shore = $_GET['shore'];
$bait = $_GET['bait'];
$length = $_GET['length'];
$weight = $_GET['weight'];
//$location = $GET[''];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
//$type = $_GET['type'];


// Insert new row with user data
try {
    $db->beginTransaction();
    $query = "INSERT INTO tblReport " .
             " (fkEmail, fldDate, fldTime, fldTide, fldShore, fldBait, fldLat, fldLong) " .
             " VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute(array($email,$date,$time,$tide,$shore,$bait,$lat,$lng));
    $dataEntered = $db->commit();
    } 
catch (PDOExecption $e) {
    $db->rollback();
    print "Error!: </br>";
}


?>