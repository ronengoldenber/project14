<?php
	include 'util.php';
	include 'global.php';
	function phone_input($name) {
		return '(<input name=' . $name . 'a maxlength=3 size=5 type=tel>) <input name=' . $name . '1b maxlength=3 size=5 type=tel> - <input name=' . $name . '1c maxlength=4 size=6 type=tel>';
	}
	function question($question, $answer) {
		return '<div id="subinfodiv"><font size=3 color=black><b>' . $question . '</b><br>' . $answer . '</font></div>';
	}
	function contour($color) { 
		return 'text-shadow: -1px 0 ' . $color . ', 0 1px ' . $color . ', 1px 0 ' . $color . ', 0 -1px ' . $color . ';';
	}
	function main_screen() {
		echo '<form action="authorizenumbers" method="post">' . PHP_EOL;
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>' . $_POST['email'] . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="authorizenumberstitle" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Authorized Numbers</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="authorizenumbers"><br>' . PHP_EOL;
		for($i=0; $i<5; $i++) {
			echo '<div id="subdiv" align=center><font color=black size=6>' .  phone_input('telephone' . $i) . '</font></div>' . PHP_EOL;
		}
		echo '<div id="subdiv" align="center"><input type="image" name="submit" src="http://1414intl.com/1414/images/save.png" border="0" alt="Save"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '<div id="infotitle"><font color=white style="' . contour('black') . '" size=6><table width="100%" cellpadding="5"><tr><td>Q&A</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="info">' . PHP_EOL;
		echo '' . question('What are authorize numbers?', '1414 allows call only from those authorize phone numbers'). '' . PHP_EOL;
		echo '' . question('How do I dial?', '1414 uses direct dial method <b>"2532432123,0507077766"</b> '). '' . PHP_EOL;
		echo '<div id="subinfodiv"><img border="1" style="border-style: solid; border-color: black;" src="http://1414intl.com/1414/images/howtodial.jpg" alt="howtodial"></div>' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return 0;
	}
	function queue_main_screen() {
		echo '<div id="bardiv"> ' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td>' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div></td><td align="right">' . PHP_EOL;
		echo '<div><font size=6 color=black>' . $_POST['email'] . '</font></div></td></tr></table>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '<table width="100%" cellpadding="10"><tr><td align="center">' . PHP_EOL;
		echo '<div id="queuetitlediv" align="left"><font color=white style="' . contour('black') . '" size=6><table cellpadding=5><tr><td>Queue</td</tr></table></font></div>' . PHP_EOL;
		echo '<div id="queuediv"><br>' . PHP_EOL;
		echo '<div id="subdiv" align=center><font color=black size=5><br>Thank You for registering to 1414<br><br>We are currently at full capacity<br><br></font>' . PHP_EOL;
		echo '<font color=black size=7>You are 4217 in line</font><br><br>' . PHP_EOL;
		echo '<font color=black size=4>We will send you an email when your turn will come</font></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</td><td align="left">' . PHP_EOL;
		echo '</div></td></tr></table>' . PHP_EOL;
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
	function isAuthorizedUser($link, $email, $password) {
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
		if (md5($email . ':' . 'tmus' . $password) != $row['ha1']) {
			exit_stmt($stmt);
			return 'Wrong password';
		}
		exit_stmt($stmt);
		return 'OK';
	}
	function isUnauthorizedUser($link, $email, $password) {
		$query = 'SELECT `email`, `url` FROM `state_unauthorized_user` WHERE `email` = ? ';
		if (!($stmt = sql_query($link, $query, 's', array($email)))) {
			return 'Could not get email [' . $email . '] status ';
		}
		mysqli_stmt_bind_result($stmt, $row['email'], $row['url']);
		if (mysqli_stmt_num_rows($stmt) == 0) {
			exit_stmt($stmt);
			$query = 'INSERT INTO `state_unauthorized_user` (`tenant_id`, `email`, `ha1`, `url`) VALUES (240000000, ?, md5(concat(?, ":", "tmus", ":", ?)), ?);';
			$random = bin2hex(openssl_random_pseudo_bytes(32));
			$stmt = sql_query($link, $query, 'ssss', array($email, $email, $password, $random));
			return 'Please verify [' . $email . '] ';
		}
		exit_stmt($stmt);
		return 'OK';
	}
	function choose_main_screen($link, $email, $password) {
		$isAuthorizedUserStr = isAuthorizedUser($link, $email, $password);
		if($isAuthorizedUserStr != 'This user is not authorized') { 
			error_screen($isAuthorizedUserStr);
			return;
		}
		$isUnauthorizedUser = isUnauthorizedUser($link, $email, $password);
		if ($isUnauthorizedUser != 'OK') { 
			error_screen($isUnauthorizedUser);
			return;
		}
		if(isset($_POST['email']) && $_POST['email'] == 'yiftah.golan@gmail.com') {
			main_screen();
			return;
		}
		queue_main_screen();
	}
	function main_startup_screen() {
		$link = db_connect();
		$email = isset($_POST['email']) ? $_POST['email'] : '';
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
