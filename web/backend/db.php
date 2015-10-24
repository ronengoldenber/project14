<?php
include_once 'global.php';
function add_user($link, $fname, $lname, $email, $username, $type) {
	$fname = printable($fname);
	$lname = printable($lname);
	$email = printable($email);
	$username = printable($username);
	if(($stmt = sql_query($link, 'DELETE FROM config_device WHERE username = ?', 'd', array($username)))) {
		exit_stmt($stmt);
	}
	$user_id = get_user_id_by_email($link, $email);
	if(!$user_id || strlen($user_id) <= 0) {
		$stmt = sql_query($link, 'INSERT INTO config_user (tenant_id, fname, lname, email, language, type) VALUES (240000001, ?, ?, ?, 0, ?);', 'ssss', array($fname, $lname, $email, $type));
		exit_stmt($stmt);
		$user_id = get_user_id_by_email($link, $email);
	}
	$stmt = sql_query($link, 'INSERT INTO config_device (user_id, username, ha1) VALUES (?, ?, "aa");', 'ss', array($user_id, $username));
	exit_stmt($stmt);
	$stmt = sql_query($link, 'UPDATE config_device set ha1 = md5(concat(?, ":", ?, ":", ?)) WHERE username = ?', 'ssss', array($username, 'tmusqa.com', 'choochee1', $username));
	exit_stmt($stmt);
	return true;
}
function create_cdr($cdr_link, $caller_id_name, $caller_id_number, $destination_number, $context, 
					$start_stamp, $answer_stamp, $end_stamp, $duration, $billsec, $hangup_cause, $uuid, $bleg_uuid, $accountcode, $domain_name) {
	$params = 'caller_id_name, caller_id_number, destination_number, context, start_stamp, answer_stamp, end_stamp, duration, billsec, hangup_cause,uuid,bleg_uuid, accountcode, domain_name';
	$vars = array(	$caller_id_name, $caller_id_number, $destination_number, $context, $start_stamp, $answer_stamp, $end_stamp,
					$duration, $billsec, $hangup_cause, $uuid, $bleg_uuid, $accountcode, $domain_name);
	if(($stmt = sql_query($cdr_link, 'INSERT INTO cdr (' . $params . ') VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);', 'ssssssssssssss', $vars))) { 
		exit_stmt($stmt);
	}
	return true;
}
function get_user_id_by_email($link, $email) {
	$user_id = '';
	if(($stmt = sql_query($link, 'SELECT user_id FROM config_user WHERE email = ?', 's', array($email)))) {
		mysqli_stmt_bind_result($stmt, $user_id);
		exit_stmt($stmt);
	}
	return $user_id;
}
function to_e164us($number) {
	if(substr($number, 0, 1) == '+') {
		$number = substr($number, 1);
	}
	if(strlen($number) != 10 && strlen($number) != 11) {
		logmsg(LOG_WARNING, 'This is not E.164 US number');
		return 0;
	}
	if(substr($number, 0, 1) == '1' && strlen($number) == 11) {
		return $number;
	}
	return '1' . $number;
}
function is_number_allowed($link, $user_id, $src) {
	logmsg(LOG_WARNING, 'Checking if the number [' . $src . '] is allowed ');
	if(!isset($src) || $src == '') {
		logmsg(LOG_WARNING, 'The source [' . $src . '] is empty ');
		return false;
	}
	$src_e164 = to_e164us($src);
	$response_user_id = '';
	if(($stmt = sql_query($link, 'SELECT user_id FROM `config_number` WHERE `number` = ?', 's', array($src_e164)))) {
		mysqli_stmt_bind_result($stmt, $response_user_id);
		exit_stmt($stmt);
	}
	if(!isset($response_user_id) || strlen($response_user_id) < 1 || $response_user_id < 1)  {
		logmsg(LOG_WARNING, 'Cannot find source number [' . $src_e164 . '] not a 1414 customer ');
		return false;
	}
	logmsg(LOG_WARNING, 'The number is allowed [' . $response_user_id . '] ');
	return true;
}
function get_user_type_by_email($link, $email) {
	$type = '';
	if(($stmt = sql_query($link, 'SELECT `type` FROM `config_user` WHERE `email` = ?', 's', array($email)))) {
		mysqli_stmt_bind_result($stmt, $type);
		exit_stmt($stmt);
	}
	return $type;
}
function get_device_id_by_email($link, $email) { 
	$device_id = '';
	$query = 'SELECT d.`device_id` FROM `config_user` s JOIN `config_device` d ON s.`user_id` = d.`user_id` WHERE s.email = ? AND d.`device_type` = 1 LIMIT 1';
	if(($stmt = sql_query($link, $query, 's', array($email)))) {
		mysqli_stmt_bind_result($stmt, $device_id);
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'the device id found [' . $device_id . '] by email [' . $email . '] '); 
	return $device_id;
}
function get_device_type_by_username($link, $username) {
	$device_type = '';
	$query = 'SELECT `device_type` FROM `config_device` WHERE username = ? LIMIT 1';
	if(($stmt = sql_query($link, $query, 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $device_type);
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'the device type found [' . $device_type . '] by username [' . $username . '] ');
	return $device_type;
}
function get_state_device_id_by_username($link, $username) {
	$state_device_id = '';
	if(($stmt = sql_query($link, 'SELECT sd.state_device_id FROM config_device d JOIN state_device sd ON d.device_id = sd.device_id WHERE d.username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $state_device_id);
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'getting state device id [' . $state_device_id . '] by username [' . $username . '] ' ); 
	return $state_device_id;
}
function get_country_by_username($link, $username) { 
	$country = '1';
	if(($stmt = sql_query($link, 'SELECT `country` FROM config_device WHERE username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $country);
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'getting country [' . $country . '] by user name [' . $username . '] '); 
	return $country;
}
function get_ha1_by_username($link, $username) {
	$ha1 = '';
	if(($stmt = sql_query($link, 'SELECT ha1 FROM config_device WHERE username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $ha1);
		exit_stmt($stmt);
	}
	return $ha1;
}
function get_nonce_by_username($link, $username) {
	$nonce = '';
	if(($stmt = sql_query($link, 'SELECT sd.nonce FROM config_device d JOIN state_device sd ON d.device_id = sd.device_id WHERE d.username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $nonce);
		exit_stmt($stmt);
	}
	return $nonce;
}
function get_apikey_by_username($link, $username) {
	$apikey = '';
	if(($stmt = sql_query($link, 'SELECT sd.apikey FROM config_device d JOIN state_device sd ON d.device_id = sd.device_id WHERE d.username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $apikey);
		exit_stmt($stmt);
	}
	return $apikey;
}
function get_match_username($link, $src) {
	$dst = '';
	logmsg(LOG_DEBUG, 'Try to match username for src [' . $src . '] ');
	if(($stmt = sql_query($link, 'SELECT `dst_username` FROM config_device_group WHERE src_username = ?', 's', array($src)))) {
		mysqli_stmt_bind_result($stmt, $dst);
		exit_stmt($stmt);
	}
	return $dst;
}
function get_clicmd($link, $username) {
	$query = 'SELECT sc.`cmd_id`, sc.`cmd` FROM `config_device` d JOIN `state_cmd` sc ON d.`device_id` = sc.`device_id` WHERE d.`username` = ? LIMIT 1';
	if(!($stmt = sql_query($link, $query, 's', array($username)))) {
		return true;
	}
	mysqli_stmt_bind_result($stmt, $cmd_id, $cmd);
	exit_stmt($stmt);
	if (isset($cmd) && isset($cmd_id) && $cmd != '' && $cmd_id != '' && strlen($cmd) > 0 && strlen($cmd_id) > 0) {
		sql_query($link, 'DELETE FROM `state_cmd` WHERE `cmd_id` = ?', 's', array($cmd_id));
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'The command found is [' . $cmd . '] ');
	return $cmd;
}


