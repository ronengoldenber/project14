<?php
	function checkxvmark($val) {
		if($val == 'X') {
			return '<img src="http://1414intl.com/1414/images/markx.png"/>';
		}
		if($val == 'V') {
			return '<img src="http://1414intl.com/1414/images/vmark.png"/>';
		}
		return $val;
	}
	function planline($col1, $col2, $col3, $col4) {
		$col2 = checkxvmark($col2);
		$col3 = checkxvmark($col3);
		$col4 = checkxvmark($col4);
		$color = '#FF3385';
		if($col1 == '') { 
			$color = 'F9F8F9';
		}
		echo '<tr>' . PHP_EOL;
		echo '<td align=left style="border-bottom: 1px solid ' . $color . '; padding:2px; font-size:14px; color: black;">' . $col1 . '</td>' . PHP_EOL;
		echo '<td align=center style="border-bottom: 1px solid ' . $color .'; padding:2px; font-size:20px; color: black;">' . $col2 . '</td>' . PHP_EOL;
		echo '<td style="border-bottom: 1px solid ' . $color . ';">&nbsp;</td>' . PHP_EOL;
		echo '<td align=center style="border-bottom: 1px solid ' . $color . '; padding:2px; font-size:20px; color:black;">' . $col3 . '</td>' . PHP_EOL;
		echo '<td style="border-bottom: 1px solid ' . $color . ';">&nbsp;</td>' . PHP_EOL;
		echo '<td align=center style="border-bottom: 1px solid ' . $color . '; padding:2px; font-size:20px; color:black;">' . $col4 . '</td>' . PHP_EOL;
		echo '</tr>' . PHP_EOL;
		return 0;
	}
	function plans() {
		echo '<div class="inner">' . PHP_EOL;
		echo '<div id="bardiv"><br><br>' . PHP_EOL;
		echo '<div style="font-size:40px;" align=center><font color=black>Plans</font></div>' . PHP_EOL;
		echo '<br><br></div>' . PHP_EOL;
		echo '<div align=center>' . PHP_EOL;
		echo '<div align="center" style="background-color:#F9F8F9; padding:8px;"><table bgcolor="#F9F8F9" style="padding:8px;"><tr>' . PHP_EOL;
		echo '<td width="360">&nbsp;</td>' . PHP_EOL;
		echo '<td width="40" height="14" bgcolor=#FF3385 style="vertical-align:middle; padding:14px;" align=center><font size=3>Out</font></td>' . PHP_EOL;
		echo '<td width="4">&nbsp;</td>' . PHP_EOL;
		echo '<td width="40" height="14" bgcolor=#FF3385 style="vertical-align:middle; padding:14px;" align=center><font size=3>In</font></td>' . PHP_EOL;
		echo '<td width="4">&nbsp;</td>' . PHP_EOL;
		echo '<td width="110" height="14" bgcolor=#FF3385 style="vertical-align:middle; padding:14px;" align=center><font size=3>Complete</font></td>' . PHP_EOL;
		echo '</tr>' . PHP_EOL;
		planline('','','','');
		planline('Price after month', '$1.98', '$1.98', '$2.98');
		planline('Unlimited incoming', 'X', 'V', 'V');
		planline('Unlimited calls', 'V', 'X', 'V');
		planline('Caller ID' ,'X', 'X', 'V'); 
		planline('Local number' , 'X', 'V', 'V');
		planline('Visiting phone' , 'V', 'V', 'V');
		planline('Cancel online' , 'V', 'V', 'V');
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
		echo '<iframe width="300" height="300" src="http://www.youtube.com/embed/yHL780N3iDI?autoplay=0"></iframe> '. PHP_EOL;
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
		echo '<div align=center style="padding:10px;">' . PHP_EOL;
		echo '<br><div align=left id="div_moval" name="div_moval" style="font-size:14px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Register To 1414</font>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;No Credit Card needed, we do prepaid</font>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Just your email and name</font><br>' . PHP_EOL;
		echo '</div><br>' . PHP_EOL;
		echo '<div align=left id="div_moval" name="div_moval" style="font-size:14px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Purchase a device it is only $49.89</font><br>' . PHP_EOL;
		echo '<font color=black>&nbsp;Connect the device to your home modem</font><br>' . PHP_EOL;
		echo '<font color=black>&nbsp;Pair the phone and the device with bluetooth</font><br>' . PHP_EOL;
		echo '</div><br>' . PHP_EOL;
		echo '<div align=left id="div_moval" name="div_moval" style="font-size:14px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Send The Device To Your Family</font>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Or we will send it for standard shipping rates</font>' . PHP_EOL;
		echo '</div><br>' . PHP_EOL;
		echo '<div align=left id="div_moval" name="div_moval" style="font-size:14px;">' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Buy a mobile phone plan in your Country</font>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Unlimited talk and text from your old phone</font>' . PHP_EOL;
		echo '<br><font color=black>&nbsp;Or buy a 2G phone for only $24.98</font>' . PHP_EOL;
		echo '<br></div></div>' . PHP_EOL;
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
		echo '<iframe width="300" height="300" src="http://www.youtube.com/embed/yHL780N3iDI?autoplay=0"></iframe> '. PHP_EOL;
		echo '</td></tr></table>' . PHP_EOL;
		echo '</div></div>' . PHP_EOL;
	}
	function sign_in_screen() {
		echo '<div align=center><br>' . PHP_EOL;
		echo '<div align=left><a href="http://1414intl.com/"><img src="http://1414intl.com/1414/images/1414sm.png" alt="1414"></a></div>' . PHP_EOL;
		echo '<br><br><br><div>' . PHP_EOL;
		echo '<font color=white size=4>Unlimited long distance calls<br>Landline or Mobile</font></div>' . PHP_EOL;
		echo '<div><br><a href="http://1414intl.com/login"><img src="http://1414intl.com/1414/images/signin.png" alt="SignIn"/></a></div>' . PHP_EOL;
		echo '</div></div>' . PHP_EOL;
		echo '<div>' . PHP_EOL;
		return true;
	}
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
<section class="panel homemobile" data-section-name="homemobile">
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
