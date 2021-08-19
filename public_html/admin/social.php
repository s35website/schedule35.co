<?php
	/**
	* Main
	*
	* @package MarsCommerce
	* @author marscommerce.net
	* @copyright 2018
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
		<h1 class="title">Social Links</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Social Links</li>
		</ol>

	</div>
	<!-- End Page Header -->



	<!-- START PRODUCT TABLE -->
	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-default">

					<div class="panel-body">
						<form class="form_submission" name="form_submission" method="post">


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_facebook" class="form-label"><i class="fa fa-facebook"></i> Facebook </label>
										<input type="text" class="form-control" id="social_facebook" name="social_facebook" placeholder="eg. https://www.facebook.com/example" value="<?php echo $core->social_facebook;?>" data-validetta="minLength[1]"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_facebook_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_facebook_1" name="enable_facebook" value="1" <?php getChecked($core->enable_facebook, 1); ?>/>
									        <label for="enable_facebook_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_facebook_0" name="enable_facebook" value="0" <?php getChecked($core->enable_facebook, 0); ?> data-validetta="minLength[1]"/>
									        <label for="enable_facebook_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_twitter" class="form-label"><i class="fa fa-twitter"></i> Twitter </label>
										<input type="text" class="form-control" id="social_twitter" name="social_twitter" placeholder="eg. https://www.twitter.com/example" value="<?php echo $core->social_twitter;?>" data-validetta="minLength[1]"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_twitter_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_twitter_1" name="enable_twitter" value="1" <?php getChecked($core->enable_twitter, 1); ?>/>
									        <label for="enable_twitter_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_twitter_0" name="enable_twitter" value="0" <?php getChecked($core->enable_twitter, 0); ?>/>
									        <label for="enable_twitter_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_instagram" class="form-label"><i class="fa fa-instagram"></i> Instagram </label>
										<input type="text" class="form-control" id="social_instagram" name="social_instagram" placeholder="do not put @" value="<?php echo $core->social_instagram;?>" data-validetta="minLength[1]"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_instagram_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_instagram_1" name="enable_instagram" value="1" <?php getChecked($core->enable_instagram, 1); ?>/>
									        <label for="enable_instagram_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_instagram_0" name="enable_instagram" <?php getChecked($core->enable_instagram, 0); ?>/>
									        <label for="enable_instagram_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_youtube" class="form-label"><i class="fa fa-youtube"></i> Youtube </label>
										<input type="text" class="form-control" id="social_youtube" name="social_youtube" placeholder="eg. https://www.youtube.com/c/example" value="<?php echo $core->social_youtube;?>" data-validetta="minLength[1]">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_youtube_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_youtube_1" name="enable_youtube" value="1" <?php getChecked($core->enable_youtube, 1); ?>/>
									        <label for="enable_youtube_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_youtube_0" name="enable_youtube" <?php getChecked($core->enable_youtube, 0); ?>/>
									        <label for="enable_youtube_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>

							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_soundcloud" class="form-label"><i class="fa fa-soundcloud"></i> Soundcloud </label>
										<input type="text" class="form-control" id="title" name="social_soundcloud" placeholder="eg. https://soundcloud.com/example" value="<?php echo $core->social_soundcloud;?>" data-validetta="minLength[1]"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_soundcloud_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_soundcloud_1" name="enable_soundcloud" value="1" <?php getChecked($core->enable_soundcloud, 1); ?> />
									        <label for="enable_soundcloud_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_soundcloud_0" name="enable_soundcloud" <?php getChecked($core->enable_soundcloud, 0); ?> />
									        <label for="enable_soundcloud_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>


							<div class="row">

								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="social_pinterest" class="form-label"><i class="fa fa-pinterest"></i> Pinterest </label>
										<input type="text" class="form-control" id="social_pinterest" name="social_pinterest" placeholder="eg. https://www.pinterest.com/example" value="<?php echo $core->social_pinterest;?>" data-validetta="minLength[1]"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="enable_pinterest_1" class="form-label show">&nbsp;</label>
										<div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_pinterest_1" name="enable_pinterest" value="1" <?php getChecked($core->enable_pinterest, 1); ?>/>
									        <label for="enable_pinterest_1">Enabled </label>
									    </div>
									    <div class="radio radio-primary radio-inline">
									        <input type="radio" id="enable_pinterest_0" name="enable_pinterest" value="0" <?php getChecked($core->enable_pinterest, 0); ?>/>
									        <label for="enable_pinterest_0">Disabled </label>
									    </div>
								    </div>
								</div>

							</div>




							<div class="row">

								<input name="processConfigSocial" type="hidden" value="1">
								<div class="col-md-12 top20 bot10">
									<button type="button" name="dosubmit" class="btn btn-default">Save Settings</button>
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
<script src="assets/js/datatables/datatables.min.js"></script>
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
