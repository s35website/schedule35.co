<?php
	/**
	* Gallery
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: gallery.php,v 3.00 2014-01-10 21:12:05 gewa Exp $
	*/
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
	  
	$gallerydata = (Filter::$id) ? $item->getGallery() : Filter::error("You have selected an Invalid Id", "Products::getGallery()");
	$title = Core::getValueById("title", Products::pTable)
?>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Products</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=products">Products</a></li>
			<li class="active">Product Gallery</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=products" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all products</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-lg-10 col-md-12 titles">
			<h1>"<?php echo $title;?>" Gallery</h1>
			<h4>Add additional images to your product to create a gallery.
				<br />
				Your product image will be replaced with the first image in your gallery.
			</h4>
		</div>
	
	</div>
	<!-- End Presentation -->
	
	
	
	<!-- START PRODUCT TABLE -->
	<div class="container-widget">
	
		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">
				
					<div id="uploader" class="panel-body">
					
						<form id="upload" method="post" action="controller.php" enctype="multipart/form-data">
						
							<div id="drop">
								Drop files here<span class="hideonhover"> or</span><a id="upl"> click to upload</a>.
								<input type="file" name="mainfile" multiple>
								<input name="uploadGalleryImages" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>">
							</div>
							
							<ul>
							</ul>
							
						</form>

					</div>

				</div>
			</div>

		</div>
		<!-- End Row -->
		
		<!-- Start Row -->
		<div class="row gallery">
			<?php if($gallerydata):?>
			<?php foreach ($gallerydata as $row):?>
			
			
			
			<div class="col-md-4 col-lg-3 item">
				<div class="panel panel-default">
			
					<div class="panel-title">
						<div contenteditable="true" data-path="false" data-edit-type="gallery" data-id="<?php echo $row->id;?>" data-key="title" class="editable"><?php echo $row->caption;?></div>
						<ul class="panel-tools">
							<li>
								<a class="icon imgdelete" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->caption;?>">
									<i class="fa fa-times"></i>
								</a>
							</li>
						</ul>
					</div>
			
					<div class="panel-body" style="display: block;">
						<img src="<?php echo UPLOADURL . '/prod_gallery/' . $row->thumb;?>" alt="" class="gallery_image">
					</div>
			
				</div>
			</div>
			
			<?php endforeach;?>
			<?php endif;?>
			
			<!-- End an Alert -->
			<div id="msgholder"></div>
			<!-- End an Alert -->
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
<script type="text/javascript" src="assets/js/dropzone/jquery.knob.js"></script>
<script type="text/javascript" src="assets/js/dropzone/jquery.ui.widget.js"></script>
<script type="text/javascript" src="assets/js/dropzone/jquery.iframe-transport.js"></script> 
<script type="text/javascript" src="assets/js/dropzone/jquery.fileupload.js"></script>
<script type="text/javascript" src="assets/js/dropzone/script.js"></script>
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>