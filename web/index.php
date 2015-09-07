<?php
	include 'backend/main.php';
	function main_screen() {
		echo '<div id="div_main">' . PHP_EOL;
		echo '<div><br>&nbsp;&nbsp;&nbsp;<a href="http://1414intl.com/"><img src="1414/images/1414bg.png" alt="1414"></a></div>' . PHP_EOL;
		echo '<div style="text-shadow: -1px 0 black, 0 2px black, 2px 0 black, 0 -1px black;"><br><br><br><font color=white size=16>&nbsp;&nbsp;&nbsp;Unlimited long distance calls<br>&nbsp;&nbsp;&nbsp;Landline or Mobile</font></div>' . PHP_EOL;
		echo '<div><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login"><img src="1414/images/signin.png" alt="SignIn"/></a></div>' . PHP_EOL;
		echo '</div></div>' . PHP_EOL;
		echo '<div>' . PHP_EOL; 
		generate_spaces(2);
		echo '<a href="1414/pp.php">privacy policy</a><font color=#808080> | </font> <a href="1414/tos.php">Terms of Service</a><br><br></div>' . PHP_EOL;
		return 0;
	}
	session_start();
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" style="height: 100%;">
	<head>
		<title>1414</title>
		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
		<link rel="stylesheet" type="text/css" href="1414/1414.css">
	</head>
	<body style="height: 100%;">
	<?php 
		if ($_SESSION['FBID']) {
			 main_customer_operator($_SESSION['FBID'], $_SESSION['FULLNAME'], $_SESSION['EMAIL']);
		}
		if(!$_SESSION['FBID']) { 
			main_screen();
		}
	?>
  </body>
</html>
