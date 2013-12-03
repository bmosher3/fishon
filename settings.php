<?php
include("top.php");
include("nav.php");
require("connect.php");
if($_SESSION['admin']){

	if (isset($_POST["Users"])) {
	    

	    // you may want to add another security check to make sure the person
	    // is allowed to delete records.
	    
	    $id = htmlentities($_POST["Users"], ENT_QUOTES);

	    $sql = "SELECT pkEmail, fldConfirmed, fldApproved, fldAdmin";
	    $sql .= "FROM tblUser ";
	    $sql .= "WHERE pkEmail=" . $email;

	    if ($debug)
	        print "<p>sql " . $sql;

	    $stmt = $db->prepare($sql);

	    $stmt->execute();

	    $users = $stmt->fetchAll();
	    if ($debug) {
	        print "<pre>";
	        print_r($poets);
	        print "</pre>";
	    }

	    foreach ($users as $user) {
	        $email = $user["pkEmail"];
	        $confirmed = $user["fldConfirmed"];
	        $approved = $user["fldApproved"];
	        $admin = $user["fldAdmin"];
	    }
	} else { //defualt values

	    $id = "";
	    $firstName = "";
	    $lastName = "";
	    $birthday = "";


	} // end isset  Users


	//-----------------------------------------------------------------------------
	//-----------------------------------------------------------------------------
	//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// simple deleting record. 
	if (isset($_POST["delete"])) {
	//-----------------------------------------------------------------------------
	// 
	// Checking to see if the form's been submitted. if not we just skip this whole 
	// section and display the form
	// 
	//#############################################################################

	    
	    // you may want to add another security check to make sure the person
	    // is allowed to delete records.
	    
	    $delId = htmlentities($_POST["deleteEmail"], ENT_QUOTES);

	    // I may need to do a select to see if there are any related records.
	    // and determine my processing steps before i try to code.

	    $sql = "DELETE ";
	    $sql .= "FROM tblUser ";
	    $sql .= "WHERE pkEmail=" . $delId;

	    if ($debug)
	        print "<p>sql " . $sql;

	    $stmt = $db->prepare($sql);

	    $DeleteData = $stmt->execute();
	    
	    
	}

	//-----------------------------------------------------------------------------
	//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// if form has been submitted, validate the information both add and update
	if (isset($_POST["submit"])) {    
	    // initialize my variables to the forms posting	
	    $email = htmlentities($_POST["email"], ENT_QUOTES);
	    $confirmed = htmlentities($_POST["confirmed"], ENT_QUOTES);
	    $approved = htmlentities($_POST["approved"], ENT_QUOTES);
	    $admin = htmlentities($_POST["admin"], ENT_QUOTES);

	    
	    
	        
	        if ($debug)
	            echo "<p>Form is valid</p>";

	        if (isset($_POST["id"])) { // update record
	            $sql = "UPDATE ";
	            $sql .= "tblUser SET ";
	            $sql .= "pkEmail='$email', ";
	            $sql .= "fldConfirmed='$confirmed', ";
	            $sql .= "fldApproved='$approved' ";
	            $sql .= "WHERE pkEmail=" . $email;
	        } else { // insert record
	            $sql = "INSERT INTO ";
	            $sql .= "tblUser SET ";
	            $sql .= "pkEmail='$email', ";
	            $sql .= "fldApproved='$approved', ";
	            $sql .= "fldAdmin='$admin'";
	        }
	        // notice the SQL is basically the same. the above code could be replaced
	        // insert ... on duplicate key update but since we have other procssing to
	        // do i have split it up.

	        if ($debug)
	            echo "<p>SQL: " . $sql . "</p>";

	        $stmt = $db->prepare($sql);

	        $enterData = $stmt->execute();

	        // Processing for other tables falls into place here. I like to use
	        // the same variable $sql so i would repeat above code as needed.
	        if ($debug){
	            print "<p>Record has been updated";
	        }
	        
	        // update or insert complete
	        
	        
	    // end no errors	
	} // end isset cmdSubmitted
	 

	if ($email != "") {
	    print "<h1>Edit User Information</h1>";
	    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	    // display a delete option
	    ?>
	    <form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
	        <fieldset>
	            <input type="submit" name="delete" value="Delete" />
	            <?php print '<input name= "deleteId" type="hidden" id="deleteId" value="' . $email . '"/>'; ?>
	        </fieldset>	
	    </form>
	    <?
	    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^% 
	} else {
	    print "<h1>Add User Information</h1>";
	}


	?>

	<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
	    <fieldset>
	        <label for="email"	>Email*</label><br>
	        <input name="email" type="text" size="20" id="email" <? print 'value="'.$email.'"'; ?>/><br>

	        <label for="confirmed">Confirmed*</label><br>
	        <input name="confirmed" type="text" size="20" id="confirmed" <? print 'value="' . $confirmed . '"'; ?>/><br>

	        <label for="approved">Approved</label><br>
	        <input name="approved" type="text" size="20" id="approved" <? print 'value="'. $approved.'"'; ?> /><br>

	        <label for="admin">Confirmed*</label><br>
	        <input name="admin" type="text" size="20" id="admin" <? print 'value="' . $admin . '"'; ?>/><br>

	        <?
	//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// if there is a record then we need to be able to pass the pk back to the page
	        if ($email != "")
	            print '<input name= "email" type="hidden" id="email" value="' . $email . '"/>';
	        ?>
	        <input type="submit" name="submit" value="submit" />
	    </fieldset>		
	</form>
	<?php


	?>


	<?
} elseif ($_SESSION['user']){ 
	$email = $_SESSION['user'];
	$sql = 'SELECT pkEmail,fldPassword from tblUser WHERE pkEmail ="'.$email.'"';
    $stmt = $db->prepare($sql);
	$stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $exists["fldPassword"];

?>
<form action="<? print $_SERVER['PHP_SELF']; ?>"
	                  method="post"
	                  id="changepass">
	<fieldset class="contact">
	<lengend>Information</lengend>
	<fieldset>
	<legend>Change Password</legend>                 
	<label class="required" for="password">Old Password </label>
	<input id ="oldpassword" name="oldpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/> 
	<label class="required" for="password">New Password </label>
	<input id ="newpassword" name="newpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/> 
	<label class="required" for="password">Verify New Password </label>
	<input id ="vnewpassword" name="vnewpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/>
	<input type="submit" id="changepass" name="changepass" value="Change Password" tabindex="502" class="button">
	</fieldset>
	</fieldset>
</form>

<? 
} 
?>