<?php
	// Pear Mail Library
	require_once 'Mail.php';
	function generate_spaces($num) {
		for($i = 0; $i < $num; $i++) {
			echo '&nbsp;';
		}
	}
	function sendemail($to, $subject, $body) {
		// Pear Mail Library
		$from = 'ronen.goldenber@gmail.com';
		$headers = array(
			'From' => $from,
			'To' => $to,
			'Subject' => $subject
		);
		$smtp = Mail::factory('smtp', array(
			'host' => 'ssl://smtp.gmail.com',
			'port' => '465',
			'auth' => true,
			'username' => '1414call@gmail.com',
			'password' => 'Lannet23'
		));
		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail)) {
			return $mail->getMessage();
		}
		return 'Message successfully sent!';
	}
?>
