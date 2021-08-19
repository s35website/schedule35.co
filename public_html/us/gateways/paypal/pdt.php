<?php
/**
 * AlertPay IPN
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: pdt.php, 2010-08-10 21:12:05 gewa Exp $
 */
define("_VALID_PHP", true);
define("_PIPN", true);

ini_set('log_errors', true);
ini_set('error_log', dirname(__file__) . '/pdt_errors.log');

require_once ("init.php");

if (isset($_GET['tx'])) {


	require_once (BASEPATH . "lib/class_mailer.php");

	include (BASEPATH . 'lib/class_pp.php');

	$demo = getValue("demo", Content::gTable, "name = 'paypal'");

	if ($demo == 1) {
		$pp_hostname = "www.paypal.com"; // Change to www.sandbox.paypal.com to test against sandbox
	}
	else {
		$pp_hostname = "www.sandbox.paypal.com";
	}

	// read the post from PayPal system and add 'cmd'

	$req = 'cmd=_notify-synch';
	$tx_token = $_GET['tx'];
	$auth_token = getValue("extra3", Content::gTable, "name = 'paypal'");
	$req.= "&tx=$tx_token&at=$auth_token";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

	// set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
	// if your server does not bundled with default verisign certificates.

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Host: $pp_hostname"
	));
	$res = curl_exec($ch);
	curl_close($ch);
	if (!$res) {

		// HTTP ERROR

	}
	else {

		// parse the data
		$lines = explode("\n", $res);
		$keyarray = array();
		if (strcmp($lines[0], "SUCCESS") == 0) {
			for ($i = 1; $i < count($lines); $i++) {
				list($key, $val) = explode("=", $lines[$i]);
				$keyarray[urldecode($key) ] = urldecode($val);
			}

			// check the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your Primary PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment
			$payment_status = $keyarray['payment_status'];
			$receiver_email = $keyarray['receiver_email'];
			$payer_email = $keyarray['payer_email'];
			$payer_status = $keyarray['payer_status'];
			$mc_currency = $keyarray['mc_currency'];
			$mc_fee = isset($keyarray['mc_fee']) ? floatval($keyarray['mc_fee']) : 0.00;
			$tax = $keyarray['tax'];
			$numitems = $keyarray['num_cart_items'];
			$single_tax = $tax / $numitems;
			list($user_id, $sesid) = explode('_', $keyarray['custom']);
			$mc_gross = $keyarray['mc_gross'];
			$txn_id = $keyarray['txn_id'];
			$getxn_id = $core->verifyTxnId($txn_id);

			$cartrow = $content->getCartContent($sesid);
			$totalrow = Content::getCart($sesid);
			$cartquantity = count($cartrow);
			$discount = $totalrow->coupon / $cartquantity;
			$gross = $totalrow->total - $totalrow->coupon;

			$v1 = number_format($gross, 2, '.', '');
			$v2 = number_format($mc_gross, 2, '.', '');

			$pp_email = getValue("extra", Content::gTable, "name = 'paypal'");
			if ($payment_status == 'Completed') {
				if ($receiver_email == $pp_email && $v1 <= $v2 && $getxn_id == true) {
					if ($cartrow) {

						$items = 0;
						$items_purchased = "";

						foreach($cartrow as $crow) {
							// Create transaction data for each product
							$data = array(
								'txn_id' => sanitize($txn_id),
								'pid' => $crow->pid,
								'uid' => intval($user_id),
								'ip' => sanitize($_SERVER['REMOTE_ADDR']),
								'created' => "NOW()",
								'payer_status' => sanitize($payer_status),
								'item_qty' => $crow->qty,
								'price' => $crow->price,
								'mc_fee' => $mc_fee,
								'currency' => sanitize($mc_currency),
								'pp' => "PayPal",
								'memo' => $crow->title,
								'status' => 1,
								'active' => 1
							);

							// $items[$crow->price] = $crow->title;
							$items = $items + $crow->qty;
							$db->insert(Products::tTable, $data);

							$items_purchased .= '<tr><td style="padding:15px 0;font-size:18px;width:50%;border-bottom:1px solid #ebebeb;color:#a2a2a2">'.$crow->title. ' x ' . $crow->qty .'</td><td style="padding:15px 0;text-align:right;font-size:18px;width:50%;border-bottom:1px solid #ebebeb;color:#a2a2a2">C' .$core->formatMoney($crow->price).'</td></tr>';



						}

						unset($crow);

						// Create data for invoice of total sale
						$xdata = array(
							'invid' => sanitize($txn_id),
							'user_id' => $user->uid,
							'items' => intval($items),
							'coupon' => $totalrow->coupon,
							'originalprice' => $totalrow->originalprice,
							'tax' => $totalrow->tax,
							'totaltax' => $totalrow->totaltax,
							'shipping' => $totalrow->shipping,
							'total' => $totalrow->total,
							'totalprice' => $totalrow->totalprice,
							'currency' => 'CDN',
							'created' => "NOW()",
							'pp' => "PayPal",
							'name' => $totalrow->name,
							'country' => $totalrow->country,
							'address' => $totalrow->address,
							'address2' => $totalrow->address2,
							'city' => $totalrow->city,
							'state' => $totalrow->state,
							'zip' => $totalrow->zip,
							'phone' => $totalrow->phone
						);
						$db->insert(Content::inTable, $xdata);
					}

					/* == Notify Administrator == */
					require_once (BASEPATH . "lib/class_mailer.php");

					$row2 = Core::getRowById(Content::eTable, 5);
					$usr = Core::getRowById(Users::uTable, $user_id);
					$body = str_replace(array(
						'[USERNAME]',
						'[STATUS]',
						'[TOTAL]',
						'[PP]',
						'[IP]'
					), array(
						$usr->username,
						"Completed",
						$core->formatMoney($totalrow->totalprice),
						"PayPal",
						$_SERVER['REMOTE_ADDR']
					), $row2->body);
					$newbody = cleanOut($body);
					$mailer = Mailer::sendMail();
					$message = Swift_Message::newInstance()->setSubject($row2->subject)->setTo(array(
						$core->site_email => $core->site_name
					))->setFrom(array(
						$core->site_email => $core->site_name
					))->setBody($newbody, 'text/html');
					$mailer->send($message);



					$subtotal = '<tr style="font-size:15px"><td style="width: 60%;"></td><td>Subtotal:</td><td>C'.$core->formatMoney($totalrow->originalprice).'</td></tr>';
					$shipping = '<tr style="font-size:15px"><td style="width: 60%;"></td><td>Shipping:</td><td>C'.$core->formatMoney($totalrow->shipping).'</td></tr>';

					if ($totalrow->coupon > 0) {
						$coupon = '<tr style="font-size:15px"><td style="width: 60%;"></td><td>Discount:</td><td>-C'.$core->formatMoney($totalrow->coupon).'</td></tr>';
					}else {
						$coupon = '';
					}

					$totaltax = '<tr style="font-size:15px"><td style="width: 60%;"></td><td>Tax:</td><td>C'.$core->formatMoney($totalrow->totaltax).'</td></tr>';
					$totalprice = '<tr style="font-size:15px"><td style="width: 60%;"></td><td>Total:</td><td>C'.$core->formatMoney($totalrow->totalprice).'</td></tr>';

					// Send Email
					$template = file_get_contents(BASEPATH . 'templates_email/email_receipt_paypal.html');
					$template = str_replace(array(
						'[SITEURL]',
						'[LOCATION]',
						'[FNAME]',
						'[PURCHASES]',
						'[PAYMENT_METHOD]',
						'[ZIP]',
						'[RECEIPT_ID]',
						'[SUBTOTAL]',
						'[SHIPPING]',
						'[DISCOUNT]',
						'[TAX]',
						'[TOTAL]',
						'[DATE]'),
					array(
							SITEURL,
							'Vancouver, ON',
							sanitize($usr->fname),
							$items_purchased,
							'PayPal',
							$totalrow->zip,
							sanitize($txn_id),
							$subtotal,
							$shipping,
							$coupon,
							$totaltax,
							$totalprice,
							date("Y-m-d")),
					$template);

          $mailer2 = Mailer::sendMail();
          $message2 = Swift_Message::newInstance()
						->setSubject('Your ' . $core->site_name . ' receipt.')
						->setTo(array($usr->username => $usr->fname))
						->setBcc(array($core->payment_email => $core->site_name))
						->setFrom(array($core->payment_email => $core->site_name))
						->setBody($template, 'text/html');

          $mailer->send($message2);

					$db->delete(Content::crTable, "user_id='" . $sesid . "'");
					$db->delete(Content::exTable, "user_id='" . $sesid . "'");
					$db->delete(Products::rTable, "user_id='" . $sesid . "'");

				}
			}
			else {
				/* == Failed Transaction= = */
				require_once (BASEPATH . "lib/class_mailer.php");

				$row = Core::getRowById(Content::eTable, 6);
				$usr = Core::getRowById(Users::uTable, $user_id);
				$body = str_replace(array(
					'[USERNAME]',
					'[STATUS]',
					'[TOTAL]',
					'[PP]',
					'[IP]'
				), array(
					$usr->username,
					"Failed",
					$core->formatMoney($gross),
					"PayPal",
					$_SERVER['REMOTE_ADDR']
				), $row->body);
				$newbody = cleanOut($body);
				$mailer = Mailer::sendMail();
				$message = Swift_Message::newInstance()->setSubject($row->subject)->setTo(array(
					$core->site_email => $core->site_name
				))->setFrom(array(
					$core->site_email => $core->site_name
				))->setBody($newbody, 'text/html');
				$mailer->send($message);
			}
		}
		if (strcmp($lines[0], "FAIL") == 0) {

			// log for manual investigation

		}
	}
}

?>
