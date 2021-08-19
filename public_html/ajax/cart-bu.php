<?php
/**
 * Cart
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2014
 * @version $Id: cart.php, v3.00 2014-07-10 10:12:05 gewa Exp $
 */
define("_VALID_PHP", true);
require_once ("../init.php");

?>
<?php
	

// If user has added something to cart
if (isset($_POST['addtocart'])):
	//If item that was added exists
	if ($row = $db->first("SELECT id, price, points, thumb, description, stock FROM " . Products::pTable . " WHERE id = " . Filter::$id)):
		$var_id = $_POST['var_id'];
		
		$ambcode = $_POST['ambcode'];
		
		$price = $row->price;
		
		if ($var_id > 0) {
			$varArr = Products::getProductVariants($_POST['id'],$_POST['var_id']);
			if (isset($varArr[0]->price)) {
				$price = $varArr[0]->price;
				$var_title = $varArr[0]->title;
			}
		}
		
		if ($var_title == null) {
			$var_title = "";
		}
	
		$stockvaltotal = $_POST['stockval'] * $_POST['qty'];
	
		if ($stockvaltotal > $row->stock) {
			// If not enough stock
			$json['type'] = 'error';
			$json['errovalue'] = $stockvaltotal;
		} else { //If product added is already in cart
			if ($previous = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND pvid = " . $var_id . " AND user_id = '" . sanitize($user->sesid) . "'") ) {
				// If added stock + previous stock is too much
				$stockvaltotal = $stockvaltotal + ($_POST['stockval'] * $previous->qty);
		
				if ($stockvaltotal > $row->stock) {
					// If not enough stock
					$json['type'] = 'error';
					$json['errovalue'] = $stockvaltotal;
				} else {
					// If enough stock
					$data = array(
						'user_id' => sanitize($user->sesid),
						'pid' => $row->id,
						'pvid' => intval($_POST['var_id']),
						'price' => floatval($price),
						'description' => sanitize($_POST['description']),
						'user_email' => sanitize($user->username),
						'qty' => $previous->qty + intval($_POST['qty']),
						'points' => ($previous->qty + intval($_POST['qty'])) * $row->points
					);
					$json['productquantity'] = $previous->qty + intval($_POST['qty']);
					//Update product quantity in cart
					$db->update(Content::crTable, $data, "id=" . $previous->id);
					$json['type'] = ($db->affected()) ? 'success' : 'error';
				}
			} else { //If product added is new
				$data = array(
					'user_id' => sanitize($user->sesid),
					'pid' => $row->id,
					'pvid' => intval($_POST['var_id']),
					'price' => floatval($price),
					'description' => sanitize($_POST['description']),
					'user_email' => sanitize($user->username),
					'qty' => intval($_POST['qty']),
					'points' => intval($_POST['qty']) * $row->points
				);
				$json['productquantity'] = intval($_POST['qty']);
				//Insert product and quantity into cart
				$db->insert(Content::crTable, $data);
				$json['type'] = ($db->affected()) ? 'success' : 'error';
			}
		
			$json['producttotal'] = "$" . number_format($json['productquantity'] * floatval($price), 2);
		
			$json['cartquantity'] = $content->getCartCounterBasic();
			$json['cartcost'] = $content->getCartCounterCost();
			
			$json['price'] = $price;
			$json['name'] = sanitize($_POST['description']);
			$json['description'] = $row->description;
			$json['thumb'] = UPLOADURL . '/prod_images/' . $row->thumb;
			$json['pid'] = $row->id;
			$json['pvid'] = intval($_POST['var_id']);
			$json['var_title'] = $var_title;
		}
	
		unset($row);
		print json_encode($json);
	else:
		$json['type'] = 'error';
	endif;
endif;

if (isset($_POST['delcart'])):
	$db->delete(Content::crTable, "pid=" . Filter::$id . " AND pvid = ".$_POST['pvid']." AND user_id = '" . $db->escape($user->sesid) . "'");

	$json['cartquantity'] = $content->getCartCounterBasic();
	$json['cartcost'] = $content->getCartCounterCost();
	$json['pid'] = Filter::$id;
	$json['pvid'] = $_POST['pvid'];

	print json_encode($json);
