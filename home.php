<?php
include('top.php');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
	 $(function() {
		$( "#datepicker" ).datepicker();
	 });
</script>
</head>
<body><header>
	<h1><b>Fish On</b></h1>
</header>
<nav>
     <ol>
		<li><a href="home.php">Home</a></li>
        <li><a href="fishmap.php">Fish Map</a></li>	
        <li><a href="eventtest.php">Submit Report</a></li>	
     </ol>
</nav>
<body>
<p>Date: <input type="text" id="datepicker" /></p>
