<?php
/**
 * Points IPN
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: ipn.php, 2010-08-10 21:12:05 gewa Exp $
 */
define("_VALID_PHP", true);

require_once ("../../init.php");

ini_set('log_errors', true);
ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

if (!$user->logged_in) redirect_to("../../index.php");

if (isset($_POST['processPointsPayment'])) {

	/* == User details == */
	$user_id = $user->uid;
	$username = $user->username;
	$usr = Core::getRowById(Users::uTable, $user_id);
	
	$cartrow = $content->getCartContent($username);
	
	/* Check to see if products in cart are still available */
	if (!$cartrow) {
		redirect_to("cart");
	}
	$errors = [];
	foreach ($cartrow as $row) {
	    $cartProduct = [
	        'productID' => (integer) $row->pid,
	        'quantity' => (integer) $row->qty,
	        'title' => $row->title,
	    ];
	    $productStock = $item->checkProductStock($cartProduct['productID']);
	    if ($productStock < $cartProduct['quantity']) {
	        $errors[] = $cartProduct['title'] . ' Out of stock';
		}
	}
	if (count($errors)) {
	    header('Location: ../../payment');
	    exit();
	}

	/* Calculate cost of cart */
	$amount = round($_POST['amount'] * 100, 0);
	$currency = $_POST['currency_code'];
	$receipt_email = $_POST['user_email'];
	$description = "Purchases: " . $_POST['item_name'];

	$mc_gross = round(($amount / 100) , 2);
	$txn_id = "BP" . $user_id . date("dmy") . date("his");

	$totalrow = Content::getCart($username);
	$cartquantity = count($cartrow);
	$gross = $totalrow->total - $totalrow->coupon;

	$v1 = number_format($gross, 2, '.', '');
	$v2 = number_format($mc_gross, 2, '.', '');

	// Get discount code from database
	$row_coupon = $db->first("SELECT * FROM " . Content::cpTable . " WHERE code = '" . $_POST['discount_code'] . "'");

	if ($row_coupon instanceof stdClass) {
        $data['used'] = $row_coupon->used + 1;
        $db->update(Content::cpTable, $data, "id='" . $row_coupon->id . "'");
	}

	if ($cartrow) {
		// Create variables to store items in cart
		$items = 0;
		$items_purchased = "";

		// For each item in the cart
		foreach ($cartrow as $crow) {
			$var_name = '';
			$var_price = $crow->price;
			if ($crow->pvid > 0) {
				$prd_var = $item->getProductVariants( $crow->pid, $crow->pvid );
				$var_name = ' (' . $prd_var[0]->title . ') ';
				$var_price = $prd_var[0]->price;
			}

			$pricerowtotal = $var_price * $crow->qty;
			$price = ($crow->pvid > 0 ? $crow->var_price : $crow->price);
			// Create transaction data for each product
			$data = array(
				'txn_id' => sanitize($txn_id),
				'pid' => $crow->pid,
				'pvid' => $crow->pvid,
				'uid' => intval($user_id),
				'ip' => sanitize($_SERVER['REMOTE_ADDR']),
				'created' => date("Y-m-d H:i:s"),
				'item_qty' => $crow->qty,
				'price' => round($price * 100, 0),
				'currency' => 'pts',
				'pp' => 'Points',
				'memo' => $crow->title,
				'status' => 1,
				'active' => 1
			);

			// $items[$crow->price] = $crow->title;
			$items = $items + $crow->qty;
			$db->insert(Products::tTable, $data);


			// Update product stock
			if($crow->pvid > 0){
			    $dosage = ($crow->qty * $crow->var_dosage);
			    $content->decreaseStock($crow->pid, $dosage);
			}else{
			    $dosage = $crow->qty;
			    $content->decreaseStock($crow->pid, $dosage);
			}
			/*$row_product = $db->first("SELECT * FROM " . Products::pTable . " WHERE id = '" . $crow->pid . "'");
			$newstock = $row_product->stock - $crow->qty;
			$pdata = array(
				'stock' => $newstock
			);
			$db->update(Products::pTable, $pdata, "id='" . $crow->pid . "'");*/


			//$pricerowtotal = $crow->price * $crow->qty;

			// Create table to be inserted inside HTML email
			$items_purchased .= '<tr>
				<td colspan="5" height="11" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; border-top: 1px solid #eaeff2;">
					<div class="clear" style="height: 11px; width: 1px;">&nbsp;</div>
				</td>
			</tr>
			<tr class="summary-item">
				<td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
					<div class="clear" style="height: 1px; width: 1px;"></div>
				</td>
				<td align="left" class="font-medium" style="border: 0; margin: 0; padding: 0; color: #292e31; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 17px;" width="100%">
					<span class="apple-override-dark" style="font-size: 14px; line-height: 17px;border: 0; margin: 0; padding: 0;color: #292e31 !important;">'.$crow->title. $var_name .' x '.$crow->qty.'</span>
				</td>
				<td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="10">
					<div class="clear" style="height: 1px; width: 10px;"></div>
				</td>
				<td align="right" class="font-medium" style="border: 0; margin: 0; padding: 0; color: #292e31; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 17px;" width="120">
					<span style="font-size: 14px; line-height: 17px;border: 0; margin: 0; padding: 0;color: #292e31 !important;">'.round($var_price * $crow->qty * 100, 0).' pts</span>
				</td>
				<td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
					<div class="clear" style="height: 1px; width: 1px;"></div>
				</td>
			</tr>
			<tr>
				<td colspan="5" height="12" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
					<div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
				</td>
			</tr>';
			
			
			
		}

		unset($crow);

		// Create data for invoice of total sale
		$xdata = array(
			'invid' => sanitize($txn_id),
			'user_id' => $user->uid,
			'items' => intval($items),
			'coupon' => round($totalrow->coupon * 100, 0),
			'discount_code' => $row_coupon->code,
			'originalprice' => round($totalrow->originalprice * 100, 0),
			'tax' => round($totalrow->tax * 100, 0),
			'totaltax' => round($totalrow->totaltax * 100, 0),
			'shipping' => round($totalrow->shipping * 100, 0),
			'total' => round($totalrow->total * 100, 0),
			'totalprice' => round($totalrow->totalprice * 100, 0),
			'currency' => 'pts',
			'created' => date("Y-m-d H:i:s"),
			'pp' => 'Points',
			'name' => $totalrow->name,
			'country' => $totalrow->country,
			'address' => $totalrow->address,
			'address2' => $totalrow->address2,
			'city' => $totalrow->city,
			'state' => $totalrow->state,
			'zip' => $totalrow->zip,
			'phone' => $totalrow->phone,
			'heatflag' => $totalrow->heatflag,
			'status' => '1',
			'points' => 0,
			'shipping_class' => $totalrow->shipping_type,
			'signature' => $totalrow->signature,
			'earninvite' => 1
		);

		


		$db->insert(Content::inTable, $xdata);

		$udata['purchases'] = $usr->purchases + 1;
		$udata['invites'] = $usr->invites + 1;
		
		$udata['points_current'] = $usr->points_current - round($totalrow->totalprice * 100, 0);
		
		$db->update(Users::uTable, $udata, "id='" . $user->uid . "'");
	}
	
	
	// Check if user wants to be notified of purchase
	$notifications = $db->fetch_all("SELECT * FROM " . Users::uTable . " WHERE username ='{$usr->username}' AND purchase_receipts = 1");
	
	if ($notifications) {
		// Setup email and variables for email
		require_once (BASEPATH . "lib/class_mailer.php");
	
		$subtotal = round($totalrow->originalprice * 100, 0);
		$shipping = round($totalrow->shipping * 100, 0);
	
		if ($totalrow->coupon > 0) {
			$coupon .= '<tr>
				<td colspan="5" height="11" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
					<div class="clear" style="height: 11px; width: 1px;">&nbsp;</div>
				</td>
			</tr>
			<tr class="summary-item">
				<td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
					<div class="clear" style="height: 1px; width: 1px;"></div>
				</td>
				<td style="font-size: 12px; line-height: 17px; font-weight: bold; border: 0; margin: 0; padding: 0; color: #292e31; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-weight: bold;text-align-right;" align="right" width="146">
					<span style="font-size: 12px; font-weight: bold; line-height: 17px;">Discount</span>
				</td>
				<td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="10">
					<div class="clear" style="height: 1px; width: 10px;"></div>
				</td>
				<td align="right" class="summary-total width" style="border: 0; margin: 0; padding: 0; color: #292e31; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold; line-height: 17px;" width="122">
					<span style="font-size: 12px; line-height: 17px;">('.round($totalrow->coupon * 100, 0).')</span>
				</td>
				<td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
					<div class="clear" style="height: 1px; width: 1px;"></div>
				</td>
			</tr>';
		}else {
			$coupon = '';
		}
	
	
		$totaltax = round($totalrow->totaltax*100, 0);
		$totalprice = round($totalrow->totalprice * 100, 0);
		
		
		// Send email to administrator
		$emailTemplate = file_get_contents(BASEPATH . 'templates_email/email_receipt_pointspay.html');

		// Create address field with unit/suite // create address field without unit/suite
		if ($totalrow->address2) {
			$address = ucwords(strtolower($totalrow->address2)) . ' - ' . ucwords(strtolower($totalrow->address)) . ',  <br>' . ucwords(strtolower($totalrow->city)) . ', ' . ucwords(strtolower($totalrow->state)) . ' ' . $totalrow->zip;
		}else {
			$address = ucwords(strtolower($totalrow->address)) . ',  <br>' . ucwords(strtolower($totalrow->city)) . ', ' . ucwords(strtolower($totalrow->state)) . ' ' . strtoupper($totalrow->zip);
		}
		
		if ($totalrow->heatflag) {
			$address = "Post Office near: <br>" . $address;
		}
	
		$emailTemplate = str_replace(array(
			'[SITEURL]',
			'[SUPPORT_EMAIL]',
			'[SITE_EMAIL]',
			'[SITE_NAME]',
			'[PURCHASES]',
			'[PAYMENT_METHOD]',
			'[ADDRESS]',
			'[RECEIPT_ID]',
			'[SUBTOTAL]',
			'[SHIPPING]',
			'[DISCOUNT]',
			'[TAX]',
			'[TOTAL]',
			'[DATE]',
			'[ADDRESS1]',
			'[POINTS]'
			),
			array(
				SITEURL,
				$core->support_email,
				$core->site_email,
				$core->site_name,
				$items_purchased,
				'Visa',
				$address,
				sanitize($txn_id),
				$subtotal,
				$shipping,
				$coupon,
				$totaltax,
				$totalprice,
				date("Y-m-d"),
				$address,
				$usr->points_current - round($totalrow->totalprice * 100, 0)
			), $emailTemplate);
	
	
		$mailer = Mailer::sendMail();
		$message = Swift_Message::newInstance()
				->setSubject('Your ' . $core->company . ' receipt.')
				->setTo(array($usr->username => $usr->fname))
				->setBcc(array($core->payment_email => $core->site_name))
				->setFrom(array($core->payment_email => $core->site_name))
				->setBody($emailTemplate, 'text/html');

		$mailer->send($message);
	}
	
	// Clean database
	$db->delete(Content::crTable, "user_id='" . $username . "'");
	$db->delete(Content::exTable, "user_id='" . $username . "'");
	$db->delete(Products::rTable, "user_id='" . $username . "'");

	header("location:../../receipt?tx=" . sanitize($txn_id));
	exit();
}
