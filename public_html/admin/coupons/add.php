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
		<h1 class="title">Add Coupon</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=coupons">Coupons</a></li>
			<li class="active">Add Coupon</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=coupons" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all coupons</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<!-- Start Presentation -->
	<div class="row presentation">

		<div class="col-lg-10 col-md-12 titles">
			<h1><i class="fa fa-gift"></i> Add New Coupon</h1>
			<h4>Here you can add a new coupon code. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
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
						<form class="form_submission" name="form_submission" method="post">

							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<label for="code" class="form-label">Coupon Code <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="code" name="code" placeholder="eg. COUPON123" data-validetta="required,minLength[1]">
									</div>
								</div>
							</div>


							<!-- Start Row: Product Artist and Product Arranger -->
							<div class="row">

								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="discount" class="form-label">Discount Amount <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="discount" name="discount" placeholder="eg. 10" data-validetta="required,minLength[1],number">
									</div>
								</div>

								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="type" class="form-label">Discount Type</label>
										<select name="type" class="selectpicker form-control">
											<option value="1">$ USD</option>
											<option value="0">% Discount</option>
										</select>
									</div>
								</div>


							</div>

							<div class="row">
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="minval" class="form-label">Minimum Amount</label>
										<input type="text" class="form-control" id="minval" name="minval" placeholder="eg. 10" data-validetta="number"/>
									</div>
								</div>

								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="validuntil" class="form-label">Coupon Expiry Date <i class="fa fa-asterisk"></i></label>
										<fieldset>
											<div class="control-group">
												<div class="controls">
													<div class="input-prepend input-group">
														<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" id="validuntil" name="validuntil" class="form-control" value="<?php echo(date("m/d/Y")); ?>" data-validetta="required"/>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="maxusage" class="form-label">Max Uses</label>
										<input type="text" class="form-control" id="maxusage" name="maxusage" placeholder="eg. 10" data-validetta="number" value=""/>
									</div>
								</div>

				                <div class="col-md-12 col-sm-12">
				                    <label for="coupon_on_cart" class="form-label show">Coupon Applied on <i class="fa fa-asterisk"></i></label>
				                    <div class="radio radio-primary radio-inline">
												        <input type="radio" id="coupon_on_cart" name="coupon_applied_on" value="0" checked="checked"/>
												        <label for="coupon_on_cart"> Cart </label>
												    </div>
				                    <div class="radio radio-primary radio-inline">
												        <input type="radio" id="coupon_on_product" name="coupon_applied_on" value="1" />
												        <label for="coupon_on_product"> Specific Product </label>
												    </div>
				                    <div class="product_list_hs top10" style="display: none;">
				                        <div class="subject-info-box-1">
				                          <label>Products</label>
				                          <select multiple class="form-control" id="lstBox1" style="min-height: 130px;">
				                            <?php
				                            $itemsproduct = $item->getProducts();
				                            foreach ($itemsproduct as $single_product):
				                                ?>
				                                <option value="<?php echo $single_product->id; ?>"><?php echo $single_product->title; ?></option>
				                            <?php
				                            endforeach;
				                            ?>
				                          </select>
				                        </div>
				
				                        <div class="subject-info-arrows text-center">
				                          <br/>
				                          <input type='button' id='btnAllRight' value='>>' class="btn btn-default" /><br />
				                          <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
				                          <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
				                          <input type='button' id='btnAllLeft' value='<<' class="btn btn-default" />
				                        </div>
				
				                        <div class="subject-info-box-2">
				                          <label>Selected Product</label>
				                          <select multiple class="form-control" id="lstBox2" style="min-height: 130px;">
				                          </select>
				                        </div>
				                        <input type="hidden" name="product_list" value="" id="hdnProductList">
				                    </div>
				                </div>

							</div>

							<div class="row">

								<div class="col-md-12 top10">
									<label for="published_1" class="form-label show">Published <i class="fa fa-asterisk"></i></label>
									<div class="radio radio-primary radio-inline">
								        <input type="radio" id="published_1" name="active" value="1" checked="checked"/>
								        <label for="published_1"> Yes </label>
								    </div>
								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="published_0" name="active" value="0" />
								        <label for="published_0"> No </label>
								    </div>
								</div>

								<input name="addDiscount" type="hidden" value="1">
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default">Add Coupon</button>
									<a href="index.php?do=coupons" class="btn btn-light">Cancel</a>
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
<script type="text/javascript" src="assets/js/multi-select/jquery.selectlistactions.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
