<?php
//start session
//session_start();

include('logged_in.php');
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
					<p>Passwords require 1 uppercase, lowercase, number, special character, and must be 8 characters long</p>
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
					if (isset($_SESSION['username'])) {
						echo "<script\n>";
						echo "document.getElementById(\"login_message\").innerHTML = \"You have logged in!\"\n";
						echo "</script>\n";
					}
					else if (isset($_SESSION['error'])) {
						echo "<script>\n";
						echo "document.getElementById(\"login_message\").innerHTML = \"Wrong username or password\"\n";
						echo "</script>\n";
					}
				?>

</html>