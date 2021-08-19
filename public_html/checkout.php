<?php
	/**
	* Checkout
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: checkout.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	$_SESSION["pageurl"] = "shipping";
	
	if (!$user->logged_in)
		redirect_to("register");
	
	$cartrow = $content->getCartContent();
	
	if (!$cartrow) {
		redirect_to("cart");
	}

	$cart = $content->getCart();
	$row = $user->getUserData();
	
	$pagename = 'Checkout';
?>
<?php require_once (THEMEDIR . "/checkout.tpl.php");?>