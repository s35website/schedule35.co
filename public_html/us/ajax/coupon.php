<?php
/**
 * Coupon
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2014
 * @version $Id: coupon.php, v3.00 2014-07-10 10:12:05 gewa Exp $
 */
define("_VALID_PHP", true);
require_once ("../init.php");

?>
<?php

if (isset($_POST['discount_code']) and !empty($_POST['discount_code'])) {

	$discount_code = sanitize($_POST['discount_code']);
	$xrow = $db->first("SELECT shipping, state FROM " . Content::exTable . " WHERE user_id = '" . $db->escape($user->username) . "'");

	$shipping = $xrow->shipping;

	// Get information regarding cart
	$cart_row = $db->first("SELECT sum(price*qty) as ptotal, sum(points) as totalpoints, COUNT(*) as itotal FROM " . Content::crTable . " WHERE user_id = '" . $db->escape($user->username) . "'");

	// Get information regarding specific coupon code
	$coupon_row = $db->first("SELECT discount, type, minval, used, maxusage, code, validuntil, coupon_applied_on,product_list FROM " . Content::cpTable . " WHERE code = '" . $db->escape($discount_code) . "' AND active = '1'");
	
	$ucprow = $db->first("SELECT payout FROM " . Users::uTable . " WHERE invite_code = '" . $db->escape($discount_code) . "'");

	$today = date("Y-m-d");
	$discount_points = $cart_row->totalpoints;
	$tax = Content::calculateTax($xrow->state);

	if ($coupon_row) {
	
		unset ($_SESSION["ambcode"]);
		
		// Check to see if coupon has already been used
		if ($coupon_row->used >= $coupon_row->maxusage && $coupon_row->maxusage != NULL && $coupon_row->maxusage != 0) {
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->CKO_DISC_E3 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if minimum purchase value is enough
		elseif ($coupon_row->minval > $cart_row->ptotal) {
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . str_replace("[TOTAL]", $core->formatMoney($coupon_row->minval) , Lang::$word->CKO_DISC_E1) . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if coupon has expired
		elseif ($coupon_row->validuntil < $today) {
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->CKO_DISC_E4 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		elseif ( $coupon_row->coupon_applied_on == 1){
			
			$invoiceArray = Content::calculateInvoice(null, 0, $discount_code);
			$discount_amount = $invoiceArray['coupon'];
			
			//Add discount amount
			if($discount_amount > 0){
				
				
				$json['type'] = "success";
				$json['gtotal'] = $core->formatMoney($invoiceArray['totalprice'], false);
				$json['pointsearned'] = $invoiceArray['points'] . " pts";
				$json['tax'] = $core->formatMoney($invoiceArray['totaltax'], false);
				$json['subt'] = $core->formatMoney($invoiceArray['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($invoiceArray['coupon'], false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'This promo code cannot be applied to the added products.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
				
		}
		else {
		
			if( $coupon_row->coupon_applied_on == 0){
			
				$invoiceArray = Content::calculateInvoice(null, 0, $discount_code);
				
				$json['type'] = "success";
				$json['gtotal'] = $core->formatMoney($invoiceArray['totalprice'], false);
				$json['pointsearned'] = $invoiceArray['points'] . " pts";
				$json['tax'] = $core->formatMoney($invoiceArray['totaltax'], false);
				$json['subt'] = $core->formatMoney($invoiceArray['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($invoiceArray['coupon'], false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'An error occurred while processing your promo code.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
		}
	}
	
	
	elseif ($ucprow) {
		
		$invoiceArray = Content::calculateInvoice(null, 0, $discount_code);
		
		
		$json['type'] = "success";
		$json['gtotal'] = $core->formatMoney($invoiceArray['totalprice'], false);
		$json['pointsearned'] = $invoiceArray['points'] . " pts";
		$json['tax'] = $core->formatMoney($invoiceArray['totaltax'], false);
		$json['subt'] = $core->formatMoney($invoiceArray['originalprice'], false);
		$json['ctotal'] = $core->formatMoney($invoiceArray['coupon'], false);
		
		
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
	}
	
	else {
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code invalid.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
	}

	print json_encode($json);
}




?>
