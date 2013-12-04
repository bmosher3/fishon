<?php

include("top.php");
include("nav.php");
include("password.php");
require("connect.php");
if($_SESSION['admin']){

            $sql  = 'SELECT pkEmail';
            $sql .= ' FROM tblUser';
            $sql .= ' ORDER BY pkEmail';
            $stmt = $db->prepare($sql);
            $stmt->execute(); 
            $users = $stmt->fetchAll(); 

            $sql  = 'SELECT pkReportID, fkEmail';
            $sql .= ' FROM tblReport';
            $sql .= ' ORDER BY pkReportID';
            $stmt = $db->prepare($sql);           
            $stmt->execute(); 
            $reports = $stmt->fetchAll(); 

            $sql  = 'SELECT pkFishID, fldFishSpecies';
            $sql .= ' FROM tblFish';
            $sql .= ' ORDER BY fldFishSpecies';
            $stmt = $db->prepare($sql);          
            $stmt->execute(); 
            $fishes = $stmt->fetchAll(); 
?>
<script>
var fishes = (<?php echo json_encode($fishes) ?>);
</script>
<?

if (isset($_POST["user_submit"])) {
        

        // you may want to add another security check to make sure the person
        // is allowed to delete records.
        
        $email = htmlentities($_POST["lstUser"], ENT_QUOTES);

        $sql = 'SELECT pkEmail, fldConfirmed, fldApproved, fldAdmin FROM tblUser WHERE pkEmail = "'. $email.'"';

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $this_users = $stmt->fetchAll();
       
        foreach ($this_users as $this_user) {
            $email = $this_user["pkEmail"];
            $confirmed = $this_user["fldConfirmed"];
            $approved = $this_user["fldApproved"];
            $admin = $this_user["fldAdmin"];
        }
    } else { //defualt values

        $uid = "";
        $ufirstName = "";
        $ulastName = "";
        $ubirthday = "";


    } // end isset  Users


    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    // simple deleting record. 
    if (isset($_POST["delete_user"])) {
    //-----------------------------------------------------------------------------
    // 
    // Checking to see if the form's been submitted. if not we just skip this whole 
    // section and display the form
    // 
    //#############################################################################

        
        // you may want to add another security check to make sure the person
        // is allowed to delete records.
        
        $delId = htmlentities($_POST["email"], ENT_QUOTES);

        // I may need to do a select to see if there are any related records.
        // and determine my processing steps before i try to code.

        $sql = 'DELETE FROM tblUser WHERE pkEmail ="' . $delId. '"';


        $stmt = $db->prepare($sql);

        $DeleteData = $stmt->execute();
        
        
    }

    //-----------------------------------------------------------------------------
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
    // if form has been submitted, validate the information both add and update
    if (isset($_POST["update_user"])) {    
        // initialize my variables to the forms posting 
        $email = htmlentities($_POST["email"], ENT_QUOTES);
        $confirmed = htmlentities($_POST["confirmed"], ENT_QUOTES);
        $approved = htmlentities($_POST["approved"], ENT_QUOTES);
        $admin = htmlentities($_POST["admin"], ENT_QUOTES);

        
        
            
            if ($debug)
                echo "<p>Form is valid</p>";

            if (isset($_POST["update_user"])) { // update record
                $sql = 'UPDATE tblUser SET pkEmail ="'.$email.'", fldConfirmed ="'.$confirmed.'", fldApproved ="' .$approved . '", fldAdmin ="' .$admin .'" WHERE pkEmail = "'.$email.'"'; 
            } else { // insert record
                $sql = "INSERT INTO ";
                $sql .= "tblUser SET ";
                $sql .= "pkEmail='$email', ";
                $sql .= "fldApproved='$approved', ";
                $sql .= "fldAdmin='$admin'";
            }

            $stmt = $db->prepare($sql);

            $enterData = $stmt->execute();

           
    } // end isset cmdSubmitted
     
if (isset($_POST["report_submit"])) {
        $email = htmlentities($_POST["email"], ENT_QUOTES);
        $confirmed = htmlentities($_POST["confirmed"], ENT_QUOTES);
        $approved = htmlentities($_POST["approved"], ENT_QUOTES);
        $admin = htmlentities($_POST["admin"], ENT_QUOTES);


        // you may want to add another security check to make sure the person
        // is allowed to delete records.
        
        $rep_ID = htmlentities($_POST["lstReport"], ENT_QUOTES);

        $sql = "SELECT tblReport.pkReportID, tblReport.fkEmail, tblReport.fldDate, tblReport.fldTime, tblReport.fldBait, tblReport.fldTide, tblReport.fldShore,";
        $sql.= "tblReport.fldDescription, tblReport.fldLocationName, tblReport.fldLat, tblReport.fldLong, tblReportFish.fkReportID, tblReportFish.fkFishID,";
        $sql.= "tblReportFish.fldFishLength, tblReportFish.fldFishWeight, tblFish.fldFishSpecies FROM tblReport INNER JOIN tblReportFish";
        $sql.=" ON pkReportID = fkReportID";
        $sql.= " INNER JOIN tblFish ON tblReportFish.fkFishID = tblFish.pkFishID WHERE tblReport.pkReportID ='".$rep_ID."'";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $this_reports = $stmt->fetchAll();
        
        foreach ($this_reports as $this_report){
            $rep_email = $this_report["fkEmail"];
            $rep_ID = $this_report["pkReportID"];
            $rep_date = $this_report["fldDate"];
            $rep_time = $this_report["fldTime"];
            $rep_bait = $this_report["fldBait"];
            $rep_tide = $this_report["fldTide"];
            $rep_shore = $this_report["fldShore"];           
            $rep_fish = $this_report["fldFishSpecies"];
            $rep_fishID = $this_report["fkFishID"];
            $rep_length = $this_report["fldFishLength"];
            $rep_weight = $this_report["fldFishWeight"];

        }
} 
if (isset($_POST["update_report"])) {
        $rep_email = htmlentities($_POST["rep_email"], ENT_QUOTES);
        $rep_ID = htmlentities($_POST["rep_id"], ENT_QUOTES);
        $rep_date = htmlentities($_POST["datepicker"], ENT_QUOTES);
        $rep_time = htmlentities($_POST["timepicker"], ENT_QUOTES);
        $rep_bait = htmlentities($_POST["bait"], ENT_QUOTES);
        $rep_tide = htmlentities($_POST["tide"], ENT_QUOTES);
        $rep_shore = htmlentities($_POST["shore"], ENT_QUOTES);
        $rep_fishID = htmlentities($_POST["fish"], ENT_QUOTES);
        //$rep_fishID = htmlentities($_POST["time"], ENT_QUOTES);
        $rep_length = htmlentities($_POST["length"], ENT_QUOTES);
        $rep_weight = htmlentities($_POST["weight"], ENT_QUOTES);

        $sql = 'UPDATE tblReport SET fldDate ="' .$rep_date. '", fldTime="' .$rep_time.'", fldBait ="' .$rep_bait.'", ';
        $sql .= 'fldTide ="' .$rep_tide. '", fldShore ="' .$rep_shore . '" WHERE pkReportID ="' .$rep_ID.'"';
        $stmt = $db->prepare($sql);
        $enterData = $stmt->execute();

        $sql = 'UPDATE tblReportFish SET fkFishID ="' .$rep_fishID. '", fldFishLength="' .$rep_length.'", fldFishWeight ="' .$rep_weight.'" ';
        $sql .= 'WHERE fkReportID ="' .$rep_ID . '"';
        
        $stmt = $db->prepare($sql);
        $enterData = $stmt->execute();
}
if (isset($_POST["delete_report"])) {
		$rep_delId = htmlentities($_POST["rep_id"], ENT_QUOTES);
		$sql = 'DELETE FROM tblReportFish WHERE fkReportID ="' . $rep_delId. '"';        
        
		$stmt = $db->prepare($sql);
		$DeleteData = $stmt->execute();
		$sql = 'DELETE FROM tblReport WHERE pkReportID ="' . $rep_delId. '"';        
        
		$stmt = $db->prepare($sql);
		$DeleteData = $stmt->execute();
}

if (isset($_POST["fish_submit"])) {
	$subfish_id = htmlentities($_POST["lstFish"], ENT_QUOTES);

	$sql = "SELECT pkFishID, fldFishSpecies FROM tblFish WHERE pkFishID = '".$subfish_id."'";
	
	$st=$db->prepare($sql);
	$st -> execute();
	$this_fishes = $st->fetchAll();
	foreach ($this_fishes as $this_fish){
		$fish_name = $this_fish['fldFishSpecies'];
		$fish_id = $this_fish['pkFishID'];
	}

}

if (isset($_POST["new_fish"])) {
	$fish_name = htmlentities($_POST["fish_name"], ENT_QUOTES);
	$sql = 'INSERT INTO tblFish (fldFishSpecies) VALUES ("'.$fish_name.'")';
	$stmt=$db->prepare($sql);
	$stmt->execute();
}

if (isset($_POST["update_fish"])) {
	$fish_name = htmlentities($_POST["fish_name"], ENT_QUOTES);
	$fish_id = htmlentities($_POST["fish_id"], ENT_QUOTES);
	$sql = 'UPDATE tblFish SET fldFishSpecies ="'.$fish_name.'" WHERE pkFishID ="'.$fish_id . '"';
	$stmt=$db->prepare($sql);
	$stmt->execute();
}

if (isset($_POST["delete_fish"])) {
	$fish_id = htmlentities($_POST["fish_id"], ENT_QUOTES);
	$sql = 'DELETE FROM tblFish WHERE pkFishID ="'.$fish_id.'"';
	$stmt=$db->prepare($sql);
	$stmt->execute();
}

    ?>
	<form action="<? print $_SERVER['PHP_SELF']; ?>"
	                      method="post"
	                      id="user_select">
	<fieldset class="listbox"><legend>User</legend>
	    <select name="lstUser" size="1" tabindex="243">';
	                    <?php foreach ($users as $user) {
	                    print '<option value=' . $user['pkEmail'] . '>'.$user['pkEmail'].'</option>';
	                    }?>
	    </select>
	    <input type="submit" id="user_submit" name="user_submit" value="Submit" tabindex="502" class="button">
	</fieldset>
	</form>

    <form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>
        <h1>User Information</h1>
            <label for="email">Email*</label>
            <input name="email" type="text" size="20" id="email" <? print 'value="'.$email.'"'; ?>/><br>

            <label for="confirmed">Confirmed</label>
            <input name="confirmed" type="text" size="20" id="confirmed" <? print 'value="' . $confirmed . '"'; ?>/><br>

            <label for="approved">Approved</label>
            <input name="approved" type="text" size="20" id="approved" <? print 'value="'. $approved.'"'; ?> /><br>

            <label for="admin">Admin</label>
            <input name="admin" type="text" size="20" id="admin" <? print 'value="' . $admin . '"'; ?>/><br>

            <input type="submit" name="update_user" value="update" />
            <input type="submit" name="delete_user" value="delete" />
        </fieldset>     
    </form>
   
<form action="<? print $_SERVER['PHP_SELF']; ?>"
                      method="post"
                      id="report_select">
<fieldset class="listbox"><legend>Report</legend>
        <select name="lstReport" size="1" tabindex="243">';
                    <?php foreach ($reports as $report) {
                    print '<option value=' . $report['pkReportID'] . '>'.$report['fkEmail']. " " . $report['pkReportID'].'</option>';
                    }?>
        </select>
        <input type="submit" id="report_submit" name="report_submit" value="Submit" tabindex="502" class="button">
</fieldset>
<form>

<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>
                    <h1 id="firstHeading" class="firstHeading">Report</h1>
                    <form id="reportForm">
                    <b>User:   </b><input type="text" name="rep_email"<? print 'value="'.$rep_email.'"'; ?>/><br>
                    <b>Report ID:   </b><input type="text" name="rep_id"<? print 'value="' .$rep_ID . '"'; ?>/><br>
                    <b>Date:   </b><input type="text" name="datepicker" <? print 'value="'.$rep_date.'"'; ?>/><br>
                    <b>Time:   </b><input type="text" name="timepicker"<? print 'value="'.$rep_time.'"'; ?>/><br>
                    <b>Fish:   </b><select name ="fish"><? print '<option value=' . $rep_fishID. '>'.$rep_fish. '</option>'; ?>/>
                    <?php foreach ($fishes as $fish) {
                    print '<option value=' . $fish['pkFishID'] . '>'.$fish['fldFishSpecies']. '</option>';
                    }?>
                    </select><br>
                    <b>Tide:   </b><select name ="tide"><? print '<option>'.$rep_tide. '</option>'; ?><option>Incoming</option><option>Outgoing</option></select><br>
                    <b>Shore:  </b><select name ="shore"><? print '<option>'.$rep_shore. '</option>'; ?><option>On Shore</option><option>Off Shore</option></select><br>
                    <b>Bait:   </b><input type="text"  name ="bait" name="bait" size="10" maxlength="20"  onfocus="this.select()"  tabindex="33" <? print 'value="'.$rep_bait.'"'; ?>/><br>
                    <b>Length: </b><input type="text" name ="length" name="txtLength" size="5" maxlength="20"  onfocus="this.select()"  tabindex="33" <? print 'value="'.$rep_length.'"'; ?>/> Inches<br>
                    <b>Weight: </b><input type="text"  name ="weight" name="txtWeight" size="5" maxlength="20"  onfocus="this.select()"  tabindex="33"<? print 'value="'.$rep_weight.'"'; ?>/> Pounds<br>
                    <input type="submit" value="update" name ="update_report"/>
                    <input type="submit" name="delete_report" value="delete" />
                    </form> 
        </fieldset>
</form>
<form action="<? print $_SERVER['PHP_SELF']; ?>"
                      method="post"
                      id="fish_select">
<fieldset class="listbox"><legend>Fish</legend>
        <select name="lstFish" size="1" tabindex="243">';
                    <?php foreach ($fishes as $fish) {
                    print '<option value=' . $fish['pkFishID']. '>'.$fish['fldFishSpecies']. '</option>';
                    }?>
        </select>   
        <input id="fish_text" type = "hidden" name = "fish_text" value = "" />
        <input type = "submit" name = "fish_submit" value = "submit"/>
           
</fieldset>
</form>
<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>
        <h1 id="firstHeading" class="firstHeading">Fish</h1>
        	<b>ID  :   </b><input type="text" name="fish_id"<? print 'value="'.$fish_id . '"';?>/><br>
        	<b>Fish:   </b><input type="text" name="fish_name"<? print 'value="'.$fish_name.'"'; ?>/><br>
			<input type="submit" name ="new_fish" value="new" />
			<input type="submit" name ="update_fish" value="update" />
        	<input type="submit" name ="delete_fish" value="delete" />
        </fieldset>
</form>
<?

}
if ($_SESSION['user']){ 
    $email = $_SESSION['user'];
    $sql = 'SELECT pkEmail,fldPassword from tblUser WHERE pkEmail ="'.$email.'"';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $exists["fldPassword"];
    

    if (isset($_POST["changepass"])) {
    	$oldpass = htmlentities($_POST["oldpassword"], ENT_QUOTES);
    	$newpass1 = htmlentities($_POST["newpassword"], ENT_QUOTES);
    	$newpass2 = htmlentities($_POST["vnewpassword"], ENT_QUOTES);
    	if (password_verify($oldpass, $hash)) {
    		if($newpass1==$newpass2){
    			$newhash = password_hash($newpass1,PASSWORD_BCRYPT);
    			$sql = 'UPDATE tblUser SET fldPassword = "'.$newhash.'" WHERE pkEmail = "'.$email.'"';
    			$stmt = $db->prepare($sql);
    			$stmt->execute(); 
    			$error = "password changed";
    		}
    		else{
    			$error = "passwords don't match";
    		}
    	}
    	else{
    		$error = "old password is wrong";
    	}
    }

?>
<form action="<? print $_SERVER['PHP_SELF']; ?>"
                      method="post"
                      id="changepass">
    <fieldset class="contact">
    <legend>Change Password</legend>  
    <div id = "error">
	    <?php
	       	if($error){
	      		echo($error);
	      	}
	  	?>
	</div>               
    <label class="required" for="password">Old Password </label>
    <input id ="oldpassword" name="oldpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/><br>
    <label class="required" for="password">New Password </label>
    <input id ="newpassword" name="newpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/><br>
    <label class="required" for="password">Verify New Password </label>
    <input id ="vnewpassword" name="vnewpassword" type ="password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/><br>
    <input type="submit" id="changepass" name="changepass" value="Change Password" tabindex="502" class="button">
    </fieldset>
    </fieldset>
</form>

<? 
} 
?>