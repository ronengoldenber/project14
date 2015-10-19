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
		echo '<div id="join">' . PHP_EOL;
		echo '<div id="subdivbottomborder"><br><img src="http://mobile.1414intl.com/1414/images/1414small.png" alt="1414"><br><br></div>'. PHP_EOL;
		echo '<br><br><div align="center"><table><tr><td>' . PHP_EOL;
		echo '<div id="subdiv"><font style="font-size:24px;" color=black>Register</font><br><br><br></div>'. PHP_EOL;
		html_field('First Name', 2, 'fname', 'text', '');
		html_field('Last Name', 2, 'lname', 'text', '');
		html_field('Email', 2, 'email', 'text', '');
		html_field('Password', 2, 'password', 'password', '');
		html_tos_pp();
		echo '<br><div id="subdiv" align="center"><input type="image" name="submit" src="http://mobile.1414intl.com/1414/images/mobilebigjoinnow.png" border="0" alt="JoinNow"/></div>' . PHP_EOL;
		echo '</td></tr></table></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		return true;
	}
	function html_main() {
		echo '<!doctype html>' . PHP_EOL;
		echo '<html lang="en">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">' . PHP_EOL;
		echo '<meta charset="utf-8">' . PHP_EOL;
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . PHP_EOL;
		echo '<title>1414</title>' . PHP_EOL;
		echo '<meta name="description" content="1414 unlimited long distance calls, mobile or landline">' . PHP_EOL;
		echo '<meta name="viewport" content="width=device-width,initial-scale=1">' . PHP_EOL;
		echo '<meta property="og:title" content="1414">' . PHP_EOL;
		echo '<meta property="og:type" content="website">' . PHP_EOL;
		echo '<meta property="og:description" content="1414 unlimited long distance calls, mobile or landline">' . PHP_EOL;
		echo '<meta property="og:image" content="http://mobile.1414intl.com/1414/images/1414bg.png">' . PHP_EOL;
		echo '<meta property="og:url" content="http://mobile.1414intl.com/">' . PHP_EOL;
		echo '<!--[if lt IE 9]>' . PHP_EOL;
		echo '<script src="1414/script/html5shiv.min.js"></script>' . PHP_EOL;
		echo '<![endif]-->' . PHP_EOL;
		echo '<link rel="stylesheet" href="http://mobile.1414intl.com/1414/style/1414.css" />' . PHP_EOL;
		js_join();
		echo '</head>' . PHP_EOL;
		echo '<body>' . PHP_EOL;
		main_screen();
		echo '</body>' . PHP_EOL;
		echo '</html>' . PHP_EOL;
	}
	html_main();
?>
