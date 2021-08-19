<?php
	/**
	* About
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: about.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$pagename = "About";
	
	$p = sanitize($_GET['p'],100);

	if ($p == "company") {
		$pagename = "Our Story";
	} elseif ($p == "mission") {
		$pagename = "Our Mission";
	} elseif ($p == "values") {
		$pagename = "Our Values";
	} elseif ($p == "microdosing") {
		$pagename = "Microdosing Guide";
	} elseif ($p == "bulk") {
		$pagename = "Bulk Pricing";
	} elseif ($p == "press") {
		$pagename = "Press";
	} elseif ($p == "contact") {
		$pagename = "Contact";
	} elseif ($p == "team") {
		$pagename = "Team";
	}elseif ($p == "points") {
		$pagename = "Points";
	}
	else {
		$pagename = "About Us";
	}
	
	$pagenameModifier =  "About";
?>
<?php require_once (THEMEDIR . "/about.tpl.php");?>