endif;

if (isset($_POST['removecart'])):

	if (isset($_POST['var_id'])) {
		$row = $db->first("SELECT id, price, points FROM " . Products::pTable . " WHERE id = " . Filter::$id);
		$cart_item = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND pvid = ".$_POST['var_id']." AND user_id = '" . sanitize($user->sesid) . "'");
	} else {
		$row = $db->first("SELECT id, price, points FROM " . Products::pTable . " WHERE id = " . Filter::$id);
		$cart_item = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND user_id = '" . sanitize($user->sesid) . "'");
	}
	
	$var_id = $_POST['var_id'];

	if ($var_id > 0) {
		$varArr = Products::getProductVariants($_POST['id'],$_POST['var_id']);
		if( isset( $varArr[0]->price ) ){
			$price = $varArr[0]->price;
		}
	} else {
		$price = $row->price;
	}
	
	//If product is completely removed
	if ($cart_item->qty > 1) {
		$data = array(
			'qty' => $cart_item->qty - intval($_POST['qty']),
			'points' => ($cart_item->qty - intval($_POST['qty'])) * $row->points
		);

		//Update product quantity in cart
		$db->update(Content::crTable, $data, "id=" . $cart_item->id);
		$json['type'] = ($db->affected()) ? 'success' : 'error';
	} else { //If product added is new
		$db->delete(Content::crTable, "pid=" . Filter::$id . " AND pvid = ". $_POST['var_id'] ." AND user_id = '" . $db->escape($user->sesid) . "'");
		$db->delete(Content::exTable, "user_id = '" . $user->sesid . "'");
		$json['type'] = ($db->affected()) ? 'success' : 'error';
	}

	$json['productquantity'] = $cart_item->qty - intval($_POST['qty']);
	$json['producttotal'] = "$" . number_format($json['productquantity'] * floatval($price), 2);

	$json['cartquantity'] = $content->getCartCounterBasic();
	$json['cartcost'] = $content->getCartCounterCost();

	$json['pid'] = $row->id;
    $json['pvid'] = $_POST['var_id'];

	unset($row);
	print json_encode($json);
endif;


