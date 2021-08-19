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
<?php $row = Core::getRowById(Content::gTable, Filter::$id);?>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Gateway</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=gateways">Payment Gateway</a></li>
			<li class="active">Edit Gateway</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=gateways" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all gateways</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-10 col-md-12 titles">
			<h1><i class="fa fa-credit-card"></i> Edit <mark><?php echo $row->displayname;?></mark></h1>
			<h4>Here you can update your payment gateways.  <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
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
						Coupon Details
					</div>
			        
					<div class="panel-body">
						<form id="coupon_add" name="coupon_add" class="form_submission" method="post">
						
						
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="displayname" class="form-label">Gateway Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="displayname" name="displayname" placeholder="PayPal" data-validetta="required,minLength[1]" value="<?php echo $row->displayname;?>">
									</div>
								</div>
								
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="extra" class="form-label"><?php echo $row->extra_txt;?></label>
										<input type="text" class="form-control" id="extra" name="extra" value="<?php echo $row->extra;?>">
									</div>
								</div>
							</div>
							
							
							<div class="row">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="extra2" class="form-label"><?php echo $row->extra_txt2;?></label>
										<input type="text" class="form-control" id="extra2" name="extra2" value="<?php echo $row->extra2;?>">
									</div>
								</div>
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="extra3" class="form-label"><?php echo $row->extra_txt3;?></label>
										<input type="text" class="form-control" id="extra3" name="extra3" value="<?php echo $row->extra3;?>">
									</div>
								</div>
								
							</div>
							
							
							<div class="row">
								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="published_1" class="form-label show">Enable</label>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="published_1" name="active" value="1" <?php getChecked($row->active, 1); ?>/>
											<label for="published_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="published_0" name="active" value="0" <?php getChecked($row->active, 0); ?>/>
											<label for="published_0"> No </label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label for="demo_1" class="form-label show">Payment Mode</label>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="demo_1" name="demo" value="1" <?php getChecked($row->demo, 1); ?>/>
											<label for="demo_1"> Live </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="demo_0" name="demo" value="0" <?php getChecked($row->demo, 0); ?>/>
											<label for="demo_0"> Demo </label>
										</div>
									</div>
								</div>
								
							</div>
							
							
							<div class="row">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="ipn_url" class="form-label">IPN URL</label>
										<input type="text" class="form-control" id="ipn_url" value="<?php echo SITEURL.'/gateways/'.$row->dir.'/ipn.php';?>">
									</div>
								</div>
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="extra" class="form-label">&nbsp;</label>
										<a class="helpbox" href="#" data-toggle="modal" data-target="#helpModal">
											<i class="fa fa-question-circle"></i>
							            </a>
									</div>
								</div>
								
								<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title"><?php echo $row->displayname;?></h4>
											</div>
											<div class="modal-body">
												<?php echo cleanOut($row->info);?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							
							
							
							<div class="row">
								
								<input name="processGateway" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
								
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
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

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script src="assets/js/datatables/datatables.min.js"></script>
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>



<script>
	$(document).ready(function() {
		
				
		$("input").keyup(function() {
			$('button[name=dosubmit]').prop('disabled', false);
		});

		$("input").change(function() {
			$('button[name=dosubmit]').prop('disabled', false);
		});

		$("body").on("click", "textarea, .note-editor", function() {
			$('button[name=dosubmit]').prop('disabled', false);
		});
	
	
		$('#validuntil').daterangepicker({
			singleDatePicker: true
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
	
	
	
		scrollPosition = $(document).height();
	
		
		function showError() {
			$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
			$("body").animate({
				scrollTop: scrollPosition
			}, '400');
		}
		// Javascript form validation
		$('#coupon_add').validetta({
			realTime: true,
			display: 'inline',
			errorTemplateClass: 'validetta-inline',
			errorClose: false,
			onError: showError
		});
	
	});
</script>