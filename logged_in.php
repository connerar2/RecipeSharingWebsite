<?php

	if(isset($_POST['username'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		
		$host = "localhost";
		$user = "root";
		$db_password = "Happy124face1!";
		$database = "tutorial";
		
		$cxn = mysqli_connect($host, $user, $db_password, $database);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
		
		
		$stmt = $cxn->prepare("SELECT * from users WHERE username = ?");
		$stmt->bind_param(1, $username);
		$stmt->execute();
		
		
		$user = $stmt->fetch();
		
		$cxn->close();
		
		/*
		if(password_verify($password, $user['password']) {
			echo "You have logged in";
		}
		else {
			echo "Sorry wrong username or password";
		}	
		*/
	}

	echo "Test";
?>