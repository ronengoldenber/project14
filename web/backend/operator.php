<?php
	function get_device_status($link) {
		$email = $_SESSION['EMAIL'];
		$query = 'SELECT sd.status FROM `config_user` s JOIN `config_device` d ON s.user_id = d.user_id ';
		$query .= 'JOIN `state_device` sd ON sd.device_id = d.device_id WHERE s.email = ? ';
		if(($stmt = sql_query($link, $query, 's', array($email)))) {
			mysqli_stmt_bind_result($stmt, $status);
			exit_stmt($stmt);
		}
		echo printable($status);
		return 0;
	}
	function get_device_btstatus($link) {
		$email = $_SESSION['EMAIL'];
		$query = 'SELECT sd.btstatus FROM `config_user` s JOIN `config_device` d ON s.user_id = d.user_id ';
		$query .= 'JOIN `state_device` sd ON sd.device_id = d.device_id WHERE s.email = ? ';
		if(($stmt = sql_query($link, $query, 's', array($email)))) {
			mysqli_stmt_bind_result($stmt, $status);
			exit_stmt($stmt);
		}
		echo printable($status);
		return 0;
	}
	function get_device_ip($link) {
		$email = $_SESSION['EMAIL'];
		$query = 'SELECT sd.ip FROM `config_user` s JOIN `config_device` d ON s.user_id = d.user_id ';
		$query .= 'JOIN `state_device` sd ON sd.device_id = d.device_id WHERE s.email = ? ';
		if(($stmt = sql_query($link, $query, 's', array($email)))) {
			mysqli_stmt_bind_result($stmt, $ip);
			exit_stmt($stmt);
		}
		echo printable(long2ip($ip));
		return 0;
	}
	function is_set_bt($link) {
		if(isset($_POST['bt1']) && isset($_POST['bt2']) && isset($_POST['bt3']) && isset($_POST['bt4']) && isset($_POST['bt5']) && isset($_POST['bt6'])) {
			$bt = $_POST['bt1'] . ':' . $_POST['bt2'] . ':' . $_POST['bt3'] . ':' . $_POST['bt4'] . ':' . $_POST['bt5'] . ':' . $_POST['bt6'];
			echo '<font color=red><b>Set device bluetooth to [' . $bt . ']<br> Please wait 1 mintues before pairing your phone automatically </b></font>' . PHP_EOL;
			$email = $_SESSION['EMAIL'];
			$device_id = get_device_id_by_email($link, $email);
			$query = 'INSERT INTO `state_cmd` (device_id, cmd) VALUES (?, ?) ';
			$cmd = 'btadd ' . $bt . '';
			sql_query($link, $query, 'ss', array($device_id, $cmd));
			exit_stmt($stmt);
			return 0;
		}
	}
	function set_bt($link) {
		is_set_bt($link);
		echo '<form action="index.php" method="post">' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt1"> :' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt2"> :' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt3"> :' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt4"> :' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt5"> :' . PHP_EOL;
		echo '<input type="text" size="1" maxlength="2" name="bt6">' . PHP_EOL;
		echo '<input type="submit" value="Set Bluetooth">' . PHP_EOL;
		echo '<br>Settings->General->About->Bluetooth' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return 0;
	}
	function operator_facebook_details($link) { 
		echo '<table border=0 cellspacing=10 width="800" height="300">' . PHP_EOL;
		if(strlen($_GET['bt']) > 10) {
			echo '<tr><td><b>Notification:</b></td><td>Please connect your bluetooth to intl1414</td></tr>' . PHP_EOL;
		}
		echo '<tr><td><b>Status:</b></td><td>';
		get_device_status($link);
		echo '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Bluetooth:</b></td><td>';
		set_bt($link);
		echo '</td></tr>' . PHP_EOL;
        echo '<tr><td><b>Bt Status:</b></td><td>';
		get_device_btstatus($link);
		echo '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>IP Address:</b></td><td>';
		get_device_ip($link);
		echo '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Facebook User Id:</b></td><td>' . $_SESSION['FBID'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Fullname:</b></td><td>' . $_SESSION['FULLNAME'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Email:</b></td><td> ' . $_SESSION['EMAIL'] . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Token:</b></td><td> ' . print_r($_SESSION, true) . '</td></tr>' . PHP_EOL;
		echo '<tr><td><b>Logout:</b></td><td> <a href="logout.php">Logout</a></td></tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function operator_inner_screen($link) {
		echo '<table border=0 width="100%" height="100%" bgcolor=#E2E2E2 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">Facebook details</a></td><td bgcolor=white rowspan=8 width="80%">' . PHP_EOL;
		operator_facebook_details($link);
		echo '</td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">Add Phone</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">View Usage</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">item4</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">item5</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">item6</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">item7</a></td></tr>' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">item8</a></td></tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function operator_screen($link,$username, $name, $email) {
		echo '<table width="100%" height="100%" id="1414main" border=0 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr align="center" valign="center">' . PHP_EOL;
		echo '		<td width="100%" align=left><a href="http://1414intl.com"><img src="images/1414background.jpg" alt="1414"></a></td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr align="center" valign="center" height="100%">' . PHP_EOL;
		echo '		<td align=center bgcolor=#E2E2E2>' . PHP_EOL;
		operator_inner_screen($link);
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr height=80>' . PHP_EOL;
		echo '		<td align=center>' . PHP_EOL;
		echo '			<a href="1414intl.com">partners</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href="1414intl.com">rates</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href="1414intl.com">how does it work</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '			<a href="1414intl.com">about</a>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;
		echo '		</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
	}
?>
