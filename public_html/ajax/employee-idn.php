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

if (isset($_POST['employee_idn']) and !empty($_POST['employee_idn'])) {

	$discount_code = sanitize($_POST['employee_idn']);
	$xrow = $db->first("SELECT shipping FROM wholesale_extras WHERE user_id = '" . $db->escape($user->username) . "'");

	$shipping = $xrow->shipping;

	// Get information regarding cart
	$crow = $db->first("SELECT sum(price*qty) as ptotal, sum(points) as totalpoints, COUNT(*) as itotal FROM wholesale_cart WHERE user_id = '" . $db->escape($user->username) . "'");

	// Get information regarding specific coupon code
	$cprow = $db->first("SELECT discount, type, minval, used, maxusage, code, validuntil,coupon_applied_on,product_list FROM employee_idn WHERE valid_users like '%" . $db->escape($user->username) . "%' AND active = '1'");
	
	
	$today = date("Y-m-d");
	$tax = Content::calculateTax($state);

	if ($cprow) {
	
		unset ($_SESSION["ambcode"]);
		// Check to see if coupon has already been used
		if ($cprow->used >= $cprow->maxusage && $cprow->maxusage != NULL && $cprow->maxusage != 0) {
			$json['coupon'] = "<span class=\"warning label\">The discount has expired.</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'The discount has expired.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if minimum purchase value is enough
		elseif ($cprow->minval > $crow->ptotal) {
			$json['coupon'] = "<span class=\"warning label\">" . str_replace("[TOTAL]", $core->formatMoney($cprow->minval) , Lang::$word->CKO_DISC_E1) . "</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . str_replace("[TOTAL]", $core->formatMoney($cprow->minval) , Lang::$word->CKO_DISC_E1) . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		// Check to see if coupon has expired
		elseif ($cprow->validuntil < $today) {
			$json['coupon'] = "<span class=\"warning label\">The discount has expired.</span>";
			$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'The discount has expired.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
		}
		elseif ( $cprow->coupon_applied_on == 1){
			$product_list = !empty($cprow->product_list) ? explode(',', $cprow->product_list) : array();
			$cart_product_ids = $db->fetch_all("SELECT pid,price,qty FROM wholesale_cart WHERE user_id = '" . $db->escape($user->username) . "'");
			$disAmount = 0;
			$json['discount_amount'] = array();
			foreach ($cart_product_ids as $cart_product_id) {
				if(in_array($cart_product_id->pid, $product_list)){
					$qty = $cart_product_id->qty;
					
					
					if ($cprow->type == 0) {
						$json['discount_amount'][$cart_product_id->pid] = number_format($cart_product_id->price - (($cart_product_id->price * $cprow->discount) / 100),2);
						$p_dis = $qty * (number_format($cart_product_id->price / 100 * $cprow->discount, 2));
					}else {
						if($cprow->discount >= $cart_product_id->price ){
							$p_dis = $cart_product_id->price;
						}else{
							$p_dis = number_format($cprow->discount, 2);
						}
						$json['discount_amount'][$cart_product_id->pid] = number_format($cart_product_id->price - $p_dis,2);
						$p_dis = $qty * $p_dis;
					}
					
					$disAmount = $disAmount + $p_dis;
				}
			}
			
			
			//Add discount amount
			if($disAmount > 0){
				
				//Product Discount
				$couponAmount = $disAmount;
				
				//Grand total
				$gtotal = $crow->ptotal;
				
				if ($shipping == $core->shipping_standard && $crow->ptotal > $core->shipping_free_flag) {
					$shipping = 0;
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
					'user_id' => $user->username,
					'discount_code' => $discount_code,
					'coupon' => $couponAmount,
					'originalprice' => $crow->ptotal,
					'tax' => $tax,
					'totaltax' => $totaltax,
					'total' => $total,
					'shipping' => $shipping,
					'totalprice' => $totalprice,
					'points' => 0,
					'created' => "NOW()"
				);
				
				$db->update("wholesale_extras", $xdata, "user_id ='" . $user->username . "'");
				
				$json['type'] = "success";
				$json['discount_type'] = "product";
				$json['gtotal'] = $core->formatMoney($xdata['totalprice'], false);
				$json['tax'] = $core->formatMoney($xdata['totaltax'], false);
				$json['subt'] = $core->formatMoney($xdata['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($couponAmount, false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Coupon code has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'This coupon code cannot be applied to the added products.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
				
		}
		else {
		
			if( $cprow->coupon_applied_on == 0){
			
			
				if ($cprow->type == 0) {
					$couponAmount = number_format($crow->ptotal * $cprow->discount / 100, 2);
				}else {
					$couponAmount = number_format($cprow->discount, 2);
                }
				$gtotal = $crow->ptotal;
				
				if ($shipping == $core->shipping_standard && $crow->ptotal > $core->shipping_free_flag) {
					$shipping = 0;
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
					'user_id' => $user->username,
					'discount_code' => $discount_code,
					'coupon' => $couponAmount,
					'originalprice' => $crow->ptotal,
					'tax' => $tax,
					'totaltax' => $totaltax,
					'total' => $total,
					'shipping' => $shipping,
					'totalprice' => $totalprice,
					'points' => 0,
					'created' => "NOW()"
				);

				$db->update("wholesale_extras", $xdata, "user_id ='" . $user->username . "'");
				
				
				$json['type'] = "success";
				$json['gtotal'] = $core->formatMoney($xdata['totalprice'], false);
				$json['pointsearned'] = $xdata['points'] . " pts";
				$json['tax'] = $core->formatMoney($xdata['totaltax'], false);
				$json['subt'] = $core->formatMoney($xdata['originalprice'], false);
				$json['ctotal'] = $core->formatMoney($couponAmount, false);
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Discount has been applied to checkout.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'An error occurred while processing employee IDN.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
		}
	}else {
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'An error occurred while processing employee IDN.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
	}

	print json_encode($json);
}




?>
