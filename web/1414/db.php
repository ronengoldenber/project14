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
function get_usernames_by_email($link, $email) {
	$query = 'SELECT d.`username` FROM `config_device` d JOIN `config_user` s ON s.`user_id` = d.`user_id` WHERE s.`email` = ? ';
	logmsg(LOG_DEBUG, 'Prepare query [' . $query . '] ' );
	$stmt = mysqli_prepare($link, $query);
	if (!$stmt) {
		logmsg(LOG_WARNING, 'Cannot get latest cdrs there are no devices attached to this email ');
		logmsg_echo('<tr><td colspan="7"><font size=2 color=black>Cannot get latest cdrs there are no numbers or devices attached to this email</font></td></tr>');
		return false;
	}
	mysqli_stmt_bind_param($stmt, 's', $email);
	if (!mysqli_stmt_execute($stmt)) {
		logmsg(LOG_WARNING, 'Cannot get cdrs because there is a problem to fetch the data ');
		logmsg_echo('<tr><td colspan="7"><font size=2 color=black>Cannot get cdrs because there is a problem to fetch the data</font></td></tr>');
		return false;
	}
	$response = mysqli_stmt_bind_result($stmt, $username);
	$usernames = '';
	$i = 0;
	while (mysqli_stmt_fetch($stmt)) {
		if($i >= 1) $usernames = $usernames . ' OR ';
		$usernames = $usernames . 'context = ' . $username;
		$i++;
	}
	logmsg(LOG_INFO, 'This [' . $i . '] email [' . $email . '] has those usernames [' . $usernames . ']');
	mysqli_stmt_close($stmt);
	return $usernames;
}
function get_latest_cdrs($link, $email) {
	$usernames = get_usernames_by_email($link, $email);
	if($usernames == false) {
		return false;
	}
	$query = 'SELECT `caller_id_number`, `destination_number`, `context`, `answer_stamp`, `end_stamp`, `duration` FROM cdr.cdr WHERE ' . $usernames . ' ORDER BY start_stamp DESC LIMIT 10;';
	logmsg(LOG_INFO, 'The cdr query is [' . $query . '] ');
	$stmt = mysqli_prepare($link, $query);
	if(!$stmt) {
		logmsg(LOG_WARNING, 'Cannot get latest cdrs there are no numbers or devices attached to this email ');
		logmsg_echo('<tr><td colspan="7"><font size=2 color=black>Cannot get latest cdrs there are no numbers or devices attached to this email</font></td></tr>');
		return false;
	}
	if (!mysqli_stmt_execute($stmt)) {
		logmsg(LOG_WARNING, 'Cannot get cdrs because there is a problem to fetch the cdrs data ');
		logmsg_echo('<tr><td colspan="7"><font size=2 color=black>Cannot get cdrs because there is a problem to fetch the cdrs data</font></td></tr>');
		return false;
	}
	$response = mysqli_stmt_bind_result($stmt, $caller_id_number, $destination_number, $context, $answer_stamp, $end_stamp, $duration);
	while (mysqli_stmt_fetch($stmt)) {
		logmsg_echo('<tr><td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $caller_id_number . '</td>');
		logmsg_echo('<td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $destination_number . '</td>');
		logmsg_echo('<td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $context . '</td>');
		logmsg_echo('<td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $answer_stamp . '</td>');
		logmsg_echo('<td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $end_stamp . '</td>');
		logmsg_echo('<td style="padding: 4px; border: 1px solid black;"><font size=2 color=black>' . $duration . '</td></tr>');
	}
	mysqli_stmt_close($stmt);
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


