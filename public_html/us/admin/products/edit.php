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

<?php $row = $core->getRowById(Products::pTable, Filter::$id); ?>
<?php $variants = $item->getProductVariants(Filter::$id); ?>
<?php $cidrow = $content->fetchProductCategories(Filter::$id); ?>

<style>
	.form-blind-wrapper {
		position: relative;
		padding: 30px;
		border: 1px solid #399bff;
		border-radius: 4px;
		overflow: hidden;
	}
	.form-blind {
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 9;
		background: rgba(255, 255, 255, .75);
	}
	.panel-compact .form-group {
		margin-bottom:  10px;
	}
	.panel.red-box {
		border-color: red!important;
	}
	.panel.blue-box {
		border-color: #399bff!important;
	}
</style>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Products</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=products">Products</a></li>
			<li class="active">Edit <mark><?php echo $row->title;?></mark></li>
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


	<!-- START PRODUCT TABLE -->
	<?php if( $row->flag_multiple == 0 ){
		$active_single = ' in active';
		$active_multi = '';
	} else {
		$active_single = '';
		$active_multi = ' in active';
	} ?>

	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				
				<form class="form_submission" name="form_submission" method="post">
				
					<div class="panel panel-default">
	
						<div class="panel-body">
								
							<!-- Start Row -->
							<div class="row top20">
								<div class="col-xs-6 col-sm-3 bot20">
									<div class="form-group" style="width: 90%;">
										<label for="stock" class="form-label">Stock</label>
										<input type="text" class="form-control" id="stock" name="stock" value="<?php echo $row->stock; ?>" placeholder="1000" value="1000">
									</div>
								</div>
								
								<div class="col-xs-6 col-sm-3 bot20">
									<div class="form-group" style="width: 90%;">
										<label for="stock" class="form-label">Points</label>
										<input type="text" class="form-control" id="points" name="points" value="<?php echo $row->points; ?>" placeholder="1000" value="1000">
									</div>
								</div>
	
								<div class="col-xs-6 col-sm-3 bot20">
									<label for="soldflag_1" class="form-label show">Availability <i class="fa fa-asterisk"></i></label>
	
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="soldflag_0" name="soldflag" value="0" <?php getChecked($row->soldflag, 0); ?>/>
										<label for="soldflag_0"> In Stock </label>
									</div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="soldflag_1" name="soldflag" value="1" <?php getChecked($row->soldflag, 1); ?>/>
										<label for="soldflag_1"> Out of Stock </label>
									</div>
								</div>
								
								
								
								<div class="col-xs-6 col-sm-3 bot20">
									<label for="ribbonflags" class="form-label show">Ribbon Flags</label>
									<div class="checkbox checkbox-primary checkbox-inline even">
										<input type="checkbox" id="flag_limited" name="flag_limited" value="1" <?php getChecked($row->flag_limited, 1); ?>/>
										<label for="flag_limited"> Limited Qty </label>
									</div>
									<div class="checkbox checkbox-primary checkbox-inline odd">
										<input type="checkbox" id="flag_sale" name="flag_sale" value="1" <?php getChecked($row->flag_sale, 1); ?>/>
										<label for="flag_sale"> Sale Flag </label>
									</div>
								</div>
								
							</div>
							
						</div>
	
					</div>
					
					
					
					<?php if($user->is_Admin()):?>
					<!-- Invoice Details -->
					<div class="panel panel-default panel-compact blue-box">
					
						<div class="panel-title">
							Product Details
					
							<ul class="panel-tools">
								<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
								<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
							</ul>
						</div>
					
						<div class="panel-body" style="display: none;">
							<div class="boxie">
												
								<!-- Start Row -->
								<div class="row">
									
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label for="title" class="form-label">Product Name <i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="title" name="title" placeholder="My First Product" value="<?php echo $row->title; ?>" data-validetta="required,minLength[1]">
										</div>
									</div>
	
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label for="brand" class="form-label">Brand <i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="brand" name="brand" placeholder="Brand" value="<?php echo $row->brand; ?>" data-validetta="required,minLength[1]">
										</div>
									</div>
									
									
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="slug" class="form-label">Product Slug <i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="slug" name="slug" placeholder="first-product-link" value="<?php echo $row->slug; ?>" data-validetta="required,minLength[1]">
										</div>
									</div>
									
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="nickname" class="form-label">Nickname <i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="nickname" value="<?php echo $row->nickname; ?>" name="nickname" placeholder="Nickname" data-validetta="required,minLength[1]">
										</div>
									</div>
									
									
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label for="weight" class="form-label">Dosage<i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="dosage" name="dosage" placeholder=""  data-validetta="required,minLength[1],number" value="<?php echo $row->dosage; ?>">
										</div>
									</div>
									
									
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label for="weight" class="form-label">Pieces<i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="pieces" name="pieces" placeholder=""  data-validetta="required,minLength[1],number" value="<?php echo $row->pieces; ?>">
										</div>
									</div>
									
									
									
									
								</div>
	
								<!-- Start Row -->
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<div class="form-group">
											<label for="description" class="form-label">Description <i class="fa fa-asterisk"></i></label>
											<textarea class="form-control" id="summernote" name="description" rows="18"><?php echo $row->description; ?></textarea>
										</div>
									</div>
								</div>
	
	
								<!-- Start Row -->
								<div class="row top10">
	
								  <div class="col-sm-12 col-md-4 fieldset-form mini">
									  <fieldset class="form-group" style="min-height: 298px;">
										  <legend>Product Categories</legend>
	
										  <?php $content->getCatRadioList(0, 0, "&#166;&nbsp;&nbsp;&nbsp;&nbsp;", $row->cid); ?>
	
									  </fieldset>
								  </div>
								  <div class="col-sm-12 col-md-8">
									<div class="row">
										<input type="hidden" name="hdn_product_type" id="hdn_product_type" value="<?php echo $row->flag_multiple; ?>" />
	
										<div class="col-sm-12">
										  <ul class="nav nav-tabs">
											  <li class="tab_price <?php echo $active_single; ?>" data-mode="0"><a data-toggle="tab" href="#single">Single Price</a></li>
											  <li class="tab_price <?php echo $active_multi; ?>" data-mode="1"><a data-toggle="tab" href="#multi">Multi Price</a></li>
										  </ul>
										</div>
	
										<div class="col-sm-12">
											<div class="tab-content row">
												<div id="single" class="tab-pane fade <?php echo $active_single; ?>">
												  <div class="col-xs-6">
													<div class="form-group">
														<label for="price" class="form-label">Product Price <i class="fa fa-asterisk"></i></label>
														<input type="text" class="form-control" id="price" name="price" placeholder="13.50"  data-validetta="required,minLength[1],number" value="<?php echo $row->price; ?>">
													</div>
												  </div>
												  <div class="col-xs-6">
													<div class="form-group">
														<label for="sale_price" class="form-label">Sale Price <i class="fa fa-asterisk"></i></label>
														<input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="13.50" value="<?php echo $row->sale_price; ?>">
													</div>
												  </div>
												  <div class="col-xs-6">
													<div class="form-group">
														<label for="weight" class="form-label">Weight (grams) <i class="fa fa-asterisk"></i></label>
														<input type="text" class="form-control" id="weight" name="weight" placeholder=""  data-validetta="required,minLength[1],number" value="<?php echo $row->weight; ?>">
													</div>
												  </div>
	
												</div>
												<div id="multi" class="tab-pane fade <?php echo $active_multi; ?>">
												  <div class="col-xs-5">
													<label for="title_multi" class="form-label">Title </label>
												  </div>
												  <div class="col-xs-2">
													<label for="dosage_multi" class="form-label">Weight</label>
												  </div>
												  <div class="col-xs-2">
													<label for="price_multi" class="form-label">Price</label>
												  </div>
												  <div class="col-xs-2">
													<label for="sale_price_multi" class="form-label">Sale Price</label>
												  </div>
												  <table id="priceTable" class=" table order-list">
													  <tbody>
														  <?php foreach ( $variants as $vk => $vv ) { ?>
														  <tr>
															  <td class="col-xs-5"><input type="text" name="title_multi[<?php echo $vv->id; ?>]" class="form-control" value="<?php echo $vv->title; ?>" placeholder="Title"/></td>
															  <td class="col-xs-2"> <input type="text" name="weight_multi[<?php echo $vv->id; ?>]" class="form-control" value="<?php echo $vv->weight; ?>" placeholder="Weight"/></td>
															  <td class="col-xs-2"><input type="text" name="price_multi[<?php echo $vv->id; ?>]" class="form-control" value="<?php echo $vv->price; ?>" placeholder="Price"/></td>
															  <td class="col-xs-2"><input type="text" name="sale_price_multi[<?php echo $vv->id; ?>]" class="form-control" value="<?php echo $vv->sale_price; ?>" placeholder="Sale Price"/></td>
															  <td class="col-sm-1"><i class="fas fa-times-circle ibtnDel"></i></td>
														  </tr>
														  <?php } ?>
													  </tbody>
													  <tfoot>
														  <tr>
															  <td style="text-align: left;padding:10px 5px 0;">
																  <input type="button" class="btn btn-default" id="addrow" value="Add New Variation" />
															  </td>
														  </tr>
														  <tr>
														  </tr>
													  </tfoot>
												  </table>
											  </div>
												<?php // if($row->stock > 0){ ?>
												<div class="col-sm-12 top10">
													<?php
													if ($row->thumb):
														$produt_image_m = UPLOADURL . 'prod_images/'. $row->thumb;
													else:
														$produt_image_m = UPLOADURL . 'prod_images/blank.png';
													endif; ?>
	
	
													<input type="hidden" data-pimage="<?php echo $produt_image_m; ?>" data-id="<?php echo $_GET['id']; ?>" data-product-name="<?php echo $row->title; ?>" data-product-link="<?php echo $row->slug; ?>" id="notify_users" value="0"/>
												</div>
												<?php // } ?>
											</div>
										</div>
	
									</div>
								  </div>
	
								</div>
								<div class="row">
	
									<div class="col-sm-4">
										<div class="form-group">
											<label for="thumbid" class="form-label">Product Image <i class="fa fa-asterisk"></i></label>
	
											<div class="custom-file-upload">
											   <!--<input type="file" id="thumbid" name="thumb" data-validetta="required"/>-->
												<input type="file" id="thumbid" name="thumb"/>
											</div>
										</div>
									</div>
									<div class="col-sm-1 col-md-1">
										<div class="form-group" style="max-width: 180px;">
											<?php if ($row->thumb): ?>
												<img src="<?php echo UPLOADURL; ?>prod_images/<?php echo $row->thumb; ?>" alt="<?php echo $row->thumb; ?>">
											<?php else: ?>
												<img src="<?php echo UPLOADURL; ?>prod_images/blank.png?v=1" alt="<?php echo $row->thumb; ?>">
											<?php endif; ?>
										</div>
									</div>
									
									
									<div class="col-sm-7">
										<label for="flag_meltable" class="form-label show">Meltable Flag <i class="fa fa-asterisk"></i></label>
										
										
										<div class="row">
											
											<div class="col-md-5">
												<div class="radio radio-primary radio-inline">
													<input type="radio" id="flag_meltable_0" name="flag_meltable" value="0" <?php getChecked($row->flag_meltable, 0); ?>/>
													<label for="flag_meltable_0"> Not-meltable </label>
												</div>
			
												<div class="radio radio-primary radio-inline">
													<input type="radio" id="flag_meltable_1" name="flag_meltable" value="1" <?php getChecked($row->flag_meltable, 1); ?>/>
													<label for="flag_meltable_1"> Meltable </label>
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="checkbox checkbox-primary even">
													<input type="checkbox" id="flag_organic" name="flag_organic" value="1" <?php getChecked($row->flag_organic, 1); ?>/>
													<label for="flag_organic"> Organic </label>
												</div>
											</div>
											<div class="col-md-2">
												<div class="checkbox checkbox-primary odd">
													<input type="checkbox" id="flag_vegan" name="flag_vegan" value="1" <?php getChecked($row->flag_vegan, 1); ?>/>
													<label for="flag_vegan"> Vegan </label>
												</div>
											</div>
											<div class="col-md-2">
												<div class="checkbox checkbox-primary odd">
													<input type="checkbox" id="flag_blacklabel" name="flag_blacklabel" value="1" <?php getChecked($row->flag_blacklabel, 1); ?>/>
													<label for="flag_blacklabel"> Black Label </label>
												</div>
											</div>
											
										</div>
										
									</div>
									
								</div>
	
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="metakeys" class="form-label">Tags <i class="fa fa-asterisk"></i></label>
											<input type="text" class="form-control" id="metakeys" name="metakeys" value="<?php echo $row->metakeys; ?>" placeholder="tags" data-validetta="required,minLength[1]">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="summernote-second" class="form-label">Secondary Body</label>
										<textarea class="input-block-level" id="summernote-second" name="body" rows="18"><?php echo $row->body; ?></textarea>
									</div>
								</div>
	
	
								<div class="row">
									<div class="col-md-12">
										<label for="published_1" class="form-label show">Published <i class="fa fa-asterisk"></i></label>
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
				
							</div>
					
						</div>
					
					</div>
					<?php endif;?>
					
					
					
					<!-- Invoice Details -->
					<div class="panel panel-default">
						<div class="panel-body">
						
							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<input type="hidden" name="info" value="cannabis-infused gummies" />
								<input type="hidden" id="notify" name="notify" value="0" />
								<input name="updateProduct" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id; ?>" />
								<div class="col-md-12 top20">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
									<a href="index.php?do=products" class="btn btn-light">Cancel</a>
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
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>


<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>


<script>
	$( "#stock" ).keyup(function() {
		if ($("#stock").val() == '0' || $("input[name='soldflag']:checked").val() == '1') {
			$("#notify_users").val(0);
		}else {
			$("#notify_users").val(1);
		}
	});
	
	$("input[name='soldflag']").change(function(){
		if ($("input[name='soldflag']:checked").val() == '1' || $("#stock").val() == '0') {
			$("#notify_users").val(0);
		}else {
			$("#notify_users").val(1);
		}
	});

</script>
