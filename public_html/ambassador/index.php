<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: index.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	if (!$user->logged_in) {
		redirect_to("login");
	}elseif (!$user->is_Ambassador()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! You must be an ambassador to access this part of the website.</li>
		</ul>';
		redirect_to("login");
	}
?>
<!DOCTYPE html>

<html lang="en-US" dir="ltr">

<head>
	<?php include( "components/header.php"); ?>
	<?php require_once('components/stats.php') ?>
</head>

<body>
	<!-- ===============================================-->
	<!--    Main Content-->
	<!-- ===============================================-->
	<main class="main" id="top">
		<div class="container">
			<div class="content">
				
				<?php if(!$countSales):?>
				<div class="modal show mt-6" style="display: block;z-index: 1001;">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<div class="mt-4">
									<img src="<?php echo AMBASSURL; ?>/assets/img/icons/ico4-cup.png" style="display: block; margin: 0 auto; width: 148px; height: auto;" alt="" />
								</div>
								<h3 class="text-center mt-4">Your dashboard is empty</h3>
								<p class="text-center mb-5">To start using your dashboard, send out your unique code so we can begin tracking your progress: <strong><?php echo $urow->invite_code;?></strong></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-backdrop fade show" style="z-index: 1000;background-color: #e9eef4; opacity: 0.85;"></div>
				
				<?php endif;?>
				
								
				<?php include( "components/topbar.php"); ?>
				
				<!-- CARD: Todays cash graph -->
				<div class="card mb-3">
					<div class="card-body rounded-soft bg-gradient">
						<div class="row text-white align-items-center no-gutters">
							<div class="col">
								<h4 class="text-white mb-0">Today <?php echo(formatMonies($todaysRevenue)); ?></h4>
								<p class="fs--1 font-weight-semi-bold">Yesterday <span class="text-300"><?php echo(formatMonies($yesterdaysRevenue)); ?></span>
								</p>
							</div>
							<div class="col-auto d-none d-sm-block">
								<select class="custom-select custom-select-sm mb-3 shadow" id="dashboard-chart-select">
									<option value="all">All Payments</option>
									<option value="successful" selected="selected">Successful Payments</option>
									<option value="failed">Unpaid Orders</option>
								</select>
							</div>
						</div>
						<canvas class="rounded" id="chart-line" width="1618" height="375" aria-label="Line chart" role="img"></canvas>
					</div>
				</div>
				
				<!-- CARD: Next payout -->
				<div class="card bg-light mb-3">
					<div class="card-body p-3">
						<p class="fs--1 mb-0"><a href="#!"><span class="fas fa-exchange-alt mr-2" data-fa-transform="rotate-90"></span>A payout for <strong><?php echo(formatMonies($lastMonthRevenue)); ?> </strong>was deposited <?php echo(date('l, F j', strtotime(date('Y-m-01').' -1 MONTH'))); ?></a>. Your next deposit is expected on <strong><?php echo(date('l, F j', strtotime('first day of next month'))); ?>.</strong>
						</p>
					</div>
				</div>
				<!-- CARD: Card deck -->
				<div class="card-deck">
					
					<div class="card mb-3 overflow-hidden" style="min-width: 12rem">
						<div class="bg-holder bg-card" style="background-image:url(<?php echo AMBASSURL; ?>/assets/img/illustrations/corner-3.png);"></div>
						<!--/.bg-holder-->
						<div class="card-body position-relative">
							<h6>Monthly Earnings
								<!--TODO: <span class="badge badge-soft-success rounded-capsule ml-2">9.54%</span>-->
							</h6>
							<div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif"><?php echo(formatMonies($monthRevenue)); ?></div>
							<a class="font-weight-semi-bold fs--1 text-nowrap" href="<?php echo AMBASSURL; ?>/history">
								See History<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
							</a>
						</div>
						
					</div>
					
					<div class="card mb-3 overflow-hidden" style="min-width: 12rem">
						<div class="bg-holder bg-card" style="background-image:url(<?php echo AMBASSURL; ?>/assets/img/illustrations/corner-2.png);"></div>
						<!--/.bg-holder-->
						<div class="card-body position-relative">
							<h6>Monthly Orders
								<!--TODO: <span class="badge badge-soft-info rounded-capsule ml-2">0.0%</span>-->
							</h6>
							
							<div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info" data-countup='{"count":<?php echo($monthSales) ?>,"format":"comma"}'>0</div>
							<a class="font-weight-semi-bold fs--1 text-nowrap" href="<?php echo AMBASSURL; ?>/history">
								See History<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
							</a>
						</div>
					</div>
					
					<div class="card mb-3 overflow-hidden" style="min-width: 12rem">
						<div class="bg-holder bg-card" style="background-image:url(<?php echo AMBASSURL; ?>/assets/img/illustrations/corner-1.png);"></div>
						<!--/.bg-holder-->
						<div class="card-body position-relative">
							<h6>Monthly Visitors
								<!--TODO: <span class="badge badge-soft-warning rounded-capsule ml-2">-0.23%</span>-->
							</h6>
							<div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" data-countupp='{"count":58386,"format":"alphanumeric"}'>
								N/A
							</div>
							<a class="font-weight-semi-bold fs--1 text-nowrap" href="#!">
								Learn More<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span>
							</a>
						</div>
					</div>
					
				</div>
				
				<!-- CARD: Recent purchases -->
				<div class="card mb-3">
					<div class="card-header">
						<div class="row align-items-center justify-content-between">
							<div class="col-6 col-sm-auto d-flex align-items-center pr-0">
								<h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Recent Purchases</h5>
							</div>
							<div class="col-6 col-sm-auto ml-auto text-right pl-0">
								<div class="d-none" id="purchases-actions">
									<div class="input-group input-group-sm">
										<select class="custom-select cus" aria-label="Bulk actions">
											<option selected="">Bulk actions</option>
											<option value="Refund">Refund</option>
											<option value="Delete">Delete</option>
											<option value="Archive">Archive</option>
										</select>
										<button class="btn btn-falcon-default btn-sm ml-2" type="button">Apply</button>
									</div>
								</div>
								<!--<div id="dashboard-actions">
									<button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ml-1">New</span>
									</button>
									<button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ml-1">Filter</span>
									</button>
									<button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span class="d-none d-sm-inline-block ml-1">Export</span>
									</button>
								</div>-->
							</div>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-md mb-0 table-dashboard fs--1">
								<thead class="bg-200 text-900">
									<tr>
										<th>
											<div class="custom-control custom-checkbox ml-3">
												<input class="custom-control-input checkbox-bulk-select" id="checkbox-bulk-purchases-select" type="checkbox" data-checkbox-body="#purchases" data-checkbox-actions="#purchases-actions" data-checkbox-replaced-element="#dashboard-actions" />
												<label class="custom-control-label" for="checkbox-bulk-purchases-select"></label>
											</div>
										</th>
										<th>Customer</th>
										<th>Email</th>
										<th>Date</th>
										<th class="text-center">Payment</th>
										<th class="text-right">Amount</th>
										<!--<th></th>-->
									</tr>
								</thead>
								<tbody id="purchases">
									
									<?php
										$fromdate = date("Y-m-1 H:i:s");
										$inrow = $item->getAmbassadorInvoices($fromdate, null, $urow->invite_code, 10);
									 ?>
									<?php if(!$inrow):?>
									<tr>
									  <td colspan="7"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
									</tr>
									<?php else:?>
									
									<?php foreach ($inrow as $row):?>
									
									<tr class="btn-reveal-trigger">
										<td class="align-middle">
											<div class="custom-control custom-checkbox ml-3">
												<input class="custom-control-input checkbox-bulk-select-target" type="checkbox" id="checkbox-1" />
												<label class="custom-control-label" for="checkbox-1"></label>
											</div>
										</td>
										<th class="align-middle"><a href="#"><?php echo $row->invid;?></a></th>
										<td class="align-middle">
											<?php
												$userDetails = $user->getUserInfoWithID($row->user_id);
												echo $userDetails->username;
											?>
										</td>
										<td class="align-middle"><?php echo date("F j, o - g:i a", strtotime($row->created));?></td>
										
										<?php if($row->status == 1 || $row->status == "1.5" || $row->status == "2" || $row->status == "3"):?>
											<td class="align-middle text-center fs-0"><span class="badge badge rounded-capsule badge-soft-success">
												Success<span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span></span>
											</td>
										<?php else:?>
											<td class="align-middle text-center fs-0"><span class="badge badge rounded-capsule badge-soft-warning">
												Pending<span class="ml-1 fas fa-stream" data-fa-transform="shrink-2"></span></span>
											</td>
										<?php endif;?>
										
										
										<td class="align-middle text-right">
											<?php 
												if ($row->pp == "Points") {
													echo(intval($row->totalprice) . " pts");
												}
												else {
													echo(formatMonies($row->totalprice));
												}
											 ?>
										</td>
										<!--<td class="align-middle white-space-nowrap">
											<div class="dropdown text-sans-serif">
												<button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span>
												</button>
												<div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
													<div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
														<div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
													</div>
												</div>
											</div>
										</td>-->
									</tr>
									<?php endforeach;?>
									<?php unset($row);?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer border-top">
						
						<div class="row align-items-center">
							<!--<div class="col">
								<p class="mb-0 fs--1"><span class="d-none d-sm-inline-block mr-1">11 Items &mdash; </span><a class="font-weight-semi-bold" href="#">view all<span class="fas fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
								</p>
							</div>
							<div class="col-auto">
								<button class="btn btn-light btn-sm" type="button" disabled="disabled"><span>Previous</span></button>
								<button class="btn btn-primary btn-sm px-4 ml-2" type="button"><span>Next</span></button>
							</div>-->
						</div>
						
					</div>
				</div>
				
				
				<footer>
					<div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
						<div class="col-12 col-sm-auto text-center">
							<p class="mb-0 text-600">2019 &copy;
								<a href="<?php echo $core->site_url; ?>"><?php echo $core->site_name; ?></a>
							</p>
						</div>
						<div class="col-12 col-sm-auto text-center">
							<p class="mb-0 text-600">v1.6.0</p>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</main>
	<!-- ===============================================-->
	<!--    End of Main Content-->
	<!-- ===============================================-->
	<!-- ===============================================-->
	<!--    JavaScripts-->
	<!-- ===============================================-->
	<script src="<?php echo AMBASSURL; ?>/assets/js/jquery.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/popper.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/bootstrap.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/stickyfilljs/stickyfill.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/sticky-kit/sticky-kit.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/is_js/is.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/@fortawesome/all.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/chart.js/Chart.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/jquery.vmap.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.world.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.usa.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/theme.js"></script>
	
	
	
	<!-- for daily sales live -->
	<?php
		
	 
		$monthnum[0] = date("n");
		$yearnum[0] = date("Y");
		$daynum[0] = date("j");
		$dayname[0] = date("M j");
		
		$dayRevenue[0] = $analytics->dayRevenue($yearnum[0], $monthnum[0], $daynum[0], $urow->invite_code)->total;
		if ($dayRevenue[0] == 0 || !$dayRevenue[0]) {
			$dayRevenue[0] = "0";
		}
		
		$dayRevenueUnpaid[0] = $analytics->dayRevenueUnpaid($yearnum[0], $monthnum[0], $daynum[0], $urow->invite_code)->total;
		if ($dayRevenueUnpaid[0] == 0 || !$dayRevenueUnpaid[0]) {
			$dayRevenueUnpaid[0] = "0";
		}
		
		$dayRevenueCombined[0] = $analytics->dayRevenueCombined($yearnum[0], $monthnum[0], $daynum[0], $urow->invite_code)->total;
		if ($dayRevenueCombined[0] == 0 || !$dayRevenueCombined[0]) {
			$dayRevenueCombined[0] = "0";
		}
		
		
		$labels = '"' . $dayname[0] . '"';
		$dataRev = $dayRevenue[0];
		$dataRevUnpaid = $dayRevenueUnpaid[0];
		$dataRevCombined = $dayRevenueCombined[0];
		$colors = '"#fff"';
		
		
		for ($i = 1; $i <= 9; $i++) {
			$monthnum[$i] = date("n", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
			$yearnum[$i] = date("Y", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
			$daynum[$i] = date("j", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
			$dayname[$i] = date("M j", strtotime( date( 'Y-m-d' )." -$i days")) . " ";
			
			$dayRevenue[$i] = $analytics->dayRevenue($yearnum[$i], $monthnum[$i], $daynum[$i], $urow->invite_code)->total;
			if ($dayRevenue[$i] == 0 || !$dayRevenue[$i]) {
				$dayRevenue[$i] = "0";
			}
			
			$dayRevenueUnpaid[$i] = $analytics->dayRevenueUnpaid($yearnum[$i], $monthnum[$i], $daynum[$i], $urow->invite_code)->total;
			if ($dayRevenueUnpaid[$i] == 0 || !$dayRevenueUnpaid[$i]) {
				$dayRevenueUnpaid[$i] = "0";
			}
			
			$dayRevenueCombined[$i] = $analytics->dayRevenueCombined($yearnum[$i], $monthnum[$i], $daynum[$i], $urow->invite_code)->total;
			if ($dayRevenueCombined[$i] == 0 || !$dayRevenueCombined[$i]) {
				$dayRevenueCombined[$i] = "0";
			}
			
			
			$labels = '"' . $dayname[$i] . '", ' . $labels;
			$dataRev = $dayRevenue[$i] . ', ' . $dataRev;
			$dataRevUnpaid = $dayRevenueUnpaid[$i] . ', ' . $dataRevUnpaid;
			$dataRevCombined = $dayRevenueCombined[$i] . ', ' . $dataRevCombined;
			
			$colors = $colors . ', ' . $colors;
		}
	?>
	
	
	<script type="text/javascript">
		/*-----------------------------------------------
		|   Chart
		-----------------------------------------------*/
		
		window.utils.$document.ready(function () {
			/*-----------------------------------------------
			|   Helper functions and Data
			-----------------------------------------------*/
			var hexToRgb = function hexToRgb(hexValue) {
				var hex;
				hexValue.indexOf('#') === 0 ? hex = hexValue.substring(1) : hex = hexValue; // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
			
				var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
				var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex.replace(shorthandRegex, function (m, r, g, b) {
					return r + r + g + g + b + b;
				}));
				return result ? [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)] : null;
			};
		
			var chartData = [<?php echo($dataRev); ?>];
			var colors = [<?php echo($colors); ?>];
			
			var rgbColor = function rgbColor(color) {
				if (color === void 0) {
					color = colors[0];
				}
				return "rgb(" + hexToRgb(color) + ")";
			};
			
			var rgbaColor = function rgbaColor(color, alpha) {
				if (color === void 0) {
					color = colors[0];
				}
				
				if (alpha === void 0) {
					alpha = 0.5;
				}
				return "rgba(" + hexToRgb(color) + "," + alpha + ")";
			};
			
			var rgbColors = colors.map(function (color) {
				return rgbColor(color);
			});
			
			var rgbaColors = colors.map(function (color) {
				return rgbaColor(color);
			});
			
			var labels = [<?php echo($labels); ?>];
		 		  
			
			/*-----------------------------------------------
			|   Chart Initialization
			-----------------------------------------------*/
			
			var newChart = function newChart(chart, config) {
			var ctx = chart.getContext('2d');
				return new window.Chart(ctx, config);
			};
			
			/*-----------------------------------------------
			|   Line Chart
			-----------------------------------------------*/
			
			var chartLine = document.getElementById('chart-line');
		
			if (chartLine) {
			var dashboardLineChart = newChart(chartLine, {
			  type: 'line',
			  data: {
			    labels: labels.map(function (l) {
			      return l;
			    }),
			    datasets: [{
			      borderWidth: 2,
			      data: chartData.map(function (d) {
			        return d.toFixed(2);
			      }),
			      borderColor: rgbaColor('#fff', 0.8),
			      backgroundColor: rgbaColor('#fff', 0.15)
			    }]
			  },
			  options: {
			    legend: {
			      display: false
			    },
			    tooltips: {
			      mode: 'x-axis',
			      xPadding: 20,
			      yPadding: 10,
			      displayColors: false,
			      callbacks: {
			        label: function label(tooltipItem) {
			          return labels[tooltipItem.index] + " - $" + tooltipItem.yLabel;
			        },
			        title: function title() {
			          return null;
			        }
			      }
			    },
			    hover: {
			      mode: 'label'
			    },
			    scales: {
			      xAxes: [{
			        scaleLabel: {
			          show: true,
			          labelString: 'Month'
			        },
			        ticks: {
			          fontColor: rgbaColor('#fff', 0.7),
			          fontStyle: 600
			        },
			        gridLines: {
			          color: rgbaColor('#fff', 0.1),
			          lineWidth: 1
			        }
			      }],
			      yAxes: [{
			        display: false
			      }]
			    }
			  }
			});
			$('#dashboard-chart-select').on('change', function (e) {
			  var LineDB = {
			    all: [<?php echo($dataRevCombined); ?>].map(function (d) {
			      return d.toFixed(2);
			    }),
			    successful: [<?php echo($dataRev); ?>].map(function (d) {
			      return d.toFixed(2);
			    }),
			    failed: [<?php echo($dataRevUnpaid); ?>].map(function (d) {
			      return d.toFixed(2);
			    })
			  };
			  dashboardLineChart.data.datasets[0].data = LineDB[e.target.value];
			  dashboardLineChart.update();
			});
			}
			
			
			});
	</script>
</body>

</html>