<?php
	include 'util.php';
	function js_login() {
		echo '	<script>' . PHP_EOL;
		echo '		function validateEmail(email) {' . PHP_EOL;
		echo '			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;' . PHP_EOL;
		echo '			var is_email = re.test(email);' . PHP_EOL;
		echo '			return is_email;' . PHP_EOL;
		echo '		}' . PHP_EOL;
		echo '		function validatePassword(password) {' . PHP_EOL;
		echo '			var re = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{6,20})$/i;' . PHP_EOL;
		echo '			var is_password = re.test(password);' . PHP_EOL;
		echo '			return is_password;' . PHP_EOL;
		echo '		}' . PHP_EOL;	
		echo '		function checkEmail() {' . PHP_EOL;
		echo '			var email = document.forms["loginform"]["email"].value;' . PHP_EOL;
		echo '			var div = document.getElementById("subdivemail");' . PHP_EOL;
		echo '			var color = "red";' . PHP_EOL;
		echo '			if(validateEmail(email)) {' . PHP_EOL;
		echo '				color = "green";' . PHP_EOL;
		echo '			}' . PHP_EOL;
		echo '			document.getElementById("email").style.borderColor = color;' . PHP_EOL;
		echo'			div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
		echo '		}' . PHP_EOL;
		echo '		function checkPassword() {' . PHP_EOL;
		echo '			var password = document.forms["loginform"]["password"].value;' . PHP_EOL;
		echo '			var div = document.getElementById("subdivpassword");' . PHP_EOL;
		echo '			var color = "red";' . PHP_EOL;
		echo '			if(validatePassword(password)) {' . PHP_EOL;
		echo '				color = "green";' . PHP_EOL;
		echo '			}' . PHP_EOL;
		echo '			document.getElementById("password").style.borderColor = color;' . PHP_EOL;
		echo '			div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
		echo '		}' . PHP_EOL;
		echo '		function validate() {' . PHP_EOL;
		echo '			var email = document.forms["loginform"]["email"].value;' . PHP_EOL;
		echo '			var password = document.forms["loginform"]["password"].value;' . PHP_EOL;
		echo '			var div = document.getElementById("subdivemail");' . PHP_EOL;
		echo '			var isEmail = validateEmail(email);' . PHP_EOL;
		echo '			var isPassword = validatePassword(password);' . PHP_EOL;
		echo '			var divPassword = document.getElementById("subdivpassword");' . PHP_EOL;
		echo '			if (!isEmail) {' . PHP_EOL;
		echo '				div.innerHTML = "<font size=2 color=red><b>Please enter valid email</b></font>";' . PHP_EOL;
		echo '				return false;' . PHP_EOL;
		echo '			}' . PHP_EOL;
		echo '			if (!isPassword) {' . PHP_EOL;
		echo '				divPassword.innerHTML = "<font size=2 color=red><b>Password must contains digit, lowercase, uppercase, special symbols, length between 6 and 20</font>";' . PHP_EOL;
		echo '				return false; ' . PHP_EOL;
		echo '			}' . PHP_EOL;
		echo '			return true;' . PHP_EOL;
		echo '		}' . PHP_EOL;
		echo '</script>' . PHP_EOL;
		return;
	}
	function main_screen() {
		echo '<form name="loginform" id="loginform" action="startup" onsubmit="return validate()" method="post">' . PHP_EOL;
		echo '<div><br><br>&nbsp;&nbsp;&nbsp;<a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '<div id="login"><br>' . PHP_EOL;
		echo '<div id="subdiv"><font size=16 color=black>Sign In</font><br><br></div>'. PHP_EOL;
		echo '<div id="subdiv"><font size=5 color=black>Email</font></div>' . PHP_EOL;
		echo '<div id="subdiv"><input id="email" name="email" onchange="checkEmail();" onkeyup="checkEmail();" onpaste="checkEmail();" oninput="checkEmail();" onchange="checkEmail();" maxlength=40 size=25 type=text></font></div>' . PHP_EOL;
		echo '<div id="subdivemail"><font size=2>&nbsp;</font></div>' . PHP_EOL;
		echo '<div id="subdiv"><font size=5 color=black>Password<br></font></div>' . PHP_EOL; 
		echo '<div id="subdiv"><input id="password" name="password" onchange="checkPassword();" onkeyup="checkPassword();" onpaste="checkPassword();" oninput="checkPassword();" onchange="checkPassword();" maxlength=40 size=25 type=password></font></div>' . PHP_EOL;
		echo '<div id="subdivpassword"><font size=2>&nbsp;</font></div>' . PHP_EOL;
		echo '<div id="subdiv"><a href=http://1414intl.com/forgot>Forgot your password?</a></div>' . PHP_EOL;
		echo '<div id="subdiv"><a href=http://1414intl.com/join>New to 1414? Join now</a></div>' . PHP_EOL;
		echo '<div id="subdiv"><font size=2 color=black> <input type="checkbox" name="pptos" value="false"> I agree to the Terms and Conditions and to the Privacy Policy</font></div>' . PHP_EOL;
		echo '<div id="subdiv"><input type="image" name="submit" src="http://1414intl.com/1414/images/signinbig.png" border="0" alt="SignIn"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return 0;
	}
	session_start();
?>
<!DOCTYPE html>
<html id="html_login">
	<head>
		<title>1414</title>
		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
		<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">
		<?php js_login(); ?>
	</head>
	<body style="height: 100%;" onresize="checkImg()">
		<?php main_screen(); ?>
		<script>
			function checkImg() { 
				var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
//				if(height > 700) {
//					document.getElementById("html_login").style.backgroundImage = "url('http://1414intl.com/1414/images/phone_booth.jpg')";
//				}
//				if(height < 700) {
//					document.getElementById("html_login").style.backgroundImage = "url('http://1414intl.com/1414/images/login.jpg')";
//				}
			}
			checkImg();
		</script>
	</body>
</html>
