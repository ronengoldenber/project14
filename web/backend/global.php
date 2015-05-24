<?php
include 'env.php';

define("PHP_MAX_LOOP", 			"255");
define("PHP_MAX_DEPTH", 		"3");
define("MULTI_REGISTRATION_MAX_SIZE", 	"10");
define('MIN_E164_NUMBER_LENGTH',        '7');
define("EXT_TYPE_REG",			0);
define("EXT_TYPE_VM",			2);
define("EXT_TYPE_IVR",			3);
define("EXT_TYPE_GENERAL_VM",		4);
define("EXT_TYPE_PSTN",			5);
define("EXT_TYPE_CONF",			6);
define("EXT_TYPE_GRP",			7);
define("EXT_TYPE_ECHO",			8);
define("EXT_TYPE_EMR",			9);

define('TENANT_STATUS_DISABLED',	0);
define('TENANT_STATUS_ACTIVE',		1);
define('TENANT_STATUS_CANCEL_PENDING',	2);
define('TENANT_STATUS_SUSPENDED',	3);

define("STAT_DROPPED_CALLS",		1);
define("STAT_INTL_CALLS",		2);
define("STAT_INBOUND_CALLS",		3);
define("STAT_OUTBOUND_CALLS",		4);
define("STAT_EXT_CALLS",		5);
define("STAT_IVR_CALLS",		6);
define("STAT_CONF_CALLS",		7);
define("STAT_VOICEMAIL",		8);
define("STAT_FILESYSTEM_ERR",		9);
define("STAT_REGI_COUNT",		10);

