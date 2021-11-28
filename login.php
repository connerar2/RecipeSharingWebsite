<?php
//start session
session_start();

?>

<!DOCTYPE HTML>

<html>

	<head>
		<link href='Styles/login_style.css' rel='stylesheet'>
		
		  <ul>
			<li><a href="index.html"><strong>Home</strong></a></li>
			<li><a href="login.php"><strong>Login</strong></a></li>
			<li><a href="add_recipe.html"><strong>Add Recipe</strong></a></li>
			<li><a href="display_recipes.php"><strong>View Recipes</strong></a></li>
		</ul>
	</head>
	
	<body>
		<div class="login_page">
			<div id="login_form">
				<form method="post" action="login.php">
					<h1>Login<h1>
					Username:
					<input type="text" id="username" name="username" placeholder="Enter Username" required>
					<br/>
					Password:
					<input type="password" id="password" name="password" placeholder="Enter Password" required>
					<br/>
					<input type="submit" value="Login"><br>
					<p id="login_message"></p>
					<a href="create_user.php">Create an Account</a>
					<br>
				</form>
			</div>
		</div>
	</body>
	
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
		
		if(password_verify($password, $user['password'])) {
			$_SESSION["username"]= $username;
			echo "<script>";
			echo "document.getElementById(\"login_message\").innerHTML = \"You have logged in!\"\n";
			echo "</script>";
		}	
		else {
			echo "<script>";
			echo "document.getElementById(\"login_message\").innerHTML = \"Wrong username or password\"\n";
			echo "</script>";
		}
		
		$cxn->close();
		}
	?>

</html>