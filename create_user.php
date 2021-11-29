<!DOCTYPE HTML>
<?php include('new_user.php') ?>
<html>
	<head>
		<link href='Styles/create_user_style.css' rel='stylesheet'>
	</head>
	
	<body>
		<div class="create_user_page">
			<div id="create_user_form">
				<form method="post" onsubmit="return validateForm();" action="create_user.php">
					<h1>Create Your Account</h1>
					<label for="u_name">Enter Username:</label>
					<input type="text" id="u_name" name="username" placeholder="Enter Username" required>
					<?php if (isset($username_taken)){ 
						echo $username_taken;
					}
					?>
					<br>
					<label for="password">Enter Password:</label>
					<input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter Password" required>
					<br>
					<label for="re_enter_password">Re-Enter Password:</label>
					<input type="password" id="check_password" name="re_enter_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter Password" required>
					<p id="hidden" style="display: none">   Passwords don't match</p> 
					<p>Passwords require 1 uppercase, lowercase, number, special character, and must be 8 characters long</p>
					<br>
					<input type="submit" value="Create Account">
					<br>
				</form>
			</div>
		</div>
	</body>
	
	<script type="text/javascript">
	
	function samePasswords() {
		
		var pw = document.getElementById("password").value;
		var check_pw = document.getElementById("check_password").value;
		
		if (pw.localeCompare(check_pw) != 0) {
			document.getElementById("hidden").style.display = "inline";
			return false;
		}
		document.getElementById("hidden").style.display = "none";
		return true;	
		
	};
	
	function validateForm() {
		var bool = samePasswords();
		return bool;
	};
	
	</script>
</html>