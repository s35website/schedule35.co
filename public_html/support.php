<?php
	/**
	* Support
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: support.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$p = sanitize($_GET['p'],100);

	if ($p == "email-whitelist") {
		$pagename = "Whitelisting Schedule35.com";
	}elseif ($p == "email-whitelist-yahoo") {
		$pagename = "Whitelist Yahoo";
	}else {
		$pagename = 'Support';
	}
?>
<?php require_once (THEMEDIR . "/support.tpl.php");?>
