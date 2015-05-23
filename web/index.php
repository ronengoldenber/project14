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
	function main_screen() {
		echo '<table width="100%" height="100%" id="1414main" border=0 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr align="center" valign="center" height="100%">' . PHP_EOL;
		echo '		<td width="100%" align=center><a href=".com"><img src="images/1414background.jpg" alt="1414"></a></td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr align="center" valign="center" height="100%">' . PHP_EOL;
		echo '		<td align=center bgcolor=white>' . PHP_EOL;
		echo '			<div class="container">' . PHP_EOL;
		echo '				<div>' . PHP_EOL;
		echo '					<a href="fbconfig.php"><img src="images/facebook.png" alt="Login with Facebook"/></a></div>' . PHP_EOL;
		echo '				</div>' . PHP_EOL;
		echo '			</div>' . PHP_EOL;
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '  <tr height=80>' . PHP_EOL;
		echo '		<td align=center>' . PHP_EOL;
		echo '			<a href=".com">partners</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">rates</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">how does it work</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">about</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function get_device_status() {
		$mysql = mysqli_connect('127.0.0.1', 'root', '','voice');
		if (mysqli_connect_errno()) {
			echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
			return 0;
		}
		$query = 'SELECT p.status FROM `cfg_user` s JOIN `state_1414` p ON s.user_id=p.user_id  WHERE email = "' . $_SESSION['EMAIL'] . '"';
		$response = mysqli_query($mysql, $query);
		$arr = mysqli_fetch_object($response);
		echo printable($arr->status);
		mysqli_close($mysql);
		return 0;
	}
	function set_bt() {
		echo '<form action=index.php>' . PHP_EOL;
		echo '<input type="text" size="50" name="bt">' . PHP_EOL;
		echo '<input type="submit" value="Set Bluetooth">' . PHP_EOL;
		echo '<br>Settings->General->About->Bluetooth' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return 0;
	}
	function facebook_details() { 
		echo '<table border=0 cellspacing=10 width="800" height="300">' . PHP_EOL;
		if(strlen($_GET['bt']) > 10) {
			echo '<tr><td><b>Notification:</b></td><td>Please connect your bluetooth aa</td></tr>' . PHP_EOL;
		}
		echo '<tr><td><b>Status:</b></td><td>';
		get_device_status();
		echo '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Bluetooth:</b></td><td>';
		set_bt();
		echo '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Facebook User Id:</b></td><td>' . $_SESSION['FBID'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Fullname:</b></td><td>' . $_SESSION['FULLNAME'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Email:</b></td><td> ' . $_SESSION['EMAIL'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Logout:</b></td><td> <a href="logout.php">Logout</a></td></tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function user_inner_screen() {
		echo '<table border=0 width="100%" height="100%" bgcolor=#E2E2E2 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">Facebook details</a></td><td bgcolor=white rowspan=8 width="80%">' . PHP_EOL;
		facebook_details();
		echo '</td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">Add Phone</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">View Usage</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">item4</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">item5</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">item6</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">item7</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://.com">item8</a></td></tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function user_screen() {
		echo '<table width="100%" height="100%" id="1414main" border=0 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr align="center" valign="center">' . PHP_EOL;
		echo '		<td width="100%" align=left><a href="http://.com"><img src="images/1414background.jpg" alt="1414"></a></td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr align="center" valign="center" height="100%">' . PHP_EOL;
		echo '		<td align=center bgcolor=#E2E2E2>' . PHP_EOL;
		user_inner_screen();
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr height=80>' . PHP_EOL;
		echo '		<td align=center>' . PHP_EOL;
		echo '			<a href=".com">partners</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">rates</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">how does it work</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href=".com">about</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
	}
	session_start();
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" style="height: 100%;">
	<head>
		<title>Welcome to 1414</title>
		<style type="text/css">
			body {
				margin: 0;
				font-family: verdana;
			}
			a:link {
				color: blue;
				text-decoration: none;
			}
			a:visited {
				color: blue;
				text-decoration: none;
			}
			a:hover {
				color: blue;
				text-decoration: none;
			}
			a:active {
				color: blue;
				text-decoration: none;
			} 
		</style>
	</head>
	<body bgcolor=#B2B2B2 style="height: 100%;">
	<?php if ($_SESSION['FBID']): ?>      <!--  After user login  -->
	<?php user_screen();?>
<!--		<div class="container">
		<div class="hero-unit">
		<h1>Hello <?php /*echo $_SESSION['USERNAME'];*/ ?></h1>
		<p>Welcome to 1414 international </p>
	</div>
	<div class="span4">
	<ul class="nav nav-list">
	<li class="nav-header">Image</li>
		<li><img src="https://graph.facebook.com/<?php /*echo $_SESSION['FBID'];*/ ?>/picture"></li>
		<li class="nav-header">Facebook ID</li>
		<li><?php /*echo  $_SESSION['FBID'];*/ ?></li>
		<li class="nav-header">Facebook fullname</li>
		<li><?php /*echo $_SESSION['FULLNAME'];*/ ?></li>
		<li class="nav-header">Facebook Email</li>
		<li><?php /*echo $_SESSION['EMAIL'];*/ ?></li>
		<div><a href="logout.php">Logout</a></div>
	</ul></div></div> -->
	<?php else: ?>     <!-- Before login --> 
	<?php main_screen(); ?>
    <?php endif ?>
  </body>
</html>
