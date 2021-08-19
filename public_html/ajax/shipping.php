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
  require_once("../init.php");
?>
<?php
	if (isset($_POST['updateCartShipping']) and !empty($_POST['updateCartShipping'])) {

		$shipping_cost = 0;
		$shipping_type = intval($_POST['shipping_type']);
		$state = sanitize($_POST['state']);
		
		
		// Calculate shipping costs (0 = standard, 1 = express)
		if ($shipping_type == 1) {
			$shipping_cost = Content::calculateExpressShipping($state);
		}else {
			$shipping_cost = Content::calculateStandardShipping($state);
		}
		
		// Get tax percentage
		$tax = Content::calculateTax($state);

		$xdata = array(
			'tax' => $tax,
			'shipping' => $shipping_cost,
			'shipping_type' => $shipping_type,
			'name' => html_entity_decode(sanitize($_POST['name']), ENT_QUOTES),
			'country' => sanitize($_POST['country']),
			'address' => html_entity_decode(sanitize($_POST['address']), ENT_QUOTES),
			'address2' => sanitize($_POST['address2']),
			'city' => html_entity_decode(sanitize($_POST['city']), ENT_QUOTES),
			'state' => $state,
			'zip' => sanitize($_POST['zip']),
			'discount_code' => sanitize($_POST['discount_code']),
			'phone' => $_POST['shipping_telephone'],
			'created' => "NOW()"
		);

		$db->update(Content::exTable, $xdata, "user_id = '" . $user->username . "'");
		
		$invoiceArray = Content::calculateInvoice();
		
		$json['type'] = 'success';
		$json['gtotal'] = Registry::get("Core")->formatMoney($invoiceArray['totalprice'], false);
		$json['tax'] = Registry::get("Core")->formatMoney($invoiceArray['totaltax'], false);
		$json['subt'] = Registry::get("Core")->formatMoney($invoiceArray['originalprice'], false);
		$json['ctotal'] = Registry::get("Core")->formatMoney($invoiceArray['coupon'], false);
		$json['shipping'] = Registry::get("Core")->formatMoney($invoiceArray['shipping']);
			
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Your shipping details have been updated.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
		print json_encode($json);
  }
  
?>
