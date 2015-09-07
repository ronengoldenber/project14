<?php   
include_once 'auth.php';
function set_username_details($link) {
	$fname = printable($_GET['fname']);
	$lname = printable($_GET['lname']);
	$email = printable($_GET['email']);
	$username = printable($_GET['username']);
	if(($stmt = sql_query($link, 'DELETE FROM config_device WHERE username = ?', 'd', array($username)))) {
		exit_stmt($stmt);
	}
	$user_id = get_user_id_by_email($link, $email);
	if(!$user_id || strlen($user_id) <= 0) {
		$stmt = sql_query($link, 'INSERT INTO config_user (tenant_id, fname, lname, email, language, type) VALUES (240000001, ?, ?, ?, 0, 0);', 'sss', array($fname, $lname, $email));
		exit_stmt($stmt);
		$user_id = get_user_id_by_email($link, $email);
	}
	$stmt = sql_query($link, 'INSERT INTO config_device (user_id, username, ha1) VALUES (?, ?, "aa");', 'ss', array($user_id, $username));
	exit_stmt($stmt);
	$stmt = sql_query($link, 'UPDATE config_device set ha1 = md5(concat(?, ":", ?, ":", ?)) WHERE username = ?', 'ssss', array($username, 'tmusqa.com', 'choochee1', $username));
	exit_stmt($stmt); 
	return true;
}
function get_name_from_phone_number($link) {
	echo 'name';
	return true;
}
function get_device_version($link) {
	$apikey = printable($_GET['apikey']);
	$username = printable($_GET['username']);
	logmsg(LOG_DEBUG, 'Getting device version username [' . $username . '] ');
	if(!auth_device($link, $apikey, $username)) {
		logmsg(LOG_DEBUG, 'Cannot auth device in set device status ');
		return true;
	}
	$country = get_country_by_username($link, $username);
	if (!isset($country) || $country == '' || strlen($country) == 0) { 
		logmsg(LOG_DEBUG, 'There is no country to the device ');
		return true;
	}
	$file = '';
	if($country == '1') $file = 'us';
	if($country == '972') $file = 'il';
	if($file == '' ) { 
		logmsg(LOG_DEBUG, 'The country [' . $country . '] is not supported ');
		return true;
	}
	download_file('/var/www/1414/device/pj1414' . $file);
}
function auth_device($link, $apikey, $username) {
	if(strlen($apikey) <= 0 || strlen($username) <= 0) {
		echo 'Invalid API Key ';
		logmsg(LOG_DEBUG, 'Invalid API key because the apikey=[' . $apikey . '] username=[' . $username . '] ');
		return false;
	}
	$app_apikey = get_apikey($link, $username);
	if($apikey != $app_apikey) {
		echo 'Wrong API Key ';
		logmsg(LOG_DEBUG, 'Wrong API key [' . $apikey . '!=' . $app_appikey . '] ');
		return false;
	}
	return true;
}
function set_device_status($link) {
	$apikey = printable($_GET['apikey']);
	$username = printable($_GET['username']);
	$status = printable(file_get_contents('php://input'));
	$ip = printable($_GET['ip']);
	$ip = ip2long($ip);
	logmsg(LOG_DEBUG, 'Setting device status username [' . $username . '] status [' . $status . '] ip [' . $ip . '] ');
	if(!auth_device($link, $apikey, $username)) {
		logmsg(LOG_DEBUG, 'Cannot auth device in set device status ');
		return true;
	}
	$state_device_id = get_state_device_id_by_username($link, $username);
	if(($stmt = sql_query($link, 'UPDATE state_device SET status = ?, ip = ?  WHERE state_device_id = ?', 'sdd', array($status, $ip, $state_device_id)))) {
		exit_stmt($stmt);
	}
	return true;
}
function set_device_btstatus($link) {
	$apikey = printable($_GET['apikey']);
	$username = printable($_GET['username']);
	$btstatus = printable(file_get_contents('php://input'));
	$ip = printable($_GET['ip']);
	$ip = ip2long($ip);
	logmsg(LOG_DEBUG, 'Setting device bt status username [' . $username . '] bt status [' . $btstatus . ']  ip [' . $ip . '] ');
	if(!auth_device($link, $apikey, $username)) {
		logmsg(LOG_DEBUG, 'Cannot auth device in set device bt status ');
		return true;
	}
	$state_device_id = get_state_device_id_by_username($link, $username);
	if(($stmt = sql_query($link, 'UPDATE state_device SET btstatus = ?, ip = ?  WHERE state_device_id = ?', 'sdd', array($btstatus, $ip, $state_device_id)))) {
		exit_stmt($stmt);
	}
	return true;
}
function get_device_nonce($link) {
	$username = printable($_GET['username']);
	$nonce = set_nonce($link, $username);
	echo $nonce;
	return true;
}
function get_device_apikey($link) {
	$username = printable($_GET['username']);
	$device_ha1 = printable($_GET['device_ha1']);
	$nonce = get_nonce($link, $username);
	$ha1 = get_ha1_by_username($link, $username);
	$md5ha1 = md5($ha1 . ':' . $nonce);
	logmsg(LOG_DEBUG, 'The ha1 = [' . $ha1 .'] nonce = [' . $nonce . '] ');
	logmsg(LOG_DEBUG, 'Checking device ha1 [' . $md5ha1 . '=' . $device_ha1 . '] ');
	if ($md5ha1 == $device_ha1) {
		$apikey = set_apikey($link, $username);	
		echo $apikey;
		return true;
	}
	echo 'INVALID API Key ';
	return true;
}

function set_cmd($link) {
	$apikey = printable($_GET['apikey']);
	$username = printable($_GET['username']);  
	if(!auth_device($link, $apikey, $username)) {
		logmsg(LOG_DEBUG, 'Cannot auth device in set device status ');
		return true;
	}
	$cmd = get_clicmd($link, $username);
	logmsg(LOG_DEBUG, 'The cmd is [' . $cmd . '] ' );
	echo $cmd;
	return true;	
}
function handle_request($link) {
	$cmd = $_GET['api'];
	switch ($cmd) {
		case 'get_device_nonce' : return get_device_nonce($link);
		case 'get_device_apikey' : return get_device_apikey($link);
		case 'set_username_details': return set_username_details($link);
		case 'get_name_from_phone_number': return get_name_from_phone_number($link);
		case 'get_device_version' : return get_device_version($link);
		case 'set_device_status': return set_device_status($link);
		case 'set_cmd' : return set_cmd($link);
		case 'set_device_btstatus' : return set_device_btstatus($link);
	}
	return true;
}
function main_voiceapi() {
	print_request();
	$link = db_connect();
	handle_request($link);
	if($link) {
		mysqli_close($link);
	}
}
if (isset($_GET['api'])) 
{
	main_voiceapi();
}
