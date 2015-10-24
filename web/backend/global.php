<?php
include 'env.php';
function severity_tostring($severity) {
	switch ($severity) {
		case LOG_DEBUG  	:	return 'DEBUG: ';
		case LOG_INFO   	:	return 'INFO: ';
		case LOG_WARNING	:	return 'WARNING: ';
		case LOG_ERR   		:	return 'ERR: ';
		case LOG_CRIT  		:	return 'CRIT: ';
		default         	:	return '';
	}
	return '';
}
function printable($str) {
	$allowed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!#@$~%^&*()_-,={}[]\\|;?<>+`,.\":\t/\' ";
	$str = trim($str);
	$text = '';
	for($i = 0; $i < strlen($str); $i++) {
		if(strstr($allowed, $str[$i])) {
			$text = $text . $str[$i];
			continue;
		}
		$text = $text . '_';
	}
	return $text;
}
function logmsg ($severity, $message) {
	$arr		=	debug_backtrace();
	$function	=	(isset($arr[1])) 	? $arr[1]['function']	: NULL;
	$line		=	(isset($arr[1]))	? $arr[1]['line']		: NULL;
	$file 		=	(isset($arr[1]))	? $arr[1]['file']		: NULL;
	$msg = severity_tostring($severity) . $function . '(' . $line . '):' . $message;
	$msg = printable($msg);
	if($severity == LOG_WARNING || $severity == LOG_ERR || $severity == LOG_CRIT) {
		openlog(basename($file), LOG_PID | LOG_PERROR, LOG_LOCAL0);
		syslog($severity, $msg);
		closelog();
		echo "$msg";
	}
	return true;
}
function logmsg_echo($message) {
	$msg = (string)$message;
	$message = printable($msg);
	echo $message . "\n";
	logmsg(LOG_DEBUG, $message);
	return true;
}
function lognmsg_echo($message) {
	echo $message;
	logmsg(LOG_INFO, $message . PHP_EOL);
	return true;
}
function print_request() {
	foreach($_POST as $key => $value) {
		logmsg(LOG_DEBUG, '[' . $key . '=' . $value . '] ');
	}
	return true;
}
function db_connect() {
	if(!($link = mysqli_connect(DB_IP, DB_USER, DB_PASS, DB_NAME))) {
		logmsg (LOG_CRIT, 'Could not connect to DB [' . mysqli_connect_error() . '(' . mysqli_connect_errno() . ')');
		return 0;
	}
	return $link;
}
function cdr_db_connect() {
	if(!($cdr_link = mysqli_connect(DB_IP, DB_USER, DB_PASS, CDR_DB_NAME))) {
		logmsg (LOG_CRIT, 'Could not connect to DB [' . mysqli_connect_error() . '(' . mysqli_connect_errno() . ')');
		return 0;
	}
	return $cdr_link;
}
function sql_query($link, $query, $types = NULL, $values = NULL) {
	if (!$link) {
		logmsg (LOG_WARNING, 'Invalid DB handle ');
		return 0;
	}
	if (!($stmt = mysqli_prepare($link, $query))) {
		logmsg (LOG_WARNING, 'Cannot prepare sql query [' . $query . '][' .  print_r($values, true) . ']');
		return 0;
	}
	$args = NULL;
	if($types && $values) {
		$args[0] = $stmt;
		$args[1] = $types;
		$i = 2;
		foreach($values as $key=>$value) {
			$args[$i] = &$values[$key];
			$i++;
		}
		call_user_func_array('mysqli_stmt_bind_param', $args);
	}
	logmsg(LOG_INFO, 'Query is [' . $query . '] types [' . $types . '] values [' . print_r($values, true) . '] ');
	for($i = 0; $i < 20; $i++) {
		$response = 1;
		if(!mysqli_stmt_execute($stmt)) {
			logmsg (LOG_DEBUG, 'Could not execute stmt [' . $query . '][' .  print_r($values, true) . '] ');
			$response = 0;
		}
		if(!mysqli_stmt_store_result($stmt)) {
			logmsg (LOG_DEBUG, 'Could not store stmt [' . $query . '][' .  print_r($values, true) . '] ');
			$response = 0;
		}
		break;
	}
	if ($response == 0) {
		mysqli_stmt_close($stmt);
		return $ret;
	}
	return $stmt;
}
function exit_stmt($stmt) {
	if (!$stmt) {
		return true;
	}
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);
	return true;
}
function makeRandomString($bits = 256) {
	$bytes = ceil($bits / 8);
	$return = '';
	for ($i = 0; $i < $bytes; $i++) {
		$return .= chr(mt_rand(0, 255));
	}
	return $return;
}
function generate_nonce() {
	return substr(hash('sha512', makeRandomString()), 0, 32);
}
function guid( $opt = false) {
	if( function_exists('com_create_guid') ){
		if( $opt ) { 
			return com_create_guid(); 
		}
		return trim( com_create_guid(), '{}' );
	}
	mt_srand( (double)microtime() * 10000 );
	$charid = strtoupper( md5(uniqid(rand(), true)) );
	$hyphen = chr( 45 );
	$left_curly = $opt ? chr(123) : '';
	$right_curly = $opt ? chr(125) : '';
	$uuid = $left_curly
		. substr( $charid, 0, 8 ) . $hyphen
		. substr( $charid, 8, 4 ) . $hyphen
		. substr( $charid, 12, 4 ) . $hyphen
		. substr( $charid, 16, 4 ) . $hyphen
		. substr( $charid, 20, 12 )
		. $right_curly;
	return $uuid;
}
function download_file($fullpath) {
	ignore_user_abort(true);
	set_time_limit(0); 
	logmsg(LOG_DEBUG, 'Trying to downloading file [' . $fullpath . '] ');
	if (!($fd = fopen ($fullpath, 'r'))) {
		logmsg(LOG_WARNING, 'Could not download file [' . $fullpath . '] ');
		return 0;
	}
	logmsg(LOG_DEBUG, 'Downloading file [' . $fullpath . '] ');
	$fsize = filesize($fullpath);
	$path_parts = pathinfo($fullpath);
	header('Content-type: application/octet-stream');
	header('Content-Disposition: filename="' . $path_parts['basename'] . '"');
	header('Content-length: ' . $fsize);
	header('Cache-control: private'); 
	while(!feof($fd)) {
		$buffer = fread($fd, 2048);
		echo $buffer;
	}
	fclose ($fd);
	return 0;
}
function to_camel($var) {
	$arr = explode('_', $var);
	$str = '';
	for($i = 0; $i < sizeof($arr); $i++) {
		$str .= strtoupper($arr[$i][0]);
		$str .= substr($arr[$i], 1);
	}
	return $str;
}
?>
