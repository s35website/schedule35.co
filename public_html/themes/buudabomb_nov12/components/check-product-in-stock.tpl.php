<?php
	/**
	* Coupon
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: coupon.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/

	$json['type'] = "success";
	$cartrow = $content->getCartContent();

	$baseErrorText = 'There\'s ';
	$notZeroQuantityText = 'only <strong>%s bag%s of %s</strong>';
	$zeroQuantityText = '<strong>no %s</strong> ';
	$endPartText = ' left. To complete your purchase try updating your cart';

	$errorText = $baseErrorText;

	$errorPartIndex = 0;

	foreach ($cartrow as $row) {
		$cartProduct = [
			'productID' => (integer) $row->pid,
			'quantity' => (integer) $row->qty,
			'title' => $row->title,
		];

		$productStock = $item->checkProductStock($cartProduct['productID']);

		if ($productStock < $cartProduct['quantity']) {
            $json['type'] = "error";

			if ($errorPartIndex > 0) {
				$errorText .= ' and ';
			}

			if ($productStock > 0) {
				if ($productStock === 1) {
					$errorText .= sprintf($notZeroQuantityText, $productStock, '', $cartProduct['title']);
				} else {
					$errorText .= sprintf($notZeroQuantityText, $productStock, 's', $cartProduct['title']);
				}
			} elseif ($productStock === 0) {
				$errorText .= sprintf($zeroQuantityText, $cartProduct['title']);
			}

			$errorPartIndex++;
		}
	}

	if ($errorPartIndex) {
		$errorText .= $endPartText;
	}

	$json['message'] = $errorText;

	print json_encode($json);

?>
