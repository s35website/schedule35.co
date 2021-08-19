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

	$cartrow = $content->getCartContent(false);
	$cart = $content->getCart();

	$pagename = 'Your Cart';
?>
<?php require_once (THEMEDIR . "/cart.tpl.php");?>
