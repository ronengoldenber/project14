<?php
include 'global.php';
function js_validate_fname() {
	echo 'function validate_fname(fname) {' . PHP_EOL;
	echo '	var re = /^[a-zA-Z]{2,15}$/i;' . PHP_EOL;
	echo '	var is_fname = re.test(fname);' . PHP_EOL;
	echo '	return is_fname;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_check_fname($form) {
	echo 'function check_fname() {' . PHP_EOL;
	echo '	var fname = document.forms["' . $form . '"]["fname"].value;' . PHP_EOL;
	echo '	var div = document.getElementById("subdivfname");' . PHP_EOL;
	echo '	var color = "red";' . PHP_EOL;
	echo '  if (fname == "") { color = "gray"; }' . PHP_EOL;
	echo '	if (fname != "" && validate_fname(fname)) { color = "green"; }' . PHP_EOL;
	echo '  div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
	echo '	if(color == "red") {' . PHP_EOL;
	echo '		div.innerHTML = "<font size=2 color=red><b>First name must be 2 to 15 letters</b></font>";' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '	document.getElementById("fname").style.borderColor = color;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_validate_lname() {
	echo 'function validate_lname(lname) {' . PHP_EOL;
	echo '  var re = /^[a-zA-Z]{2,15}$/i;' . PHP_EOL;
	echo '  var is_lname = re.test(lname);' . PHP_EOL;
	echo '  return is_lname;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_check_lname($form) {
	echo 'function check_lname() {' . PHP_EOL;
	echo '  var lname = document.forms["' . $form . '"]["lname"].value;' . PHP_EOL;
	echo '  var div = document.getElementById("subdivlname");' . PHP_EOL;
	echo '  var color = "red";' . PHP_EOL;
	echo '  if (lname == "") { color = "gray"; }' . PHP_EOL;
	echo '  if (lname != "" && validate_lname(lname)) { color = "green"; }' . PHP_EOL;
	echo '	div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
	echo '	if(color == "red") {' . PHP_EOL;
	echo '		div.innerHTML = "<font size=2 color=red><b>Last name must be 2 to 15 letters</b></font>";' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '  document.getElementById("lname").style.borderColor = color;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function html_field($title, $title_font_size, $field, $input) {
	echo '<div id="subdiv" align="left"><font size=' . $title_font_size . ' color=black>' . $title . '</font></div>' . PHP_EOL;
	echo '<div id="subdiv" align="left"><input id="' . $field . '" name="' . $field . '"' ;
	echo ' onchange="check_' . $field . '();" onkeyup="check_' . $field . '();"';
	echo ' onpaste="check_' . $field . '();" oninput="check_' . $field . '();" onchange="check_' . $field . '();" maxlength=40 size=40 type=' . $input . '></font></div>' . PHP_EOL;
	echo '<div id="subdiv' . $field . '"><font size=2>&nbsp;</font></div>' . PHP_EOL;
	return true;
}
function js_validate_email() {
	echo 'function validate_email(email) {' . PHP_EOL;
	echo '	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;' . PHP_EOL;
	echo '	var is_email = re.test(email);' . PHP_EOL;
	echo '	return is_email;' . PHP_EOL;
	echo '}' . PHP_EOL;
}
function js_check_email($form) { 
	echo 'function check_email() {' . PHP_EOL;
	echo '	var email = document.forms["' . $form . '"]["email"].value;' . PHP_EOL;
	echo '	var div = document.getElementById("subdivemail");' . PHP_EOL;
	echo '	var color = "red";' . PHP_EOL;
	echo '  if (email == "") { color = "gray"; }' . PHP_EOL;
	echo '	if (email != "" && validate_email(email)) { color = "green"; }' . PHP_EOL;
	echo '	div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
	echo '	if(color == "red") {' . PHP_EOL;
	echo '		div.innerHTML = "<font size=2 color=red><b>Please enter valid email</b></font>";' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '	document.getElementById("email").style.borderColor = color;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_validate_password() {
	echo 'function validate_password(password) {' . PHP_EOL;
	echo '	var re = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{6,20})$/i;' . PHP_EOL;
	echo '	var is_password = re.test(password);' . PHP_EOL;
	echo '	return is_password;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_check_password($form) {
	echo 'function check_password() {' . PHP_EOL;
	echo '	var password = document.forms["' . $form . '"]["password"].value;' . PHP_EOL;
	echo '	var div = document.getElementById("subdivpassword");' . PHP_EOL;
	echo '	var color = "red";' . PHP_EOL;
	echo '	if (password == "") { color = "gray"; }' . PHP_EOL;
	echo '	if (password != "" && validate_password(password)) { color = "green"; }' . PHP_EOL;
    echo '	div.innerHTML = "<font size=2>&nbsp;</font>";' . PHP_EOL;
	echo '	if(color == "red") {' . PHP_EOL;
	echo '		div.innerHTML = "<font size=2 color=red><b>Password must contains digit, lowercase, uppercase, special symbols, length between 6 and 20</b></font>";' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '	document.getElementById("password").style.borderColor = color;' . PHP_EOL;
	echo '}' . PHP_EOL;
	return true;
}
function js_validate($form) {
	echo 'function validate() {' . PHP_EOL;
	echo '	var email = document.forms["' . $form . '"]["email"].value;' . PHP_EOL;
	echo '	var password = document.forms["' . $form . '"]["password"].value;' . PHP_EOL;
	echo '	var div = document.getElementById("subdivemail");' . PHP_EOL;
	echo '	var isEmail = validate_email(email);' . PHP_EOL;
	echo '	var isPassword = validate_password(password);' . PHP_EOL;
	echo '	var divPassword = document.getElementById("subdivpassword");' . PHP_EOL;
	echo '	if (!isEmail) {' . PHP_EOL;
	echo '		div.innerHTML = "<font size=2 color=red><b>Please enter valid email</b></font>";' . PHP_EOL;
	echo '		return false;' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '	if (!isPassword) {' . PHP_EOL;
	echo '		divPassword.innerHTML = "<font size=2 color=red><b>Password must contains digit, lowercase, uppercase, special symbols, length between 6 and 20</font>";' . PHP_EOL;
	echo '		return false; ' . PHP_EOL;
	echo '	}' . PHP_EOL;
	echo '	return true;' . PHP_EOL;
	echo '}' . PHP_EOL;
}
function html_tos_pp() {
	echo '<div id="subdiv"><font size=1 color=black> By clicking Join now, you agree to 1414\'s <a href=http://1414intl.com/terms>Terms and Conditions</a> and <a href=http://1414intl.com/privacy>Privacy Policy</a></font></div>' . PHP_EOL;
	return true;
}
function screen_size() {
	echo '<script>' . PHP_EOL;
	echo '	function checkImg() {' . PHP_EOL;
	echo '		var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;' . PHP_EOL;
	echo '		var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;' . PHP_EOL;
	echo '//	if(height > 700) {' . PHP_EOL;
	echo '//		document.getElementById("html_join").style.backgroundImage = "url(\'http://1414intl.com/1414/images/phone_booth.jpg\')";' . PHP_EOL;
	echo '//	}' . PHP_EOL;
	echo '//	if(height < 700) {' . PHP_EOL;
	echo '//		document.getElementById("html_join").style.backgroundImage = "url(\'http://1414intl.com/1414/images/join.jpg\')";' . PHP_EOL;
	echo '//	}' . PHP_EOL;
	echo '}' . PHP_EOL;
	echo 'checkImg();' . PHP_EOL;
	echo '</script>' . PHP_EOL;
	return true;
}
function validate_fname($fname) {
	if(!isset($fname)) {
		logmsg(LOG_DEBUG, 'The first name is not set ');
		return 'The first name is not set';
	}
	if(strlen($fname) < 2) { 
		logmsg(LOG_DEBUG, 'The first name is too short ');
		return 'The first name is too short';
	}
	if(strlen($fname) > 15) { 
		logmsg(LOG_DEBUG, 'The first name is too long ');
		return 'The first name is too long';
	}
	return '';
}
function validate_lname($lname) {
	if(!isset($lname)) {
		logmsg(LOG_DEBUG, 'The last name is not set ');
		return 'The last name is not set';
	}
	if(strlen($lname) < 2) {
		logmsg(LOG_DEBUG, 'The last name is too short ');
		return 'The last name is too short (less than 2 characters)';
	}
	if(strlen($lname) > 15) {
		logmsg(LOG_DEBUG, 'The last name is too long ');
		return 'The last name is too long (more than 15 characters)';
	}
	return '';
}
function validate_email($email) {
	if(!isset($email)) {
		logmsg(LOG_DEBUG, 'The email is invalid it is not set ');
		return 'The email is invalid it is not set';
	}
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return '';
	}
	logmsg(LOG_DEBUG, 'The email invalid ');
	return 'The email invalid';
}
function validate_password($password) {
	if(!isset($password)) { 
		logmsg(LOG_DEBUG, 'The password is invalid it is not set ');
		return 'The password is invalid it is not set';
	}
	if(strlen($password) < 8) {
		logmsg(LOG_DEBUG, 'The password length cannot be less than 8 characters ');
		return 'The password length cannot be less than 8 characters';
	}
	if(strlen($password) > 20) {
		logmsg(LOG_DEBUG, 'The password length cannot be more than 20 characters '); 
		return 'The password length cannot be more than 20 characters';
	}
	return '';
}
?>
