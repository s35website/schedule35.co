<?php
  /**
   * Main
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>



<?php
	$receiptid = $_GET['tx'];
	$receiptInvoice = $item->getWholesaleReceiptInvoice($receiptid);
	$receiptProducts = $item->getWholesaleReceiptProducts($receiptid);
	$userDetails = $user->getUserInfoWithID($receiptInvoice->user_id);
	$productrow = $item->getAllProducts();
 ?>
 
 <style>
 	.panel-compact .form-group {
 		margin-bottom:  10px;
 	}
 	.panel.red-box {
 		border-color: red!important;
 	}
 	.panel.blue-box {
 			border-color: #399bff!important;
 		}
 </style>


<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Record (#<?php echo $receiptInvoice->id;?>)</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=invoices<?php echo($invoiceSession) ?>">Invoices</a></li>
			<li class="active">Edit Record</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=invoices" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all invoices</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<!-- START RECORD TABLE -->
	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				
				
				
				
				<!-- Order Details -->
				<div class="panel panel-default">
				
					<div class="panel-title">
						Order Summary

						<ul class="panel-tools">
							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
						</ul>
					</div>

					<div class="panel-body">
					<form class="form-horizontal form-display transaction form_transaction" name="form_transaction" method="post">
						<div class="row">
							<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">

								<table class="table table-hover" style="padding-bottom: 24px; margin-bottom: 24px;">
									<thead>
										<tr>
											<td style="padding-left: 0;">Product</td>
											<td style="text-align: center;">Quantity</td>
											<td></td>
											<td style="text-align: center;">Price</td>
											<td>Total Price</td>
										</tr>
									</thead>
									<tbody>
									<input type="hidden" name="invid" value="<?php echo($receiptInvoice->invid); ?>" />
							<?php $total_weight = 0; ?>
							<?php foreach ($receiptProducts as $prow):?>
							<?php 
								$total_weight = $total_weight + $prow->weight * $prow->item_qty; 
							?>
										
										<tr class="product-selections">
										<input type="hidden" name="id" value="<?php echo $prow->id ?>" />
											<td style="padding-left: 0;">
												<select class="selectpicker" name="pid" style="max-width: 224px;" data-validetta="required">
													<?php foreach($productrow as $lrow):?>
														<option value="<?php echo $lrow->id ?>" <?php if($lrow->id == $prow->pid){ echo 'selected'; } ?>><?php echo $lrow->title?></option>
													<?php endforeach;?>
													<?php unset($lrow);?>
												</select>
											</td>
											<td style="text-align: center;">
												<input type="number" class="form-control" name="qty" style="max-width: 100px; margin: 0 auto;text-align: center;" value="<?php echo $prow->item_qty ?>">
											</td>
											
											<td style="text-align: center;"><i class="fa fa-times"></i></td>
											
											<td style="text-align: center;">
												<input type="text" class="form-control" name="price" style="max-width: 100px; margin: 0 auto;text-align: center;" value="$<?php echo $prow->price ?>">
											</td>
											<td class="subtotal"><?php echo($core->formatMoney($prow->price*$prow->item_qty)) ?></td>
										</tr>
							<?php endforeach;?>
							<?php unset($prow);?>
										<tr class="add-product-section">
											<td colspan="5">
												<button type="button" class="btn btn-default add-product">Add Product</button>
											</td>
										</tr>
									</tbody>
								</table>


								<p style="margin-bottom: 30px;">Net weight = <strong><?php echo $total_weight ?> g</strong> (<?php echo $total_weight*0.00220462?> lbs)</p>
								
								
								<div class="boxie" style="background: #f5f5f5;padding-top: 24px;padding-bottom: 18px;">
								
									<!-- Start Row: Product Name and Product Slug -->
									<div class="row">
										<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
											<div class="form-group" style="margin-bottom: 0;">
												<label class="col-sm-3 control-label form-label">Subtotal:</label>
												<div class="col-sm-9">
													<p class="form-control-static">$<?php echo($receiptInvoice->originalprice); ?></p>
												</div>
											</div>
										</div>
									</div>
	
									<div class="row bordered">
										<div class="col-sm-3 col-sm-offset-1 border" style="margin-top: 12px; margin-bottom: 12px;"></div>
									</div>
	
									<!-- Start Row: Product Name and Product Slug -->
									<div class="row">
										<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
											<div class="form-group" style="margin-bottom: 0;">
												<label class="col-sm-3 control-label form-label">Shipping:</label>
												<div class="col-sm-9">
													<p class="form-control-static">$<?php echo($receiptInvoice->shipping); ?></p>
												</div>
											</div>
										</div>
									</div>
	
									<!-- Start Row: Product Name and Product Slug -->
									<div class="row">
										<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
											<div class="form-group" style="margin-bottom: 0;">
												<label class="col-sm-3 control-label form-label">Tax:</label>
												<div class="col-sm-9">
													<p class="form-control-static">$<?php echo($receiptInvoice->totaltax); ?></p>
												</div>
											</div>
										</div>
									</div>
	
									<div class="row bordered">
										<div class="col-sm-3 col-sm-offset-1 border" style="margin-top: 12px; margin-bottom: 12px;"></div>
									</div>
	
									<!-- Start Row: Product Name and Product Slug -->
									<div class="row">
										<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
											<div class="form-group">
												<label class="col-sm-3 control-label form-label">Total:</label>
												<div class="col-sm-9">
													<p class="form-control-static"><strong>$<?php echo($receiptInvoice->totalprice); ?></strong></p>
												</div>
											</div>
										</div>
									</div>
	
								</div>
								
								
								<div class="col-md-12 top40 bot20">
									<button type="button" name="transactionSubmit" class="btn btn-default save-product-selection-change">Save Changes</button>
									<button type="button" class="btn btn-default invoice-print">Print Invoice</button>
									<div class="img-loading">
									  <span class="css-loading"></span>
									</div>
								</div>
	

							</div>
						</div>
						</form>
					</div>

				</div>
				
				
				
				

				<!-- Shipping Details -->
				<div class="panel panel-default panel-compact <?php echo ($receiptInvoice->heatflag == 1)?('red-box'):('blue-box');  ?>">

					<div class="panel-title">
						Invoice Details
						<ul class="panel-tools">
							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
						</ul>
					</div>

					<div class="panel-body">
						<form class="form-horizontal form-display transaction form_submission" name="form_submission" method="post">

							<!-- Start Row: ID -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">ID:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $receiptInvoice->id;?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Invoice # -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Invoice #:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><strong><?php echo($receiptInvoice->invid); ?></strong> </p>
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Created -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Created:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo date("F j, Y", strtotime($receiptInvoice->created));?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Company:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><strong><?php echo $receiptInvoice->company;?></strong></p>
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Name:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $receiptInvoice->name;?></p>
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Address -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Address:</label>
										<div class="col-sm-9">
											<p class="form-control-static">
												<?php if ($receiptInvoice->address2) {echo $receiptInvoice->address2 . ' - ';}?> <?php echo $receiptInvoice->address;?>, <?php echo $receiptInvoice->city;?>, <?php echo $receiptInvoice->state;?>, <?php echo $receiptInvoice->zip;?>
											</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Phone -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Phone:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo ($receiptInvoice->phone)?( $receiptInvoice->phone):('&nbsp;');  ?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Email -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Email:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $receiptInvoice->user_id;?>"><?php echo $userDetails->username;?></a>&nbsp;</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Weight -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Estimated Weight:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><strong><?php echo($total_weight); ?> g</strong> (<?php echo($total_weight * 0.00220462); ?> lbs)</p>
										</div>
									</div>
								</div>
							</div>
							

								<!-- Start Row: Shipping Type -->
								<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Shipping Type:</label>
										<div class="col-sm-9">
											<p class="form-control-static">
												<?php
												if ($receiptInvoice->shipping >= $core->shipping_express) {
													echo("<span class='clr_express'>Express ($" . $receiptInvoice->shipping . ")</span>");
												}
												elseif ($receiptInvoice->shipping < $core->shipping_express) {
													echo("<span class='clr_standard'>Standard ($" . $receiptInvoice->shipping . ")</span>");
												}
												else {
													echo("Undefined");
												}
												?>
											</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Status -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Status: </label>
										<div class="col-sm-9">
											<select class="selectpicker" id="status" name="status" style="min-width: 264px;" data-validetta="required">
												<option value="0" <?php echo getSelected($receiptInvoice->status, "0");?>>Payment Instructions Sent</option>
												<option value="1" <?php echo getSelected($receiptInvoice->status, "1");?>>Paid</option>
												<option value="1.2" <?php echo getSelected($receiptInvoice->status, "1.2");?>>Exported</option>
												<option value="1.5" <?php echo getSelected($receiptInvoice->status, "1.5");?>>Label Printed</option>
												<option value="2" <?php echo getSelected($receiptInvoice->status, "2");?>>Packaged</option>
												<option value="3" <?php echo getSelected($receiptInvoice->status, "3");?>>Delivered</option>
											</select>
										</div>
									</div>
								</div>

								<!-- Start an Alert -->
								<div id="alertShipped" class="kode-alert alert3 kode-alert-top-right">
									<a href="#" class="closed">&times;</a>
									<h4>Shipping status changed!</h4>
									An email will be sent to the user to notify them of this update.
								</div>
								<!-- End an Alert -->

								<!-- Start an Alert -->
								<div id="alertBoxed" class="kode-alert alert10 kode-alert-top-right">
									<a href="#" class="closed">&times;</a>
									<h4>Shipping status changed!</h4>
									An email will be sent to the user to notify them of this update.
								</div>
								<!-- End an Alert -->

							</div>

							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Tracking Number:</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="trackingnum" name="trackingnum" value="<?php echo $receiptInvoice->trackingnum;?>">
										</div>
									</div>
								</div>
							</div>

							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
								  <div class="form-group">
								    <label class="col-sm-3 control-label form-label">Note:</label>
								    <div class="col-sm-8">
								      <textarea rows="4" cols="50" class="form-control" id="note" name="note"><?php echo $receiptInvoice->note;?></textarea>
								    </div>
								  </div>
								</div>
							</div>


							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">

										<input type="hidden" id="notify" name="notify" value="0" />
										<input type="hidden" id="username" name="username" value="<?php echo $userDetails->username;?>" />
										<input type="hidden" id="fname" name="fname" value="<?php echo $receiptInvoice->name;?>" />
										<input name="updateWholesaleInvoice" type="hidden" value="1">
										<input name="id" type="hidden" value="<?php echo $receiptInvoice->id;?>" />
										<input name="invid" type="hidden" value="<?php echo $receiptInvoice->invid;?>" />


										<div class="col-md-12 top40 bot20">
											<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
											<a href="index.php?do=invoices" class="btn btn-light">Cancel</a>
											<div class="img-loading">
											  <span class="css-loading"></span>
											</div>
										</div>
									</div>
								</div>
							</div>


						</form>

					</div>

				</div>


				


			</div>

		</div>
		<!-- End Row -->


	</div>
	<!-- END CONTAINER -->

								
	<!-- End an Alert -->
	<div id="msgholder"></div>
	<!-- End an Alert -->

	<!-- Start Footer -->
	<?php include("components/footer.php") ?>
	<!-- End Footer -->


</div>

<!-- Start invoice print -->
<div class="invoice-page">
		
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
								<?php echo $receiptInvoice->name ?><br>
								<?php echo $receiptProducts[0]->payer_email ?>
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
			
		</table>
	</div>

	<!-- End invoice print -->		

<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.form.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script type="text/javascript">

	$( document ).ready(function() {
		$('.invoice-print').click(function(){
			window.print()
		
		});
		
		
	});
	
</script>
<style>
	.invoice-page {
		display: none;
	}
</style>
<link rel="stylesheet" media="print" href="<?php echo THEMEURL;?>/assets/css/wholesaleinvoiceprint.css?r=<?php echo(date("Ymd")); ?>v2" />
<script type="text/javascript">
	
	
	$( document ).ready(function() {
		$(".save-product-selection-change").click(function() {
			var wholeSaleTransactions = [];
			var invid = $(".form_transaction").find('input[name="invid"]').val();
			$(".product-selections").each(function(){
				var transactionItem = new Object();
				transactionItem["id"] = $(this).find('input[name="id"]').val();
				transactionItem["pid"] = $(this).find('select[name="pid"]').val();
				transactionItem["qty"] = $(this).find('input[name="qty"]').val();
				transactionItem["description"] = $(this).find('select[name="pid"] option:selected').text();
				var price = $(this).find('input[name="price"]').val();
				if("$" === price[0]){
					price = price.substr(1);
				}
				transactionItem["price"] = price;
				if(transactionItem["qty"] > 0){
					wholeSaleTransactions.push(transactionItem);
				}
			});
			$.ajax({
			type: "post",
			dataType: "json",
			url: "/admin/controller.php",
			data: {
			updateWholesaleTransactions: 1,
			invid: invid,
			items: wholeSaleTransactions
			},
			beforeSend: function() {
				$('.css-loading').show();
				$('#msgholder .kode-alert').hide();
				$('button[name=transactionSubmit]').prop('disabled', true);
			},
			success: function(json) {
				$("#msgholder").html(json.message);
				$('button[name=transactionSubmit]').prop('disabled', false);
				$('.css-loading').hide();
				$('#msgholder').show();
			},
			error: function() {
			
			}
			});

			});
		
		$(".add-product").click(function(evt){
			var productSelections = $(evt.target.closest("tbody")).find(".product-selections").first().clone();
			var id = productSelections.find('input[name="id"]').val();
			productSelections.find('input[name="id"]').val('new'+id);
			productSelections.find('select[name="pid"]').val('');
			productSelections.find('input[name="qty"]').val('');
			productSelections.find('input[name="price"]').val('');
			productSelections.find('.subtotal').text('');
			productSelections.insertBefore(evt.target.closest(".add-product-section"));
		})	
		
  	
	});
	
</script>



