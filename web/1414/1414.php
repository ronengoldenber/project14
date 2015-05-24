<?php
	define('FACEBOOK_SDK_V4_SRC_DIR', '/var/www/1414/facebook-php-sdk-v4-4.0-dev/src/Facebook/');
	require '/var/www/1414/facebook-php-sdk-v4-4.0-dev/autoload.php';
	// Make sure to load the Facebook SDK for PHP via composer or manually
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	FacebookSession::setDefaultApplication('1629113783967407', '29f23f2066632fd2f94a5bb1d5809297');
	// Add `use Facebook\FacebookRedirectLoginHelper;` to top of file
	$helper = new FacebookRedirectLoginHelper('www.1414intl.com');
	$loginUrl = $helper->getLoginUrl();
	// Use the login url on a link or button to 
	// redirect to Facebook for authentication
	// Add `use Facebook\FacebookRedirectLoginHelper;` to top of file
	$helper = new FacebookRedirectLoginHelper();
	try {
		$session = $helper->getSessionFromRedirect();
	} catch(FacebookRequestException $ex) {
		 // When Facebook returns an error
	} catch(\Exception $ex) {
		// When validation fails or other local issues
	}
	if ($session) {
	  try {
			$user_profile = (new FacebookRequest(
			$session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
			echo "Name: " . $user_profile->getName();
		} catch(FacebookRequestException $e) {
			echo "Exception occured, code: " . $e->getCode();
			echo " with message: " . $e->getMessage();
		}   
	}

/*	echo '<table border=1 width = "100%">' . PHP_EOL;
	echo '<tr>' . PHP_EOL;
	echo '<td align="center">service</td>' . PHP_EOL;
	echo '<td align="center">rates</td>' . PHP_EOL;
	echo '<td align="center">customers</td>' . PHP_EOL;
	echo '<td align="center">resellers</td>' . PHP_EOL;
	echo '</tr></table>' . PHP_EOL;
	
	echo '<br><br>' . PHP_EOL;
	echo '<table border = 1 width = "100%" height="100%">' . PHP_EOL;
	echo '<tr>' . PHP_EOL;
	echo '<td align = "center">facebook login</td>' . PHP_EOL;
	echo '</tr></table>' . PHP_EOL;*/
?>
