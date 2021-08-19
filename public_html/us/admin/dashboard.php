<?php
	/**
	* Main
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: main.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $page = "dashboard" ?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Dashboard</h1>
		<ol class="breadcrumb">
			<li class="active"><?php echo(date("F j, Y, g:i a")); ?></li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<form method="post" class="btn-group" id="topbar" name="topbar">
				<a href="index.php" class="btn btn-light"><i class="fa fa-refresh"></i></a>
				<a href="#" class="btn btn-light" id="topstats"><i class="fa fa-line-chart"></i></a>
			</form>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<?php if($user->is_Admin()):?>

	<!-- START CONTAINER -->
	<div class="container-widget">
		
		
		<!-- Start Top Stats -->
		<div class="col-md-12">
			<ul class="topstats clearfix">
				<li class="arrow"></li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-dot-circle-o hide"></i> Today's<br/>Revenue</span>
					<h3>
						<?php echo(formatMonies($todaysRevenue)) ?>
					</h3>
				</li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-dot-circle-o hide"></i> Yesterday's<br/>Revenue</span>
					<h3>
						<?php echo(formatMonies($yesterdaysRevenue)) ?>
					</h3>
				</li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-calendar-o hide"></i> This<br/>Month</span>
					<h3>
						<?php echo(formatMonies($monthRevenue)) ?>
					</h3>
				</li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-shopping-cart hide"></i> Monthly<br/>Sales</span>
					<h3><?php echo($monthSales); ?></h3>
				</li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-shopping-cart hide"></i> Monthly<br/>Inventory</span>
					<h3><?php echo($analytics->inventoryTransactions($curr_year, $curr_month)->total); ?></h3>
				</li>
				<li class="col-xs-6 col-lg-2">
					<span class="title"><i class="fa fa-users hide"></i> New<br/>Users</span>
					<h3><?php echo($activeUsers); ?></h3>
				</li>
			</ul>
		</div>
		<!-- End Top Stats -->

		<!-- Start First Row -->
		<div class="row">
			
			<?php if($sold):?>
			<!-- Start General Stats -->
			<div class="col-md-12 col-lg-7">
				<div class="panel panel-widget">
					<div class="panel-title">
						Top Products (Monthly) 
					</div>
					<div class="panel-body">
					
						<?php foreach($sold as $i => $irow):?>
						
						
						<?php
							if ($analytics->inventoryTransactions($curr_year, $curr_month)->total == 0) {
								$percent = 0;
							}
							else {
								$percent = round($analytics->inventoryTransactionsSpecific($curr_year, $curr_month, $irow->pid)->total / $analytics->inventoryTransactions($curr_year, $curr_month)->total * 100);
							}
							
						?>
						
						<div class="easypie margin-b-20 margin-r-20" data-percent="<?php echo $percent;?>">
							<span><?php echo $percent;?>%</span>
							<?php echo sanitize($irow->title,20);?>
							<small style="display: block;"><?php echo $analytics->inventoryTransactionsSpecific($curr_year, $curr_month, $irow->pid)->total;?></small>
						</div>
						
						<?php endforeach;?>
					</div>
				</div>
			</div>
			<!-- End General Stats -->
			<?php endif;?>
			
			
			<!-- Start Latest transactions -->
			<div class="col-md-12 col-lg-5">
				<div class="panel panel-widget">
					<div class="panel-title">
						Inventory Stock
						<ul class="panel-tools" style="display: none;">
							<li><a class="icon"><i class="fa fa-refresh"></i></a></li>
							<li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
						</ul>
					</div>
					<div class="panel-body table-responsive" style="height:380px;overflow-y: auto;">
						
						<table class="table table-dic table-hover ">
							<tbody>
								<?php if(!$itemsrow):?>
								<tr>
								  <td colspan="3"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($itemsrow as $itemrow):?>
								<tr>
									<td style="width: 42px;padding: 0;">
										<?php if($itemrow->thumb):?>
										<img src="<?php echo UPLOADURL;?>prod_images/<?php echo $itemrow->thumb;?>" alt="<?php echo $itemrow->title;?>" style="width: 40px;"/>
										<?php else:?>
										<img src="<?php echo UPLOADURL;?>prod_images/blank.png?v=1" alt="<?php echo $itemrow->title;?>" style="width: 40px;" />
										<?php endif;?>
									</td>
									<td><?php echo truncate($itemrow->title,35);?></td>
									<td class="text-r">
										
										<?php
										    if ($itemrow->stock > 15) {
										      echo('<span class="color-shipped">' . $itemrow->stock . '</span>');
										    }elseif ($itemrow->stock > 0) {
										      echo('<span class="color-paid">' . $itemrow->stock . '</span>');
										    }elseif ($itemrow->stock == 0) {
										      echo('<span class="color-unpaid">' . $itemrow->stock . '</span>');
										    }
										    else {
										      echo($itemrow->stock);
										    }
										?>
									</td>
								</tr>
								<?php endforeach;?>
								<?php unset($row);?>
								<?php endif;?>
							</tbody>
						</table>
						

					</div>
				</div>
			</div>
			<!-- End Latest transactions -->

		</div>
		<!-- End First Row -->
		
		
		<!-- Start Row -->
		<div class="row">

			<!-- Start Latest transactions -->
			<div class="col-md-12 col-lg-12">
				<div class="panel panel-widget">
					<div class="panel-title">
						Daily Inventory
					</div>
					<div class="panel-body">
						
						<canvas id="dailySalesChart" width="400" height="160"></canvas>
						
					</div>
				</div>
			</div>
			<!-- End Latest transactions -->
			
		</div>
		<!-- End Row -->
		
		
		<!-- Start Third Row -->
		<div class="row">
			
			<!-- Start Chart Daily -->
			<div class="col-md-12 col-lg-12">
				<div class=" panel-widget widget chart-with-stats clearfix" style="height:450px;">

					<div class="col-sm-12" style="height:450px;">
						<h4 class="title">TRAFFIC REPORT</h4>
						<div class="bigchart" id="todayInventory"></div>
					</div>
					<div class="right" style="height:450px;">
						<h4 class="title">Legend</h4>
						<!-- start stats -->
						<ul class="widget-inline-list clearfix">
							<li class="col-12">Total Views<i class="chart sparkline-lightblue"></i></li>
							<li class="col-12">Unique Views<i class="chart sparkline-blue"></i></li>
							<li class="col-12">Page Views<i class="chart sparkline-darkblue"></i></li>
						</ul>
						<!-- end stats -->
					</div>


				</div>
			</div>
			<!-- End Chart Daily -->

		</div>
		<!-- End Third Row -->


	</div>
	<!-- END CONTAINER -->
	
	<?php elseif($user->is_Writer()):?>
	<div class="container-widget">
		
		<div class="row">
			<!-- Start General Stats -->
			<div class="col-md-6 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-title">
			          News
			        </div>
					<div class="panel-heading">Write Article</div>
					<div class="panel-body">
						Write a news article and share your story with the world...
						<br />
						<br />
						<a href="index.php?do=news&action=add" class="btn btn-default btn-lg">Write Article</a>
			        </div>
				</div>
			</div>
		</div>
		
	</div>
	<?php elseif($user->is_Manager()):?>
	
	<div class="container-widget">
			
		<div class="row">
			<!-- Start General Stats -->
			<div class="col-md-6 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-title">
			          Shop
			        </div>
					<div class="panel-heading">View inventory</div>
					<div class="panel-body">
						Update inventory
						<br />
						<br />
						<a href="index.php?do=products" class="btn btn-default btn-lg">View Inventory</a>
			        </div>
				</div>
			</div>
		</div>
		
	</div>
	<?php endif;?>

	<!-- Start Footer -->
	<?php include("components/footer.php") ?>
	<!-- End Footer -->


</div>



<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="assets/js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap-select/bootstrap-select.js"></script>

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- ================================================
Bootstrap WYSIHTML5
================================================ -->
<!-- main file -->
<script type="text/javascript" src="assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js"></script>
<!-- bootstrap file -->
<script type="text/javascript" src="assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<!-- ================================================
Summernote
================================================ -->
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>

<!-- ================================================
Easy Pie Chart
================================================ -->
<!-- main file -->
<script type="text/javascript" src="assets/js/easypiechart/easypiechart.js"></script>
<!-- demo codes -->
<script type="text/javascript" src="assets/js/easypiechart/easypiechart-plugin.js"></script>

<!-- ================================================
Sparkline
================================================ -->
<!-- main file -->
<script type="text/javascript" src="assets/js/sparkline/sparkline.js"></script>
<!-- demo codes -->
<script type="text/javascript" src="assets/js/sparkline/sparkline-plugin.js"></script>


<!-- ================================================
Data Tables
================================================ -->
<script src="assets/js/datatables/datatables.min.js"></script>

<!-- ================================================
Sweet Alert
================================================ -->
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Validetta
================================================ -->
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>

<!-- ================================================
Kode Alert
================================================ -->
<script src="assets/js/kode-alert/main.js"></script>

<!-- ================================================
jQuery UI
================================================ -->
<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script>

<!-- ================================================
Moment.js
================================================ -->
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/Chart.min.js?v=2"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/plugins.js"></script>



<!-- for daily sales live -->
<?php
	
 
	$monthnum[0] = date("n");
	$yearnum[0] = date("Y");
	$daynum[0] = date("j");
	$dayname[0] = date("D M j");
	
	$dayInventory[0] = $analytics->dayInventory($yearnum[0], $monthnum[0], $daynum[0])->total;
	if ($dayInventory[0] == 0 || !$dayInventory[0]) {
		$dayInventory[0] = "0";
	}
	
	
	$labels = '"' . $dayname[0] . '"';
	$dataRev = $dayInventory[0];
	
	
	for ($i = 1; $i <= 30; $i++) {
		$monthnum[$i] = date("n", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
		$yearnum[$i] = date("Y", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
		$daynum[$i] = date("j", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
		$dayname[$i] = date("D M j", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
		
		$dayInventory[$i] = $analytics->dayInventory($yearnum[$i], $monthnum[$i], $daynum[$i])->total;
		if ($dayInventory[$i] == 0 || !$dayInventory[$i]) {
			$dayInventory[$i] = "0";
		}
		
		$labels = '"' . $dayname[$i] . '", ' . $labels; 
		$dataRev = $dayInventory[$i] . ', ' . $dataRev; 
	}
?>

<script>
	var ctx = document.getElementById("dailySalesChart").getContext('2d');
	var dailySalesChart = new Chart(ctx, {
	    type: 'line',
	    data: {
	        labels: [<?php echo($labels); ?>],
	        datasets: [{
	            label: 'Product Moved',
	            data: [<?php echo($dataRev); ?>],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255,99,132,1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:false
	                }
	            }]
	        }
	    }
	});
</script>