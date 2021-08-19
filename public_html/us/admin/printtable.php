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
	<title>Print Invoice Table</title>
	<style>
	body {
		font-family: sans-serif;
		font-size: 14px;
	}
	.title {
		font-weight: bold;
		margin: 10px 0 5px;
	}
		table {
			text-align: left;
			font-family: sans-serif;
			font-size: 14px;
			border-collapse: collapse;
		}
		table td, table th {
			vertical-align: top;
			border: 1px solid #ddd;
			padding: 10px;
		}
		tr:nth-child(even) {
			background-color: #f4f4f4
		}
	.order p {
		margin: 0 0 5px;
		white-space: nowrap;
	}
	.order p:last-of-type {
		margin-bottom: 0;
	}
	.summary {
		border: 3px solid #333;
	}
		.summary-row{
				float: left;
				margin-right: 25px;
		}
		.summary-row label{
				font-weight: bold;
				margin-bottom: 5px;
		border-bottom: 1px solid #333;
				display: block;
		}
		.summary-row > div {
				line-height: 125%;
		}
	
	.hide-print {
		margin-bottom: 30px;
	}
	
	@media print { 
		.hide-print {
			display: none;
		}
	}
	</style>
</head>
<body>

	
	<!-- START CONTENT -->
	<?php
	
		$fromdate = date("Y-m-d H:i:s", strtotime("-3 month"));
		$statusDisplay = "All Invoices";
	
	if (isset($_GET['status'])) {
	
		$status = $_GET['status'];
		$status = number_format((float)$status, 1, '.', '');
		$inrow = $item->getInvoices($fromdate, $status);
		
	} else {
		$inrow = $item->getInvoices($fromdate, null);
	}
	
		$fromdate = date("Y-m-d H:i:s", strtotime("-3 month"));
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
		$status = number_format((float)$status, 1, '.', '');
		$status = number_format((float)$status, 1, '.', '');
		$inrow = $item->getInvoices($fromdate, $status);
	}
	
	?>
	<div class="hide-print">
	<a href="printtable.php?status=3">Shipped</a> |
	<a href="printtable.php?status=2">Packaged</a> |
	<a href="printtable.php?status=1.5">Labelled</a> |
	<a href="printtable.php?status=1.2">Exported</a> |
	<a href="printtable.php?status=1">Paid</a> |
	<a href="printtable.php?status=0">Unpaid</a> |
	<a href="printtable.php">All</a>
	</div>
	
	<table id="testTable" class="table display">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Order</th>
			<th>Total Price</th>
			<th>Size</th>
			<th>Note</th>
		</tr>
	</thead>
	
	
	<tbody>
		<?php if(!$inrow):?>
		<tr>
			<td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
		</tr>
		<?php else:?>
		<?php
		$count_row = 1;
		$p_cat = array();
		$total_row = count($inrow);
		foreach ($inrow as $row):?>
		<tr>
			<td>
				<?php echo $row->id;?>
			</td>
			<td>
				<p style="text-transform:uppercase;margin-top:0;margin-bottom:2px">
					<?php echo $row->name;?> <span style="font-weight: bold;">(<?php echo $content->countUserOrders($row->user_id); ?>)</span>
				</p>
				<span style="font-size: 80%;color:#333"><?php echo($row->trackingnum); ?></span>
			</td>
	
			<td class="order">
				<?php
					$receiptProducts = $item->getReceiptProducts($row->invid);
	
					foreach ($receiptProducts as $prow) {
						$variantTitle = ($prow->variantTitle != "" ? " (".$prow->variantTitle.")" : "");
	//							if($_GET['status'] == "packaged"){
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
	//							}
	
						echo('<p>' . $prow->title .$variantTitle . ' x <strong>' . $prow->item_qty . "</strong></p>");
	
					}
	
				?>
				<?php unset($prow);?>
			</td>
	
			<td>
			<?php 
				if ($row->pp == "Points") {
					echo(intval($row->totalprice) . " pts");
				}
				else {
					echo(formatMonies($row->totalprice));
				}
			 ?>
				<span style="display: none;">
					<?php echo($row->pp); ?>
				</span>
			</td>
		
		<td>
			
			<?php
				$t_qty = 0; // total quantity (chocolates count as two)
			 	foreach ($receiptProducts as $prow) {
			 		// If black label
			 		if ($prow->cid == 2) {
			 			$t_qty = $t_qty + ($prow->item_qty * 2);
			 		}
			 		// If chocolate
			 		elseif ($prow->cid == 3) {
				 		$t_qty = $t_qty + ($prow->item_qty * 2);
				 	}
				 	// If Bundles
			 		elseif ($prow->cid == 4) {
				 		$t_qty = $t_qty + ($prow->item_qty * 12);
				 	}
			 		else {
			 			$t_qty = $t_qty + $prow->item_qty;
			 		}
			 	}
				if ($t_qty < 9) {
					echo("Small Bag");
				}
				elseif ($t_qty < 16) {
					echo("Box 6x4x4");
				}
				elseif ($t_qty < 23) {
					echo("Box 6x6x4");
				}
				elseif ($t_qty < 32) {
					echo("Box 9x6x4");
				}
				else {
					echo("Large Bag");
				}
			?>
		</td>
			
			<td>
			<?php echo($row->note); ?>
			</td>
	
	
	
		</tr>
		<?php
			//Display summary of 10 rows
		if( isset($_GET['status']) && ( $count_row % 10 == 0 || $total_row == $count_row ) ){ ?>
		<tr>
			<td class="summary" colspan="6">
				<?php
				if(!empty($p_cat)){
					ksort($p_cat);
					foreach ($p_cat as $cname => $c_arr) { ?>
						<div class="summary-row">
							<label><?php echo $cname; ?></label>
							<?php
							 ksort($c_arr);
							 foreach ($c_arr as $key => $value) {
								echo '<div>' . $key . ' : ' . $value .' </div>';
							}
							?>
						</div>
					<?php
					}
				}
				$p_cat = array();
				?>
			</td>
		</tr>
		<?php
		}
		$count_row++;
		endforeach;?>
		<?php unset($row);?>
		<?php endif;?>
	
	</tbody>
	</table>
	
	
	
	
	
	<div class="total-summ" style="margin-top: 60px;padding-bottom: 60px;">
		
		<h2>Totals</h2>
		
		<?php 
			$row = $content->getAllCategories();
			
			// for each category
			foreach ($row as $crow) {
				$catrow = $content->renderCategories($crow->slug, $crow->id);
				if ($catrow) {
					echo '<div class="title">' . $crow->name .' </div>';
					
					// for each item inside the category
					foreach ($catrow as $lrow) {
						$totalrow = $item->getItemInventory($status, $lrow->id);
						if ($totalrow->total) {
							echo('<div class="item">' . $lrow->title . ': ');
							echo($totalrow->total);
							echo('</div>');
						}
						
					}
				}
			}
			
		 ?>
		
		
		
		
	</div>
	
	
	
	<!-- ================================================
	jQuery Library
	================================================ -->
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>


</body>

</html>
