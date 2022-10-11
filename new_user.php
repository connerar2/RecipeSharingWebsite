<?php

if (isset($_POST['username'])) {
	//get username and password user entered
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	//info for database
	$host = "localhost";
	$user = "root";
	$db_password = "";
	$database = "tutorial";
	
	//connect to database
	$cxn = mysqli_connect($host, $user, $db_password, $database);
	//check if connected, 
	if (mysqli_connect_errno()) {
		echo "Failed to connect to database: ".mysqli_connect_errno();
		die();
	}
	
	//check if username is in database
	$stmt = $cxn->prepare("SELECT username FROM users WHERE username=(?)");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	
	//if it is error message
	if ($result->num_rows > 0) {
			$username_taken = "Sorry that username has already been taken";
	}
	//otherwise add it and the password
	else {
			$stmt = $cxn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
			$stmt->bind_param("ss", $username, $password);
			$stmt->execute();
	
			$cxn->close();
	
			header("Location: login.php");
			exit();
	}
}
?>