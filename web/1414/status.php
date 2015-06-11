<?php
	function printable($str) {
		$allowed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!#@$%^&*()~_-,={}[]\\|;?<>,+.\":\t`/\' ";
		$text = "";
		for($i = 0; $i < strlen($str); $i++) {
			if(strstr($allowed, $str[$i])) {
				$text = $text . $str[$i];
				continue;
			}
			$text = $text . '_';
		}
		return $text;
	}	
	$mysql = mysqli_connect('127.0.0.1', '', '','voice');
	if (mysqli_connect_errno()) {
		echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	$query = 'UPDATE state_1414 set `status` = "' . printable(file_get_contents('php://input')) . '" ';
	mysqli_query($mysql, $query);
	mysqli_close($mysql);
?>
