<?php
	include '1414.php';
	function main_screen() {
		echo '<table style="height: 100%; width: 100%;"  cellpadding=40 border=0><tr height="100%"><td height="100%" width="100" valign="top">' . PHP_EOL;
		echo '<form name="authorizeform" id="authorizeform" action="authorize" method="post">' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '</td><td align="left" valign="center">' . PHP_EOL;
		echo '<div id="authorize"><br>' . PHP_EOL;
		echo '<div id="subdiv"><font size=5 color=black>Email address authorization</font><br><br></div>' . PHP_EOL;
		echo '<div id="subdiv"><font size=3 color=black>' . $_POST['fname'] . ' ' . $_POST['lname'] . ', thank you for choosing 1414</font><br>' . PHP_EOL;
		echo '<font size=3 color=black>We sent you an email to  [' . $_POST['email'] . ']</font></div><br>' . PHP_EOL;
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
	function validate_details() {
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
		return '';
	}
	function html_startup() {
		echo '<!DOCTYPE html>' . PHP_EOL;
		echo '<html id="html_authorize">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<title>1414</title>' . PHP_EOL;
		echo '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		echo '<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">' . PHP_EOL;
		echo '</head>' . PHP_EOL;
		echo '<body style="height: 100%;">' . PHP_EOL;
		$is_authorize = validate_details();
		if($is_authorize != '') { error_screen($is_authorize); }
		if($is_authorize == '') { main_screen(); }
		echo '</body>' . PHP_EOL;
		echo '</html>' . PHP_EOL;
		return true;
	}
	html_startup();
?>
