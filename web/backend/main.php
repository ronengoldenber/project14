<?php
	include 'db.php';
	include 'operator.php';
	include 'customer.php';
	function is_customer($link,$username, $name, $email) {
		if(!$name || !isset($name) || !strlen($name)) {
			logmsg(LOG_WARNING, 'The name does not exist ');
			return false;
		}
		$namearr = explode(' ', $name);
		$fname = $namearr[0];
		$lname = $namearr[1];
		if(!$email || !isset($email) || !strlen($email)) {
			logmsg(LOG_WARNING, 'The email does not exist using name instead ');
			$email = strtolower($fname) . '.' . strtolower($lname) . '@1414intl.com';
		}
		logmsg(LOG_DEBUG, 'Checking if the user exist [' . $email . '] ');
		$type = get_user_type_by_email($link, $email);
		logmsg(LOG_DEBUG,' Type found [' . $type . '] '); 
		if(!$type || !isset($type) || !strlen($type)) {
			logmsg(LOG_DEBUG, 'User [' . $email . '] does not exists creating user [' . $fname . '][' . $lname . '][' . $username . ']');
			add_user($link, $fname, $lname, $email, $username, 2);
			return true;
		}
		return ($type == '2');
	}
	function generate_spaces($num) { 
		for($i = 0; $i < $num; $i++) {
			echo '&nbsp;';
		}
	}
	function main_inner($link,$username, $name, $email) { 
#		if(is_customer($link,$username, $name, $email)) {
#			logmsg(LOG_DEBUG, 'This is a customer account ');
#			return customer_screen($link,$username, $name, $email);
#		}
		logmsg(LOG_DEBUG, 'This is an operator account ');
		return operator_screen($link,$username, $name, $email);
	}
	function main_customer_operator($username, $name, $email) { 
		$link = db_connect();
		logmsg(LOG_DEBUG, 'Choosing between customer and operator [username=' . $username . '][name=' . $name . '][email=' . $email . '] ');
		main_inner($link, $username, $name, $email);
		if($link) {
			mysqli_close($link);
		}
	}
?>
