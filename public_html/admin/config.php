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
	
	if (!$user->is_Admin()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}

?>

<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Settings</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Edit Settings</li>
		</ol>

	</div>
	<!-- End Page Header -->


	<!-- Start Presentation -->
	<div class="row presentation">

		<div class="col-lg-8 titles">
			<h1><i class="fa fa-gears"></i> Settings</h1>
			<h4>Here you can update your websites settings. <br />Fields marked with a <i class="fa fa-asterisk"></i> are required.</h4>
		</div>

	</div>
	<!-- End Presentation -->


	<!-- START PRODUCT TABLE -->
	<div class="container-widget">

		<form class="form_submission" name="form_submission" method="post">

			<input name="processConfig" type="hidden" value="1">

			<!-- Start Row -->
			<div class="row">

				<div class="col-md-12">
					<div class="panel panel-default">

						<div class="panel-title">
							Setup
							<ul class="panel-tools">
	  							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
	  							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
	  						</ul>
						</div>

						<div class="panel-body" style="display: none">

							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="site_name" class="form-label">Website Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="site_name" name="site_name" placeholder="Website Name" value="<?php echo $core->site_name;?>" data-validetta="required,minLength[1]">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="site_url" class="form-label">Website Url <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="site_url" name="site_url" placeholder="http://www.example.com" value="<?php echo $core->site_url;?>" data-validetta="required,minLength[1]">
									</div>
								</div>

							</div>

							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="company" class="form-label">Company Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="company" name="company" placeholder="Company Name" value="<?php echo $core->company;?>" data-validetta="required,minLength[1]">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="site_email" class="form-label">Company Email</label>
										<input type="text" class="form-control" id="site_email" name="site_email" placeholder="contact@example.com" value="<?php echo $core->site_email;?>">
									</div>
								</div>

							</div>


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="file_dir" class="form-label">Support Email <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="support_email" name="support_email" value="<?php echo $core->support_email;?>">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="site_dir" class="form-label">Payment Email</label>
										<input type="text" class="form-control" id="payment_email" name="payment_email" value="<?php echo $core->payment_email;?>">
									</div>
								</div>

											  <input type="hidden" id="file_dir" name="file_dir" value="<?php echo $core->file_dir;?>">
											  <input type="hidden" id="site_dir" name="site_dir" value="<?php echo $core->site_dir;?>">
							</div>




							<div class="row">
								<div class="col-sm-12 col-md-5">
									<div class="form-group">
										<label for="logo" class="form-label">Company Logo</label>
										<div class="custom-file-upload">
										    <input type="file" id="logo" name="logo"/>
										</div>
									</div>
								</div>

								<div class="col-sm-12 col-md-6 col-md-offset-1">
									<div class="form-group">
										<label for="logo" class="form-label">Remove Logo</label>
										<div class="checkbox checkbox-primary">
											<input id="dellogo" name="dellogo" value="1" type="checkbox">
											<label for="dellogo">Yes, remove logo. </label>
										</div>
									</div>

								</div>

							</div>
							<div class="row top10">
								<div class="col-md-3">
									<label for="offline_0" class="form-label show">Website Online <i class="fa fa-asterisk"></i></label>

								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="offline_0" name="offline" value="0" <?php getChecked($core->offline, 0); ?>/>
								        <label for="offline_0"> Yes </label>
								    </div>
								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="offline_1" name="offline" value="1" <?php getChecked($core->offline, 1); ?>/>
								        <label for="offline_1"> No </label>
								    </div>
								</div>
								<div class="col-md-3">
									<label for="invite_only_0" class="form-label show">Invite Only <i class="fa fa-asterisk"></i></label>
								    <div class="radio radio-primary radio-inline">
								        <input type="radio" id="invite_only_1" name="invite_only" value="1" <?php getChecked($core->invite_only, 1); ?>/>
								        <label for="invite_only_1"> Yes </label>
								    </div>
									<div class="radio radio-primary radio-inline">
								        <input type="radio" id="invite_only_0" name="invite_only" value="0" <?php getChecked($core->invite_only, 0); ?>/>
								        <label for="invite_only_0"> No </label>
								    </div>
								</div>
							</div>



							<div class="row">

								<div class="col-md-12 top20 text-right">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
								</div>

							</div>

						</div>



					</div>
				</div>

			</div>
			<!-- End Row -->


			<!-- Start Row -->
			<div class="row">

				<div class="col-md-12">
					<div class="panel panel-default">

						<div class="panel-title">
							Shop Settings
							<ul class="panel-tools">
								<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
  								<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
							</ul>
						</div>

						<div class="panel-body">

							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="theme" class="form-label">Theme</label>
										<select name="theme" class="selectpicker form-control">
											<?php getTemplates(BASEPATH."/themes/", $core->theme)?>
										</select>
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="time_format" class="form-label">Time Format</label>
										<select name="time_format" class="selectpicker form-control">
											<?php echo Core::getTimeFormat($core->time_format);?>
										</select>
									</div>
								</div>

							</div>


							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="currency" class="form-label">Default Currency <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="site_name" name="currency" value="<?php echo $core->currency;?>" data-validetta="required,minLength[1]" placeholder="USD">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="cur_symbol" class="form-label">Currency Symbol <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="cur_symbol" name="cur_symbol" value="<?php echo $core->cur_symbol;?>" data-validetta="required,minLength[1]" placeholder="$">
									</div>
								</div>

							</div>
							
							<div class="row">


								<div class="col-sm-6 col-md-3">
									<div class="form-group">
										<label for="shipping_standard" class="form-label">Standard Shipping Cost <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="shipping_standard" name="shipping_standard" value="<?php echo $core->shipping_standard;?>" data-validetta="required,minLength[1]" placeholder="$">
									</div>
								</div>

							  <div class="col-sm-6 col-md-3">
									<div class="form-group">
										<label for="shipping_express" class="form-label">Express Shipping Cost <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="shipping_express" name="shipping_express" value="<?php echo $core->shipping_express;?>" data-validetta="required,minLength[1]" placeholder="$">
									</div>
								</div>

							  <div class="col-sm-6 col-md-3">
									<div class="form-group">
										<label for="shipping_free_flag" class="form-label">Free Shipping Minimum <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="shipping_free_flag" name="shipping_free_flag" value="<?php echo $core->shipping_free_flag;?>" data-validetta="required,minLength[1]" placeholder="$">
									</div>
								</div>

							</div>
							
							<div class="row">

							  <div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Show Heat Warning</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="meltable_warning_1" name="meltable_warning" value="1" <?php getChecked($core->meltable_warning, 1); ?>/>
										    <label for="meltable_warning_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="meltable_warning_0" name="meltable_warning" value="0" <?php getChecked($core->meltable_warning, 0); ?>/>
										    <label for="meltable_warning_0"> No </label>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Allow Free Downloads</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="free_allowed_1" name="free_allowed" value="1" <?php getChecked($core->free_allowed, 1); ?>/>
										    <label for="free_allowed_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="free_allowed_0" name="free_allowed" value="0" <?php getChecked($core->free_allowed, 0); ?>/>
										    <label for="free_allowed_0"> No </label>
										</div>
									</div>
								</div>


								<div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Show Slider</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="show_slider_1" name="show_slider" value="1" <?php getChecked($core->show_slider, 1); ?>/>
										    <label for="show_slider_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="show_slider_0" name="show_slider" value="0" <?php getChecked($core->show_slider, 0); ?>/>
										    <label for="show_slider_0"> No </label>
										</div>
									</div>
								</div>

							</div>


							<div class="row">

								<div class="col-md-12 top20 text-right">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
								</div>

							</div>

						</div>



					</div>
				</div>

			</div>
			<!-- End Row -->


			<!-- Start Row -->
			<div class="row">

				<div class="col-md-12">
					<div class="panel panel-default">

						<div class="panel-title">
							Advanced Settings
							<ul class="panel-tools">
  							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
  							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
  						</ul>
						</div>

						<div class="panel-body">

							<div class="row">
								<div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Registration Verification</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="reg_verify_1" name="reg_verify" value="1" <?php getChecked($core->reg_verify, 1); ?>/>
										    <label for="reg_verify_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="reg_verify_0" name="reg_verify" value="0" <?php getChecked($core->reg_verify, 0); ?>/>
										    <label for="reg_verify_0"> No </label>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Allow Registration</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="reg_allowed_1" name="reg_allowed" value="1" <?php getChecked($core->reg_allowed, 1); ?>/>
										    <label for="reg_allowed_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="reg_allowed_0" name="reg_allowed" value="0" <?php getChecked($core->reg_allowed, 0); ?>/>
										    <label for="reg_allowed_0"> No </label>
										</div>
									</div>
								</div>

								<div class="col-sm-6 col-md-3">
									<label for="logo" class="form-label">Registration Notification</label>
									<div class="form-group">
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="notify_admin_1" name="notify_admin" value="1" <?php getChecked($core->notify_admin, 1); ?>/>
										    <label for="notify_admin_1"> Yes </label>
										</div>
										<div class="radio radio-primary radio-inline">
										    <input type="radio" id="notify_admin_0" name="notify_admin" value="0" <?php getChecked($core->notify_admin, 0); ?>/>
										    <label for="notify_admin_0"> No </label>
										</div>
									</div>
								</div>

							</div>


							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="user_limit" class="form-label">User Limit</label>
										<input type="text" class="form-control" id="user_limit" name="user_limit" value="<?php echo $core->user_limit;?>" data-validetta="number">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="perpage" class="form-label">Products Per Page</label>
										<input type="text" class="form-control" id="perpage" name="perpage" value="<?php echo $core->perpage;?>" data-validetta="number">
									</div>
								</div>

							</div>


							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="featured" class="form-label">Featured Items</label>
										<input type="text" class="form-control" id="featured" name="featured" value="<?php echo $core->featured;?>" data-validetta="number">
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="popular" class="form-label">Popular Products</label>
										<input type="text" class="form-control" id="popular" name="popular" value="<?php echo $core->popular;?>" data-validetta="number">
									</div>
								</div>

							</div>



							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="mailer" class="form-label">Default Mailer</label>
										<select name="mailer" class="selectpicker form-control">
											<option value="PHP" <?php if ($core->mailer == "PHP") echo "selected=\"selected\"";?>>PHP Mailer</option>
											<option value="SMAIL" <?php if ($core->mailer == "SMAIL") echo "selected=\"selected\"";?>>Sendmail</option>
											<option value="SMTP" <?php if ($core->mailer == "SMTP") echo "selected=\"selected\"";?>>SMTP Mailer</option>
										</select>
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="lang" class="form-label">Default Language</label>
										<select name="lang" class="selectpicker form-control">
											<?php foreach(Lang::fetchLanguage() as $langlist):?>
											<option value="<?php echo $langlist;?>"<?php if($core->lang == $langlist) echo ' selected="selected"';?>><?php echo strtoupper($langlist);?></option>
											<?php endforeach;?>
										</select>
									</div>
								</div>

							</div>



							<div class="row">

								<div class="col-md-12 top20 text-right">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
								</div>

							</div>

						</div>



					</div>
				</div>

			</div>
			<!-- End Row -->



			<!-- Start Row -->
			<div class="row">

				<div class="col-md-12">
					<div class="panel panel-default">

						<div class="panel-title">
							Analytics / Metatags
							<ul class="panel-tools">
  							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
  							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
  						</ul>
						</div>

						<div class="panel-body">

							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="metakeys" class="form-label">Website Keywords</label>
										<textarea class="form-control" rows="8" id="metakeys" name="metakeys"><?php echo $core->metakeys;?></textarea>
									</div>
								</div>

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="metadesc" class="form-label">Website Description</label>
										<textarea class="form-control" rows="8" id="metadesc" name="metadesc"><?php echo $core->metadesc;?></textarea>
									</div>
								</div>

							</div>

							<div class="row">

								<div class="col-sm-12">
									<div class="form-group">
										<label for="analytics" class="form-label">Google Analytics</label>
										<textarea class="form-control" rows="8" id="analytics" name="analytics"><?php echo $core->analytics;?></textarea>
									</div>
								</div>

							</div>



							<div class="row">

								<div class="col-md-12 top20 text-right">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
								</div>

							</div>

						</div>



					</div>
				</div>

			</div>
			<!-- End Row -->

			

			<!-- Start Row -->
			<div class="row">

				<div class="col-md-12">
					<div class="panel panel-default">

						<div class="panel-title">
						    Infinite Scroll settings
							  <ul class="panel-tools">
    							<li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
    							<li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
    						</ul>
						</div>

						<div class="panel-body">

							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="paging-per-page" class="form-label">Results per page</label>
										<input type="text" class="form-control" id="paging-per-page" name="paging-per-page" value="<?php echo $scrollSettings->perPage;?>" data-validetta="number">
										<p class="helper=text">It's best to make this a multiple of 4, as the results show 4 products per line.</p>
									</div>
								</div>
							</div>

							<div class="row">

								<div class="col-md-12 top20 text-right">
									<button type="button" name="dosubmit" class="btn btn-default">Save Changes</button>
								    <div class="img-loading">
										  <span class="css-loading" style="box-shadow: -3px 3px 8px rgba(0,0,0,0.2);"></span>
										</div>
									</div>

							</div>

						</div>

					</div>
				</div>

      </div>
      <!-- End Row -->

		</form>

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
<script src="assets/js/datatables/datatables.min.js"></script>
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
