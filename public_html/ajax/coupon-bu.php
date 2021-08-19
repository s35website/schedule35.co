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
	$xrow = $db->first("SELECT shipping, state FROM " . Content::exTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'");

	$shipping = $xrow->shipping;

	// Get information regarding cart
	$crow = $db->first("SELECT sum(price*qty) as ptotal, sum(points) as totalpoints, COUNT(*) as itotal FROM " . Content::crTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'");

	// Get information regarding specific coupon code
	$cprow = $db->first("SELECT discount, type, minval, used, maxusage, code, validuntil,coupon_applied_on,product_list FROM " . Content::cpTable . " WHERE code = '" . $db->escape($discount_code) . "' AND active = '1'");
	
	$ucprow = $db->first("SELECT payout FROM " . Users::uTable . " WHERE invite_code = '" . $db->escape($discount_code) . "'");

	$today = date("Y-m-d");
	$disPoints = $crow->totalpoints;
	$tax = Content::calculateTax($xrow->state);

	if ($cprow) {
	
		unset ($_SESSION["ambcode"]);
		
		// Check to see if coupon has already been used
		if ($cprow->used >= $cprow->maxusage && $cprow->maxusage != NULL && $cprow->maxusage != 0) {
			$json['coupon'] = "<span class=\"warning label\">" . Lang::$word->CKO_DISC_E3 . "</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->CKO_DISC_E3 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if minimum purchase value is enough
		elseif ($cprow->minval > $crow->ptotal) {
			$json['coupon'] = "<span class=\"warning label\">" . str_replace("[TOTAL]", $core->formatMoney($cprow->minval) , Lang::$word->CKO_DISC_E1) . "</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . str_replace("[TOTAL]", $core->formatMoney($cprow->minval) , Lang::$word->CKO_DISC_E1) . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if coupon has expired
		elseif ($cprow->validuntil < $today) {
			$json['coupon'] = "<span class=\"warning label\">" . Lang::$word->CKO_DISC_E4 . "</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->CKO_DISC_E4 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		elseif ( $cprow->coupon_applied_on == 1){
			$product_list = !empty($cprow->product_list) ? explode(',', $cprow->product_list) : array();
			$cart_product_ids = $db->fetch_all("SELECT pid,price,qty FROM " . Content::crTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'");
			$disAmount = 0;
			$json['discount_amount'] = array();
			foreach ($cart_product_ids as $cart_product_id) {
				if(in_array($cart_product_id->pid, $product_list)){
					$qty = $cart_product_id->qty;
					
					
					if ($cprow->type == 0) {
						$json['discount_amount'][$cart_product_id->pid] = number_format($cart_product_id->price - (($cart_product_id->price * $cprow->discount) / 100),2);
						$p_dis = $qty * (number_format($cart_product_id->price / 100 * $cprow->discount, 2));
						$disPoints = $crow->totalpoints - ($crow->totalpoints * $cprow->discount / 100);
					}else {
						if($cprow->discount >= $cart_product_id->price ){
							$p_dis = $cart_product_id->price;
						}else{
							$p_dis = number_format($cprow->discount, 2);
						}
						$json['discount_amount'][$cart_product_id->pid] = number_format($cart_product_id->price - $p_dis,2);
						$p_dis = $qty * $p_dis;
						$disPoints = $crow->totalpoints - $cprow->discount;
					}
					
					$disAmount = $disAmount + $p_dis;
				}
			}
			
			
			//Add discount amount
			if($disAmount > 0){
				
				//Product Discount
				$couponAmount = $disAmount;
				
				//Grand total
				$gtotal = number_format($crow->ptotal, 2);
				
				if ($shipping == $core->shipping_standard && $crow->ptotal > $core->shipping_free_flag) {
					$shipping = "0.00";
				}
				
				if (($gtotal + $shipping) > $couponAmount) {
					$total = max($gtotal - $couponAmount,0) + $shipping;
				}
				else {
					$total = 0;
				}
				
				$totaltax = $total * $tax;
				$totalprice = $total + $totaltax;
				$xdata = array(
					'user_id' => $user->sesid,
					'discount_code' => $discount_code,
					'coupon' => $couponAmount,
					'originalprice' => $crow->ptotal,
					'tax' => $tax,
					'totaltax' => $totaltax,
					'total' => $total,
					'shipping' => $shipping,
					'totalprice' => $totalprice,
					'points' => $disPoints,
					'created' => "NOW()"
				);
				
				$db->update(Content::exTable, $xdata, "user_id ='" . $user->sesid . "'");
				
				$json['type'] = "success";
				$json['discount_type'] = "product";
				$json['gtotal'] = $core->formatMoney($xdata['totalprice'], false);
				$json['tax'] = $core->formatMoney($xdata['totaltax'], false);
				$json['subt'] = $core->formatMoney($xdata['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($couponAmount, false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'This promo code cannot be applied to the added products.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
				
		}
		else {
		
			if( $cprow->coupon_applied_on == 0){
			
			
				if ($cprow->type == 0) {
					$couponAmount = number_format($crow->ptotal * $cprow->discount / 100, 2);
					$disPoints = $crow->totalpoints - ($crow->totalpoints * $cprow->discount / 100);
				}else {
					$couponAmount = number_format($cprow->discount, 2);
					$disPoints = $crow->totalpoints - $cprow->discount;
				}
				
				$gtotal = number_format($crow->ptotal, 2);
				
				if ($shipping == $core->shipping_standard && $crow->ptotal > $core->shipping_free_flag) {
					$shipping = "0.00";
				}
				
				if (($gtotal + $shipping) > $couponAmount) {
					$total = max($gtotal - $couponAmount,0) + $shipping;
				}
				else {
					$total = 0;
				}
				
				$totaltax = $total * $tax;
				$totalprice = $total + $totaltax;
				$xdata = array(
					'user_id' => $user->sesid,
					'discount_code' => $discount_code,
					'coupon' => $couponAmount,
					'originalprice' => $crow->ptotal,
					'tax' => $tax,
					'totaltax' => $totaltax,
					'total' => $total,
					'shipping' => $shipping,
					'totalprice' => $totalprice,
					'points' => $disPoints,
					'created' => "NOW()"
				);

				$db->update(Content::exTable, $xdata, "user_id ='" . $user->sesid . "'");
				
				
				$json['type'] = "success";
				$json['gtotal'] = $core->formatMoney($xdata['totalprice'], false);
				$json['pointsearned'] = $xdata['points'] . " pts";
				$json['tax'] = $core->formatMoney($xdata['totaltax'], false);
				$json['subt'] = $core->formatMoney($xdata['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($couponAmount, false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'An error occurred while processing your promo code.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
		}
	}
	
	
	elseif ($ucprow) {
		
		$couponAmount = number_format($crow->ptotal * ($core->payout - $ucprow->payout) / 100, 2);
		$disPoints = $crow->totalpoints - ($crow->totalpoints * ($core->payout - $ucprow->payout) / 100);
		
		$gtotal = number_format($crow->ptotal, 2);
		
		if ($shipping == $core->shipping_standard && $crow->ptotal > $core->shipping_free_flag) {
			$shipping = "0.00";
		}
		
		if (($gtotal + $shipping) > $couponAmount) {
			$total = max($gtotal - $couponAmount,0) + $shipping;
		}
		else {
			$total = 0;
		}
		
		$totaltax = $total * $tax;
		$totalprice = $total + $totaltax;
		$xdata = array(
			'user_id' => $user->sesid,
			'discount_code' => $discount_code,
			'coupon' => $couponAmount,
			'originalprice' => $crow->ptotal,
			'tax' => $tax,
			'totaltax' => $totaltax,
			'total' => $total,
			'shipping' => $shipping,
			'totalprice' => $totalprice,
			'points' => $disPoints,
			'payout' => $ucprow->payout,
			'created' => "NOW()"
		);

		$db->update(Content::exTable, $xdata, "user_id ='" . $user->sesid . "'");
		
		
		$json['type'] = "success";
		$json['gtotal'] = $core->formatMoney($xdata['totalprice'], false);
		$json['pointsearned'] = $xdata['points'] . " pts";
		$json['tax'] = $core->formatMoney($xdata['totaltax'], false);
		$json['subt'] = $core->formatMoney($xdata['originalprice'], false);
		$json['ctotal'] = $core->formatMoney($couponAmount, false);
		
		
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
	}
	
	else {
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Promo code invalid.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
	}

	print json_encode($json);
}




?>
