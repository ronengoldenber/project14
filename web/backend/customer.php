<?php
	function customer_facebook_details($link) { 
		echo '<table border=0 cellspacing=10 width="800" height="300">' . PHP_EOL;
		echo '<tr><td><b>Status:</b></td><tr>';
		echo '</table>' . PHP_EOL;
		return 0;
	}
	function customer_inner_screen($link) {
		echo '<table border=0 width="100%" height="100%" bgcolor=#E2E2E2 style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr><td>&nbsp;&nbsp;<a href="http://1414intl.com">Facebook details</a></td><td bgcolor=white rowspan=8 width="80%">' . PHP_EOL;
		customer_facebook_details($link);
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
	function customer_screen($link,$username, $name, $email) {
		echo '<table width="100%" height="100%" id="1414main" border=0  background="../1414/images/main.jpg" style="padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px;">' . PHP_EOL;
		echo '	<tr align="center" valign="center">' . PHP_EOL;
		echo '		<td width="100%" align=left>&nbsp;</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;
	}
?>
