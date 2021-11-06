<!DOCTYPE HTML>

<html>
	<head>
		<h1>Login</h1>
	</head>
	<?php 
		$host = "localhost";
		$user = "root";
		$password = "Happy124face1!";
		$database = "tutorial";
		
		$cxn = mysqli_connect($host, $user, $password, $database);
		
		if (mysqli_connect_errno()) {
			echo "Failed to connect to database: ".mysqli_connect_errno();
			die();
		}
	?>
	<body>
		<form method="post" action="test2.php">
			Username:
			<input type="text" name="username" placeholder="Enter Username" required>
			<br/>
			Password:
			<input type="password" name="password" placeholder="Enter Password" required>
			<br/>
			<input type="submit" value="Login">
			
	</body>
</html>