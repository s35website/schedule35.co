<?php
	/**
	* Account Profile
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: profile.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	$p = sanitize($_GET['p'],100);

	if ($p == "orders") {
		$pagename = "Order History";
		$_SESSION["pageurl"] = "profile?p=orders";
	}elseif ($p == "notifications") {
		$pagename = "Notifications";
		$_SESSION["pageurl"] = "profile?p=notifications";
	}elseif ($p == "referrals") {
		$pagename = "Invite a Friend";
		$_SESSION["pageurl"] = "profile?p=referrals";
	}elseif ($p == "points") {
		$pagename = "Points Wallet";
		$_SESSION["pageurl"] = "profile?p=points";
	}else {
		$pagename = 'Account Details';
		$_SESSION["pageurl"] = "profile?p=details";
	}
	
	if (!$user->logged_in)
		redirect_to("login");
?>
<?php require_once (THEMEDIR . "/profile.tpl.php");?>
