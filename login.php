<?php
//start session
session_start();

include('logged_in.php');
?>

<!DOCTYPE HTML>

<html>

	<head>
		<link href='Styles/login_style.css' rel='stylesheet'>
		
	</head>
	
	<body>
		<div class="login_page">
			<div id="login_form">
				<form method="post" action="login.php">
					Username:
					<input type="text" id="username" name="username" placeholder="Enter Username" required>
					<br/>
					Password:
					<input type="password" id="password" name="password" placeholder="Enter Password" required>
					<br/>
					<input type="submit" value="Login"><br>
					<a href="create_user.php">Create a new account</a>
					<br>
				</form>
				<?php
					if (isset($_SESSION['username'])) {
						echo "You have logged in!";
					}
					else {
						
					}
				?>
			</div>
		</div>
	</body>

</html>