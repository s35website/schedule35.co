<?php
  /**
   * Invoices
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: invoices.php, v3.00 2014-07-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->logged_in)
	  redirect_to("home");
	  $receiptid = $_GET['tx'];
  	$receiptInvoice = $item->getWholesaleReceiptInvoice($receiptid);
	$receiptProducts = $item->getWholesaleReceiptProducts($receiptid);
?>
<?php $_SESSION["pageurl"] = "wholesale?p=invoice"; ?>


<div class="main">

		<section class="wrapper cart-padding padded mini bg-lightgrey padded-b-120">
			<!-- Checkout Nav -->
	<ul class="checkout-progress">
				<li class="active">Checkout</li>
				<li class="active">Payment</li>
				<li class="active">Invoice</li>
			</ul>
	
	<div class="invoice-page" style="margin-top:30px;">
		
		<!-- Header Table -->
		<table class="invoice-box" cellpadding="0" cellspacing="0">
			<tr class="top">
				<td colspan="2">
					<table>
						<tr>
							<td class="title">
								<img src="<?php echo THEMEURL;?>/assets/img/logo-black.svg" style="width:100%; max-width:96px;">
							</td>
							
							<td>
								Invoice #: <?php echo $receiptid ?><br>
								<?php $invoiceCreatedDate =  strtotime($receiptInvoice->created) ?>
								Created: <?php echo date('F j, Y', $invoiceCreatedDate); ?><br>
								<?php if("Cash" == $receiptInvoice->pp || "eTransfer" == $receiptInvoice->pp){ ?>
								Due: <?php echo date('F j, Y', strtotime("+1 month", $invoiceCreatedDate)); ?>
								<?php } ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr class="information">
				<td colspan="2">
					<table>
						<tr>
							<td>
								<?php echo $receiptInvoice->address ?><br>
								
								<?php 
									if ($receiptInvoice->address2) {
										echo($receiptInvoice->address2 . "<br>");
									}
								 ?>
								<?php echo $receiptInvoice->city .", ". $receiptInvoice->state . " " . $receiptInvoice->zip ?>
							</td>
							
							<td>
								<?php echo $receiptInvoice->name ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="heading">
				<td>
					Payment Method
				</td>
				
				<td>
					Status
				</td>
			</tr>
			
			<tr class="details">
				<td>
					<?php echo $receiptInvoice->pp ?>
				</td>
				
				<td>
				<?php
					if ($receiptInvoice->status == 4) {
						echo('error');
					}elseif ($receiptInvoice->status == 3) {
						echo('shipped');
					}elseif ($receiptInvoice->status == 2) {
						echo('packaged');
					}elseif ($receiptInvoice->status == 1) {
						echo('paid');
					}
					else {
						echo('unpaid');
					}
				?>
				</td>
			</tr>
		</table>
		
		
		<!-- Product Table -->
		<table class="invoice-products" cellpadding="0" cellspacing="0">
		<?php if($receiptProducts):?>
			<tr class="heading">
				<td>
					Item
				</td>
				<td>
					Rate
				</td>
				<td>
					Qty
				</td>
				<td>
					Line Total
				</td>
			</tr>
			<?php foreach ($receiptProducts as $prow):?>
			<tr class="item">
				<td>
					<?php echo $prow->title ?>
				</td>
				<td>
					$<?php echo $prow->price ?>
				</td>
				<td><?php echo $prow->item_qty ?></td>
				<td>
					<?php echo($core->formatMoney($prow->price*$prow->item_qty)) ?>
				</td>
			</tr>
			<?php endforeach;?>
			<?php unset($prow);?>
			<?php endif;?>
			
			<tr class="total">
				<td></td>
				
				<td colspan="3">
					<table class="total">
						<tr>
							<td>Subtotal: </td>
							<td class="subtotal-line" colspan="3">
							    <?php echo($core->formatMoney($receiptInvoice->originalprice)); ?>
							</td>
						</tr>
						<?php if($core->formatMoney($receiptInvoice->coupon) != "FREE"){ ?>
						<tr>
							<td>Discount: </td>
							<td class="subtotal-line" colspan="3">
							    <?php echo($core->formatMoney($receiptInvoice->coupon)); ?>
							</td>
						</tr>
						<?php } ?>
						<?php if($core->formatMoney($receiptInvoice->shipping) != "FREE"){ ?>
						<tr>
							<td>Shipping: </td>
							<td class="subtotal-line" colspan="3">
							    <?php echo($core->formatMoney($receiptInvoice->shipping)); ?>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td>GST (<?php echo $receiptInvoice->tax*100?>%):</td>
							<td class="subtotal-line" colspan="3">
							    <?php echo($core->formatMoney($receiptInvoice->totaltax)); ?>
							</td>
						</tr>
						<?php if($receiptInvoice->pp != "Cash" && $receiptInvoice->pp != "eTransfer"){ ?>
						<tr>
							<td>Service Fee:</td>
							<td class="subtotal-line" colspan="3">
							    <?php echo($core->formatMoney($receiptInvoice->totalprice - $receiptInvoice->total - $receiptInvoice->totaltax)); ?>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td class="total-line">Total:</td>
							<td class="total-line" colspan="3">
							<?php echo($core->formatMoney($receiptInvoice->totalprice)); ?>
							</td>
						</tr>
					</table>
				</td>
				
				
			</tr>
			
			<tr class="note">
				<td colspan="4">
					<?php if("Cash" == $receiptInvoice->pp){ ?>
						<span style="font-weight: bold;">Notes</span> <br />
						To Schedule a pickup, text or call <a href="tel:647-847-6557">647-847-6557</a> or send us an email <a href="mailto:hi@budabomb.com">hi@budabomb.com</a>
					<?php }elseif ("eTransfer" == $receiptInvoice->pp) { ?>
						<span style="font-weight: bold;">Notes</span> <br />
						To finalize your invoice send an e-Transfer to support@getsango.com with the following details: <br />
					Question: Order #: <?php echo $receiptid ?> <br />
					Answer: buuda420
					<?php } ?>
				</td>
			</tr>
			<tr class="print">
				<td colspan="4">
					<a class="btn fr black invoice-print" href="javascript:void(0)" style="padding: 5px 35px; margin-bottom:10px"><span>Print</span></a>	
				</td>
			</tr>
		</table>
	</div>
	</section>
	</div>
<link rel="stylesheet" media="print" href="<?php echo THEMEURL;?>/assets/css/wholesaleinvoiceprint.css?r=<?php echo(date("Ymd")); ?>" />
<?php require(THEMEDIR . "/components/scripts.tpl.php"); ?>
<script type="text/javascript">

	$( document ).ready(function() {
		$('.invoice-print').click(function(){
			window.print()
		
		});
		
		
	});
	
</script>