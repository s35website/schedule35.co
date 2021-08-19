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
<?php $row = Core::getRowById(Users::uTable, Filter::$id);?>

<?php 
	$monthRevenue = $analytics->monthRevenue($curr_year, $curr_month, $row->invite_code)->total;
	$lastMonthRevenue = $analytics->monthRevenue($curr_year, $curr_month - 1, $row->invite_code)->total;
 ?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Edit</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=ambassadors">Ambassadors</a></li>
			<li class="active">Edit Ambassador</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=ambassadors" class="btn btn-light"><i class="fa fa-chevron-left"></i>View all Ambassadors</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- Start Presentation -->
	<div class="row presentation">
	
		<div class="col-md-8 titles">
			<h1><i class="fa fa-user"></i> Update User <mark><?php echo $row->username;?></mark></h1>
		</div>
		
		<div class="col-md-4 avatar">
			<?php if($row->avatar):?>
			<img src="<?php echo UPLOADURL;?>avatars/<?php echo $row->avatar;?>" alt="<?php echo $row->username;?>">
			<?php else:?>
			<img src="<?php echo UPLOADURL;?>avatars/blank.png?v=1" alt="<?php echo $row->username;?>">
			<?php endif;?>
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
						User Details
					</div>
					
					<div class="panel-body">
						<form class="form_submission" name="form_submission" method="post">
						
							<!-- Disable autofill -->
							<input style="display:none" type="text" name="fakeusernameremembered"/>
							<input style="display:none" type="password" name="fakepasswordremembered"/>
							
							<!-- Start Row: Username Password -->
							
							<!--
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="username" class="form-label">Username <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" autocomplete="off" id="username" name="username" placeholder="johndoe" data-validetta="minLength[1]" value="<?php echo $row->username;?>">
									</div>
								</div>
								
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="password" class="form-label">Password <i class="fa fa-asterisk"></i></label>
										<input type="password" autocomplete="off" class="form-control" id="password" name="password" data-validetta="minLength[1]">
									</div>
								</div>
							</div>
							-->
							
							
							
							<div class="row">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<?php $details = json_decode(file_get_contents("http://ipinfo.io/{$row->lastip}/json")); ?>
										<label for="lastip" class="form-label"><?php echo(date('F', mktime(0, 0, 0, $curr_month, 1))); ?>'s Revenue</label>
										
										<input type="text" class="form-control form-control-line" id="lastip" value="<?php echo(formatMonies($monthRevenue)) ?>" readonly>
										
										
										
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<?php $details = json_decode(file_get_contents("http://ipinfo.io/{$row->lastip}/json")); ?>
										<label for="lastip" class="form-label"><?php echo(date('F', mktime(0, 0, 0, $curr_month - 1, 1))); ?>'s Revenue</label>
										
										<input type="text" class="form-control form-control-line" id="lastip" value="<?php echo(formatMonies($lastMonthRevenue)) ?>" readonly>
									</div>
								</div>
								
							</div>
							
							
							<!-- Start Row: First Name and Last Name -->
							<div class="row">
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="fname" class="form-label">First Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="fname" name="fname" placeholder="John" data-validetta="required,minLength[1]" value="<?php echo $row->fname;?>">
									</div>
								</div>
								
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="lname" class="form-label">Last Name <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="lname" name="lname" placeholder="Doe" value="<?php echo $row->lname;?>">
									</div>
								</div>
								
								<div class="col-sm-6 col-md-6">
									<div class="form-group">
										<label for="password" class="form-label">Password <i class="fa fa-asterisk"></i></label>
										<input type="password" autocomplete="off" class="form-control" id="password" name="password" data-validetta="minLength[1]">
									</div>
								</div>
								
							</div>
							
							
							<!-- Start Row: Email and Avatar -->
							<div class="row">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="email" class="form-label">Email Address <i class="fa fa-asterisk"></i></label>
										<input type="text" class="form-control" id="email" name="email" placeholder="johndoe@gmail.com" data-validetta="required,minLength[1],email" value="<?php echo $row->username;?>">
									</div>
								</div>
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="thumbid" class="form-label">User Avatar <i class="fa fa-asterisk"></i></label>
										
										<div class="custom-file-upload">
											<input type="file" id="thumbid" name="avatar" style="padding: 5px;"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								
								<div class="col-md-12 col-md-6">
									<div class="form-group">
										<label for="userlevel_1" class="form-label show">User Level <i class="fa fa-asterisk"></i></label>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="userlevel_1" name="userlevel" value="1" <?php echo getChecked($row->userlevel, 1);?>>
											<label for="userlevel_1"> User </label>
										</div>
										
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="userlevel_2" name="userlevel" value="2" <?php echo getChecked($row->userlevel, 2);?>/>
											<label for="userlevel_2"> Ambassador </label>
										</div>
										
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="userlevel_6" name="userlevel" value="6" <?php echo getChecked($row->userlevel, 6);?>/>
											<label for="userlevel_6"> Manager </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="userlevel_7" name="userlevel" value="7" <?php echo getChecked($row->userlevel, 7);?>/>
											<label for="userlevel_7"> Author </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="userlevel_9" name="userlevel" value="9" <?php echo getChecked($row->userlevel, 9);?>/>
											<label for="userlevel_9"> Admin </label>
										</div>
									</div>
								</div>
								
								
								<div class="col-md-12 col-md-6">
									<div class="form-group">
										<label for="userlevel_1" class="form-label show">User Status <i class="fa fa-asterisk"></i></label>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="user_active" name="active" value="y" <?php echo getChecked($row->active, "y");?>/>
											<label for="user_active"> Active </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="user_inactive" name="active" value="n" <?php echo getChecked($row->active, "n");?>/>
											<label for="user_inactive"> Inactive </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="user_banned" name="active" value="b" <?php echo getChecked($row->active, "b");?>/>
											<label for="user_banned"> Banned </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" id="user_pending" name="active" value="t" <?php echo getChecked($row->active, "t");?>/>
											<label for="user_pending"> Pending </label>
										</div>
									</div>
								</div>
								
								
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label for="notes" class="form-label">User Notes</label>
									<textarea class="form-control" rows="8" id="notes" name="notes"><?php echo $row->notes;?></textarea>
								</div>
								
							</div>
							
							<div class="row top20">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="lastlogin" class="form-label">Last Login</label>
										<input type="text" class="form-control form-control-line" id="lastlogin" value="<?php echo date('F j, Y, g:i a', strtotime($row->lastlogin)); ?>" readonly>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<?php $details = json_decode(file_get_contents("http://ipinfo.io/{$row->lastip}/json")); ?>
										<label for="lastip" class="form-label">Last IP</label>
										<?php
											if ($details->city) {
												$city = $details->city;
											} else {
												$city = "undefined";
											}
											
											if ($details->region) {
												$region = $details->region;
											} else {
												$region = "undefined";
											}
											
											if ($details->country) {
												$country = $details->country;
											} else {
												$country = "undefined";
											}
										 ?>
										<input type="text" class="form-control form-control-line" id="lastip" value="<?php echo $row->lastip;?> (<?php echo $city . ", " . $region . ", " . $country;?>)" readonly>
									</div>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12 top20">
								
									<div class="row">
									
										<div class="col-md-4">
											<label for="newsletter_1" class="form-label show">Newsletter</label>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="newsletter_1" name="newsletter" value="1" <?php echo getChecked($row->newsletter, 1);?>/>
												<label for="newsletter_1"> Yes </label>
											</div>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="newsletter_0" name="newsletter" value="0" <?php echo getChecked($row->newsletter, 0);?>/>
												<label for="newsletter_0"> No </label>
											</div>
										</div>
										
										<div class="col-md-4">
											<label for="notifications_1" class="form-label show">Notifications </label>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="notifications_1" name="notifications" value="1" <?php echo getChecked($row->notifications, 1);?>/>
												<label for="notifications_1"> Yes </label>
											</div>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="notifications_0" name="notifications" value="0" <?php echo getChecked($row->notifications, 0);?>/>
												<label for="notifications_0"> No </label>
											</div>
										</div>
										
										<div class="col-md-4">
											<label for="purchase_receipts_1" class="form-label show">Purchase Receipts </label>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="purchase_receipts_1" name="purchase_receipts" value="1" <?php echo getChecked($row->purchase_receipts, 1);?>/>
												<label for="purchase_receipts_1"> Yes </label>
											</div>
											<div class="radio radio-primary radio-inline">
												<input type="radio" id="purchase_receipts_0" name="purchase_receipts" value="0" <?php echo getChecked($row->purchase_receipts, 0);?>/>
												<label for="purchase_receipts_0"> No </label>
											</div>
										</div>
										
									</div>
									
								</div>
								
								<input type="hidden" id="notify" name="notify" value="0" />
								<input name="processUser" type="hidden" value="1">
								<input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
								
								<div class="col-md-12 top40">
									<button type="button" name="dosubmit" class="btn btn-default" disabled="true">Update Profile</button>
									<a href="index.php?do=ambassadors" class="btn btn-light">Cancel</a>
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
