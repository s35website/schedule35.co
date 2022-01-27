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
	$receiptInvoice = $item->getReceiptInvoice($receiptid);
	$receiptProducts = $item->getReceiptProducts($receiptid);
	$userDetails = $user->getUserInfoWithID($receiptInvoice->user_id);
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
	.form-display input.input-morph {
		border: 1px solid transparent;
		margin-left: -10px;
	}
	.form-display input.input-morph:hover {
		border: 1px solid #BDC4C9;
	}
	.form-display input.input-morph:active,
	.form-display input.input-morph:focus {
		border: 1px solid #479CCF;
	}
	.form-control {
		box-shadow: none;
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
				
				<?php if($receiptProducts):?>
				
				<!-- Items Details -->
				<div class="panel panel-default">

					<div class="panel-title">
						Order Summary

						<ul class="panel-tools">
							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
						</ul>
					</div>

					<div class="panel-body" style="display: none;">
						<div class="row">
							<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">

								<p style="display: none;">There are <code><?php echo $receiptInvoice->items;?> transaction(s)</code> in this invoice.</p>

								<table class="table table-hover" style="padding-bottom: 24px; margin-bottom: 24px;">
									<thead>
										<tr>
											<td style="padding-left: 0;">Product</td>
											<td>Quantity</td>
											<td>Price</td>
											<td>Total Price</td>
										</tr>
									</thead>
									<tbody>
										<?php
											$weight = 10; //weight of package
										?>
										<?php foreach ($receiptProducts as $row):?>
										<tr>
											<?php
											$variantTitle = ($row->variantTitle != "" ? " (".$row->variantTitle.")" : "");
											?>
											<td style="padding-left: 0;"><?php echo $row->title .$variantTitle; ?></td>
											<td><?php echo($row->item_qty); ?></td>
											<?php if($receiptInvoice->pp == 'Points'):?>
											<td><?php echo(number_format($row->price, 0)); ?>pts</td>
											<td><?php echo($row->price * $row->item_qty); ?>pts</td>
											<?php else:?>
											<td><?php echo(formatMonies($row->price)); ?></td>
											<td><?php echo(formatMonies($row->price * $row->item_qty)); ?></td>
											<?php endif;?>
											<?php
						                        if ($row->weight == 0 || $row->weight == "" || $row->weight == NULL) {
						                          $weight = $weight + ($row->item_qty * $row->variantWeight) + ($row->item_qty * 5);
						                        }
						                        else {
						                          $weight = $weight + ($row->item_qty * $row->weight);
						                        }
											 ?>
										</tr>
										
										<?php endforeach;?>
										<?php unset($row);?>
									</tbody>
								</table>


								<p style="margin-bottom: 30px;">Net weight = <strong><?php echo($weight); ?> g</strong> (<?php echo($weight * 0.00220462); ?> lbs)</p>

							</div>
						</div>
					</div>

				</div>

				<?php endif;?>

				<!-- Shipping Details -->
				<div class="panel panel-default panel-compact <?php echo ($receiptInvoice->heatflag == 1)?('red-box'):('blue-box');  ?>">

					<div class="panel-title">
						Invoice #: <?php echo($receiptInvoice->invid); ?>
						<ul class="panel-tools">
							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
						</ul>
					</div>

					<div class="panel-body">
						<form class="form-horizontal form-display transaction form_submission" name="form_submission" method="post">
							
							<div class="section-address">
							

								<!-- Start Row: Product Name and Product Slug -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">Name:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="name" name="name" value="<?php echo $receiptInvoice->name;?>">
											</div>
										</div>
									</div>
								</div>
	
								<!-- Start Row: Address -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">Address:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" id="address_1" name="address_1" value="<?php echo ucwords(strtolower($receiptInvoice->address));?>">
											</div>
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="address_2" name="address_2" value="<?php echo $receiptInvoice->address2;?>">
											</div>
										</div>
									</div>
								</div>
								
								<!-- Start Row: City -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">City:</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="city" name="city" value="<?php echo ucwords(strtolower($receiptInvoice->city));?>">
											</div>
										</div>
									</div>
								</div>
								
								<!-- Start Row: state -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">State / Postal Code:</label>
											<div class="col-sm-1">
												<select id="state" name="state" data-validetta="required">
													<option value="" disabled selected></option>
													
													<?php $provRow = $content->getProvinces(); ?>
													<?php foreach ($provRow as $prrow): ?>
													<option value="<?php echo($prrow->abbr); ?>" data-cost="<?php echo($prrow->shipping_cost); ?>" <?php echo $receiptInvoice->state == $prrow->abbr ? 'selected' : ''?>><?php echo($prrow->abbr); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="zip" name="zip" value="<?php echo strtoupper($receiptInvoice->zip);?>">
											</div>
										</div>
									</div>
								</div>
	
								<!-- Start Row: Phone -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">Phone:</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" id="phone" name="phone" value="<?php echo ($receiptInvoice->phone)?( $receiptInvoice->phone):('&nbsp;');  ?>">
											</div>
										</div>
									</div>
								</div>
							
							
							</div>
							
							<!-- Start Row: Invid -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Invoice #:</label>
										<div class="col-sm-4">
											<input type="text" class="form-control input-morph" id="invid-new" name="invid-new" value="<?php echo $receiptInvoice->invid;?>">
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
							
							<!-- Start Row: Created -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Created:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo date("F j, Y  g:i a", strtotime($receiptInvoice->created));?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Discount Code -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Discount Code:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo ($receiptInvoice->discount_code)?( $receiptInvoice->discount_code):('N/A');  ?></p>
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
												
													if ($receiptInvoice->shipping_class == 0 || !$receiptInvoice->shipping_class) {
														$shipping_type = Standard;
													}elseif ($receiptInvoice->shipping_class == 1) {
														$shipping_type = Express;
													}
													
													if ($receiptInvoice->pp == 'Points') {
														echo("<span class='clr_standard'>". $shipping_type . " (" . number_format($receiptInvoice->shipping, 0) . "pts)</span>");
													}else {
														echo("<span class='clr_express'>". $shipping_type . " ($" . $receiptInvoice->shipping . ")</span>");
													}
												
												 ?>
												
											</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Shipping Type -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Confirmation:</label>
										<div class="col-sm-9">
											<p class="form-control-static">
												
												<?php 
												
													if ($receiptInvoice->signature == 0 || !$receiptInvoice->shipping_class) {
														echo('None');
													}elseif ($receiptInvoice->shipping_class == 1) {
														echo('Signature');
													}
												
												 ?>
												
											</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Size -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Size:</label>
										<div class="col-sm-9">
											<p class="form-control-static">
												
												<?php
													$t_qty = 0; // total quantity (chocolates count as two)
												 	foreach ($receiptProducts as $prow) {
												 		if ($prow->cid == 2) {
												 			$t_qty = $t_qty + ($prow->item_qty * 2);
												 		}
												 		else {
												 			$t_qty = $t_qty + $prow->item_qty;
												 		}
												 	}
													if ($t_qty < 7) {
														echo("Small Bag");
													}
													elseif ($t_qty < 14) {
														echo("Box 6x4x4");
													}
													elseif ($t_qty < 22) {
														echo("Box 6x6x4");
													}
													elseif ($t_qty < 32) {
														echo("Box 9x6x4");
													}
													else {
														echo("Large Bag");
													}
												?>
											</p>
										</div>
									</div>
								</div>
							</div>
							
							
							<!-- Start Row: Weight -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Weight:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><strong><?php echo($weight); ?> g</strong> (<?php echo($weight * 0.00220462); ?> lbs)</p>
										</div>
									</div>
								</div>
							</div>
							
							
							<!-- Start Row: Shipping instructions -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-3 control-label form-label">Shipping Instructions:</label>
										<div class="col-sm-9">
											<p class="form-control-static">
												<?php
												if ($receiptInvoice->heatflag == 1) {
													echo("***Ship to local post office***");
												}
												elseif ($receiptInvoice->heatflag == 0) {
													echo("Deliver directly");
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
												<option value="1" <?php echo getSelected($receiptInvoice->status, "1");?>>Getting Boxed Up</option>
												<option value="1.2" <?php echo getSelected($receiptInvoice->status, "1.2");?>>Exported</option>
												<option value="1.5" <?php echo getSelected($receiptInvoice->status, "1.5");?>>Label Printed</option>
												<option value="2" <?php echo getSelected($receiptInvoice->status, "2");?>>Packaged</option>
												<option value="3" <?php echo getSelected($receiptInvoice->status, "3");?>>Shipped</option>
												<option value="4" <?php echo getSelected($receiptInvoice->status, "4");?>>Error</option>
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
										<input type="hidden" name="updateInvoice" value="1">
										<input type="hidden" name="id" value="<?php echo $receiptInvoice->id;?>" />
										<input type="hidden" name="invid" value="<?php echo $receiptInvoice->invid;?>" />
										
										
										<input type="hidden" name="address1" value="<?php if ($receiptInvoice->address2) {echo $receiptInvoice->address2 . ' - ';}?> <?php echo $receiptInvoice->address;?>" />
										<input type="hidden" name="address2" value="<?php echo $receiptInvoice->city;?>, <?php echo $receiptInvoice->state;?> <?php echo $receiptInvoice->zip;?>" />


										<div class="col-md-12 top40 bot20">
											<!--<a href="index.php?do=invoices<?php echo($invoiceSession) ?>" class="btn btn-light">Cancel</a>-->
											
											<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
											
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


				<!-- Invoice Details -->
				<div class="panel panel-default">

					<div class="panel-title">
						Invoice Summary

						<ul class="panel-tools">
							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
						</ul>
					</div>

					<div class="panel-body">
						<form class="form-horizontal form-display transaction form_submission" name="form_submission" method="post">
							
							<?php if($receiptInvoice->pp == 'Points'):?>
							<div class="boxie" style="background: #f5f5f5;padding-top: 24px;padding-bottom: 18px;">
								<!-- Start Row: Product Name and Product Slug -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group" style="margin-bottom: 0;">
											<label class="col-sm-3 control-label form-label">Subtotal:</label>
											<div class="col-sm-9">
												<p class="form-control-static"><?php echo(number_format($receiptInvoice->originalprice, 0)); ?> pts</p>
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
												<p class="form-control-static"><?php echo(number_format($receiptInvoice->shipping, 0)); ?> pts</p>
											</div>
										</div>
									</div>
								</div>
								

								<!-- Start Row: Product Name and Product Slug -->
								<div class="row">
									<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
										<div class="form-group" style="margin-bottom: 0;">
											<label class="col-sm-3 control-label form-label">Discount:</label>
											<div class="col-sm-9">
												<p class="form-control-static">(<?php echo(number_format($receiptInvoice->coupon, 0)); ?> pts)</p>
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
												<p class="form-control-static"><?php echo(number_format($receiptInvoice->totaltax, 0)); ?> pts</p>
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
											<label class="col-sm-3 control-label form-label">Total:</label>
											<div class="col-sm-9">
												<p class="form-control-static"><strong><?php echo(number_format($receiptInvoice->totalprice, 0)); ?> pts</strong></p>
											</div>
										</div>
									</div>
								</div>

							</div>
							<?php else:?>
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
											<label class="col-sm-3 control-label form-label">Discount:</label>
											<div class="col-sm-9">
												<p class="form-control-static">($<?php echo($receiptInvoice->coupon); ?>)</p>
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
										<div class="form-group" style="margin-bottom: 0;">
											<label class="col-sm-3 control-label form-label">Total:</label>
											<div class="col-sm-9">
												<p class="form-control-static"><strong>$<?php echo($receiptInvoice->totalprice); ?></strong></p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label form-label">Points Earned:</label>
											<div class="col-sm-9">
												<p class="form-control-static"><strong>+<?php echo($receiptInvoice->points); ?> pts</strong></p>
											</div>
										</div>
									</div>
								</div>

							</div>
							<?php endif;?>
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
