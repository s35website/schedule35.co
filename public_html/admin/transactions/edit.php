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


<?php $row = (Filter::$id) ? $item->getPaymentRecord() : Filter::error("You have selected an Invalid Id", "Products::getPaymentRecord()");;?>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Record</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=transactions">Transactions</a></li>
			<li class="active">Edit Record</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=transactions" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all transactions</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-10 col-md-12 titles">
			<h1><i class="fa fa-exchange"></i> Edit Record <mark><?php echo $row->txn_id;?></mark></h1>
			<h4>Here you can manually assign payment transaction. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
		</div>
	
	</div>
	<!-- End Presentation -->
	
	
	<!-- START RECORD TABLE -->
	<div class="container-widget">
	
		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					
					<div class="panel-title">
						Transaction Details
					</div>
			        
					<div class="panel-body">
						<form class="form-horizontal form-display transaction form_submission" name="form_submission" method="post">
						
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">ID:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $row->id;?> / <strong><?php echo $row->txn_id;?></strong></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row" style="display: none;">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Username:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->uid;?>"><?php echo $row->username;?></a>&nbsp;</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">User ID:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $row->uid;?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Product ID:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $row->pid;?></p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Product Name:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><a href="index.php?do=products&amp;action=edit&amp;id=<?php echo $row->pid;?>"><?php echo $row->title;?></a>&nbsp;</p>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Transaction Date:</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo date("F j, Y", strtotime($row->created));?></p>
										</div>
									</div>
								</div>
							</div>
							
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Price:</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="price" name="price" value="<?php echo $row->price;?>" data-validetta="required">
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Quantity:</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="item_qty" name="item_qty" value="<?php echo $row->item_qty;?>" data-validetta="required">
										</div>
									</div>
								</div>
							</div>
							
							
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Default Currency: </label>
										<div class="col-sm-9">
											<select class="selectpicker" id="currency" name="currency">
												<option value="CAD" <?php echo getSelected($row->currency, "CAD");?>>CAD</option>
												<option value="USD" <?php echo getSelected($row->currency, "USD");?>>USD</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-10 col-xs-offset-1 col-sm-offset-1">
									<div class="form-group">
										<label class="col-sm-2 control-label form-label">Payment Method: </label>
										<div class="col-sm-9">
											<select class="selectpicker" id="pp" name="pp">
												<option value="Offline" <?php echo getSelected($row->pp, "Offline");?>>Offline</option>
												<option value="Refunded" <?php echo getSelected($row->pp, "Refunded");?>>Refunded</option>
												<option value="Referral" <?php echo getSelected($row->pp, "Referral");?>>Referral</option>
												<option value="PayPal" <?php echo getSelected($row->pp, "PayPal");?>>PayPal</option>
												<option value="Stripe" <?php echo getSelected($row->pp, "Stripe");?>>Stripe</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							
							
							<div class="row bordered">
								<div class="col-sm-9 col-sm-offset-1 border"></div>
							</div>
							
							<div class="secondary-box top40">
							
								<!-- Start Row: Product Name and Product Slug -->
								<div class="row">
									<div class="col-sm-3 col-md-offset-1">
										<div class="form-group">
											<label for="paymentstatus_1" class="form-label show">Payment Status</label>
											<div class="radio radio-primary radio-inline">
											    <input type="radio" id="paymentstatus_1" name="status" value="1" <?php getChecked($row->status, 1); ?>>
											    <label for="paymentstatus_1"> Completed </label>
											</div>
											<div class="radio radio-primary radio-inline">
											    <input type="radio" id="paymentstatus_0" name="status" value="0" <?php getChecked($row->status, 0); ?>>
											    <label for="paymentstatus_0"> Pending </label>
											</div>
										</div>
									</div>
									
									
									<div class="col-sm-3">
										<div class="form-group">
											<label for="transaction_1" class="form-label show">Active</label>
											<div class="radio radio-primary radio-inline">
											    <input type="radio" id="transaction_1" name="active" value="1" <?php getChecked($row->active, 1); ?>>
											    <label for="transaction_1"> Yes </label>
											</div>
											<div class="radio radio-primary radio-inline">
											    <input type="radio" id="transaction_0" name="active" value="0" <?php getChecked($row->active, 0); ?>>
											    <label for="transaction_0"> No </label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row top20">
									<div class="col-md-9 col-md-offset-1">
										<div class="form-group">
											<label for="summernote" class="form-label">Transaction Memo</label>
											
											<textarea class="input-block-level" id="summernote" name="memo" rows="18">
												<?php echo $row->memo;?>
											</textarea>
										</div>
										
									</div>
								</div>
								
								<div class="row">
									<div class="form-group">
										<input name="processTransaction" type="hidden" value="1">
										<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
										
										<div class="col-md-10 top20 bot20 col-md-offset-1">
											<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
											<a href="index.php?do=transactions" class="btn btn-light">Cancel</a>
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