<?php
ob_start();
require("connect.php");

/*function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 
*/
// Select all the rows in the markers table
$sql = "SELECT fkEmail, fldDate, fldTime, fldBait, fldTide, fldShore, fldDescription, fldLocationName, fldLat, fldLong FROM tblReport";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($result);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}
echo json_encode($result);
?>
