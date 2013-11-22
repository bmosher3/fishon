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

if (isset($_POST["btnSubmit"])) {
	$email = htmlentities($_POST["email"], ENT_QUOTES, "UTF-8");
	$pass = password_hash(htmlentities($_POST["email"], ENT_QUOTES, "UTF-8"), PASSWORD_BCRYPT);

	try {
	            $db->beginTransaction();

	            $sql = 'SELECT pkEmail from tblUser WHERE pkEmail ="'.$email.'"';
	            $stmt = $db->prepare($sql);
	            $stmt->execute();
	            $exists = $stmt->fetchAll();

	            if(!($exists)){
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
}
?>

<body>
		<?
		include('nav.php');
		?>
 		<form action="<? print $_SERVER['PHP_SELF']; ?>"
                  method="post"
                  id="register">
                <fieldset class="contact">
                    <legend>Registration</legend>
                    	<label class="required" for="email">Email </label>
                    	<input id ="email" name="email" class="element text medium<" type="text" maxlength="655" value="<?php echo $email; ?>" placeholder="enter your preferred email address" onfocus="this.select()"  tabindex="500"/>
                    	<label class="required" for="password">Password </label>
                    	<input id ="password" name="password" type = "password" type="text" maxlength="655" onfocus="this.select()" tabindex = "501"/> 
                    	<input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="502" class="button">
                	    <input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="503" class="button" onclick="reSetForm()" >
                </fieldset>                    

   </form>

</body>