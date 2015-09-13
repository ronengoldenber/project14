<?php
	include '1414.php';
	function js_join() {
		echo '<script>' . PHP_EOL;
		js_validate_fname();
		js_validate_lname();
		js_validate_email();
		js_validate_password();
		js_check_fname('joinform');
		js_check_lname('joinform');
		js_check_email('joinform');
		js_check_password('joinform');
		js_validate('joinform');
		echo '</script>' . PHP_EOL;
		return;
	}
	function main_screen() {
		echo '<table style="height: 100%; width: 100%;"  cellpadding=40 border=0><tr height="100%"><td height="100%" width="100" valign="top">' . PHP_EOL;
		echo '<form name="joinform" id="joinform" action="authorize" onsubmit="return validate()" method="post">' . PHP_EOL;
		echo '<div><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '</td><td align="left" valign="center">' . PHP_EOL;
		echo '<div id="join"><br>' . PHP_EOL;
		html_field('First Name', 3, 'fname', 'text');
		html_field('Last Name', 3, 'lname', 'text');
		html_field('Email', 3, 'email', 'text');
		html_field('Password', 3, 'password', 'password');
		html_tos_pp();
		echo '<div id="subdiv"><input type="image" name="submit" src="http://1414intl.com/1414/images/joinnowbig.png" border="0" alt="JoinNow"/></div>' . PHP_EOL;
		echo '</div><br><br>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		return true;
	}
	function html_main() {
		echo '<!DOCTYPE html>' . PHP_EOL;
		echo '<html id="html_join">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<title>1414</title>' . PHP_EOL;
		echo '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		echo '<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/1414.css">' . PHP_EOL;
		js_join();
		echo '</head>' . PHP_EOL;
		echo '<body style="height: 100%;">' . PHP_EOL;
		main_screen();
		echo '</body>' . PHP_EOL;
		echo '</html>' . PHP_EOL;
		return true;
	}
	html_main();
?>
