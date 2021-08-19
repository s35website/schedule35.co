<?php
	/**
	* Payment
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: payment.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	if (!$user->logged_in)
		redirect_to("login");
	
    $cartrow = $content->getCartContent();
	
	if (!$cartrow) {
		redirect_to("cart");
	}

	$baseErrorText = 'Unfortunately, there are ';
	$notZeroQuantityText = 'only <strong>%s bag%s of %s</strong> left. ';
	$zeroQuantityText = '<strong>no more %s</strong>. ';
	$endPartText = ' To complete your&nbsp;purchase, try updating your cart.';

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

	$cart = $content->getCart();
	$gaterow = $content->getGateways(true);
	
	$pagename = 'Payment Details';
?>
<?php require_once (THEMEDIR . "/payment.tpl.php");?>