<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: faqs.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$faqrow = $content->getFaq();

	$pagename = "FAQs";
?>
<?php require_once (THEMEDIR . "/faqs.tpl.php");?>
