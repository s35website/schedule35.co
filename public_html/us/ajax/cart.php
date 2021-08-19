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
			if ($previous = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND pvid = " . $var_id . " AND user_id = '" . sanitize($user->username) . "'") ) {
				// If added stock + previous stock is too much
				$stockvaltotal = $stockvaltotal + ($_POST['stockval'] * $previous->qty);
		
				if ($stockvaltotal > $row->stock) {
					// If not enough stock
					$json['type'] = 'error';
					$json['errovalue'] = $stockvaltotal;
				} else {
					// If enough stock
					$data = array(
						'user_id' => sanitize($user->username),
						'pid' => $row->id,
						'pvid' => intval($_POST['var_id']),
						'price' => floatval($price),
						'description' => sanitize($_POST['description']),
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
					'user_id' => sanitize($user->username),
					'pid' => $row->id,
					'pvid' => intval($_POST['var_id']),
					'price' => floatval($price),
					'description' => sanitize($_POST['description']),
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
			$content->calculateInvoice();
		}
	
		unset($row);
		print json_encode($json);
	else:
		$json['type'] = 'error';
	endif;
endif;

if (isset($_POST['delcart'])):
	$db->delete(Content::crTable, "pid=" . Filter::$id . " AND pvid = ".$_POST['pvid']." AND user_id = '" . $db->escape($user->username) . "'");

	$json['cartquantity'] = $content->getCartCounterBasic();
	$json['cartcost'] = $content->getCartCounterCost();
	$json['pid'] = Filter::$id;
	$json['pvid'] = $_POST['pvid'];
	
	$content->calculateInvoice();

	print json_encode($json);
endif;

if (isset($_POST['removecart'])):

	if (isset($_POST['var_id'])) {
		$row = $db->first("SELECT id, price, points FROM " . Products::pTable . " WHERE id = " . Filter::$id);
		$cart_item = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND pvid = ".$_POST['var_id']." AND user_id = '" . sanitize($user->username) . "'");
	} else {
		$row = $db->first("SELECT id, price, points FROM " . Products::pTable . " WHERE id = " . Filter::$id);
		$cart_item = $db->first("SELECT * FROM " . Content::crTable . " WHERE pid = " . Filter::$id . " AND user_id = '" . sanitize($user->username) . "'");
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
		$db->delete(Content::crTable, "pid=" . Filter::$id . " AND pvid = ". $_POST['var_id'] ." AND user_id = '" . $db->escape($user->username) . "'");
		$db->delete(Content::exTable, "user_id = '" . $user->username . "'");
		$json['type'] = ($db->affected()) ? 'success' : 'error';
	}

	$json['productquantity'] = $cart_item->qty - intval($_POST['qty']);
	$json['producttotal'] = "$" . number_format($json['productquantity'] * floatval($price), 2);

	$json['cartquantity'] = $content->getCartCounterBasic();
	$json['cartcost'] = $content->getCartCounterCost();

	$json['pid'] = $row->id;
    $json['pvid'] = $_POST['var_id'];
   
   	$content->calculateInvoice();

	unset($row);
	print json_encode($json);
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
			'created' => date("Y-m-d H:i:s")
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


?>
