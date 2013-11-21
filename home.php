<?php
$debug = true;
include('top.php');
include('password.php');
require('connect.php');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
</script>
</head>
<?

$email = "";
$pass = "";

if (isset($_POST["btnSubmit"])) {
	$email = htmlentities($_POST["email"], ENT_QUOTES, "UTF-8");
	$pass = password_hash(htmlentities($_POST["email"], ENT_QUOTES, "UTF-8"), PASSWORD_DEFAULT);

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
<body><header>
	<h1><b>Fish On</b></h1>
</header>
<nav>
     <ol>
		<li><a href="home.php">Home</a></li>
        <li><a href="fishmap.php">Fish Map</a></li>	
        <li><a href="popmap.php">Submit Report</a></li>	
     </ol>
</nav>
<body>
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