<?php
	include '1414/utils/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	if ($detect->isMobile() && !$detect->isTablet()) {
		header('Location: http://mobile.1414intl.com/');
		exit(0);
	}
	function checkxvmark($val) {
		if($val == 'X') {
			return '<img src="http://1414intl.com/1414/images/markx.png"/>';
		}
		if($val == 'V') {
			return '<img src="http://1414intl.com/1414/images/vmark.png"/>';
		}
		return $val;
	}
	function planline($fontsize, $col1, $col2, $col3, $col4) {
		$col2 = checkxvmark($col2);
		$col3 = checkxvmark($col3);
		$col4 = checkxvmark($col4);
		echo '<tr>' . PHP_EOL;
		echo '<td align=left style="border-bottom: 1px solid #FF3385; padding:14px"><font size=3 color=black>' . $col1 . '</font></td>' . PHP_EOL;
		echo '<td align=center style="border-bottom: 1px solid #FF3385; padding:14px"><font size=' . $fontsize . ' color=black>' . $col2 . '</font></td>' . PHP_EOL;
		echo '<td style="border-bottom: 1px solid #FF3385;">&nbsp;</td>' . PHP_EOL;
		echo '<td style="border-bottom: 1px solid #FF3385;" align=center style="padding:14px"><font size=' . $fontsize . ' color=black>' . $col3 . '</font></td>' . PHP_EOL;
		echo '<td style="border-bottom: 1px solid #FF3385;">&nbsp;</td>' . PHP_EOL;
		echo '<td align=center style="border-bottom: 1px solid #FF3385; padding:14px"><font size=' . $fontsize . ' color=black>' . $col4 . '</font></td>' . PHP_EOL;
		echo '</tr>' . PHP_EOL;
		return 0;
	}
	function plans() {
		echo '<div class="inner">' . PHP_EOL;
		echo '<div id="bardiv"><br><br>' . PHP_EOL;
		echo '<div style="font-size:40px;" align=center><font color=black>Plans</font></div>' . PHP_EOL;
		echo '<br><br></div>' . PHP_EOL;
		echo '<div align=center>' . PHP_EOL;
		echo '<div align="center" style="background-color:#F9F8F9; padding:10px;"><table bgcolor="#F9F8F9" style="padding:10px;"><tr>' . PHP_EOL;
		echo '<td width="360">&nbsp;</td>' . PHP_EOL;
		echo '<td width="110" height="60" bgcolor=#FF3385 style="vertical-align:middle; padding:20px;" align=center><font size=5>In</font></td>' . PHP_EOL;
		echo '<td width="50">&nbsp;</td>' . PHP_EOL;
		echo '<td width="110" height="60" bgcolor=#FF3385 style="vertical-align:middle; padding:20px;" align=center><font size=5>Out</font></td>' . PHP_EOL;
		echo '<td width="50">&nbsp;</td>' . PHP_EOL;
		echo '<td width="110" height="60" bgcolor=#FF3385 style="vertical-align:middle; padding:20px;" align=center><font size=5>Complete</font></td>' . PHP_EOL;
		echo '</tr>' . PHP_EOL;
		planline(3, 'Price after free month', '$1.98', '$2.98', '$3.98');
		planline(3, 'Unlimited incoming calls', 'V', 'X', 'V');
		planline(3, 'Unlimited calls land line or mobile', 'X', 'V', 'V');
		planline(3, 'Call back to the caller ID' ,'X', 'X', 'V'); 
		planline(3, 'Local and remote number' , 'V', 'X', 'V');
		planline(3, 'Use your phone when visiting' , 'V', 'V', 'V');
		planline(3, 'Cancel anytime online' , 'V', 'V', 'V');
		echo '</table></div>' . PHP_EOL;
		echo '<div align=center style="background-color:#F9F8F9;"><a href="#options" class="scroll"></a></div>' . PHP_EOL;
		return 0;
	}
	function groups() {
		echo '<div class="inner">' . PHP_EOL;
		echo '<div id="bardiv"><br><br>' . PHP_EOL;
		echo '<div style="font-size:40px;" align=center><font color=black>Demo</font></div>' . PHP_EOL;
		echo '<br><br></div>' . PHP_EOL;
		echo '<div align=center>' . PHP_EOL;
		echo '<table style="border: 2px solid #FF3385; align: center;"><tr><td style="padding: 1px;">' . PHP_EOL;
		echo '<iframe width="720" height="500" src="http://www.youtube.com/embed/yHL780N3iDI?autoplay=0"></iframe> '. PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '<div align=center style="background-color:#F9F8F9;"><a href="#methods" class="scroll"></a></div>' . PHP_EOL;
		return 0;
	}
	function how_does_it_work() {
		echo '<div class="inner" align="center">' . PHP_EOL;
		echo '<div id="bardiv"><br><br>' . PHP_EOL;
		echo '<div style="font-size:40px;" align=center><font color=black>How Does It Work</font></div>' . PHP_EOL;
		echo '<br><br></div>' . PHP_EOL;
		echo '<div align=center>' . PHP_EOL;
		echo '<table>' . PHP_EOL;
		echo '<tr><td style="padding: 10px;">' . PHP_EOL;
		echo '<div align=left id="div_oval" name="div_oval" style="font-size:15px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Join To 1414</font><br>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;No Credit Card needed, use PayPal</font><br>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Just your email and name</font><br>' . PHP_EOL;
		echo '<br><div align=center><a href="http://1414intl.com/join"><img src="http://1414intl.com/1414/images/joinnow.png"></img></div></a>' . PHP_EOL;
		echo '</div></td><td>' . PHP_EOL;
		echo '<div align=left id="div_oval" name="div_oval" style="font-size:15px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Purchase a device it is only $49.89</font><br><br>' . PHP_EOL;
		echo '<font color=black>&nbsp;Connect the device to your home modem</font><br><br>' . PHP_EOL;
		echo '<font color=black>&nbsp;Pair the phone and the device with bluetooth</font><br><br>' . PHP_EOL;
		echo '<div align=center><a href="http://1414intl.com/join"><img src="http://1414intl.com/1414/images/rpi.png"></div></img></a>' . PHP_EOL;
		echo '</div></td></tr>' . PHP_EOL;
		echo '<tr><td>' . PHP_EOL;
		echo '<div align=left id="div_oval" name="div_oval" style="font-size:15px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Send The Device To Your Family</font>' . PHP_EOL;
		echo '<br><br><font color=black>&nbsp;Or we will send it for standard shipping rates</font>' . PHP_EOL;
		echo '<br><br><br><br><div align=center><a href="http://1414intl.com/join"><img src="http://1414intl.com/1414/images/mailbird.png"></img></a></div></div><br></td>' . PHP_EOL;
		echo '<td><div align=left id="div_oval" name="div_oval" style="font-size:15px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Buy a mobile phone plan in your Country</font>' . PHP_EOL;
		echo '<br><br><font color=black>&nbsp;Unlimited talk from your old phone</font>' . PHP_EOL;
		echo '<br><br><font color=black>&nbsp;Or buy a 2G phone for only $24.98</font>' . PHP_EOL;
		echo '<br><br><div align=center><a href="http://1414intl.com/join"><img src="http://1414intl.com/1414/images/nokia.png"></img></a></div></div><br></td></tr></table></div>' . PHP_EOL;
		echo '<div align=center><a href="#configuration" class="scroll"></a></div>' . PHP_EOL;
		return true;
	}
	function demo() {
		echo '<div class="inner">' . PHP_EOL;
		echo '<div id="bardiv"><br><br>' . PHP_EOL;
		echo '<div style="font-size:40px;" align=center><font color=black>Demo</font></div>' . PHP_EOL;
		echo '<br><br></div><br>' . PHP_EOL;
		echo '<div align=center>' . PHP_EOL;
		echo '<table style="border: 2px solid #FF3385; align: center;"><tr><td style="padding: 1px;">' . PHP_EOL;
		echo '<iframe width="720" height="500" src="http://www.youtube.com/embed/yHL780N3iDI?autoplay=0"></iframe> '. PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		echo '</div></div>' . PHP_EOL;
	}
	function sign_in_screen() {
		echo '<div align=center><br><br>' . PHP_EOL;
		echo '<table width="100%"><tr><td>' . PHP_EOL;
		echo '<div align=left><br><a href="http://1414intl.com/"><img src="1414/images/1414BigIconPrecise.png" alt="1414"></a></div>' . PHP_EOL;
		echo '</td><td align="right">' . PHP_EOL;
		echo '<div><br><a href="login"><img src="1414/images/signin.png" alt="SignIn"/></a></div>' . PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		echo '<div style="text-shadow: -1px 0 black, 0 2px black, 2px 0 black, 0 -1px black;">' . PHP_EOL;
		echo '<font color=white size=6>Unlimited long distance calls<br>Landline or Mobile</font></div>' . PHP_EOL;
		echo '<div><br><a href="join"><img src="1414/images/joinnow.png" alt="JoinNow"/></a></div>' . PHP_EOL;
		echo '</div></div>' . PHP_EOL;
		echo '<div>' . PHP_EOL;
		return true;
	}
	function main_screen() {
		echo '<table height="1200" width="100%"  border=1><tr><td valign=top style="background-image:url(http://1414intl.com/1414/images/phone_booth.jpg);background-repeat:no-repeat;">' . PHP_EOL;
		sign_in_screen();
		echo '</td></tr><tr><td height=500 style="background-image:url(http://1414intl.com/1414/images/phone_booth.jpg);background-repeat:no-repeat;">' . PHP_EOL;
		how_does_it_work();
		echo '</td></tr></table>' . PHP_EOL;
		generate_spaces(2);
		echo '<a href="1414/pp.php">privacy policy</a><font color=#808080> | </font> <a href="1414/tos.php">Terms of Service</a><br><br></div>' . PHP_EOL;
		return true;
	}
