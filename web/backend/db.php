<?php
include_once 'global.php';
function get_user_id_by_email($link, $email) {
	$user_id = '';
	if(($stmt = sql_query($link, 'SELECT user_id FROM config_user WHERE email = ?', 's', array($email)))) {
		mysqli_stmt_bind_result($stmt, $user_id);
		exit_stmt($stmt);
	}
	return $user_id;
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
function get_state_device_id_by_username($link, $username) {
	$state_device_id = '';
	if(($stmt = sql_query($link, 'SELECT sd.state_device_id FROM config_device d JOIN state_device sd ON d.device_id = sd.device_id WHERE d.username = ?', 's', array($username)))) {
		mysqli_stmt_bind_result($stmt, $state_device_id);
		exit_stmt($stmt);
	}
	logmsg(LOG_DEBUG, 'getting state device id [' . $state_device_id . '] by username [' . $username . '] ' ); 
	return $state_device_id;
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


