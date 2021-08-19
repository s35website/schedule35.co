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

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Add Record</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=invoices">Invoices</a></li>
			<li class="active">Add Record</li>
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
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-10 col-md-12 titles">
			<h1><i class="fa fa-exchange"></i> Add Record</h1>
			<h4>Here you can manually create a payment transaction. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
		</div>
	
	</div>
	<!-- End Presentation -->
	
	
	<!-- START PRODUCT TABLE -->
	<div class="container-widget">
	
		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
					
					<div class="panel-title">
						Product Details
					</div>
			        
					<div class="panel-body">
						<form id="product_add" class="form_submission" name="form_submission" method="post">
						
							<!-- Start Row: Select User Select Product -->
							<div class="row">
							
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="uid" class="form-label">Select User</label>
										<select id="uid" name="uid" class="selectpicker " data-live-search="true">
											<option value="">--- <?php echo Lang::$word->TXN_SELUSER;?> ---</option>
											<?php if($userlist):?>
											<?php foreach ($userlist as $urow) : ?>
											<option value="<?php echo $urow->id; ?>"><?php echo $urow->username.' ('.$urow->name.')';?> </option>
											<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>
								
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="pid" class="form-label">Select Product <i class="fa fa-asterisk"></i></label>
										<select id="pid" name="pid" class="selectpicker " data-live-search="true">
											<option value="">--- Select Product ---</option>
											<?php if($prodrow):?>
											<?php foreach ($prodrow as $prow) : ?>
											<option value="<?php echo $prow->id; ?>"><?php echo $prow->title;?></option>
											<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
								</div>
							</div>
							
							
							<!-- Start Row: Payment Method Select Product -->
							<div class="row">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="pp" class="form-label">Select Payment Method</label>
										<select id="pp" name="pp" class="selectpicker" data-live-search="true">
											<option value="Offline">Offline</option>
											<?php if($gaterow):?>
											<?php foreach ($gaterow as $grow) : ?>
											<option value="<?php echo $grow->displayname;?>"><?php echo $grow->displayname;?></option>
											<?php endforeach; ?>
											<option value="Refunded">Refunded</option>
											<option value="Referral">Referral</option>
											<?php endif; ?>
										</select>
									</div>
								</div>
								
								
								<div class="col-sm-12 col-md-6">
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
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="item_qty" class="form-label">Quantity</label>
										<input type="text" class="form-control" id="item_qty" name="item_qty" data-validetta="number" placeholder="1" value="1">
									</div>
								</div>
								
								<div class="col-md-12 col-md-6">
									<label for="notify_1" class="form-label show">Notify User</label>
									<div class="radio radio-primary radio-inline">
								        <input type="radio" id="notify_1" name="notify" value="1"/>
								        <label for="notify_1"> Yes </label>
								    </div>
								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="notify_0" name="notify" value="0" checked="checked" />
								        <label for="notify_0"> No </label>
								    </div>
								</div>
								
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label for="summernote" class="form-label">Transaction Memo</label>
									<textarea class="input-block-level" id="summernote" name="memo" rows="18">
										Write something about your transaction here...
									</textarea>
								</div>
								
								<input name="processTransaction" type="hidden" value="1">
								<div class="col-md-12 top20 bot10">
									<button type="button" name="dosubmit" class="btn btn-default">Add Record</button>
									<a href="index.php?do=transactions" class="btn btn-light">Cancel</a>
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