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
        <h1 class="title">Comments</h1>
        <ol class="breadcrumb">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?do=comments">Comments</a></li>
            <li class="active">Add Comments</li>
        </ol>

        <!-- Start Page Header Right Div -->
        <div class="right">
            <div class="btn-group" role="group" aria-label="...">
                <a href="index.php?do=comments" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all comments</a>
            </div>
        </div>
        <!-- End Page Header Right Div -->

    </div>
    <!-- End Page Header -->


    <!-- START COMMENTS TABLE -->
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
								<label class="col-sm-2 control-label form-label">Textarea</label>
								<div class="col-sm-10">
									<textarea class="input-block-level" id="summernote-full" name="body" rows="18"><?php echo $row->body;?></textarea>
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
								<label class="col-sm-2 control-label form-label">Active  <i class="fa fa-asterisk"></i></label>
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
								
								<input type="hidden" name="addComment" value="1">
								
								<label class="col-sm-2 control-label form-label"></label>
								<div class="col-sm-10">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Update Article</button>
									<a href="index.php?do=comments" class="btn btn-light">Cancel</a>
								
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
