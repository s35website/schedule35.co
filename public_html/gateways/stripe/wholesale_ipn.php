<?php
/**
 * Stripe IPN
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: ipn.php, 2010-08-10 21:12:05 gewa Exp $
 */
define("_VALID_PHP", true);

require_once ("../../init.php");

require_once (dirname(__file__) . '/lib/Stripe.php');

ini_set('log_errors', true);
ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

if (!$user->logged_in) redirect_to("../../index.php");

if (isset($_POST['processWholeSaleStripePayment'])) {

	$user_id = $user->uid;
	$sesid = $user->sesid;
	$usr = Core::getRowById(Users::uTable, $user_id);

	$cartrow = $content->getWholesaleCartContent($sesid);
	
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
	    header('Location: ../../wholesale?p=payment');
	    exit();
	}


	$key = $db->first("SELECT * FROM gateways WHERE name = 'stripe'");
	$stripe = array(
		"secret_key" => $key->extra,
		"publishable_key" => $key->extra3
	);
	Stripe::setApiKey($stripe['secret_key']);

	try {
		$charge = Stripe_Charge::create(array(
			"amount" => round($_POST['amount'] * 102, 0) , // amount in cents, again
			"currency" => $_POST['currency_code'],
			"card" => array(
				"number" => $_POST['card-number'],
				"exp_month" => $_POST['card-expiry-month'],
				"exp_year" => $_POST['card-expiry-year'],
				"cvc" => $_POST['card-cvc'],
				"name" => $_POST['card-name']
			) ,
			//"receipt_email" => $_POST['user_email'],
			"description" =>  "Purchases: " . $_POST['item_name']));

		$chargeArray = $charge->__toArray(true);

		$json = json_decode($charge);
		$mc_gross = round(($json->{'amount'} / 100) , 2);
		$txn_id = $json->{'balance_transaction'};
		$card_type = $json->{'source'}->{'brand'};
		$card_last_digits = substr($_POST['card-number'], -4);
		$txn_id_last_digits = str_replace('txn_', '', $txn_id);

		if ($card_type == "MasterCard") {
			$card_type_image = SITEURL . "/templates_email/images/mastercard-light@2x.png";
		}
		else {
			$card_type_image = SITEURL . "/templates_email/images/visa-light@2x.png";
		}

		/* == Payment Completed == */
		$totalrow = Content::getWholesaleCart($sesid);
		$cartquantity = count($cartrow);
		$discount = $totalrow->coupon / $cartquantity;
		$gross = $totalrow->total - $totalrow->coupon;

		$v1 = number_format($gross, 2, '.', '');
		$v2 = number_format($mc_gross, 2, '.', '');

		// Get discount code from database
		$row_coupon = $db->first("SELECT * FROM " . Content::cpTable . " WHERE code = '" . $_POST['discount_code'] . "'");

		if ($row_coupon) {
		    $data['used'] = $row_coupon->used + 1;
		    $db->update(Content::cpTable, $data, "id='" . $row_coupon->id . "'");
		}


		if ($chargeArray['paid']==1 && $v1 <= $v2) {
		
			if ($cartrow) {
				$items = 0;
				$items_purchased = "";

				foreach($cartrow as $crow) {
		            $var_name = '';
		            $var_price = $crow->price;
		            if( $crow->pvid > 0 ){
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
						'payer_email' => sanitize($usr->username),
						'item_qty' => $crow->qty,
						'price' => $price,
						'mc_fee' => $mc_fee,
						'currency' => sanitize($mc_currency),
						'pp' => $card_type,
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
							<span style="font-size: 14px; line-height: 17px;border: 0; margin: 0; padding: 0;color: #292e31 !important;">'.$core->formatMoney($var_price * $crow->qty).'</span>
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
					'coupon' => $totalrow->coupon,
					'discount_code' => sanitize($_POST['discount_code']),
					'originalprice' => $totalrow->originalprice,
					'tax' => $totalrow->tax,
					'totaltax' => $totalrow->totaltax,
					'shipping' => $totalrow->shipping,
					'total' => $totalrow->total,
					'totalprice' => round($totalrow->totalprice*1.02,2),
					'currency' => 'CDN',
					'created' => "NOW()",
					'pp' => $card_type,
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
					'points' => $totalrow->points,
					'payout' => $totalrow->payout,
					'earninvite' => 1
				);
				$db->insert("wholesale_invoices", $xdata);

				$udata['purchases'] = $usr->purchases + 1;
				$udata['invites'] = $usr->invites + + 1;
				
				$udata['points_current'] = $usr->points_current + $totalrow->points;
				$udata['points_lifetime'] = $usr->points_lifetime + $totalrow->points;
				//TODO: Is this for the invoice checking? will it affect normal purchase?
				$db->update(Users::uTable, $udata, "id='" . $user->uid . "'");
			}
			
			
			// Check if user wants to be notified of purchase
			$notifications = $db->fetch_all("SELECT * FROM " . Users::uTable . " WHERE username ='{$usr->username}' AND purchase_receipts = 1");
			
			if ($notifications) {
			
				// Setup email and variables for email
				require_once (BASEPATH . "lib/class_mailer.php");
				
				$subtotal = $core->formatMoney($totalrow->originalprice);
				$shipping = $core->formatMoney($totalrow->shipping);
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
							<span style="font-size: 12px; line-height: 17px;">('.$core->formatMoney($totalrow->coupon).')</span>
						</td>
						<td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
							<div class="clear" style="height: 1px; width: 1px;"></div>
						</td>
					</tr>';
				}else {
					$coupon = '';
				}
		
				$totaltax = $core->formatMoney($totalrow->totaltax);
				$totalprice = $core->formatMoney($totalrow->totalprice);
		
				// Send email to administrator
				$emailTemplate = file_get_contents(BASEPATH . 'templates_email/email_receipt_stripe.html');
				
				
				// Create address field with unit/suite // create address field without unit/suite
				if ($totalrow->address2) {
					$address = ucwords(strtolower($totalrow->address2)) . ' - ' . ucwords(strtolower($totalrow->address)) . ',  <br>' . ucwords(strtolower($totalrow->city)) . ', ' . ucwords(strtolower($totalrow->state)) . ' ' . strtoupper($totalrow->zip);
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
					'[CARD_DIGITS]',
					'[CARD_IMAGE]',
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
						sanitize($txn_id_last_digits),
						$subtotal,
						$shipping,
						$coupon,
						$totaltax,
						$totalprice,
						$card_last_digits,
						$card_type_image,
						date("Y-m-d"),
						$address,
						$totalrow->points
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
			$db->delete("wholesale_cart", "user_id='" . $sesid . "'");
			$db->delete("wholesale_extras", "user_id='" . $sesid . "'");
            header("location:../../wholesale?p=invoice&tx=" . sanitize($txn_id));
			exit();
	    }
	}

	catch(Stripe_CardError $e) {
		// $json = json_decode($e);
		$body = $e->getJsonBody();
		$err = $body['error'];
		$json['type'] = 'error';
		Filter::$msgs['status'] = 'Status is:' . $e->getHttpStatus() . "\n";
		Filter::$msgs['type'] = 'Type is:' . $err['type'] . "\n";
		Filter::$msgs['code'] = 'Code is:' . $err['code'] . "\n";
		Filter::$msgs['param'] = 'Param is:' . $err['param'] . "\n";
		Filter::$msgs['msg'] = 'Message is:' . $err['message'] . "\n";
		$json['message'] = Filter::msgStatus();
		//print json_encode($json);
		$_SESSION['stripe_error'] = $err['message'];
		header("location:../../payment");
	}

	catch(Stripe_InvalidRequestError $e) {
		$body = $e->getJsonBody();
		$err = $body['error'];
		$_SESSION['stripe_error'] = $err['message'];
		header("location:../../payment");
	}

	catch(Stripe_AuthenticationError $e) {
		$_SESSION['stripe_error'] = 'Authentication Error';
		header("location:../../payment");
	}

	catch(Stripe_ApiConnectionError $e) {
		$_SESSION['stripe_error'] = 'Connection Error';
		header("location:../../payment");
	}

	catch(Stripe_Error $e) {
		$_SESSION['stripe_error'] = 'Stripe Error';
		header("location:../../payment");
	}

	catch(exception $e) {
		$_SESSION['stripe_error'] = 'Exception';
		header("location:../../payment");
	}
}

?>
