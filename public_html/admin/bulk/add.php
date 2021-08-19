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
<?php $prodrow = $item->getProductList();?>
<?php $gaterow = $content->getGateways(true);?>
<?php $userlist = $user->getUserList();?>

<style>
	.form-group {
		margin-bottom: 12px;
	}
</style>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">New Bulk Order</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=bulk">Bulk</a></li>
			<li class="active">Add Bulk Order</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=bulk" class="btn btn-light"><i class="fa fa-chevron-left"></i>View bulk orders</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- START PRODUCT TABLE -->
	<div class="container-widget">
	
		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					
					<div class="panel-title">
						Bulk Order Details
					</div>
			        
					<div class="panel-body">
						<form id="product_add" class="form_submission" name="form_submission" method="post">
							
							<!-- Shipping section -->
							
							<div class="shipping-section" style="background: #f2f2f2; padding: 30px;border: 1px solid #bdc4c9; margin: 12px 0 30px;">
								<div class="row">
									
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="item_qty" class="form-label">Name / Company</label>
											<input type="text" class="form-control" id="name" name="name" data-validetta="required" placeholder="Attention Name" value="">
										</div>
									</div>
									
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="item_qty" class="form-label">Email / Username</label>
											<input type="text" class="form-control" id="email" name="email" data-validetta="required" placeholder="Email / Username" value="">
										</div>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-sm-12 col-md-8">
										<div class="form-group">
											<label for="item_qty" class="form-label">Address</label>
											<input type="text" class="form-control" id="address" name="address" data-validetta="required" placeholder="Address" value="">
										</div>
									</div>
									
									<div class="col-sm-12 col-md-4">
										<div class="form-group">
											<label for="item_qty" class="form-label">Apt / Suite #</label>
											<input type="text" class="form-control" id="address2" name="address2" data-validetta="required" placeholder="Apt / Suite #" value="">
										</div>
									</div>
									
								</div>
								<div class="row">
									
									<div class="col-sm-12 col-md-4">
										<div class="form-group">
											<label for="item_qty" class="form-label">City</label>
											<input type="text" class="form-control" id="city" name="city" data-validetta="required" placeholder="City" value="">
										</div>
									</div>
									
									<div class="col-sm-12 col-md-4">
										<div class="form-group">
											<label for="item_qty" class="form-label">Province</label>
											<input type="text" class="form-control" id="state" name="state" data-validetta="required" placeholder="Province" value="">
										</div>
									</div>
									
									<div class="col-sm-12 col-md-4">
										<div class="form-group">
											<label for="item_qty" class="form-label">Postal Code</label>
											<input type="text" class="form-control" id="zip" name="zip" data-validetta="required" placeholder="Postal Code" value="">
										</div>
									</div>
									
								</div>
							</div>
							<!-- / Shipping section -->
							
							
							
							<!-- Product Section -->
							
							<div style="padding: 30px;border: 1px solid #bdc4c9; margin: 12px 0 30px;">
								
								<div class="row">
									<table class="table display">
										<thead>
											<tr>
												<th style="width: 350px;">Product</th>
												<th style="width: 100px;">Unit Cost</th>
												<th style="width: 100px;">Quantity</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="width: 350px;">
													<select style="width: 100%;">
														<option id="1">Apple Gummies</option>
														<option id="2">Strawberry Gummies</option>
														<option id="3">Peach Gummies</option>
													</select>
												</td>
												<td style="width: 100px;"><input type="number" name="price" value="10" /></td>
												<td style="width: 100px;"><input type="number" name="quantity" value="2" /></td>
												<td><span>20</span></td>
											</tr>
										</tbody>
									</table>
									
								</div>
								
								<div class="row">
									
									<div class="col-sm-12 col-md-12">
										<a  class="btn btn-primary"style="margin: 10px;" class="btn btn-default">New a Line</a>
									</div>
									
								</div>
							</div>
							<!-- / Shipping section -->
							
							<div class="row">
								
								<div class="col-md-12">
									<div class="form-group">
										<label for="note" class="form-label">Note</label>
										<textarea class="input-block-level" id="note" name="note" rows="6" style="display: block; width: 100%;max-width: 100%;">Write something about this order here...</textarea>
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="created" class="form-label">Date Created</label>
										<fieldset>
											<div class="control-group">
												<div class="controls">
													<div class="input-prepend input-group">
														<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" id="created" name="created" class="form-control" value="<?php echo(date("m/d/Y")); ?>" data-validetta="required"/>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								
								<input name="processBulkOrder" type="hidden" value="1">
								<div class="col-md-12 top20 bot10">
									<button type="button" name="dosubmit" class="btn btn-default">Add Order</button>
									<a href="index.php?do=bulk" class="btn btn-light">Cancel</a>
									<div class="img-loading">
									  <span class="css-loading"></span>
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
<script type="text/javascript" src="assets/js/bootstrap-select/bootstrap-select.js"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>