//	session_start();
?>
<!doctype html>
<html lang="en">
<head>
<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>1414</title>
<meta name="description" content="1414 unlimited long distance calls, mobile or landline">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta property="og:title" content="1414">
<meta property="og:type" content="website">
<meta property="og:description" content="1414 unlimited long distance calls, mobile or landline">
<meta property="og:image" content="http://1414intl.com/1414/images/1414bg.png">
<meta property="og:url" content="http://1414intl.com/">
<!--[if lt IE 9]>
<script src="1414/script/html5shiv.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="http://1414intl.com/1414/style/1414.css" />
</head>
<body>
<section class="panel home" data-section-name="home">
<div class="inner">
<?php sign_in_screen(); ?>
<a href="#overview" class="scroll"></a>
</div>
</section>
<section class="panel overview" data-section-name="overview">
<?php how_does_it_work(); ?>
<?php /* Connect 1414 device to your phone via Bluetooth, Make phone calls via the number that 1414 will supply to you, Receive phone calls to the number that you configured */?>
</section>
<section class="panel configuration" data-section-name="configuration">
<?php plans(); ?>
</section>
<section class="panel options" data-section-name="options">
<?php groups(); ?>
</section>
<section class="panel methods" data-section-name="methods">
<?php demo(); ?>
</section>
<script src="http://1414intl.com/1414/script/jquery-1.6.js"></script>
<!--<script src="script/jquery-2.1.1.js"></script>-->
<!--<script src="script/jquery-1.11.1.js"></script>-->
<script src="http://1414intl.com/1414/script/jquery.scrollify.js"></script>
<script src="http://1414intl.com/1414/script/main.js"></script>
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','http://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-50992962-1', 'lukehaas.me');
ga('send', 'pageview');</script>
</body>
</html>
<?php
/*
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" style="height: 100%;">
	<head>
		<title>1414</title>
		<link rel="icon" href="favicon.png" type="image/png" sizes="16x16">
		<link rel="stylesheet" type="text/css" href="1414/1414.css">
	</head>
	<body style="height: 100%;">
		if ($_SESSION['FBID']) {
			 main_customer_operator($_SESSION['FBID'], $_SESSION['FULLNAME'], $_SESSION['EMAIL']);
		}
		if(!$_SESSION['FBID']) { 
			main_screen();
		}
  </body>
</html>*/?>
