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
        <h1 class="title">Products</h1>
        <ol class="breadcrumb">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?do=products">Products</a></li>
            <li class="active">Add Product</li>
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
    <div class="container-widget">

        <!-- Start Row -->
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-title">
                        Product Details
                    </div>

                    <div class="panel-body">
                        <form class="form_submission" name="form_submission" method="post">

                            <!-- Start Row -->
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Product Name <i class="fa fa-asterisk"></i></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="My First Product" data-validetta="required,minLength[1]">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="brand" class="form-label">Brand <i class="fa fa-asterisk"></i></label>
                                        <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand" value="Schedule35" data-validetta="required,minLength[1]">
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="slug" class="form-label">Product Slug <i class="fa fa-asterisk"></i></label>
                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="first-product-link" data-validetta="required,minLength[1]">
                                    </div>
                                </div>
								
								
								
								<div class="col-sm-12 col-md-6">
								    <div class="form-group">
								        <label for="nickname" class="form-label">Nickname <i class="fa fa-asterisk"></i></label>
								        <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" data-validetta="required,minLength[1]">
								    </div>
								</div>
								
								<div class="col-sm-6 col-md-3">
								  <div class="form-group">
								      <label for="weight" class="form-label">Dosage <i class="fa fa-asterisk"></i></label>
								      <input type="text" class="form-control" id="dosage" name="dosage" placeholder=""  data-validetta="required,minLength[1],number">
								  </div>
								</div>
								<div class="col-sm-6 col-md-3">
								  <div class="form-group">
								      <label for="weight" class="form-label">Pieces (grams) <i class="fa fa-asterisk"></i></label>
								      <input type="text" class="form-control" id="pieces" name="pieces" placeholder=""  data-validetta="required,minLength[1],number">
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

                                        <?php $content->getCatRadioList(0, 0, "|&nbsp;&nbsp;&nbsp;&nbsp;"); ?>

                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-md-8">

                                        <div class="row">
                                            <input type="hidden" name="hdn_product_type" id="hdn_product_type" value="0" />
                                            <div class="col-sm-12">
                                                <ul class="nav nav-tabs">
                                                    <li class="active tab_price" data-mode="0"><a data-toggle="tab" href="#single">Single Price</a></li>
                                                    <li class="tab_price" data-mode="1"><a data-toggle="tab" href="#multi">Multi Price</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="tab-content row">
                                                    <div id="single" class="tab-pane fade in active">
                                                      <div class="col-xs-6">
                                                        <div class="form-group">
                                                            <label for="price" class="form-label">Product Price <i class="fa fa-asterisk"></i></label>
                                                            <input type="text" class="form-control" id="price" name="price" placeholder="13.50"  data-validetta="required,minLength[1],number">
                                                        </div>
                                                      </div>
                                                      <div class="col-xs-6">
                                                        <div class="form-group">
                                                            <label for="sale_price" class="form-label">Sale Price <i class="fa fa-asterisk"></i></label>
                                                            <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="13.50"  data-validetta="required,minLength[1],number">
                                                        </div>
                                                      </div>
													  
													  <div class="col-xs-6">
													    <div class="form-group">
													        <label for="points" class="form-label">Points <i class="fa fa-asterisk"></i></label>
													        <input type="text" class="form-control" id="points" name="points" placeholder=""  data-validetta="required,minLength[1],number">
													    </div>
													  </div>
													  
                                                      <div class="col-xs-6">
                                                        <div class="form-group">
                                                            <label for="weight" class="form-label">Weight (grams) <i class="fa fa-asterisk"></i></label>
                                                            <input type="text" class="form-control" id="weight" name="weight" placeholder=""  data-validetta="required,minLength[1],number">
                                                        </div>
                                                      </div>
                                                    
													</div>
                                                    <div id="multi" class="tab-pane fade">
                                                        <div class="col-xs-5">
                                                          <label for="price" class="form-label">Variant Name </label>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <label for="sale_price" class="form-label">Weight</label>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <label for="sale_price" class="form-label">Price</label>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <label for="sale_price" class="form-label">Sale&nbsp;Price</label>
                                                        </div>
                                                        <table id="priceTable" class=" table order-list">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="col-sm-5">
                                                                        <input type="text" name="title_multi[]" class="form-control" placeholder="Title" />
                                                                    </td>
                                                                    <td class="col-sm-2">
                                                                        <input type="text" name="weight_multi[]"  class="form-control" placeholder="Weight"/>
                                                                    </td>
                                                                    <td class="col-sm-2">
                                                                        <input type="text" name="price_multi[]"  class="form-control" placeholder="Price"/>
                                                                    </td>
                                                                    <td class="col-sm-2">
                                                                        <input type="text" name="sale_price_multi[]"  class="form-control" placeholder="Sale Price"/>
                                                                    </td>
                                                                    <td class="col-sm-1"><a class="deleteRow"></a></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td style="text-align: left;padding: 10px 5px 0;">
                                                                        <input type="button" class="btn btn-default" id="addrow" value="Add New Variation" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="thumbid" class="form-label">Product Image <i class="fa fa-asterisk"></i></label>

                                        <div class="custom-file-upload">
                                            <input type="file" id="thumbid" name="thumb" data-validetta="required"/>
                                        </div>
                                    </div>
                                </div>
								
								
								
								<div class="col-sm-7">
									<label for="flag_meltable" class="form-label show">Meltable Flag <i class="fa fa-asterisk"></i></label>
									
									
									<div class="row">
										
										<div class="col-md-5">
											<div class="radio radio-primary radio-inline">
			                                    <input type="radio" id="flag_meltable_0" name="flag_meltable" value="0">
			                                    <label for="flag_meltable_0"> Not-meltable </label>
			                                </div>
			
			                                <div class="radio radio-primary radio-inline">
			                                    <input type="radio" id="flag_meltable_1" name="flag_meltable" value="1" checked="checked">
			                                    <label for="flag_meltable_1"> Meltable </label>
			                                </div>
										</div>
										
										<div class="col-md-2">
											<div class="checkbox checkbox-primary even">
												<input type="checkbox" id="flag_organic" name="flag_organic" value="1" checked/>
												<label for="flag_organic"> Organic </label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="checkbox checkbox-primary odd">
												<input type="checkbox" id="flag_vegan" name="flag_vegan" value="1" />
												<label for="flag_vegan"> Vegan </label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="checkbox checkbox-primary odd">
												<input type="checkbox" id="flag_blacklabel" name="flag_blacklabel" value="1" />
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
                                        <input type="text" class="form-control" id="metakeys" name="metakeys" value="" placeholder="tags" data-validetta="required,minLength[1]">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="summernote-second" class="form-label">Secondary Description</label>
                                    <textarea class="input-block-level" id="summernote-second" name="body" rows="18"></textarea>
                                </div>
                            </div>
							
							
							<div class="row">
							   
							   
								<div class="col-xs-12 col-sm-4">
									<div class="form-group" style="width: 90%;">
										<label for="stock" class="form-label">Stock</label>
										<input type="text" class="form-control" id="stock" name="stock" placeholder="1000" value="">
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-4">
									<label for="soldflag_1" class="form-label show">Availability <i class="fa fa-asterisk"></i></label>
									
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="soldflag_0" name="soldflag" value="0" checked/>
										<label for="soldflag_0"> In Stock </label>
									</div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="soldflag_1" name="soldflag" value="1"/>
										<label for="soldflag_1"> Out of Stock </label>
									</div>
								</div>
							   
							    <div class="col-xs-12 col-sm-4">
							        <label for="soldflag_1" class="form-label show">Ribbon Flags <i class="fa fa-asterisk"></i></label>
							        <div class="row">
							            <div class="col-md-6">
							                <div class="checkbox checkbox-primary even">
							                    <input type="checkbox" id="limited" name="offer" value="1"/>
							                    <label for="limited"> Limited Quantity </label>
							                </div>
							            </div>
							            <div class="col-md-6">
							                <div class="checkbox checkbox-primary odd">
							                    <input type="checkbox" id="sale" name="offer" value="1"/>
							                    <label for="sale"> Sale Price </label>
							                </div>
							            </div>
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

                            </div>

                            <div class="row">
								<input type="hidden" name="info" value="cannabis-infused gummies" />
                                <input name="addProduct" type="hidden" value="1">
                                <div class="col-md-12 top40">
                                    <button type="button" name="dosubmit" class="btn btn-default" disabled="true">Add Product</button>
                                    <a href="index.php?do=products" class="btn btn-light">Cancel</a>

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
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>


<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
