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
	
	if (!$user->logged_in)
	  redirect_to("login");
	  
	  
	include ('gateways/paypal/pdt.php');
	
	$receiptid = $_GET['tx'];
	$receiptInvoice = $item->getReceiptInvoice($receiptid);
	$receiptProducts = $item->getReceiptProducts($receiptid);
	
	if (!$receiptid) {
		redirect_to("cart");
	}
	
	$pagename = 'Receipt';
  
?>
<?php require_once (THEMEDIR . "/receipt.tpl.php");?>