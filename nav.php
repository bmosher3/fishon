<?php 
if ($_SESSION['user']){ ?>
	<nav>
		<ol>
			<li><a href="home.php">Fish On</a></li>
	        <li><a href="fishmap.php">Fish Map</a></li>	
	        <li><a href="popmap.php">Submit Report</a></li>	
	        <li id = "settings"><a href= "settings.php"><?php echo $_SESSION['user'] ?></a></li>
	        <li><a href="logout.php" >Logout</a></li>
	     </ol>
	</nav>
<?php } 

else { ?>
	<nav>
		<ol>
			<li><a href="home.php">Fish On</a></li>
	        <li><a href="fishmap.php">Fish Map</a></li>	
	    </ol>
	</nav>
<?php } ?>