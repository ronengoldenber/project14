<?php
	function logger($msg) {
		openlog(basename($file), LOG_PID | LOG_PERROR, LOG_LOCAL0);
		syslog(LOG_DEBUG, $msg);
		closelog();
	}
	if (!isset($_POST) || !isset($_POST['email'])) {
		exit;
	}
	$mysql = mysqli_connect('127.0.0.1', '', '','voice');
	if (mysqli_connect_errno()) {
		echo 'Failed to connect to MySQL [' . mysqli_connect_error() . '] ';
	}
	$query = 'SELECT c.`cmd_id`, c.`cmd` FROM `cfg_user` s JOIN `state_cmd` c ON s.`user_id` = c.`user_id` WHERE s.`email` = "' . $_POST['email'] . '"';
	logger('Query is [' . $query . '] ');
	if(!($response = mysqli_query($mysql, $query))) { 
		logger('Cannot get query response [' . $query . '] ');
		exit;
	}
	$arr = mysqli_fetch_object($response);
	logger('Query response [' . print_r($respone, true) . '] ');
	if(strlen($arr->cmd_id) <= 0) { 
		logger('No cmd for [' . addslashes($_POST['email']) . '] ');
		exit;
	}
	$query = 'DELETE FROM `state_cmd` WHERE `cmd_id` = ' . $arr->cmd_id . '';
	logger('Query is [' . $query . '] ');
	mysqli_query($mysql, $query);
	mysqli_close($mysql);
	echo $arr->cmd . PHP_EOL;
?>
