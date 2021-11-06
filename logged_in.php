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
		
		
		$stmt = $cxn->prepare("SELECT * FROM users WHERE username = (?) ");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		
		
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		
		if ($result->num_rows > 0) {
			echo "Got Results<br>";
		}
		else {
			echo "Fetch Failed<br>";
		}
		
		if(password_verify($password, $user['password'])) {
			echo "You have logged in with ".$result->num_rows." rows";
		}
		else {
			echo "Sorry wrong username or password";
		}	
		
		$cxn->close();
	}
?>