define('SOUND_CUSTOM_GREETING_TYPE',	2);
define('SOUND_TTS_TYPE',		1);
define('SOUND_NONE_TYPE',		0);
define('MAIN_IVR_EXT',			200);
#############################################################################################################################
function severity_tostring($severity)
{
	switch ($severity)
	{
		case LOG_DEBUG  	:       return "DEBUG: ";
		case LOG_INFO   	:       return "INFO: ";
		case LOG_WARNING	:	return "WARNING: ";
		case LOG_ERR   		:       return "ERR: ";
		case LOG_CRIT  		:       return "CRIT: ";
		default         	:       return "";
	}
	return "";
}
function printable($str)
{
	$allowed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!#@$%^&*()_-,={}[]\\|;?<>+`,.\":\t/\' ";
	$str = trim($str);
	$text = "";
	for($i = 0; $i < strlen($str); $i++)
	{
		if(strstr($allowed, $str[$i]))
		{
			$text = $text . $str[$i];
			continue;
		}
		$text = $text . '_';
	}
	return $text;
}
function logmsg ($severity, $message)
{
	$arr		=	debug_backtrace();
	$function	=	(isset($arr[1])) 	? $arr[1]['function'] 	: NULL;
	$line		=	(isset($arr[1]))	? $arr[1]['line'] 	: NULL;
	$file 		=	(isset($arr[1]))	? $arr[1]['file']	: NULL;
	$msg = severity_tostring($severity) . $function . "(" . $line . "):" . $message;
	$msg = printable($msg);
	openlog(basename($file), LOG_PID | LOG_PERROR, LOG_LOCAL0);
	syslog($severity, $msg);
	closelog();
#	echo "$msg";
	return true;
}
function logmsg_echo($message)
{
	$msg = (string)$message;
	$message = printable($msg);
	echo "$message" . "\n";
	logmsg(LOG_INFO, $message);
	return true;
}
function lognmsg_echo($message)
{
	echo "$message";
	logmsg(LOG_INFO, $message . PHP_EOL);
	return true;
}
function print_request()
{
	foreach($_POST as $key => $value)
	{
		logmsg(LOG_DEBUG, "[" . $key . "=" . $value . "]");
	}
	return true;
}
function db_connect() {
	logmsg (LOG_DEBUG, "db_ip:" . DB_IP);
	if(!($link = mysqli_connect(DB_IP, DB_USER, DB_PASS, DB_NAME)))
	{
		logmsg (LOG_CRIT, "Could not connect to DB [". mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
		return 0;
	}
	logmsg (LOG_DEBUG, "DB connected");
	return $link;
}
function sql_query($link, $query, $types = NULL, $values = NULL)
{
	if (!$link)
	{
		logmsg (LOG_WARNING, "Invalid DB handle");
		return 0;
	}
	if (!($stmt = mysqli_prepare($link, $query)))
	{
		logmsg (LOG_WARNING, "Cannot prepare sql query [" . $query . "][" .  print_r($values, true) . "]");
		return 0;
	}
	$args = NULL;
	if($types && $values)
	{
		$args[0] = $stmt;
		$args[1] = $types;
		$i = 2;
		foreach($values as $key=>$value)
		{
			$args[$i] = &$values[$key];
			$i++;
		}
		call_user_func_array('mysqli_stmt_bind_param', $args);
	}
	logmsg(LOG_DEBUG, "Query is [" . $query . "] types [" . $types . "] values [" . print_r($values, true) . "]");
	for($i = 0; $i < 20; $i++)
	{
		$ret = 1;
		if(!mysqli_stmt_execute($stmt))
		{
			logmsg (LOG_DEBUG, "Could not execute stmt [" . $query . "][" .  print_r($values, true) . "]");
			$ret = 0;
		}
		if(!mysqli_stmt_store_result($stmt))
		{
			logmsg (LOG_DEBUG, "Could not store stmt [" . $query . "][" .  print_r($values, true) . "]");
			$ret = 0;
		}
		if (!strcmp (substr ($query, 0, 4), 'CALL'))
		{
			$query1 = "SELECT @error as error_code, @errorMessage as error_message;";
			if(!($res = mysqli_query($link, $query1)))
			{
				logmsg (LOG_DEBUG, "call to storedprocedure failed due to DB error, retrying");
				continue;
			}
			if(!($row = mysqli_fetch_assoc($res)))
			{
				logmsg (LOG_DEBUG, "call to storedprocedure failed due to DB error, retrying");
				continue;
			}
			if (($row['error_code'] != 0 )&& (strstr ($row['error_message'],'lock found when trying to get lock') || strstr ($row['error_message'], 'probably caused by deadlock')))
			{
				logmsg (LOG_DEBUG, "call to storedprocedure failed, retrying");
				continue;
			}
			break;
		}
		break;
	}
	if ($ret == 0)
	{
		mysqli_stmt_close($stmt);
		return $ret;
	}
	return $stmt;
}
function exit_stmt($stmt)
{
	if (!$stmt)
		return true;

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
	return hash('sha512', makeRandomString());
}
function guid( $opt = false) {
	if( function_exists('com_create_guid') ){
		if( $opt ) { 
			return com_create_guid(); 
		}
		return trim( com_create_guid(), '{}' );
	}
	mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
	$charid = strtoupper( md5(uniqid(rand(), true)) );
	$hyphen = chr( 45 );    // "-"
	$left_curly = $opt ? chr(123) : "";     //  "{"
	$right_curly = $opt ? chr(125) : "";    //  "}"
	$uuid = $left_curly
		. substr( $charid, 0, 8 ) . $hyphen
		. substr( $charid, 8, 4 ) . $hyphen
		. substr( $charid, 12, 4 ) . $hyphen
		. substr( $charid, 16, 4 ) . $hyphen
		. substr( $charid, 20, 12 )
		. $right_curly;
	return $uuid;
}
function check_error ($link, $name)
{
	$query = "SELECT @error, @errorMessage;";
	if (!($stmt = sql_query($link, $query)))
		logmsg_echo("0");
	
	mysqli_stmt_bind_result($stmt, $error, $errorMessage);
	exit_stmt($stmt);
	logmsg(LOG_DEBUG, $name. ": error_code = [" . $error . "] error_message = [" . $errorMessage . "]");
	if ($error) logmsg_echo("-1");
	else logmsg_echo("0");
}
function to_camel($var)
{
	$arr = explode('_', $var);
	$str = "";
	for($i = 0; $i < sizeof($arr); $i++)
	{
		$str .= strtoupper($arr[$i][0]);
		$str .= substr($arr[$i], 1);
	}
	return $str;
}
?>
