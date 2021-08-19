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
<?php $row = Core::getRowById(Content::slTable, Filter::$id);?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Slider</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=slider">Slider</a></li>
			<li class="active">Edit Slider</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=slider" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all slides</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-8 col-md-8 titles">
			<h1>Edit Slide</h1>
			<h4>Here you can add a new slide for your slider. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
		</div>
		
		<div class="col-md-4 slider">
			<?php if($row->thumb):?>
			<img src="<?php echo UPLOADURL;?>slider/<?php echo $row->thumb;?>" alt="<?php echo $row->caption;?>">
			<?php endif;?>
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
						Slide Details
					</div>
			        
					<div class="panel-body">
						<form id="slider_add" name="slider_add" method="post">
						
							<!-- Start Row: Username Password -->
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="caption" class="form-label">Slide Caption  <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" autocomplete="off" id="caption" name="caption" placeholder="eg. Featured Product: The Zambalaya" value="<?php echo $row->caption;?>" data-validetta="required">
									</div>
								</div>
								
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="thumbid" class="form-label">Select Image <i class="fa fa-asterisk"></i></label>
										
										<div class="custom-file-upload">
										    <input type="file" id="thumbid" name="thumb" style="padding: 5px;"/>
										</div>
									</div>
								</div>
								
							</div>
							
							
							<div class="row">
							
								<div class="col-md-12">
									<div class="form-group">
										<label for="body" class="form-label">Slider Text</label>
										<textarea class="form-control" rows="8" id="body" name="body"><?php echo $row->body;?></textarea>
									</div>
								</div>
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group urltype">
										<label for="newsletter_1" class="form-label show">Select URL type <i class="fa fa-asterisk"></i></label>
										<div class="radio radio-primary radio-inline">
											<input id="urltype_ext" name="urltype" type="radio" value="ext" data-link="url_external" <?php getChecked($row->urltype, "ext"); ?>>
											<label for="urltype_ext"> External Link </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input id="urltype_int" name="urltype" type="radio" value="int" data-link="url_internal" <?php getChecked($row->urltype, "int"); ?>>
											<label for="urltype_int"> Internal Link </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input id="urltype_nourl" name="urltype" type="radio" value="nourl" <?php getChecked($row->urltype, "nourl"); ?>>
											<label for="urltype_nourl"> No Link </label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-12 col-md-5">
								
									<div class="form-group slider_link" id="url_external" <?php echo ($row->urltype == "ext") ? "" : " style=\"display:none\""; ?>>
										<label for="url" class="form-label">External Link</label>
										<input type="text" class="form-control" autocomplete="off" id="url" name="url" placeholder="eg. http://www.google.com" value="<?php echo $row->url;?>">
									</div>
									
									<div class="form-group slider_link" id="url_internal" <?php echo ($row->urltype == "int") ? "" : " style=\"display:none\""; ?>>
										<label for="type" class="form-label">Internal Page</label>
										<?php echo Content::getProductList("id", $row->page_id);?> </div>
									</div>
									
								</div>
								
							</div>
							
							
							
							
							<div class="row">
								<input name="processSlide" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Save Slide</button>
									<a href="index.php?do=slider" class="btn btn-light">Cancel</a>
								</div>
							</div>
							

						</form>

					</div>
					
					
					<!-- End an Alert -->
					<div id="msgholder"></div>
					<!-- End an Alert -->

				</div>
			</div>

		</div>
		<!-- End Row -->
		

	</div>
	<!-- END CONTAINER -->

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

	$('.urltype').on('click', 'input', function() {
		
		linktype = $(this).data( "link");
		
		$('.slider_link').hide();
		$('#' + linktype).show();
		
		console.log(linktype);
	});
	
	

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

		$('#slider_add').ajaxForm(options).submit();
	});
	
	function showResponse() {
		$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
		$("body").animate({
			scrollTop: scrollPosition
		}, '400');
	}
	// Javascript form validation
	$('#slider_add').validetta({
		realTime: true,
		display: 'inline',
		errorTemplateClass: 'validetta-inline',
		errorClose: false,
		onError: showResponse
	});

});
</script>