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
							
							
							
							
							
							<!-- Start Row: First Name and Last Name -->
							<div class="row">
								
								
								<?php 
									$start_month = date('m');
									$start_year = date('Y');
									$total_rev = 0;
									
									for($i=0; $i<=12; ++$i){
										$year = date('Y', mktime(0, 0, 0, $start_month-$i));
										$month = date('m', mktime(0, 0, 0, $start_month-$i));
										
										$monthRevenue = $analytics->monthRevenue($year, $month, $row->invite_code)->total;
										$monthSales = $analytics->monthSales($year, $month, $row->invite_code)->total;
									
								?>
								
								<?php if($start_year == $year && $monthRevenue != 0):?>
								
								<?php 
									$total_rev = $total_rev + $monthRevenue;
								 ?>
								
								<div class="col-md-4">
									
									<div class="panel panel-widget" style="border: 1px solid #333;">
										<div class="panel-body">
											<h4 style="margin-top: 6px;">
												<?php echo date('F Y', mktime(0, 0, 0, $start_month-$i, 1, $start_year)); ?> <br />
											</h4>
											<p class="text">
												
												Earnings: <?php echo(formatMonies($monthRevenue)) ?> <br />
												Sales: <?php echo($monthSales); ?>
											</p>
										</div>
									</div>
								</div>
								
								
								<?php endif;?>
								
								<?php } ?>
								
								
								
							</div>
							
							
							<div class="row top40">
								
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
							
							
							<div class="row top40">
								
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="lastip" class="form-label">Total revenue:</label>
										
										<input type="text" class="form-control form-control-line" id="lastip" value="<?php echo(formatMonies($total_rev)) ?>" readonly>
										
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
