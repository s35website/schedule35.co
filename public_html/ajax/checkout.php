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
	if (isset($_POST['checkout'])) {

		$xdata = array(
			'name' => html_entity_decode(sanitize($_POST['name']), ENT_QUOTES),
			'country' => sanitize($_POST['country']),
			'address' => html_entity_decode(sanitize($_POST['address']), ENT_QUOTES),
			'address2' => sanitize($_POST['address2']),
			'city' => html_entity_decode(sanitize($_POST['city']), ENT_QUOTES),
			'state' => sanitize($_POST['state']),
			'zip' => sanitize($_POST['zip']),
			'discount_code' => $_POST['discount_code'],
			'phone' => $_POST['shipping_telephone'],
			'created' => "NOW()"
		);
		$db->update(Content::exTable, $xdata, "user_id = '" . $user->username . "'");

		$json['message'] = ($db->affected()) ? 'successfully updated' : 'error updating';
		$json['type'] = "success";

		print json_encode($json);
	}
	else {
		$json['message'] = 'unable to post for checkout';
		$json['type'] = "success";

		print json_encode($json);
	}
?>
