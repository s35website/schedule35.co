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
<?php $row = Core::getRowById(Content::invTable, Filter::$id);?>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit Invites</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=invites">Invites</a></li>
			<li class="active">Edit Invites <mark><?php echo $row->code;?></mark></li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=invites" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all invites</a>
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
						Invite Details
					</div>

					<div class="panel-body">
						<form class="form_submission" name="form_submission" method="post">

							<!-- Start Row: Product Name and Product Slug -->
							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="code" class="form-label">Invite Code <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="code" name="code" placeholder="eg. INVITE123" data-validetta="required,minLength[1]" value="<?php echo $row->code;?>">
									</div>
								</div>

                <div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="validuntil" class="form-label">Invite Expiry Date <i class="fa fa-asterisk"></i></label>
										<fieldset>
											<div class="control-group">
												<div class="controls">
													<div class="input-prepend input-group">
														<span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" id="validuntil" name="validuntil" class="form-control" value="<?php echo(date("m/d/Y", strtotime($row->validuntil))); ?>" data-validetta="required"/>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>

							</div>


							<!-- Start Row: Product Artist and Product Arranger -->
							<div class="row">
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="maxusage" class="form-label">Max Uses</label>
										<input type="text" class="form-control" id="maxusage" name="maxusage" placeholder="eg. 10" data-validetta="number" value="<?php echo $row->maxusage;?>"/>
									</div>
								</div>

								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="used" class="form-label">Already Used</label>
										<input type="text" class="form-control" id="used" name="used" placeholder="eg. 10" data-validetta="number" value="<?php echo $row->used;?>"/>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 top10">
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

								<input name="processInvite" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />

								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
									<a href="index.php?do=invites" class="btn btn-light">Cancel</a>
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
