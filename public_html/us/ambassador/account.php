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
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("login");
	}
?>
<!DOCTYPE html>

<html lang="en-US" dir="ltr">

<head>
	<?php include( "components/header.php"); ?>
</head>

<body>
	
	<div id="notifyProfileSettings" class="toast hide position-fixed b-0 r-0">
		<div class="toast-header"><strong class="mr-auto">Your settings have been updated.</strong>
			<button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button>
		</div>
	</div>
	
	
	<!-- ===============================================-->
	<!--    Main Content-->
	<!-- ===============================================-->
	
	
	
	<main class="main" id="top">
		
		
		<div class="container">
			
			<div class="content">
				
				<?php include( "components/topbar.php"); ?>
				
				<!--<div class="row">
					<div class="col-12">
						<div class="card mb-3 btn-reveal-trigger">
							<div class="card-header position-relative min-vh-25 mb-8">
								<div class="cover-image">
									<div class="bg-holder rounded-soft rounded-bottom-0" style="background-image:url(<?php echo AMBASSURL;?>/assets/img/generic/4.jpg);"></div>
									<!--/.bg-holder--*>
									<input class="d-none" id="upload-cover-image" type="file">
									<label class="cover-image-file-input" for="upload-cover-image"><span class="fas fa-camera mr-2"></span><span>Change cover photo</span>
									</label>
								</div>
								<div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
									<div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
										<img src="<?php echo THEMEURL;?>/assets/img/icons/avatar-img.png" width="200" alt="">
										<input class="d-none" id="profile-image" type="file">
										<label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span class="bg-holder overlay overlay-0"></span><span class="z-index-1 text-white text-center fs--1"><span class="fas fa-camera"></span><span class="d-block">Update</span></span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>-->
				
				<div class="row no-gutters">
					<div class="col-lg-8 pr-lg-2">
						
						<div class="card mb-3 mt-3">
							<div class="card-header">
								<h5 class="mb-0">Profile Settings</h5>
							</div>
							<div class="card-body bg-light">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="first-name">First Name</label>
											<input class="form-control" id="fname" type="text" value="<?php echo $urow->fname;?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="last-name">Last Name</label>
											<input class="form-control" id="lname" type="text" value="<?php echo $urow->lname;?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="email1">Email</label>
											<input class="form-control" id="email" type="text" value="<?php echo $urow->username;?>" readonly>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="phone">Phone</label>
											<input class="form-control" id="phone" type="number" value="<?php echo $urow->phone;?>">
										</div>
									</div>
									
									<div class="col-12 d-flex justify-content-end">
										<button id="btnProfileSettings" class="btn btn-primary">
											Update <span class="sync-loader"><span class="fas fa-spin fa-sync-alt ml-1"></span></span>
										</button>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="card mb-3 mb-lg-0">
							<div class="card-header">
								<h5 class="mb-0">Shipping Address</h5>
							</div>
							<div class="card-body bg-light">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="shipping_name">Full Name (for shipping)</label>
											<input class="form-control" id="shipping_name" type="text" value="<?php echo $urow->fullname_shipping;?>">
										</div>
									</div>
									
									<div class="col-md-8">
										<div class="form-group">
											<label for="shipping_address_line_1">Address</label>
											<input class="form-control" id="shipping_address_line_1" type="text" value="<?php echo $urow->address;?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="shipping_address_line_2">Apt / Suite #</label>
											<input class="form-control" id="shipping_address_line_2" type="text" value="<?php echo $urow->address2;?>">
										</div>
									</div>
									
									
									<div class="col-md-4">
										<div class="form-group">
											<label for="shipping_city">City</label>
											<input class="form-control" id="shipping_city" type="text" value="<?php echo $urow->city;?>">
										</div>
									</div>
									<div class="col-md-4">
										
										<div class="form-group">
										
										<label for="shipping_state">Example select</label>
										
											<select class="form-control" id="shipping_state">
												<option value="AB" <?php echo $urow->state == 'AB' ? 'selected' : ''?>>AB</option>
												<option value="BC" <?php echo $urow->state == 'BC' ? 'selected' : ''?>>BC</option>
												<option value="MB" <?php echo $urow->state == 'MB' ? 'selected' : ''?>>MB</option>
												<option value="NB" <?php echo $urow->state == 'NB' ? 'selected' : ''?>>NB</option>
												<option value="NL" <?php echo $urow->state == 'NL' ? 'selected' : ''?>>NL</option>
												<option value="NS" <?php echo $urow->state == 'NS' ? 'selected' : ''?>>NS</option>
												<option value="ON" <?php echo $urow->state == 'ON' ? 'selected' : ''?>>ON</option>
												<option value="PE" <?php echo $urow->state == 'PE' ? 'selected' : ''?>>PE</option>
												<option value="QC" <?php echo $urow->state == 'QC' ? 'selected' : ''?>>QC</option>
												<option value="SK" <?php echo $urow->state == 'SK' ? 'selected' : ''?>>SK</option>
												<option value="NT" <?php echo $urow->state == 'NT' ? 'selected' : ''?>>NT</option>
												<option value="NU" <?php echo $urow->state == 'NU' ? 'selected' : ''?>>NU</option>
												<option value="YT" <?php echo $urow->state == 'YT' ? 'selected' : ''?>>YT</option>
											</select>
										
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="shipping_zip">Postal Code</label>
											<input class="form-control" id="shipping_zip" type="text" value="<?php echo $urow->zip;?>">
										</div>
									</div>
									<div class="col-12 d-flex justify-content-end">
										<button id="btnShippingAddress" class="btn btn-primary">
											Update <span class="sync-loader"><span class="fas fa-spin fa-sync-alt ml-1"></span></span>
										</button>
									</div>
								</div>
							</div>
						</div>
						
						
						
						<div class="card mb-3 mt-3 mb-lg-0">
							<div class="card-header">
								<h5 class="mb-0">Notes</h5>
							</div>
							<div class="card-body bg-light">
								<div class="row">
									
									<div class="col-12">
										<div class="form-group">
											<textarea class="form-control" id="notes" name="notes" rows="8"><?php echo $urow->notes;?></textarea>
										</div>
									</div>
									
									<div class="col-12 d-flex justify-content-end">
										<button id="btnNotes" class="btn btn-primary">
											Update <span class="sync-loader"><span class="fas fa-spin fa-sync-alt ml-1"></span></span>
										</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
					
					
					<div class="col-lg-4 pl-lg-2">
						<div class="sticky-top sticky-sidebar">
							<div class="card mb-3 overflow-hidden">
								<div class="card-header">
									<h5 class="mb-0">Ambassador Details</h5>
								</div>
								<div class="card-body bg-light">
									<h6 class="font-weight-bold">Unique Code: <span class="fs--2 ml-1 text-primary" data-toggle="tooltip" data-placement="top" title="Earn money everytime a purchase is made using this discount code."><span class="fas fa-question-circle"></span></span>
				                          </h6>
									<div class="form-group">
										<input class="form-control" id="unique-code" type="text" value="<?php echo $urow->invite_code;?>" readonly>
									</div>
									<hr class="border-dashed border-bottom-0">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" id="checkbox1" checked="checked" />
										<label class="custom-control-label" for="checkbox1">Receive newslettter</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" id="checkbox2" checked="checked" />
										<label class="custom-control-label" for="checkbox2">Receive purchase receipts</label>
									</div>
									<!--<hr class="border-dashed border-bottom-0">
									<div class="custom-control custom-switch">
										<input class="custom-control-input" type="checkbox" id="switch2" />
										<label class="custom-control-label" for="switch2">Keep identity anonymous</label>
									</div>-->
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header">
									<h5 class="mb-0">Change Password</h5>
								</div>
								<div class="card-body bg-light">
									<div class="form-group">
										<label for="verifyPW">Current Password</label>
										<input class="form-control" id="verifyPW" type="password" autocomplete="false">
									</div>
									<div class="form-group">
										<label for="newPW">New Password</label>
										<input class="form-control" id="newPW" type="password" autocomplete="false">
									</div>
									<div class="form-group">
										<label for="confirmPW">Confirm Password</label>
										<input class="form-control" id="confirmPW" type="password" autocomplete="off">
									</div>
									<button id="btnChangePassword" class="btn btn-primary">
										Update <span class="sync-loader"><span class="fas fa-spin fa-sync-alt ml-1"></span></span>
									</button>
									
								</div>
							</div>
							
						</div>
					</div>
					
				</div>
				<footer>
					<div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
						<div class="col-12 col-sm-auto text-center">
							<p class="mb-0 text-600">
								</span> 2019 &copy; <a href="<?php echo $core->site_url;?>"><?php echo $core->site_name;?></a>
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
	<script src="<?php echo AMBASSURL; ?>/assets/lib/owl.carousel/owl.carousel.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/fancybox/jquery.fancybox.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/flatpickr/flatpickr.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.world.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.usa.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/theme.js"></script>
	
	<script type="text/javascript">
		
		/* == Update Profile Info == */
		function fieldValid(x) {
		     if (x.val().length > 0) {
		     	x.removeClass("error");
		     	return true;
		     }else {
		     	x.addClass("error");
		     	return false;
		     }
		}
		
		$('body').on('click', '#btnProfileSettings', function() {
		
			fieldValid($("#fname"));
		
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/user.php",
				data: {
					'updateProfileSettings': 1,
					'fname': $("#fname").val(),
					'lname': $("#lname").val(),
					'phone': $("#phone").val()
				},
				beforeSend: function() {
					$("#btnProfileSettings").addClass("loading");
					$("#btnProfileSettings").attr("disabled", true);
					
					$(".toast").addClass("hide");
					$(".toast").removeClass("show");
				},
				success: function(json) {
					
					$("#notifyProfileSettings").addClass("show");
					$("#notifyProfileSettings").removeClass("hide");
					
					$("#btnProfileSettings").removeClass("loading");
					$("#btnProfileSettings").attr("disabled", false);
				},
				error: function(json) {
					console.log('error');
				}
			});
		});
		
		
		$('body').on('click', '#btnNotes', function() {
		
			fieldValid($("#fname"));
		
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/user.php",
				data: {
					'updateNotes': 1,
					'notes': $("#notes").val()
				},
				beforeSend: function() {
					$("#btnNotes").addClass("loading");
					$("#btnNotes").attr("disabled", true);
					
					$(".toast").addClass("hide");
					$(".toast").removeClass("show");
				},
				success: function(json) {
					
					$("#notifyProfileSettings").addClass("show");
					$("#notifyProfileSettings").removeClass("hide");
					
					$("#btnNotes").removeClass("loading");
					$("#btnNotes").attr("disabled", false);
				},
				error: function(json) {
					console.log('error');
				}
			});
		});
		
		
		$('body').on('click', '#btnShippingAddress', function() {
		
			fieldValid($("#shipping_name"));
		
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/user.php",
				data: {
					'updateShippingAddress': 1,
					'fullname': $("#shipping_name").val(),
					'address': $("#shipping_address_line_1").val(),
					'address2': $("#shipping_address_line_2").val(),
					'city': $("#shipping_city").val(),
					'state': $("#shipping_state").val(),
					'zip': $("#shipping_zip").val()
				},
				beforeSend: function() {
					$("#btnShippingAddress").addClass("loading");
					$("#btnShippingAddress").attr("disabled", true);
					
					$(".toast").addClass("hide");
					$(".toast").removeClass("show");
				},
				success: function(json) {
					
					$("#notifyProfileSettings").addClass("show");
					$("#notifyProfileSettings").removeClass("hide");
					
					$("#btnShippingAddress").removeClass("loading");
					$("#btnShippingAddress").attr("disabled", false);
				},
				error: function(json) {
					console.log('error');
				}
			});
		});
		
		
		
		$('body').on('click', '#btnChangePassword', function() {
		
			if (fieldValid($("#verifyPW"))) {
				$.ajax({
					type: "post",
					dataType: 'json',
					url: SITEURL + "/ajax/user.php",
					data: {
						'updatePassword': 1,
						'id': $(this).attr("data-id"),
						'section': $(this).attr("data-name"),
						'verifyPW': $("#verifyPW").val(),
						'newPW': $("#newPW").val(),
						'confirmPW': $("#confirmPW").val()
					},
					beforeSend: function() {
						$("#btnChangePassword").addClass("loading");
						$("#btnChangePassword").attr("disabled", true);
						
						$(".toast").addClass("hide");
						$(".toast").removeClass("show");
					},
					success: function(json) {
						$("#notifyProfileSettings").addClass("show");
						$("#notifyProfileSettings").removeClass("hide");
						
						$("#btnChangePassword").removeClass("loading");
						$("#btnChangePassword").attr("disabled", false);
					},
					error: function() {
						console.log('error');
					}
				});
			}
		
		});
		
	</script>
	
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
		
		  var chartData = [3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5, 8, 9, 7, 9, 3, 2, 3, 8, 4, 6, 2, 6, 4, 3, 3, 8, 3, 2, 7, 9, 5, 0, 2, 8, 8, 4, 1, 9, 7];
		  var colors = ['#2c7be5', '#00d97e', '#e63757', '#39afd1', '#fd7e14', '#02a8b5', '#727cf5', '#6b5eae', '#ff679b', '#f6c343'];
		
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
		  var labels = ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM', '8:00 PM'];
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
		          return l.substring(0, l.length - 3);
		        }),
		        datasets: [{
		          borderWidth: 2,
		          data: chartData.map(function (d) {
		            return (d * 3.14).toFixed(2);
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
		              return labels[tooltipItem.index] + " - " + tooltipItem.yLabel + " USD";
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
		        all: [4, 1, 6, 2, 7, 12, 4, 6, 5, 4, 5, 10].map(function (d) {
		          return (d * 3.14).toFixed(2);
		        }),
		        successful: [3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5, 8].map(function (d) {
		          return (d * 3.14).toFixed(2);
		        }),
		        failed: [1, 0, 2, 1, 2, 1, 1, 0, 0, 1, 0, 2].map(function (d) {
		          return (d * 3.14).toFixed(2);
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