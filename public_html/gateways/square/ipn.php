<?php
    /**
     * Square IPN
     *
     * @package Live Deftsoft
     * @author deftsoft.com
     * @copyright 2021
     * @version 
     */
    define("_VALID_PHP", true);
    require_once ("../../init.php");
    ini_set('log_errors', true);
    ini_set('error_log', dirname(__file__) . '/ipn_errors.log');
    if (!$user->logged_in) redirect_to("../../index.php");  
    
    if(isset($_POST['nonce']) && $_POST['amount']){

    	$user_id = $user->uid;
        $username = $user->username;
        $usr = Core::getRowById(Users::uTable, $user_id);
        $totalrow = Content::getCart($username);   
       	
       	// Get address
        if (intval($_POST['billing_address_opt'])) {
            $bill_country = sanitize($_POST['billing_country']);
            $bill_address = sanitize($_POST['billing_address']);
            $bill_address2 = sanitize($_POST['billing_address2']);
            $bill_city = sanitize($_POST['billing_city']);
            $bill_state = sanitize($_POST['billing_state']);
            $bill_zip = sanitize($_POST['billing_zip']);
            $buyer_email_address = sanitize($_POST['billing_email']);

        }else {
            $bill_country = $totalrow->country;
            $bill_address = $totalrow->address;
            $bill_address2 = $totalrow->address2;
            $bill_city = $totalrow->city;
            $bill_state = $totalrow->state;
            $bill_zip = $totalrow->zip;
            $buyer_email_address = $user->username;;
        }

       $cartrow = $content->getCartContent($username);    
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
        //this loads the SquareClient class
        LoadSquareClients();
        
        // SquareClient class contains helper functions to create customerId, search customerId and create payment
        $squareClient = new SquareClient();
        
        // first of all we try to find out if we have stored the customer id in our system, already.
        $currentUserSquareCustomerId = $user->getSquareCustomerId();
        if (!isset($currentUserSquareCustomerId))
        {
          // if we dont have current user's customer id, we try to search existing customers on square. We search by email.
          $posibleSquareCustomerId = $squareClient->loadSquareCustomerIdByEmail($user->username);
          if (isset($posibleSquareCustomerId))
          {
            // if we found a square customer, then we save the customerId to our system
            if (strlen($posibleSquareCustomerId) > 0)
              $db->replaceinto('square_customers_ids', array('user_id' => $user->uid, "square_customer_id" => $posibleSquareCustomerId, "date_created" => date('Y-m-d H:i:s', time())));
            $currentUserSquareCustomerId = $posibleSquareCustomerId;
          }
          else
          {
            // if we dont find a square customer id, then we create a new one and save the customer id to our system
            $customerId = $squareClient->createCustomer($user->username, $user->fname, $user->lname);
            if (strlen($customerId) > 0)
              $db->replaceinto('square_customers_ids', array('user_id' => $user->uid, "square_customer_id" => $customerId, "date_created" => date('Y-m-d H:i:s', time())));
            $currentUserSquareCustomerId = $customerId;
          }
        }


        /**** Square payment start ****/

        $ship_address = $totalrow->address;
        $ship_address2 = $totalrow->address2;
        $ship_city = $totalrow->city;
        $ship_country = $totalrow->country;
        $ship_zip = $totalrow->zip;

        $first_name = '';
        $last_name = '';
        $name = explode(" ",$_POST['card-name']);
        $first_name = $name[0];
        $last_name = $name[1];

        $shipname = explode(" ",$totalrow->name);

        $shipping_first_name = $shipname[0];
        $shipping_last_name = $shipname[1];
        
        $nonce = $_POST['nonce'];
        $amount = $_POST['amount']*100;        
        $idempotency_key = uniqid();

        $key = $db->first("SELECT * FROM gateways WHERE name = 'square'");
        $currency = $key->extra2;
        $bearer = $key->extra3;
        $kar = explode('/',$key->extra);
        $appId = $kar[0];
        $locId = $kar[1];

         if($key->demo == 0){
            $paymentGatewayUrl = 'https://connect.squareupsandbox.com/v2/payments';
        }else{
             $paymentGatewayUrl = 'https://connect.squareup.com/v2/payments';
        }     
        $transaction_id = "txn_" . md5(uniqid("txn_", true) . rand(1, 25000));
        $paymentPostFields = array(
          'amount_money' => array(
            'amount' => intval($amount),
            'currency' => $currency
          ),
          'idempotency_key' => $idempotency_key,
          'source_id' => $nonce,
          'billing_address' => array(
            'address_line_1' => $bill_address,
            'administrative_district_level_1' => $bill_address2,
            'country' => $bill_country,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'postal_code' => $bill_zip,
          ),
          'shipping_address' => array(
            'address_line_1' => $ship_address,
            'address_line_2' => $ship_address2,
            'administrative_district_level_1' => $ship_city,
            'country' => $ship_country,
            'first_name' => $shipping_first_name,
            'last_name' => $shipping_last_name,
            'postal_code' => $ship_zip,
          ),
          'buyer_email_address' => $buyer_email_address,
          'location_id' => $locId,
          'note' => $transaction_id
        );
        if (isset($currentUserSquareCustomerId))
          $paymentPostFields['customer_id'] = $currentUserSquareCustomerId;
        
        
        $json = $squareClient->createPayment($paymentPostFields);
       if ($json->errors[0]->detail!='') {
          $_SESSION['square_error'] = $json->errors[0]->detail;
		  header("location:../../payment");
        } else {
           $location_id = $json->payment->location_id;
           // we decided to create the invoice id before creating the payment, to save the invoice id into payment `note` field
           //$transaction_id = 'txn_'.$json->payment->id;
           $created_at = $json->payment->created_at;
           $tenders = $json->payment;
           $res_amount = $tenders->amount_money->amount;
           $currency = $tenders->amount_money->currency;
           $card_details = $tenders->card_details;
           $status = $card_details->status;
           $card = $card_details->card;
           $card_brand = $card->card_brand;
           $last_4 = $card->last_4;
           $type = $card->card_type;
           $fingerprint = $card->fingerprint;
           $entry_method = $card_details->entry_method;
           $product = $json->payment->product;


           /**** Square payment end ****/
            $mc_gross = round(($res_amount / 100) , 2); 

            if ($card_brand == "MasterCard") {
                $card_type_image = SITEURL . "/templates_email/images/mastercard-light@2x.png";
            }
            else {
                $card_type_image = SITEURL . "/templates_email/images/visa-light@2x.png";
            }

            /* == Payment Completed == */
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

            if ($status=='CAPTURED' && $v1 <= $v2) {
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
                        $price = ($crow->pvid > 0 ? $crow->var_price : $crow->price);
                        // Create transaction data for each product
                        $data = array(
                            'txn_id' => sanitize($transaction_id),
                            'pid' => $crow->pid,
                            'pvid' => $crow->pvid,
                            'uid' => intval($user_id),
                            'ip' => sanitize($_SERVER['REMOTE_ADDR']),
                            'created' => date("Y-m-d H:i:s"),
                            'item_qty' => $crow->qty,
                            'price' => $price,
                            'currency' => sanitize($currency),
                            'pp' => 'Square',
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

                        /*$row_product = $db->first("SELECT * FROM " . Products::pTable . " WHERE id 
                                = '" . $crow->pid . "'");
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
                    $invdata = array(
                        'invid' => sanitize($transaction_id),
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
                        'created' => date("Y-m-d H:i:s"),
                        'pp' => $card_brand,
                        'name' => $totalrow->name,
                        'country' => $totalrow->country,
                        'address' => $totalrow->address,
                        'address2' => $totalrow->address2,
                        'city' => $totalrow->city,
                        'state' => $totalrow->state,
                        'zip' => $totalrow->zip,
                        'phone' => $totalrow->phone,
                        'status' => '1',
                        'points' => $totalrow->points,
                        'payout' => $totalrow->payout,
                        'earninvite' => 1
                    );
                    $db->insert(Content::inTable, $invdata);

                    $udata['purchases'] = $usr->purchases + 1;
                    $udata['invites'] = $usr->invites + + 1;
                    
                    $udata['points_current'] = $usr->points_current + $totalrow->points;
                    $udata['points_lifetime'] = $usr->points_lifetime + $totalrow->points;
                    
                    $db->update(Users::uTable, $udata, "id='" . $user->uid . "'");
                }



                // Check if user wants to be notified of purchase
                $notifications = $db->fetch_all("SELECT * FROM " . Users::uTable . " WHERE username ='" . sanitize($usr->username) . "' AND purchase_receipts = 1");

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
            
                    // Send email
                    $emailTemplate = file_get_contents(BASEPATH . 'templates_email/email_receipt_stripe.html');

                    // Create address field with unit/suite // create address field without unit/suite
                    if ($totalrow->address2) {
                        $address = ucwords(strtolower($totalrow->address2)) . ' - ' . ucwords(strtolower($totalrow->address)) . ',  <br>' . ucwords(strtolower($totalrow->city)) . ', ' . ucwords(strtolower($totalrow->state)) . ' ' . strtoupper($totalrow->zip);
                    }else {
                        $address = ucwords(strtolower($totalrow->address)) . ',  <br>' . ucwords(strtolower($totalrow->city)) . ', ' . ucwords(strtolower($totalrow->state)) . ' ' . strtoupper($totalrow->zip);
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
                        sanitize($last_4),
                        $subtotal,
                        $shipping,
                        $coupon,
                        $totaltax,
                        $totalprice,
                        $last_4,
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
                $db->delete(Content::crTable, "user_id='" . $username . "'");
                $db->delete(Content::exTable, "user_id='" . $username . "'");
                //$db->delete(Products::rTable, "user_id='" . $username . "'");


                
                header("location:../../receipt?type=visa&tx=" . sanitize($transaction_id));
                exit();
            }


        }   
    }    
?>
