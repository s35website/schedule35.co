<?php
  /**
   * Index
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: index.php, v3.00 2014-07-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("init.php");

	if ($_GET['checkuser'] == "yes"){
		$_SESSION["editurl"] = $_GET['id'];
	}
	
	if (!$user->is_Admin()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory</title>
  <style>
  	
  	* {
  		font-family: Arial, sans-serif;
  	}
  	
  	.title {
  		font-weight: bold;
  	}
	
	@media print { 
		.hide-print {
			display: none;
		}
	}
  </style>
</head>
<body>
	
	<h2>Online Orders</h2>
	<!-- START CONTENT: Online orders -->
	<?php
	
		$fromdate = date("Y-m-d H:i:s", strtotime("-3 month"));
		$statusDisplay = "All Invoices";
		
		$status = 1.5;
		$inrow = $item->getInventory();
		
		if ($inrow) {
			$count_row = 1;
			$p_cat = array();
			$total_row = count($inrow);
			
			foreach ($inrow as $row) {
				$receiptProducts = $item->getReceiptProducts($row->invid);
				
				foreach ($receiptProducts as $prow) {
					$crow = Core::getRowById(Content::cTable, $prow->cid);
					
					if(array_key_exists($crow->name, $p_cat)){
						if(array_key_exists($prow->title .$variantTitle,$p_cat[$crow->name])){
							$p_cat[$crow->name][$prow->title .$variantTitle] = $p_cat[$crow->name][$prow->title .$variantTitle] + $prow->item_qty;
						}else{
							$p_cat[$crow->name][$prow->title .$variantTitle] = $prow->item_qty;
						}
					}else{
						$p_cat[$crow->name] = array();
						$p_cat[$crow->name][$prow->title .$variantTitle] = $prow->item_qty;
					}
				}
				
				unset($prow);
				
				if ($total_row == $count_row) {
					if (!empty($p_cat)) {
						ksort($p_cat);
						foreach ($p_cat as $cname => $c_arr) {
							echo '<div class="title">' . $cname .' </div>';
							ksort($c_arr);
							foreach ($c_arr as $key => $value) {
							    echo '<div>' . $key . ' : ' . $value .' </div>';
							}
						}
					}
				}
				$count_row++;
			}
		}
	
	?>
	
	
	
	<h2>Bulk Orders</h2>
	
	
	
	<!-- ================================================
	jQuery Library
	================================================ -->
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	

</body>

</html>
