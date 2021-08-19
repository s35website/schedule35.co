<?php
	/**
	* Category
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: category.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	$row = $content->getAllCategories();
	
	$pagename = "Shop";
?>
<?php require_once (THEMEDIR . "/shop.tpl.php");?>