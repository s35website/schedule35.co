<?php
	/**
	* 404
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2010
	* @version $Id: 404.php, v2.00 2011-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	$latest = $item->getLatestProducts();
	
	$pagename = "404 Error";
?>
<?php require_once (THEMEDIR . "/404.tpl.php");?>