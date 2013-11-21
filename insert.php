<?php
require("connect.php");

// Gets data from URL parameters
$email = $_GET['email'];
//$date = $_GET['date'];
//$time = $_GET['time'];
//$bait = $_GET['bait'];
//$location = $GET[''];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
//$type = $_GET['type'];


// Insert new row with user data
try {
    $db->beginTransaction();
    $query = "INSERT INTO tblReport " .
             " (fkEmail, fldLat, fldLong) " .
             " VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute(array($email,$lat,$lng));
    $dataEntered = $db->commit();
    } 
catch (PDOExecption $e) {
    $db->rollback();
    print "Error!: </br>";
}


?>