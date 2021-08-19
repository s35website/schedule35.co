<?php
	/**
	* Login
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: login.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");


	if (isset($_SESSION['pageurl'])) {
		$url = sanitize($_SESSION["pageurl"]);
		if ($url == "404") {
			$url = "home";
		}
	}else {
		$url = "home";
	}

	if ($user->logged_in) {
		redirect_to($url);
	}

	if (isset($_POST['doLogin'])) {
		$result = $user->login($_POST['username'], $_POST['password']);
	}

	if ($result) {
		$user->autoLoggedin($_POST['username'], $_POST['remember_me']);
		redirect_to($url);
	}

	$pagename = 'Login';

?>
<?php require_once (THEMEDIR . "/login.tpl.php");?>
