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
$sql = "SELECT tblReport.pkReportID, tblReport.fkEmail, tblReport.fldDate, tblReport.fldTime, tblReport.fldBait, tblReport.fldTide, tblReport.fldShore,";
$sql.= "tblReport.fldDescription, tblReport.fldLocationName, tblReport.fldLat, tblReport.fldLong, tblReportFish.fkReportID, tblReportFish.fkFishID,";
$sql.= "tblReportFish.fldFishLength, tblReportFish.fldFishWeight, tblFish.fldFishSpecies FROM tblReport INNER JOIN tblReportFish";
$sql.=" ON pkReportID = fkReportID";
$sql.= " INNER JOIN tblFish ON tblReportFish.fkFishID = tblFish.pkFishID ";

$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}
echo json_encode($result);

?>
