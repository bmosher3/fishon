<?php

$debug = false;
include('top.php');
include('password.php');
require('connect.php');
?>

</head>
<?

$email = "";
$pass = "";

//registration
if (isset($_POST["submit"])) {
	$email = htmlentities($_POST["email"], ENT_QUOTES, "UTF-8");
	$pass = password_hash(htmlentities($_POST["password"], ENT_QUOTES, "UTF-8"), PASSWORD_BCRYPT);

	try {
	            $db->beginTransaction();

	            $sql = 'SELECT pkEmail from tblUser WHERE pkEmail ="'.$email.'"';
	            $stmt = $db->prepare($sql);
	            $stmt->execute();
	            $exists = $stmt->fetchAll();
	           	
	          if($exists){
	          	$error ="email already exists";
	          }
	          else{
	          	$error = "Registration email sent to " . $email;
	            $sql = 'INSERT into tblUser (pkEmail,fldPassword) VALUES (?,?)';	
	           	$stmt = $db->prepare($sql);
	           	$stmt->execute(array($email,$pass));
	            }
	            $dataEntered = $db->commit();
	}
	catch (PDOExecption $e) {
	            $db->rollback();
	            print "Error!: " . $e->getMessage() . "</br>";
	            
	    }
	if ($dataEntered&&(!($exists))) {
		
		 $ehash = password_hash($email,PASSWORD_BCRYPT);
		 $messageA = '<h1>Thank you for registering for Fish On.</h1>';
         $messageB = "<p>Click this link to confirm your registration: ";
         $messageB .= '<a href=http://www.uvm.edu/~bmosher/cs148/assignment5.1/confirm.php?q=' . $ehash.'&email='.$email.'>Confirm Registration</a></p>';
         $messageB .= "<p>or copy and paste this url into a web browser: ";
         $messageB .= "http://www.uvm.edu/~bmosher/cs148/assignment5.1/confirm.php?q=" . $ehash. "&email=" . $email;
         $subject = "Fish On Registration";
         include_once('mail.php');
         $mailed = sendMail($email, $subject, $messageA . $messageB);
	}
}

//login
if (isset($_POST["login"])) {
	$email = htmlentities($_POST["email"], ENT_QUOTES, "UTF-8");
	$pass = htmlentities($_POST["password"], ENT_QUOTES, "UTF-8");
	
    $sql = 'SELECT pkEmail,fldPassword, fldConfirmed, fldApproved, fldAdmin from tblUser WHERE pkEmail ="'.$email.'"';
    $stmt = $db->prepare($sql);
	$stmt->execute();
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $exists["fldPassword"];
    $user = $exists["pkEmail"];
    $admin = $exists["fldAdmin"];
    $confirmed = $exists["fldConfirmed"];
    $approved = $exists["fldApproved"];
    if(!($exists)){
	    $error ="user does not exist";
	}
	else{
	 	if (password_verify($pass, $hash)) {
	 		$_SESSION['user']= $email;
	 		$_SESSION['confirmed'] = $confirmed;
	 		$_SESSION['approved'] = $approved;
	 		$_SESSION['admin'] = $admin;
	  	}
	  	else{
	  		$error = "wrong password";
	  	}
	}
}
	

?>

<body>
		<?
		include('nav.php');
		?>
		<?php if (!($_SESSION['user'])){ ?>
		
	 		<form action="<? print $_SERVER['PHP_SELF']; ?>"
	                  method="post"
	                  id="register">
	                <fieldset class="contact">
	                    <legend>Registration</legend>
	                    	<div id = "error">
	                    	<?php
		                    	if($error){
		                    		echo($error);
		                    	}
	                    	?>
	                    	</div>
	                       	<label class="required" for="email">Email </label>
	                    	<input id ="email" name="email" type="text" maxlength="655" value="" onfocus="this.select()"  tabindex="500"/>
	                    	<label class="required" for="password">Password </label>
	                       	<input id ="password" name="password" type ="password" maxlength="655" onfocus="this.select()" tabindex = "501"/> 
	                    	<p>
	                    	<input type="submit" id="login" name="login" value="Login" tabindex="503" class="button" >
	                    	<input type="submit" id="btnSubmit" name="submit" value="Register" tabindex="502" class="button">
	                	    
	                </fieldset>                    

	   		</form>
	   	<?php } ?>

</body>