if (isset($_POST['addtocart']) or isset($_POST['delcart']) or isset($_POST['removecart']) ):


	if ($row = $db->first("SELECT sum(price * qty) as ptotal, sum(points) as totalpoints, COUNT(*) as itotal FROM " . Content::crTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'")):
		
		$disPoints = $row->totalpoints;
		$couponAmount = 0;
		$couponCode = null;
		$payout = 0;
		$state = null;
		
		$exrow = $db->first("SELECT * FROM " . Content::exTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'");
		
		// If extra row exists
		if ($exrow) {
			$couponCode = $exrow->discount_code;
			
			$cprow = $db->first("SELECT discount, type, minval, code, coupon_applied_on, product_list FROM " . Content::cpTable . " WHERE code = '" . $db->escape($couponCode) . "' AND active = '1'");
			
			
			/* Use ambassador code for discount */
			if ($ambcode) {
				$couponCode = $ambcode;
			}
			$ucprow = $db->first("SELECT payout FROM " . Users::uTable . " WHERE invite_code = '" . $db->escape($couponCode) . "'");
			$payout = $ucprow->payout;
			
			if ($cprow) {
				if($cprow->coupon_applied_on == 1){
					$product_list = !empty($cprow->product_list) ? explode(',', $cprow->product_list) : array();
					$cart_product_ids = $db->fetch_all("SELECT pid, price, qty FROM " . Content::crTable . " WHERE user_id = '" . $db->escape($user->sesid) . "'");
					$disAmount = 0;
					foreach ($cart_product_ids as $cart_product_id) {
						if(in_array($cart_product_id->pid, $product_list)){
							$qty = $cart_product_id->qty;
							if ($cprow->type == 0):
								$p_dis = $qty * (number_format($cart_product_id->price / 100 * $cprow->discount, 2));
								$disAmount = $disAmount + $p_dis;
								$disPoints = $row->totalpoints - ($row->totalpoints * $cprow->discount / 100);
							else:
								if($cprow->discount >= $cart_product_id->price ){
									$p_dis = $cart_product_id->price;
								}else{
									$p_dis = number_format($cprow->discount, 2);
								}
								$p_dis = $qty * $p_dis;
								$disAmount = $disAmount + $p_dis;
								$disPoints = $row->totalpoints - $cprow->discount;
							endif;
						}
					}
					$couponAmount = $disAmount;
				}
				else{
					if ($cprow->type == 0) {
						$couponAmount = number_format($row->ptotal / 100 * $cprow->discount, 2);
						$disPoints = $row->totalpoints - ($row->totalpoints * $cprow->discount / 100);
					} else {
						$couponAmount = number_format($cprow->discount, 2);
						$disPoints = $row->totalpoints - $cprow->discount;
					}
				}
			}
			elseif ($ucprow) {
				$couponAmount = number_format($row->ptotal * ($core->payout - $ucprow->payout) / 100, 2);
				$disPoints = $row->totalpoints - ($row->totalpoints * ($core->payout - $ucprow->payout) / 100);
			}
			
			$shipping = $exrow->shipping;
			
			$state = $exrow->state;
		}else {
			// If no extra table, then use state from users address book
			$state = $user->state;
		}
		
		$tax = Content::calculateTax($state);
		
		if ($row->ptotal > $core->shipping_free_flag) {
			$shipping = "0.00";
		} else {
			$shipping = $content->calculateStandardShipping($state);
		}
	
		$gtotal = number_format($row->ptotal, 2);
	
		$total = $row->ptotal + $shipping - $couponAmount;
		$totaltax = $total * $tax;
		$totalprice = $total + $totaltax;
	
		$xdata = array(
			'user_id' => $user->sesid,
			'discount_code' => $couponCode,
			'coupon' => $couponAmount,
			'originalprice' => $row->ptotal,
			'tax' => $tax,
			'totaltax' => $totaltax,
			'total' => $total,
			'shipping' => $shipping,
			'totalprice' => $totalprice,
			'points' => $disPoints,
			'payout' => $payout,
			'created' => "NOW()"
		);
	
		if ($exrow) {
			$db->update(Content::exTable, $xdata, "user_id = '" . $user->sesid . "'");
		}else {
			$db->delete(Content::exTable, "user_id = '" . $user->sesid . "'");
			$db->insert(Content::exTable, $xdata);
		}
	
		$json['message'] = $totalprice;
		$json['total'] = $core->formatMoney($row->ptotal);
	
	else:
		$json['message'] = '0 ' . Lang::$word->ITEMS . ' / ' . $core->cur_symbol . '0.00';
		$json['total'] = '0.00';
	endif;
	

endif;

if (isset($_POST['notifyMe'])):
	$row = $db->first("SELECT id FROM " . Content::nmTable . " WHERE pid = '" . sanitize($_POST['id']) . "' AND user_email = '{$user->username}'");
	if($row){
		$json['type'] = 'success';
	}else{
		$data = array(
			'pid' => sanitize($_POST['id']),
			'user_id' => sanitize($user->uid),
			'user_email' => sanitize($user->username),
			'description' => sanitize($_POST['description']),
			'created' => "NOW()"
		);
		//Insert product and quantity into cart
		$db->insert(Content::nmTable, $data);
		$json['type'] = ($db->affected()) ? 'success' : 'error';
	}
	$json['message'] = 'Data inserted successfully';
	print json_encode($json);
endif;

if (isset($_POST['notifyMeStop'])):
	$row = $db->first("SELECT id FROM " . Content::nmTable . " WHERE pid = '" . sanitize($_POST['id']) . "' AND user_email = '{$user->username}'");
	if($row){
		$db->delete(Content::nmTable, "pid=" . sanitize($_POST['id']) . " AND user_email = '" . $user->username . "'");
		$json['type'] = 'success';
	}else{
		$json['type'] = 'success';
	}
	$json['message'] = 'Data inserted successfully';
	print json_encode($json);
endif;

if (isset($_POST['addtocartwholesale'])):
  $result =array();

  foreach($_POST['items'] as $item){
	 //file_put_contents('./logs/log_'.date("j.n.Y").'.log', $item['id'] .' - '.date("F j, Y, g:i a").PHP_EOL, FILE_APPEND);
		$price = $item['price'];
		$description = 	$item['description'];
		$qty = $item['qty'];
		 //If product added is already in cart
			if ($previous = $db->first("SELECT * FROM wholesale_cart WHERE pid = " . $item['id'] . " AND pvid = 0 AND user_id = '" . sanitize($user->sesid) . "'") ) {
					$data = array(
						'user_id' => sanitize($user->sesid),
						'pid' => $item['id'],
						'pvid' => 0,
						'price' => floatval($price),
						'description' => sanitize($description),
						'user_email' => sanitize($user->username),
						'qty' => intval($qty),
						'points' => 0
					);
					//Update product quantity in cart
					$db->update("wholesale_cart", $data, "id=" . $previous->id);
					$data[$item['id']] = ($db->affected()) ? 'success' : 'error';
				
			} else { //If product added is new
				$data = array(
					'user_id' => sanitize($user->sesid),
					'pid' => $item['id'],
					'pvid' => 0,
					'price' => floatval($price),
					'description' => sanitize($description),
					'user_email' => sanitize($user->username),
					'qty' => intval($qty),
					'points' => 0
				);
				
				//Insert product and quantity into cart
				$db->insert("wholesale_cart", $data);
				$data[$item['id']] = ($db->affected()) ? 'success' : 'error';
			}		
	}
	$json['type'] = $result;
	print json_encode($json);
endif;


if (isset($_POST['removecartwholesale'])):

	$db->delete("wholesale_cart", "pid=" . $_POST['id'] . " AND user_id = '" . $db->escape($user->sesid) . "'");
	$json['type'] = ($db->affected()) ? 'success' : 'error';
	unset($row);
	print json_encode($json);
endif;

if (isset($_POST['addtocartwholesale']) or isset($_POST['removecartwholesale'])  ):

	if ($row = $db->first("SELECT sum(price * qty) as ptotal, COUNT(*) as itotal FROM wholesale_cart WHERE user_id = '" . $db->escape($user->sesid) . "'")):
		$exrow = $db->first("SELECT * FROM wholesale_extras WHERE user_id = '" . $db->escape($user->sesid) . "'");

		$tax = 0.13;
	
		$shipping = $exrow->shipping;
	
		if ($row->ptotal > $core->shipping_free_flag) {
			$shipping = 0;
		}else {
			$shipping = $core->shipping_standard;
		}
	
		$gtotal = $row->ptotal;
	
		$total = $gtotal + $shipping;
		$totaltax = $total * $tax;
		$totalprice = $total + $totaltax;
	
		$xdata = array(
			'user_id' => $user->sesid,
			'originalprice' => $gtotal,
			'tax' => $tax,
			'totaltax' => $totaltax,
			'total' => $total,
			'shipping' => $shipping,
			'totalprice' => $totalprice,
			'created' => "NOW()"
		);
	
		if ($exrow) {
			$db->update("wholesale_extras", $xdata, "user_id = '" . $user->sesid . "'");
		}else {
			$db->delete("wholesale_extras", "user_id = '" . $user->sesid . "'");
			$db->insert("wholesale_extras", $xdata);
		}
	
		$json['message'] = $totalprice;
		$json['total'] = $core->formatMoney($row->ptotal);
	
	else:
		$json['message'] = '0 ' . Lang::$word->ITEMS . ' / ' . $core->cur_symbol . '0.00';
		$json['total'] = '0.00';
	endif;

endif;
?>
