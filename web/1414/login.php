<?php
include_once 'global.php';
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
	echo '			var isValidEmail = validateEmail(email);' . PHP_EOL;
	echo '			if(email == "") color="#FF3385";' . PHP_EOL;
	echo '			if(isValidEmail) color = "green";' . PHP_EOL;
	echo '			document.getElementById("email").style.borderColor = color;' . PHP_EOL;
	echo '			if(!isValidEmail && email != "") { ' . PHP_EOL;
	echo '				div.innerHTML = "<font size=2 color=#FF3385><b>Please enter valid email</b></font>";' . PHP_EOL;
	echo '				return;' . PHP_EOL;
	echo '			}' . PHP_EOL;
	echo '			div.innerHTML = "<font size=2 color=#FF3385>&nbsp;</font>";' . PHP_EOL;
	echo '		}' . PHP_EOL;
	echo '		function checkPassword() {' . PHP_EOL;
	echo '			var password = document.forms["loginform"]["password"].value;' . PHP_EOL;
	echo '			var div = document.getElementById("subdivpassword");' . PHP_EOL;
	echo '			var color = "red";' . PHP_EOL;
	echo '			var isValidPassword = validatePassword(password); ' . PHP_EOL;
	echo '			if(password == "") color="#FF3385";' . PHP_EOL;
	echo '			if(isValidPassword) color="green";' . PHP_EOL;
	echo '			document.getElementById("password").style.borderColor = color;' . PHP_EOL;
	echo '			if(!isValidPassword && password != "") { ' . PHP_EOL;
	echo '				div.innerHTML = "<font size=2 color=#FF3385><b>Password must contains digit, lowercase, uppercase,<br> special symbols, length between 6 and 20</b></font>";' . PHP_EOL;
	echo '				return;' . PHP_EOL;
	echo '			}' . PHP_EOL;
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
	echo '				div.innerHTML = "<font size=4 color=#FF3385><b>Please enter valid email</b></font>";' . PHP_EOL;
	echo '				return false;' . PHP_EOL;
	echo '			}' . PHP_EOL;
	echo '			if (!isPassword) {' . PHP_EOL;
	echo '				divPassword.innerHTML = "<font size=4 color=#FF3385><b>Password must contains digit, lowercase, uppercase, special symbols, length between 6 and 20</b></font>";' . PHP_EOL;
	echo '				return false; ' . PHP_EOL;
	echo '			}' . PHP_EOL;
	echo '			return true;' . PHP_EOL;
	echo '		}' . PHP_EOL;
	echo '</script>' . PHP_EOL;
	return;
}
function get_email_input() {
	$onfunctions = 'onchange="checkEmail();" onkeyup="checkEmail();" onpaste="checkEmail();" oninput="checkEmail();" onchange="checkEmail();"'; 
	return '<input id="email" name="email" ' . $onfunctions . ' maxlength=40 size=40 type=text>';
}
function get_password_input() {
	$onfunctions = 'onchange="checkPassword();" onkeyup="checkPassword();" onpaste="checkPassword();" oninput="checkPassword();" onchange="checkPassword();"';
	return '<input id="password" name="password" ' . $onfunctions . ' maxlength=40 size=40 type=password>';
}
function main_screen() {
	echo '<form name="loginform" id="loginform" action="startup" onsubmit="return validate()" method="post">' . PHP_EOL;
	echo '<div><br><br>&nbsp;&nbsp;&nbsp;<a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414BigIconPrecise.png" alt="1414"></a></div>' . PHP_EOL;
	echo '<div align="center">' . PHP_EOL;
	echo '<div id="login"><br><br><br>' . PHP_EOL;
	echo '<div align="center"><table><tr><td>' . PHP_EOL;
	echo '<div id="subdiv"><font style="font-size:34px;" color=black>Sign In</font><br><br><br></div>'. PHP_EOL;
	echo '<div id="subdiv" align="left"><font size=3 color=black>Email</font></div>' . PHP_EOL;
	echo '<div id="subdiv" align="left">' . get_email_input() . '</div>' . PHP_EOL;
	echo '<div id="subdivemail" align="left"><font size=4 color=#FF3385>&nbsp;</font></div>' . PHP_EOL;
	echo '<div id="subdiv"><font size=3 color=black>Password<br></font></div>' . PHP_EOL; 
	echo '<div id="subdiv">' . get_password_input() . '</div>' . PHP_EOL;
	echo '<div id="subdivpassword"><font size=4 color=#FF3385>&nbsp;</font></div>' . PHP_EOL;
	echo '<div id="subdiv" align="right"><font style="font-size:14px;"><a href=http://1414intl.com/forgot>Forgot your password?</a></font></div>' . PHP_EOL;
	echo '<br><div id="subdiv" align="left"><font size=2 color=black>' . PHP_EOL;
	echo '<br><div id="subdiv" align="center"><input type="image" name="submit" src="http://1414intl.com/1414/images/signinbig.png" border="0" alt="SignIn"/></div>' . PHP_EOL;
	echo '<br><div id="subdiv"><font style="font-size:14px;"><a href=http://1414intl.com/join>New to 1414? Join now</a></font></div>' . PHP_EOL;
	echo '</td></tr></table></div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '</form>' . PHP_EOL;
	return 0;
}
?>
<!DOCTYPE html>
<html id="html_login">
	<head>
		<title>1414</title>
		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
		<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/style/1414.css">
		<?php js_login(); ?>
	</head>
	<body style="height: 100%;">
		<?php main_screen(); ?>
		</script>
	</body>
</html>
