<?php
	/**
	* Summary
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: summary.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	if (!$user->logged_in)
		redirect_to("login");
	
	$cartrow = $content->getCartContent();
	
	if (!$cartrow)
		redirect_to("cart");
	
	$cart = $content->getCart();
	$gaterow = $content->getGateways(true);
	$row = $user->getUserData();
?>
<?php require_once (THEMEDIR . "/summary.tpl.php");?>