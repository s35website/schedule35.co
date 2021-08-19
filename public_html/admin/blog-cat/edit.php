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
<?php $row = Core::getRowById(Content::bcTable, Filter::$id);?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Category</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=blog-cat">Categories</a></li>
			<li class="active">Edit Category</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=blog-cat" class="btn btn-light"><i class="fa fa-chevron-left"></i>Add category</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- START CATEGORY TABLE -->
	<div class="container-widget bot10">
	
		<!-- Start Row -->
		<div class="row">
			
			<!-- START DRAGGABLE -->
			<div class="col-sm-6">
				<div class="panel panel-default">
					
					<div class="panel-title">
						Rearrange Categories
					</div>
			        
					<div class="panel-body">
						<form id="category_page" name="category_page" method="post">
							
							<div class="row">
							
								<!-- Start Row: Category Name -->
								<div class="col-sm-12">
									<div class="form-group">
										<div id="external-events">
											<div id="menusort"> <?php echo $content->getBlogSortCatList();?></div>
										</div>
									</div>
								</div>
								
							</div>
							
							<div id="showalert" class="kode-alert kode-alert-icon kode-alert-click alert3 kode-alert-bottom">
								Categories updated!
							</div>
							
						</form>

					</div>

				</div>
				
				<a class="btn btn-default" href="index.php?do=blog-cat">Add Category</a>
			</div>

			<div class="col-sm-6">
				<div class="panel panel-default blue-box">
					
					<div class="panel-title">
						Edit <mark>"<?php echo $row->name;?>"</mark> Category
					</div>
			        
					<div class="panel-body">
						<form id="category_page" name="category_page" class="form_submission" method="post">
						
							
							<div class="row">
							
								<!-- Start Row: Category Name -->
								<div class="col-sm-12">
									<div class="form-group">
										<label for="name" class="form-label">Category Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="name" name="name" placeholder="eg. Action / Adventure" data-validetta="required,minLength[1]" value="<?php echo $row->name;?>">
									</div>
								</div>
								
								<!-- Start Row: Category Parent -->
								<div class="col-sm-12" style="display: none;">
									<div class="form-group">
										<label for="parent_id" class="form-label">Category Parent</label>
										<select name="parent_id" class="selectpicker form-control">
											<option value="0" selected>Top Level</option>
											<?php $content->getBlogCatDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;", $row->parent_id);?>
										</select>
									</div>
								</div>
								
								<!-- Start Row: Category Slug -->
								<div class="col-sm-12">
									<div class="form-group">
										<label for="slug" class="form-label">Category Slug <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="slug" name="slug" placeholder="eg. action-adventure" data-validetta="required,minLength[1]" value="<?php echo $row->slug;?>">
									</div>
								</div>
								
								<!-- Start Row: Category Slug -->
								<div class="col-sm-12">
									<label for="notes" class="form-label">Category Description</label>
									<textarea class="form-control" rows="8" id="description" name="description" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque urna dui, finibus sed diam quis, ultrices commodo mauris."><?php echo $row->description;?></textarea>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-md-12 top10">
									<label for="published_1" class="form-label show">Published <i class="fa fa-asterisk"></i></label>
									<div class="radio radio-primary radio-inline">
								        <input type="radio" id="published_1" name="active" value="1"  <?php getChecked($row->active, 1); ?>/>
								        <label for="published_1"> Yes </label>
								    </div>
								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="published_0" name="active" value="0" <?php getChecked($row->active, 0); ?>/>
								        <label for="published_0"> No </label>
								    </div>
								</div>
								
								<input name="processBlogCat" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
								
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default">Update Category</button>
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
Sweet Alert
================================================ -->
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>

<script src="assets/js/tree/jquery.tree.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>

<script>
	
	$(document).ready(function() {
		
		function showError() {
			$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
			$("body").animate({
				scrollTop: scrollPosition
			}, '400');
			$('button[name=dosubmit]').prop('disabled', true);
		}
		// Javascript form validation
		$('#category_page').validetta({
			realTime: true,
			display: 'inline',
			errorTemplateClass: 'validetta-inline',
			errorClose: false,
			onError: showError
		});
	
	});
	
	function showError() {
		$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
		$("body").animate({
			scrollTop: scrollPosition
		}, '400');
	}
	
	
	
	
	$('#menusort').nestedSortable({
		forcePlaceholderSize: true,
		listType: 'ul',
		handle: 'div',
		helper: 'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div'
	});
	
	function saveCategory() {
		serialized = $('#menusort').nestedSortable('serialize');
		serialized += '&doNewsCatSort=1';
		console.log(serialized);
		$.ajax({
			type: 'post',
			url: "controller.php",
			data: serialized,
			success: function (msg) {
				$("#msgholder").html(msg);
				$("#showalert").fadeIn(350).delay(3200).fadeOut(350);
				
			}
		});
	}
	
	$(document).ready(function() {
		
		$("#menusort .sortMenu").sortable({
			stop: function(e, ui) {
				saveCategory(); 
			}
		});
		
		$("#menusort .sortMenu").disableSelection();
	});
	
	
</script>