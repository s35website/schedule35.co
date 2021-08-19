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

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Add FAQ</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=faq">FAQs</a></li>
			<li class="active">Add FAQ</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=faq" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all slides</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-8 col-md-12 titles">
			<h1>Add FAQ</h1>
			<h4>Here you can add a new question. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
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
						Frequently Asked Question
					</div>
			        
					<div class="panel-body">
						<form id="faq_add" name="faq_add" method="post">
							
							
							<div class="row">
							
								<div class="col-md-12">
									<div class="form-group">
										<label for="question" class="form-label">Question</label>
										<textarea class="form-control" rows="2" id="question" name="question" data-validetta="required,minLength[1]"></textarea>
									</div>
								</div>
							
								<div class="col-md-12">
									<div class="form-group">
										<label for="answer" class="form-label">Answer</label>
										<textarea class="form-control" rows="8" id="answer" name="answer" data-validetta="required,minLength[1]"></textarea>
									</div>
								</div>
								
								
							</div>
							
							
							<div class="row">
								<input name="processFaq" type="hidden" value="1">
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Add Question</button>
									<a href="index.php?do=faq" class="btn btn-light">Cancel</a>
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

<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
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
	
	$( "body" ).on( "click", "textarea", function() {
	  $('button[name=dosubmit]').prop('disabled', false);
	});


	scrollPosition = $(document).height();

	/* == Master Form == */
	$('body').on('click', 'button[name=dosubmit]', function() {
		function showResponse(json) {
			$("#msgholder").html(json.message);
			$("body").animate({
				scrollTop: scrollPosition
			}, '400');
			$('button[name=dosubmit]').prop('disabled', true);
		}

		var options = {
			target: "#msgholder",
			/*beforeSubmit: showLoader,*/
			success: showResponse,
			type: "post",
			url: "controller.php",
			dataType: 'json'
		};

		$('#faq_add').ajaxForm(options).submit();
	});
	
	function showResponse() {
		$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
		$("body").animate({
			scrollTop: scrollPosition
		}, '400');
	}
	// Javascript form validation
	$('#faq_add').validetta({
		realTime: true,
		display: 'inline',
		errorTemplateClass: 'validetta-inline',
		errorClose: false,
		onError: showResponse
	});

});
</script>