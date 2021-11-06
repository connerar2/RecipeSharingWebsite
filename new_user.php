<?php

if (isset($_POST['username'])) {
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	$host = "localhost";
	$user = "root";
	$db_password = "Happy124face1!";
	$database = "tutorial";
		
	$cxn = mysqli_connect($host, $user, $db_password, $database);
		
	if (mysqli_connect_errno()) {
		echo "Failed to connect to database: ".mysqli_connect_errno();
		die();
	}
	
	$stmt = $cxn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	
	$cxn->close();
	
	header("Location: login.php");
	exit();
}
?>