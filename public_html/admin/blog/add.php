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
        <h1 class="title">Blog</h1>
        <ol class="breadcrumb">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?do=blog">Blog</a></li>
            <li class="active">Add Article</li>
        </ol>

        <!-- Start Page Header Right Div -->
        <div class="right">
            <div class="btn-group" role="group" aria-label="...">
                <a href="index.php?do=blog" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all articles</a>
            </div>
        </div>
        <!-- End Page Header Right Div -->

    </div>
    <!-- End Page Header -->


    <!-- START BLOG TABLE -->
	
    <div class="container-widget">

        <!-- Start Row -->
        <div class="row clearfix">

            <div class="col-md-12">
				
				
				<div class="panel panel-default clearfix">
					
					<div class="panel-title">
					    Article Details
					</div>
					
					<div class="panel-body">
						<form class="form_submission" name="form_submission" method="post">
							
							
							<div class="form-group clearfix">
								<label for="title" class="col-sm-2 control-label form-label">Article Banner</label>
								<div class="col-sm-10">
									
									<?php $url = ($row->image) ? UPLOADURL . 'news_images/' . $row->image : UPLOADURL . 'news_images/blank-pattern.png';?>
									
									<div id="uploadPreview" class="news-image" style="background-image: url(<?php echo $url;?>" alt="<?php echo $row->title;?>);">
										
										<input type="file" name="file-image" id="file-image" class="inputfile" data-multiple-caption="{count} files selected" multiple  data-validetta="required"/>
										<label for="file-image">
											<span>Upload Image</span>
										</label>
										
										<span class="inputerror"><?php echo(isset($_SESSION['image_msg']) ? $_SESSION['image_msg'] : ''); ?></span>
									</div>
									
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="title" class="col-sm-2 control-label form-label">Article title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" placeholder="eg. About Us" data-validetta="required,minLength[1]" />
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="author" class="col-sm-2 control-label form-label">Author</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="author" name="author" placeholder="eg. Johnny Dee" data-validetta="required,minLength[1]" value="<?php echo $row->author;?>" />
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="created" class="col-sm-2 control-label form-label">Date Created</label>
								<div class="col-sm-6 col-md-3">
									<fieldset>
										<div class="control-group">
											<div class="controls">
												<div class="input-prepend input-group">
													<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="created" name="created" class="form-control" value="<?php echo(date("m/d/Y")); ?>" data-validetta="required" />
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="author" class="col-sm-2 control-label form-label">Hero Video</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="herovideo" name="herovideo" placeholder="eg. LEKxm_VaXtc" value="" />
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="title" class="col-sm-2 control-label form-label">Blog Categories</label>
								<div class="col-sm-10 fieldset-form mini">
									<fieldset class="form-group field-checklist" style="min-height: 128px;">
										<?php $content->getBlogCatCheckList(0, 0, "|&nbsp;&nbsp;&nbsp;&nbsp;"); ?>
									</fieldset>
								</div>
							</div>
							
							
							<div class="form-group clearfix">
								<label class="col-sm-2 control-label form-label">Textarea</label>
								<div class="col-sm-10">
									<textarea class="input-block-level" id="summernote-full" name="body" rows="18"><?php echo $row->body;?></textarea>
								</div>
							</div>
							
							
							<div class="form-group clearfix">
								<label class="col-sm-2 control-label form-label">Published  <i class="fa fa-asterisk"></i></label>
								<div class="col-sm-10">
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="active_1" name="active" value="1" />
									    <label for="active_1"> Yes </label>
									</div>
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="active_0" name="active" value="0" checked="true"/>
									    <label for="active_0"> No </label>
									</div>
								</div>
							</div>
							
							<div class="form-group clearfix top40">
								
								<input type="hidden" name="processArticle" value="1">
								
								<label class="col-sm-2 control-label form-label"></label>
								<div class="col-sm-10">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Update Article</button>
									<a href="index.php?do=blog" class="btn btn-light">Cancel</a>
								
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
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js?v=1"></script>



<script type="text/javascript">
	
	/*
		By Osvaldas Valutis, www.osvaldas.info
		Available for use under the MIT License
	*/
	
	'use strict';
	
	;( function( $, window, document, undefined )
	{
		$( '.inputfile' ).each( function()
		{
			var $input	 = $( this ),
				$label	 = $input.next( 'label' ),
				labelVal = $label.html();
	
			$input.on( 'change', function( e )
			{
				var fileName = '';
	
				if( this.files && this.files.length > 1 )
					fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
				else if( e.target.value )
					fileName = e.target.value.split( '\\' ).pop();
				
				if (fileName) {
					$label.find( 'span' ).html( fileName );
					console.log(fileName);
				}
				else {
					$label.html( labelVal );
				}
					
					
				
			});
	
			// Firefox bug fix
			$input
			.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
			.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
		});
	})( jQuery, window, document );
	
	
	
	
	
	$(document).ready(function() {
		$("#file-image").change(function() {
			var length = this.files.length;
			if (!length) {
				return false;
			}
			changeBackground(this);
		});
	});
	
	// Creating the function
	function changeBackground(img) {
		var file = img.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			alert("Invalid File Extension");
		} else {
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(img.files[0]);
		}
	
		function imageIsLoaded(e) {
			$('#uploadPreview').css({
				'background-image': "url(" + e.target.result + ")"
			});
	
		}
	}
	
</script>
<?php unset($_SESSION['image_msg']); ?>
