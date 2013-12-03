<?php
include('top.php');
include("nav.php");
require("connect.php");
include("password.php");
$email = $_GET['email'];
$ehash = $_GET['q'];

if (password_verify($email, $ehash)){
	try {
	    $db->beginTransaction();
	    $query = 'UPDATE tblUser SET fldConfirmed = 1 WHERE pkEmail ="'.$email.'"';
	    $stmt = $db->prepare($query);
	    $stmt->execute();
	    $dataEntered = $db->commit();
	    } 
	catch (PDOExecption $e) {
	    $db->rollback();
	    print "Error!: </br>";
	}
	if ($dataEntered){
		echo "<h1>Registration Confirmed. You can now submit fishing reports on the submit report page after you <a href=http://www.uvm.edu/~bmosher/cs148/assignment5.1/home.php>login</a></h1>";
	}
}
else{
	echo "<h1>There was a problem confirming your registration, please try again later.";
}
?>