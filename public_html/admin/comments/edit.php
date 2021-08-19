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
<?php $row = Core::getRowById(Content::cmTable, Filter::$id);?>
<?php $arow = Core::getRowById(Content::bTable, $row->nid);?>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title">Edit Article Comment</h1>
        <ol class="breadcrumb">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?do=comments&action=default&id=<?php echo($row->nid); ?>">Article Comment</a></li>
            <li class="active">Edit Article Comment</li>
        </ol>

        <!-- Start Page Header Right Div -->
        <div class="right">
            <div class="btn-group" role="group" aria-label="...">
                <a href="index.php?do=news" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all articles</a>
            </div>
        </div>
        <!-- End Page Header Right Div -->

    </div>
    <!-- End Page Header -->

    <!-- START NEWS TABLE -->
    <div class="container-widget">

        <!-- Start Row -->
        <div class="row">

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
								<label for="created" class="col-sm-2 control-label form-label">Date Created</label>
								<div class="col-sm-6 col-md-3">
									<fieldset>
										<div class="control-group">
											<div class="controls">
												<div class="input-prepend input-group">
													<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="created" name="created" class="form-control" data-validetta="required" value="<?php echo date('m/d/Y', strtotime($row->created)); ?>" />
												</div>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
							
							<div class="form-group clearfix">
								<label for="title" class="col-sm-2 control-label form-label">Article title</label>
								<div class="col-sm-10">
									<?php echo $arow->title;?>
								</div>
							</div>
							
							
							<div class="form-group clearfix">
								<label for="fullname" class="col-sm-2 control-label form-label">Users name</label>
								<div class="col-sm-10">
									<?php echo $row->fullname;?>
								</div>
							</div>
							
							
							<div class="form-group clearfix">
								<label class="col-sm-2 control-label form-label">Private  <i class="fa fa-asterisk"></i></label>
								<div class="col-sm-4">
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="private_1" name="private" value="1" <?php getChecked($row->private, 1); ?>/>
									    <label for="private_1"> Yes </label>
									</div>
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="private_0" name="private" value="0" <?php getChecked($row->private, 0); ?>/>
									    <label for="private_0"> No </label>
									</div>
								</div>
							</div> 
							
							
							<div class="form-group clearfix">
								<label class="col-sm-2 control-label form-label">Published  <i class="fa fa-asterisk"></i></label>
								<div class="col-sm-4">
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="active_1" name="active" value="1" <?php getChecked($row->active, 1); ?>/>
									    <label for="active_1"> Yes </label>
									</div>
									<div class="radio radio-primary radio-inline">
									    <input type="radio" id="active_0" name="active" value="0" <?php getChecked($row->active, 0); ?>/>
									    <label for="active_0"> No </label>
									</div>
								</div>
							</div> 
							
							<div class="form-group clearfix top40">
								
								<input type="hidden" name="updateComment" value="1">
								<input name="comment_id" type="hidden" value="<?php echo Filter::$id; ?>" />
								
								<label class="col-sm-2 control-label form-label"></label>
								<div class="col-sm-10">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Update Comment</button>
									<a href="index.php?do=comments&action=default&id=<?php echo($row->nid); ?>" class="btn btn-light">Cancel</a>
								
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
<script type="text/javascript" src="assets/js/plugins.js"></script>