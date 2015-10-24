<?php
	include 'db.php';
	function phone_input($name) {
		return '(<input name=' . $name . 'a maxlength=3 size=3 type=tel>) <input name=' . $name . '1b maxlength=3 size=3 type=tel> - <input name=' . $name . '1c maxlength=4 size=3 type=tel>';
	}
	function question($question, $answer) {
		return '<div id="subinfodiv"><font style="font-size: 14px;" color=black><b>' . $question . '</b><br>' . $answer . '</font></div>';
	}
	function contour($color) { 
		return 'text-shadow: -1px 0 ' . $color . ', 0 1px ' . $color . ', 1px 0 ' . $color . ', 0 -1px ' . $color . ';';
	}
	function upper_bar() {
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div style="padding: 8px;"><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414sm.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div style="padding: 8px;"><font style="font-size: 20px;" color=black>' . strtolower($_POST['email']) . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
	}
	function authorize_numbers_bar() {
		echo '<div id="authorizenumberstitle" align="left"> ' . PHP_EOL;
		echo '<div style="padding: 8px;"><font color=white style="font-size: 20px;">Authorized Numbers</font></div></div>' . PHP_EOL;
		echo '<div id="authorizenumbers"><br>' . PHP_EOL;
		for($i=0; $i<7; $i++) {
			echo '<div id="subdiv" align=center><font color="#FF3385" size=4>' .  phone_input('telephone' . $i) . '</font></div>' . PHP_EOL;
		}
		echo '<div id="subdiv" align="center"><input type="image" name="submit" src="http://1414intl.com/1414/images/save.png" border="0" alt="Save"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	function qna() {
		echo '<div id="infotitle"><div style="padding: 8px;"><font color=white style="font-size: 20px;">Q&A</font></div></div>' . PHP_EOL;
		echo '<div id="info">' . PHP_EOL;
		echo '' . question('What are authorize numbers?', '1414 allows call only from those authorize phone numbers'). '' . PHP_EOL;
		echo '' . question('How do I dial?', '1414 uses direct dial method <b>"2532432123,0507077766"</b> '). '' . PHP_EOL;
		echo '<div id="subinfodiv"><img border="1" style="border-style: solid; border-color: black;" src="http://1414intl.com/1414/images/howtodial.jpg" alt="howtodial"></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	function cdr($link, $email) {
		echo '<div id="cdrtitle"><div style="padding: 8px;"><font color=white style="font-size: 20px;">Calls</font></div></div>' . PHP_EOL;
		echo '<div id="cdr">' . PHP_EOL;
		echo '<div style="padding: 10px;">' . PHP_EOL;
		echo '<table width="100%">' . PHP_EOL;
		echo '<tr><th style="padding: 4px; border: 1px solid black;"><font color=black size=2>From</font></th>' . PHP_EOL;
		echo '<th style="padding: 4px; border: 1px solid black;"><font color=black size=2>To</font></th>' . PHP_EOL;
		echo '<th style="padding: 4px; border: 1px solid black;"><font color=black size=2>Through</font></th>' . PHP_EOL;
		echo '<th style="padding: 4px; border: 1px solid black;"><font color=black size=2>Start</font></th>' . PHP_EOL;
		echo '<th style="padding: 4px; border: 1px solid black;"><font color=black size=2>End</font></th>' . PHP_EOL;
		echo '<th style="padding: 4px; border: 1px solid black;"><font color=black size=2>Duration</font></th></tr>' . PHP_EOL;
		get_latest_cdrs($link, $email);
		echo '</div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}
	function main_screen($link, $email) {
		echo '<form action="authorizenumbers" method="post">' . PHP_EOL;
		upper_bar();
		echo '<table width="100%"><tr><td align=center>' . PHP_EOL;
		echo '<table><tr><td align="left">' . PHP_EOL;
		authorize_numbers_bar();
		echo '</td><td align="right">' . PHP_EOL;
		qna();
		echo '</td></tr><tr><td colspan="2" align="left"><br><br>' . PHP_EOL;
		cdr($link, $email);
		echo '<br><br></td></tr></table></tr></td></table>' . PHP_EOL;
		echo '<br><br><br>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return 0;
	}
	function unauthorized_user() { 
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>' . $_POST['email'] . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="queuetitlediv" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Email Authorize</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="queuediv"><br>' . PHP_EOL;
		echo '<div id="subdiv" align=center><font color=black size=5><br>Please authorize your email<br><br></font>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;
	}
	function error_screen($error) {
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>' . $_POST['email'] . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="queuetitlediv" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Error</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="queuediv"><br>' . PHP_EOL;
		echo '<div id="subdiv" align=center><font color=black size=5><br>' . $error . '<br><br></font>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;	
	}
function is_authorized_user($link, $email, $password) {
	$query = 'SELECT `email`, `ha1` FROM `config_user` WHERE `email` = ? ';
	logmsg(LOG_DEBUG, 'Checking if the user is authorized');
	if (!($stmt = sql_query($link, $query, 's', array($email)))) {
		return 'Cannot validate user authorization';
	}
	mysqli_stmt_bind_result($stmt, $row['email'], $row['ha1']);
	if (mysqli_stmt_num_rows($stmt) == 0) {
		exit_stmt($stmt);
		return 'This user is not authorized';
	}
	exit_stmt($stmt);
	if (md5(strtolower($email) . ':' . 'tmus' .  ':' . $password) != $row['ha1']) {
		return 'Wrong password';
	}
	return 'OK';
}
function choose_main_screen($link, $email, $password) {
	$is_authorized_userStr = is_authorized_user($link, $email, $password);
	if($is_authorized_userStr != 'OK') {
		error_screen($is_authorized_userStr);
		return;
	}
	main_screen($link, $email);
	return;
}
function main_startup_screen() {
	$link = db_connect();
	$email = isset($_POST['email']) ? strtolower($_POST['email']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	choose_main_screen($link, $email, $password);
	if($link) {
		mysqli_close($link);
	}
}
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>1414</title>
		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
		<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/style/1414.css">
	</head>
	<body style="height: 100%;">
		<?php main_startup_screen(); ?>
	</body>
</html>
