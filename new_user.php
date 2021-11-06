<?php
	$username = $_POST['username'];
	$password = "password";
	
	$host = "localhost";
	$user = "root";
	$password = "Happy124face1!";
	$database = "tutorial";
		
	$cxn = mysqli_connect($host, $user, $password, $database);
		
	if (mysqli_connect_errno()) {
		echo "Failed to connect to database: ".mysqli_connect_errno();
		die();
	}
	else {
		echo "<h1>Connected Successfully</h1>";
	}
	
	
	$stmt = $cxn->prepare("INSERT INFO users (username, password) VALUES (?, ?)");
	//$stmt->bind_param("ss", $username, $password);
	//$stmt->execute();
	
?>