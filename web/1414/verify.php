<?php
	include 'util.php';
	include 'global.php';
	function contour($color) { 
		return 'text-shadow: -1px 0 ' . $color . ', 0 1px ' . $color . ', 1px 0 ' . $color . ', 0 -1px ' . $color . ';';
	}
	function error_screen($error) {
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>&nbsp;</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="queuetitlediv" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Error</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="queuediv"><br>' . PHP_EOL;
		echo '<div id="subdiv" align=center><font color=black size=5><br>' . $error . '<br><br></font>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;
	}
	function verify_user($email) {
		echo '<form action="http://1414intl.com/startup" method="post">' . PHP_EOL;
		echo '<input type="hidden" name="email" value="' . $email . '"/>' . PHP_EOL;
		echo '<input type="hidden" name="ha1" value="' . $ha1 . '"/>' . PHP_EOL;
		echo '<input type="hidden" name="url" value="' . $url . '"/>' . PHP_EOL;
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>' . $email . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="queuetitlediv" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Verify</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="queuediv"><br>' . PHP_EOL;
		echo '<div id="subdiv" align=center><font color=black size=5><br>' . $email . ', thank you for choosing 1414<br>Please auhorize your email<br></font>' . PHP_EOL;
		echo '<div id="subdiv"><font size=1 color=black> <input type="checkbox" name="pptos" value="false"> I agree to the Terms and Conditions and to the Privacy Policy</font></div>' . PHP_EOL;
		echo '<div id="subdiv" align="center"><input type="image" name="submit" src="http://1414intl.com/1414/images/save.png" border="0" alt="Save"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
	}
	function is_verify_user($link, $url) {
		$query = 'SELECT `email` FROM `state_unauthorized_user` WHERE `url` = ? ';
		if (!($stmt = sql_query($link, $query, 's', array($url)))) {
			return 'Cannot validate user authorization';
		}
		mysqli_stmt_bind_result($stmt, $email);
		if (mysqli_stmt_num_rows($stmt) == 0) {
			exit_stmt($stmt);
			return 'The url is invalid';
		}
		exit_stmt($stmt);
		return $email;
	}
	function choose_main_screen($link, $url) {
		$is_verify_user = is_verify_user($link, $url);
		if($is_verify_user == 'Cannot validate user authorization' || $is_verify_user == 'The url is invalid' ) { 
			error_screen($is_verify_user);
			return;
		}
		verify_user($is_verify_user);
	}
	function main_startup_screen() {
		$link = db_connect();
		$url = $_SERVER['REQUEST_URI'];
		logmsg(LOG_DEBUG, 'The url is [' . $url . '] ');
		$actual_link = explode('/', $url);
		$url = isset($actual_link[2]) ? $actual_link[2] : '';
		choose_main_screen($link, $url);
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
		<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">
	</head>
	<body style="height: 100%;" onresize="checkImg()">
		<?php main_startup_screen(); ?>
		<script>
			function checkImg() { 
				var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
//				if(height > 700) {
//					document.getElementById("html_login").style.backgroundImage = "url('http://1414intl.com/1414/images/phone_booth.jpg')";
//				}
//				if(height < 700) {
//					document.getElementById("html_login").style.backgroundImage = "url('http://1414intl.com/1414/images/login.jpg')";
//				}
			}
			checkImg();
		</script>
	</body>
</html>
