<!DOCTYPE HTML>

<html>
	<head>
		<h1>Login</h1>
	</head>
	
	<body>
		<form method="post" action="logged_in.php">
			Username:
			<input type="text" name="username" placeholder="Enter Username" required>
			<br/>
			Password:
			<input type="password" name="password" placeholder="Enter Password" required>
			<br/>
			<input type="submit" value="Login"><br>
			<a href="create_user.php">Create a new account</a>
		</form>
			
	</body>
</html>