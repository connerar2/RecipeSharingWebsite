<!DOCTYPE HTML>

<html>
	<head>
		<h1>Create Your Account</h1>
	</head>
	
	<body>
		<form method="post" onsubmit="return validateForm();" action="new_user.php">
			Enter Username:
			<input type="text" name="username" placeholder="Enter Username" required>
			<br>
			Enter Password:
			<input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter Password" required>
			<br>
			Re-Enter Password:
			<input type="password" id="check_password" name="re_enter_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter Password" required>
			<p id="hidden" style="display: none">   Passwords don't match</p> 
			<br>
			<input type="submit" value="Create Account">
			<br>
		</form>
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