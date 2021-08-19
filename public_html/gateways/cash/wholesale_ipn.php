<?php
/**
 * eTransfer IPN
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

if (isset($_POST['processCashPayment'])) {

	/* == User details == */
	$user_id = $user->uid;
	$username = $user->username;
	$usr = Core::getRowById(Users::uTable, $user_id);
	
	$cartrow = $content->getWholesaleCartContent($username);
	
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
	$txn_id = $user_id . date("dmy") . date("his");

	$totalrow = Content::getWholesaleCart($username);
	$cartquantity = count($cartrow);
	$gross = $totalrow->total - $totalrow->coupon;

	$v1 = number_format($gross, 2, '.', '');
	$v2 = number_format($mc_gross, 2, '.', '');

	// Get discount code from database
	$row_coupon = $db->first("SELECT * FROM " . Content::cpTable . " WHERE code = '" . $_POST['discount_code'] . "'");

	if ($row_coupon) {
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
			$price = $crow->unit_price ;
			// Create transaction data for each product
			$data = array(
				'txn_id' => sanitize($txn_id),
				'pid' => $crow->pid,
				'pvid' => $crow->pvid,
				'uid' => intval($user_id),
				'ip' => sanitize($_SERVER['REMOTE_ADDR']),
				'created' => "NOW()",
				'item_qty' => $crow->qty,
				'price' => $price,
				'mc_fee' => $mc_fee,
				'currency' => 'CDN',
				'pp' => 'Cash',
				'memo' => $crow->title,
				'status' => 1,
				'active' => 1
			);

			// $items[$crow->price] = $crow->title;
			$items = $items + $crow->qty;
			$db->insert("wholesale_transactions", $data);


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
			$items_purchased .= '<table align="center" cellpadding="0" cellspacing="0" border="0" class="re-row"><tbody><tr><th width="209" class="stack2" style="margin:0; padding:0;border-bottom:1px solid #dcdcdc;"><table width="209" align="center" cellpadding="0" cellspacing="0" border="0" class="table60032"><tbody><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr><tr><td width="30" class="wz2"></td><td class="header2TD" style="color: #323232;font-family: sans-serif;font-size: 14px;text-align: left;line-height: 19px;font-weight: lighter;">' .$crow->title . $var_name . '</td><td width="30" class="wz2"></td></tr><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr></tbody></table> </th><th width="139" class="stack3" style="border-left:1px solid #dcdcdc;border-bottom:1px solid #dcdcdc;margin:0; padding:0;"> <table width="139" align="center" cellpadding="0" cellspacing="0" border="0" class="table60033"><tbody><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr><tr><td width="30" class="wz2"></td><td class="RegularText5TD" style="color: #323232;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">' .$core->formatMoney($var_price).'</td><td width="30" class="wz2"></td></tr><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr></tbody></table></th><th width="139" class="stack3" style="border-left:1px solid #dcdcdc;border-bottom:1px solid #dcdcdc;margin:0; padding:0;"><table width="139" align="center" cellpadding="0" cellspacing="0" border="0" class="table60033"><tbody><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr><tr><td width="30" class="wz2"></td><td class="RegularText5TD" style="color: #323232;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">' .$crow->qty.'</td><td width="30" class="wz2"></td></tr><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr></tbody></table></th><th width="139" class="stack3" style="border-left:1px solid #dcdcdc;border-bottom:1px solid #dcdcdc;margin:0; padding:0;"><table width="139" align="center" cellpadding="0" cellspacing="0" border="0" class="table60033"><tbody><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr><tr><td width="30" class="wz2"></td><td class="RegularText5TD" style="color: #323232;font-family: sans-serif;font-size: 14px;font-weight: lighter;text-align: center;line-height: 23px;">' .$core->formatMoney($pricerowtotal).'</td><td width="30" class="wz2"></td></tr><tr><td colspan="3" height="20" style="font-size:0;line-height:0;" class="va2">&nbsp;</td></tr></tbody></table></th></tr></tbody></table>';
		}

		unset($crow);

		// Create data for invoice of total sale
		$xdata = array(
			'invid' => sanitize($txn_id),
			'user_id' => $user->uid,
			'items' => intval($items),
			'coupon' => $totalrow->coupon,
			'discount_code' => sanitize($_POST['discount_code']),
			'originalprice' => $totalrow->originalprice,
			'tax' => $totalrow->tax,
			'totaltax' => $totalrow->totaltax,
			'shipping' => $totalrow->shipping,
			'total' => $totalrow->total,
			'totalprice' => $totalrow->totalprice,
			'currency' => 'CDN',
			'created' => "NOW()",
			'pp' => 'Cash',
			'name' => $totalrow->name,
			'country' => $totalrow->country,
			'address' => $totalrow->address,
			'address2' => $totalrow->address2,
			'city' => $totalrow->city,
			'state' => $totalrow->state,
			'zip' => $totalrow->zip,
			'phone' => $totalrow->phone,
			'heatflag' => $totalrow->heatflag,
			'status' => '0',
			'points' => $totalrow->points,
			'payout' => $totalrow->payout,
			'earninvite' => 1
		);

		$db->insert("wholesale_invoices", $xdata);

		$udata['purchases'] = $usr->purchases + 1;
		$udata['invites'] = $usr->invites + 1;
		$db->update(Users::uTable, $udata, "id='" . $user->uid . "'");
	}
	
	
	// Check if user wants to be notified of purchase
	
	$notifications = $db->fetch_all("SELECT * FROM " . Users::uTable . " WHERE username ='{$usr->username}' AND purchase_receipts = 1");
	
	if ($notifications) {
		// Setup email and variables for email
		require_once (BASEPATH . "lib/class_mailer.php");
	
		$subtotal = $core->formatMoney($totalrow->originalprice);
		$shipping = $core->formatMoney($totalrow->shipping);
		$couponAmount = $core->formatMoney($totalrow->coupon);
		$totaltax = $core->formatMoney($totalrow->totaltax);
		$totalprice = $core->formatMoney($totalrow->totalprice);
		$totalpricetext = $core->formatMoney($totalrow->totalprice);
	
		// Choose template between discount or no discount
		if ($totalrow->coupon > 0) {
			$emailTemplate = file_get_contents(BASEPATH . 'templates_email/receipt_etransfer.html');
		} else {
			$emailTemplate = file_get_contents(BASEPATH . 'templates_email/receipt_etransfer_nodiscount.html');
		}
	
	
		// Create address field with unit/suite // create address field without unit/suite
		if ($totalrow->address2) {
			$address = $totalrow->address2 . ' - ' . $totalrow->address . ', ' . $totalrow->city . ', ' . $totalrow->state . ' ' . $totalrow->zip;
		}else {
			$address = $totalrow->address . ', ' . $totalrow->city . ', ' . $totalrow->state . ' ' . $totalrow->zip;
		}
	
	
		$emailTemplate = str_replace(array(
			'[SITEURL]',
			'[PAYMENT_EMAIL]',
			'[SUPPORT_EMAIL]',
			'[SITE_EMAIL]',
			'[SITE_NAME]',
			'[SECRETANSWER]',
			'[FORMALITY]',
			'[FULLNAME]',
			'[PURCHASES]',
			'[PAYMENT_METHOD]',
			'[ADDRESS]',
			'[RECEIPT_ID]',
			'[SUBTOTAL]',
			'[SHIPPING]',
			'[DISCOUNT]',
			'[TAX]',
			'[TOTAL]',
			'[POINTS]',
			'[DATE]'),
			array(
				SITEURL,
				$core->payment_email,
				$core->support_email,
				$core->site_email,
				$core->site_name,
				$core->etransfer_answer,
				sanitize($usr->fname) . " (" . $usr->username . ")",
				sanitize($totalrow->name),
				$items_purchased,
				'e-Transfer',
				$address,
				sanitize($txn_id),
				$subtotal,
				$shipping,
				$couponAmount,
				$totaltax,
				$totalprice,
				$totalrow->points,
				date("Y-m-d")),
			$emailTemplate);
	
	
		$mailer = Mailer::sendMail();
		$message = Swift_Message::newInstance()
			->setSubject($core->company . ' Invoice')
			->setTo(array($usr->username => $usr->fname))
			->setBcc(array($core->payment_email => $core->site_name))
			->setFrom(array($core->payment_email => $core->site_name))
			->setBody($emailTemplate, 'text/html');
		
		$mailer->send($message);
	}
	
	// Clean database
	$db->delete("wholesale_cart", "user_id='" . $username . "'");
	$db->delete("wholesale_extras", "user_id='" . $username . "'");

	header("location:../../wholesale?p=invoice&tx=" . sanitize($txn_id));
	exit();
}
