<?php
	include '1414.php';
	function main_screen($fname, $lname, $email, $password) {
		echo '<table style="height: 100%; width: 100%;"  cellpadding=40 border=0><tr height="100%"><td height="100%" width="100" valign="top">' . PHP_EOL;
		echo '<form name="authorizeform" id="authorizeform" action="authorize" method="post">' . PHP_EOL;
		echo '<input id="fname" name="fname" type="hidden" value="' . $fname . '">' . PHP_EOL;
		echo '<input id="lname" name="lname" type="hidden" value="' . $lname . '">' . PHP_EOL;
		echo '<input id="email" name="email" type="hidden" value="' . $email . '">' . PHP_EOL;
		echo '<input id="password" name="password" type="hidden" value="' . $password . '">' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '</td><td align="left" valign="center">' . PHP_EOL;
		echo '<div id="authorize"><br>' . PHP_EOL;
		echo '<div id="subdiv"><font size=5 color=black>Email address authorization</font><br><br></div>' . PHP_EOL;
		echo '<div id="subdiv"><font size=3 color=black>' . $fname . ' ' . $lname . ', thank you for choosing 1414</font><br>' . PHP_EOL;
		echo '<font size=3 color=black>We sent you an email to  [' . $email . ']</font></div><br>' . PHP_EOL;
		echo '<div id="subdiv"><input type="image" name="submit" src="http://1414intl.com/1414/images/resendemail.png" border="0" alt="resendemail"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		return true;
	}
	function error_screen($is_authorize) {
		echo '<table style="height: 100%; width: 100%;"  cellpadding=40 border=0><tr height="100%"><td height="100%" width="100" valign="top">' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '</td><td align="left" valign="center">' . PHP_EOL;
		echo '<div id="authorize"><br>' . PHP_EOL;
		echo '<div id="subdiv"><font size=5 color=black><b>Error</b></font><br><br></div>' . PHP_EOL;
		echo '<div id="subdiv"><font size=3 color=black>We cannot authorize your details [<b>' . $is_authorize . '</b>] please check your details again</font></div><br>' . PHP_EOL;
		echo '<div id="subdiv"><font size=3><a href="http://1414intl.com/join">Try Again</a></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		return true;
	}
	function send_email_to_user($fname, $lname, $email, $url) {
		$title = 'Welcome to 1414';
		$body .= '<html>' . PHP_EOL;
		$body .= '<head>' . PHP_EOL;
		$body .= '<title>1414</title>' . PHP_EOL;
		$body .= '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		$body .= '<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">' . PHP_EOL;
		$body .= '</head>' . PHP_EOL;
		$body .= '<body style="height: 100%;">' . PHP_EOL;
		$body .= '<table heigth="100%" width="100%" align=center><tr align=center><td align=center>' . PHP_EOL;
		$body .= '<table><tr><td><img src="http://1414intl.com/1414/images/1414bg.png"/></td><td>' . PHP_EOL;
		$body .= '<font size=5 color=black><b>Activate 1414</b></font></td></tr></table><br>' . PHP_EOL;
		$body .= '<font size=3 color=black>Please Activate your account</font><br>' . PHP_EOL;
		$body .= '<font size=3 color=black>Enjoy unlimited long distance calls landline or mobile</font><br>' . PHP_EOL;
		$body .= '<font size=3 color=black>After activating your account you will be entered to a queue</font><br>' . PHP_EOL;
		$body .= '<font size=3 color=black>Once your turn will come you will be able to start using 1414</font><br> ' . PHP_EOL;
		$body .= '<a href="http://1414intl.com/verify/' . $url . '"><img src="http://1414intl.com/1414/images/activate.png" alt="Please authorize your email address"/></a><br>' . PHP_EOL;
		$body .= '<font size=2 color=black> By clicking Activate, you agree to 1414\'s <a href=http://1414intl.com/terms>Terms and Conditions</a> and <a href=http://1414intl.com/privacy>Privacy Policy</a>' . PHP_EOL;
		$body .= '</td></tr></table>' . PHP_EOL;
		$body .= '</body>' . PHP_EOL;
		$body .= '</html>' . PHP_EOL;
		logmsg(LOG_DEBUG, 'Sending email to [' . $email . '][url=' . $url . '] ');
		sendemail($email, $title, $body);
		return true;
	}
	function add_unauthorized_user($link, $fname, $lname, $email, $password) {
		$query = 'SELECT `email`, `url` FROM `state_unauthorized_user` WHERE `email` = ? ';
		if (!($stmt = sql_query($link, $query, 's', array($email)))) {
			return 'Could not get email [' . $email . '] status ';
		}
		mysqli_stmt_bind_result($stmt, $queryemail, $url);
		if (mysqli_stmt_num_rows($stmt) == 0) {
			exit_stmt($stmt);
			$query = 'INSERT INTO `state_unauthorized_user` (`tenant_id`, `fname`, `lname`, `email`, `ha1`, `url`) VALUES (240000000, ?, ?, ?, md5(concat(?, ":", "tmus", ":", ?)), ?);';
			$random = bin2hex(openssl_random_pseudo_bytes(32));
			$stmt = sql_query($link, $query, 'ssssss', array($fname, $lname, $email, $email, $password, $random));
			send_email_to_user($fname, $lname, $email, $random);
			return '';
		}
		exit_stmt($stmt);
		logmsg(LOG_DEBUG, 'Sending email [' . $email . '] to user did not add user with url [' . $url . '] ');
		send_email_to_user($fname, $lname, $email, $url);
		return '';
	}
	function validate_details($link) {
		if(!isset($_POST['fname'])) { return 'Missing first name';}
		if(!isset($_POST['lname'])) { return 'Missing last name';} 
		if(!isset($_POST['email'])) { return 'Missing email';}
		if(!isset($_POST['password'])) { return 'Missing password';}
		$is_fname = validate_fname($_POST['fname']);
		$is_lname = validate_lname($_POST['lname']);
		$is_email = validate_email($_POST['email']);
		$is_password = validate_password($_POST['password']);
		if($is_fname != '') { return $is_fname; }
		if($is_lname != '') { return $is_lname; }
		if($is_email != '') { return $is_email; }
		if($is_password != '') { return $is_password; }
		$is_unauthorized_user = add_unauthorized_user($link, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
		if($is_unauthorized_user != '') { return  $is_unauthorized_user; }
		return '';
	}
	function html_startup() {
		$link = db_connect();
		echo '<!DOCTYPE html>' . PHP_EOL;
		echo '<html id="html_authorize">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<title>1414</title>' . PHP_EOL;
		echo '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		echo '<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">' . PHP_EOL;
		echo '</head>' . PHP_EOL;
		echo '<body style="height: 100%;">' . PHP_EOL;
		$is_authorize = validate_details($link);
		if($is_authorize != '') { error_screen($is_authorize); }
		if($is_authorize == '') { main_screen($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']); }
		echo '</body>' . PHP_EOL;
		echo '</html>' . PHP_EOL;
		if($link) {
			mysqli_close($link);
		}
		return true;
	}
	html_startup();
?>
