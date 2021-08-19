<?php
	/**
	* Register
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2010
	* @version $Id: register.php, v2.00 2011-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");


	if (isset($_SESSION['pageurl'])) {
		$url =   sanitize($_SESSION["pageurl"]);
	}else {
		$url = "home";
	}

	if ($user->logged_in) {
		redirect_to($url);
	}

	$pagename = 'Register';

?>
<?php require_once (THEMEDIR . "/register.tpl.php");?>
