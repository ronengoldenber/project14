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
		echo '<form name="joinform" id="joinform" action="authorize" onsubmit="return validate()" method="post">' . PHP_EOL;
		echo '<div><br><br>&nbsp;&nbsp;&nbsp;<a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414BigIconPrecise.png" alt="1414"></a></div>' . PHP_EOL;
		echo '<div align="center">' . PHP_EOL;
		echo '<div id="login" align="center"><br><br>' . PHP_EOL;
		echo '<table><tr><td>' . PHP_EOL;
		echo '<div id="subdiv"><font style="font-size:34px;" color=black>Register</font><br><br><br></div>'. PHP_EOL;
		html_field('First Name', 2, 'fname', 'text');
		html_field('Last Name', 2, 'lname', 'text');
		html_field('Email', 2, 'email', 'text');
		html_field('Password', 2, 'password', 'password');
		echo '</td></tr></table>' . PHP_EOL;
		html_tos_pp();
		echo '<div id="subdiv"><input type="image" name="submit" src="http://1414intl.com/1414/images/joinnowbig.png" border="0" alt="JoinNow"/></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '<br><br>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return true;
	}
	function html_main() {
		echo '<!DOCTYPE html>' . PHP_EOL;
		echo '<html id="html_join">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<title>1414</title>' . PHP_EOL;
		echo '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		echo '<link rel="stylesheet" type="text/css" href="http://1414intl.com/1414/style/1414.css">' . PHP_EOL;
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
