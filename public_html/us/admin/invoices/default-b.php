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
<style>
	.loading {
		display: block;
	}
	.statelock {
		/*border: none;
		box-shadow: none;*/
		background: none;
		opacity: 0.4;
	}
	.tracking-visible {
		display: none;
		white-space: nowrap;
	}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Invoice Tracking (Last 3 months)</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Invoice Tracking</li>
		</ol>
		
		<!-- Start Page Header Right Div -->
		<div class="right" style="display: block!important;">
			
			<input id="action_mode" type="checkbox" checked data-toggle="toggle" data-on="Action Mode" data-off="Shipping Mode">
			
			<div class="btn-group">
				
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span><?php echo($statusDisplay); ?></span>
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
        		<ul class="dropdown-menu pull-right" role="menu">
        			<li><a class="btnToggleInvoice" data-toggle="4" href="index.php?do=invoices&amp;status=5">All Invoices</a></li>
        			<li><a class="btnToggleInvoice" data-toggle="3" href="index.php?do=invoices&amp;status=3">Shipped Invoices</a></li>
        			<li><a class="btnToggleInvoice" data-toggle="2" href="index.php?do=invoices&amp;status=2">Packaged Invoices</a></li>
        			<li><a class="btnToggleInvoice" data-toggle="1.5" href="index.php?do=invoices&amp;status=1.5">Labelled Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="1.2" href="index.php?do=invoices&amp;status=1.2">Exported Invoices</a></li>
        			<li><a class="btnToggleInvoice" data-toggle="1" href="index.php?do=invoices&amp;status=1">Paid Invoices</a></li>
        			<li><a class="btnToggleInvoice" data-toggle="0" href="index.php?do=invoices&amp;status=0">Unpaid Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="4" href="index.php?do=invoices&amp;status=4">Error Invoices</a></li>
        			<li class="divider"></li>
        			<li><a href="index.php?do=invoices&amp;action=add"><i class="fa fa-plus"></i> Add Record</a></li>
        			<li><a href="printtable.php?status=1.5" target="_blank"><i class="fa fa-file-excel-o"></i> View Table</a></li>
        			<li><a href="printinventory.php" target="_blank"><i class="fa fa-file-excel-o"></i> View Inventory</a></li>
        		</ul>
			</div>
			
			<div class="btn-group">
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span>Update Orders</span>
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a id="packs_shipped">Packs Shipped</a></li>
					<li><a id="packs_packaged">Packs Packaged</a></li>
					<li class="divider"></li>
					<li><a id="export_all_new_orders">Export All New Orders </a></li>
					<!--<li><a id="export_to_shipstation">Export to ShipStation</a></li>-->
				</ul>
			</div>
			
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<!-- START PRODUCT TABLE -->
	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<!-- Start Panel -->
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body table-responsive">

						<table id="tproduct" class="table display">
							<thead>
								<tr>
									<th>Invoices ID</th>
									<th>Status</th>
									<th>Name</th>
									<th class="hide-mobile">Date</th>
									<th>Actions</th>
								</tr>
							</thead>


							<tbody>
								<?php if(!$inrow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($inrow as $row):?>
								<tr tx="<?php echo $row->invid;?>" txID="<?php echo $row->id;?>" status="<?php echo $row->status;?>" heatflag="<?php echo $row->heatflag;?>" >
									<td>
										<a class="t-block" href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
											<span class="t-overflow" style="width: 150px;"><?php echo $row->invid;?></span>
											<span class="t-block-absolute"><?php echo $row->invid;?></span>
											
											<?php 
												if ($row->pp == "Points") {
													echo(intval($row->totalprice) . " pts");
												}
												else {
													echo(formatMonies($row->totalprice));
												}
											 ?>
										</a>
										
										<div class="hide">
											<?php
												$userDetails = $user->getUserInfoWithID($row->user_id);
												echo $userDetails->username;
											?>
										</div>
										<div class="hide">
											<?php echo $row->trackingnum;?>
											 
											<span style="display: none;">
												<?php echo($row->pp); ?>
											</span>
										</div>
									</td>
									<td>
										<a href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
										<?php
											if ($row->status == 4) {
												echo('<span class="color-error">error</span>');
											}elseif ($row->status == 3) {
												echo('<span class="color-shipped">shipped</span>');
											}elseif ($row->status == 2) {
												echo('<span class="color-packaged">packaged</span>');
											}elseif ($row->status == 1.5) {
												echo('<span class="color-labelled">label printed</span>');
											}elseif ($row->status == 1.2) {
												echo('<span class="color-exported">Exported</span>');
											}elseif ($row->status == 1) {
												echo('<span class="color-paid">paid</span>');
											}
											else {
												echo('<span class="color-unpaid">unpaid</span>');
											}
										?>
										</a>
										<div style="font-size: 9px; text-transform: uppercase;">
											<?php
											if ($row->shipping >= $core->shipping_express) {
												echo("<span style='font-weight:bold;opacity: 0.5;'>Express</span>");
											}else {
												echo("<span style='font-weight:bold;opacity: 0.5;'>Standard</span>");
											}
											?>
											
											<?php
											if ($row->heatflag) {
												echo("/ <span style='font-weight:bold;color:red;'>Heat</span>");
											}
											?>
										</div>
									</td>
									<td>
										<a class="t-overflow" style="width: 130px;" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>">
											<span><?php echo $row->name;?></span>
										</a>
										<div>
											<?php echo($row->zip); ?>
										</div>
										
									</td>
									
									<td class="hide-mobile">
										<a class="t-block">
											<span class="t-overflow" style="width: 150px;"><?php echo date("Y-m-d H:i", strtotime($row->created));?></span>
											<span class="t-block-absolute"><?php echo date("Y-m-d H:i", strtotime($row->created));?></span>
										</a>
									</td>	
									<td>
										<div class="tracking-visible">
											<?php if($row->trackingnum):?>
											<input class="statelock" type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
											<?php else:?>
											<input type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
											<?php endif;?>
											<a class="btn btn-rounded btn-option5 btn-icon trackingSaveBtn" data-id="<?php echo $row->id;?>" style="margin-left: 10px;margin-right: 10px;">
												<i class="fa fa-save"></i>
											</a>
										</div>
										
										
										<a class="btn btn-rounded btn-success btn-icon tracking-invisible" href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn btn-rounded btn-danger btn-icon deleteBtn tracking-invisible" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteInvoice" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->invid;?>">
											<i class="fa fa-remove"></i>
										</a>
										
										<?php echo isActive($row->status);?>
										
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
			<!-- End Panel -->

		</div>
		<!-- End Row -->


	</div>
	<!-- END CONTAINER -->


	
	<div class="img-loading" style="position: fixed; bottom: 10%; right: 5%;">
		  <span class="css-loading" style="box-shadow: -3px 3px 8px rgba(0,0,0,0.2);"></span>
		</div>
	</div>
	
	
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
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>

<script type="text/javascript" src="assets/js/datatables/jquery.table2excel.min.js"></script>

<script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.min.js?v2.1.2"></script>
<script type="text/javascript" src="assets/js/spin/spin.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>


<script>

	$(document).ready(function() {
		<?php if($inrow):?>
	    var shippingTable = $('#tproduct').DataTable({
	    	"lengthMenu": [[100, 500, 10000, -1], [100, 500, 10000, "All"]],
	    	"order": [[ 3, "desc" ]],
	    	"aoColumns": [
	    		null,
	    		null,
	    		null,
	    		null,
	    		{
	    			"orderSequence": ["null"]
	    		}
	    	]
		});
		
		/* spin for exporting */
		var mySpinner = null;

		function setupLoading() {    

		    $('<div id="divSpin" style="position:fixed;top:50%;left:50%"></div>').appendTo(document.body);
		 
		    var opts = {
		    		  lines: 13 // The number of lines to draw
		    		, length: 28 // The length of each line
		    		, width: 14 // The line thickness
		    		, radius: 42 // The radius of the inner circle
		    		, scale: 1 // Scales overall size of the spinner
		    		, corners: 1 // Corner roundness (0..1)
		    		, color: '#000' // #rgb or #rrggbb or array of colors
		    		, opacity: 0.5 // Opacity of the lines
		    		, rotate: 0 // The rotation offset
		    		, direction: 1 // 1: clockwise, -1: counterclockwise
		    		, speed: 1 // Rounds per second
		    		, trail: 60 // Afterglow percentage
		    		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		    		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		    		, className: 'spinner' // The CSS class to assign to the spinner
		    		, top: '50%' // Top position relative to parent
		    		, left: '50%' // Left position relative to parent
		    		, shadow: false // Whether to render a shadow
		    		, hwaccel: false // Whether to use hardware acceleration
		    		, position: 'absolute' // Element positioning
		    		}
		    
		   
		     mySpinner = new Spinner(opts);
		}

		function removeLoading(){
			
			mySpinner.stop();
		}

		function showLoading() {
			 var target = document.getElementById('divSpin')
			 mySpinner.spin(target);
		}

		//Setup spinner
		setupLoading();

		/* == Export shipping to ShipStatoin == */
	$('body').on('click', '#export_to_shipstation', function() {
		var txIDs = [];
		shippingTable.rows().iterator('row', function(context, index){
			var node = $(this.row(index).node()); 
			txIDs.push({'id':node.attr('txID'), 'tx':node.attr('tx')});
		});
		
		swal({
			title: "Are you sure?",
			text: "You are about to all shippings to ShipStation.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's ready",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'txIDs':txIDs,
							'exportOrdersToShipStation': 1
						},
						beforeSend: function() {
							showLoading();
						},
						success: function(json) {
							//console.log(json.message)
							removeLoading();
							var resultTable = '<table class="table table-bordered">';

                            $.each(json.message, function(index, item) {
                                $.each(item, function(key, value){
                                    resultTable = resultTable + '<tr><td>'+value.id+'</td><td>'+key+'</td><td>'+value.result+'</td></tr>';
                                });
                            });

							var div = document.createElement("div");
							div.innerHTML = resultTable;
                            resultTable = resultTable + '</table>';
									swal({
								text: "Your shipment have been exported.",
								icon: "success",
								content: div,
								buttons: {
									catch: {
									text: "Ok",
									value: "catch",
									}
								},
							})
							.then((value) => {
								location.reload();
							});
						},
						error: function() {
							removeLoading();
							console.log("error exporting shipping");
						}
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		
	});

		/* == Export all paid orders to ShipStatoin == */
		$('body').on('click', '#export_all_new_orders', function() {
		var txIDs = [];
		shippingTable.rows().iterator('row', function(context, index){
			var node = $(this.row(index).node()); 
			if( "1.0" == node.attr('status') && "0" == node.attr('heatflag')) {
				txIDs.push({'id':node.attr('txID'), 'tx':node.attr('tx')});
			}
		});
		if(txIDs.length > 0){
		swal({
			title: "Are you sure?",
			text: "You are about to export all paid orders to ShipStation.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's ready",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'txIDs':txIDs,
							'exportOrdersToShipStation': 1
						},
						beforeSend: function() {
							showLoading();
						},
						success: function(json) {
							//console.log(json.message)
							removeLoading();
							var resultTable = '<table class="table table-bordered">';
                            $.each(json.message, function(index, item) {
                                $.each(item, function(key, value){
                                    resultTable = resultTable + '<tr><td>'+value.id+'</td><td>'+key+'</td><td>'+value.result+'</td></tr>';
                                });
                            });

							var div = document.createElement("div");
							div.innerHTML = resultTable;
                            resultTable = resultTable + '</table>';
									swal({
								text: "Your shipment have been exported.",
								icon: "success",
								content: div,
								buttons: {
									catch: {
									text: "Ok",
									value: "catch",
									}
								},
							})
							.then((value) => {
								location.reload();
							});
						},
						error: function() {
							removeLoading();
							console.log("error exporting shipping");
						}
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		}else{
			swal("All the orders are exported or there is no new order!");
		}
		
	});

	    <?php endif;?>

	} );
	
	
	/* == Change invoice to shipped == */
	$('body').on('click', '#packs_shipped', function() {
		swal({
			title: "Are you sure?",
			text: "You are about to change all status to shipped.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's been shipped",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'updateInvoiceShipped': 1
						},
						beforeSend: function() {
						},
						success: function(json) {
							console.log("success");
						},
						error: function() {
							console.log("error updating shipping");
						}
					});
					swal({
						text: "Your shipment statuses have been updated.",
						icon: "success",
						buttons: {
						    catch: {
						      text: "Ok",
						      value: "catch",
						    }
						},
					})
					.then((value) => {
						location.reload();
					});
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
	});
	
	
	/* == Change invoice to shipped == */
	$('body').on('click', '#packs_packaged', function() {
		
		
		swal({
			title: "Are you sure?",
			text: "You are about to change all status to packaged.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's been packaged",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'updateInvoiceLabeled': 1
						},
						beforeSend: function() {
						},
						success: function(json) {
							console.log("success");
						},
						error: function() {
							console.log("error updating shipping");
						}
					});
					
					swal({
						text: "Your shipment statuses have been updated.",
						icon: "success",
						buttons: {
						    catch: {
						      text: "Ok",
						      value: "catch",
						    }
						},
					})
					.then((value) => {
						location.reload();
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		
	});
	
	
	
	/* == Tracking Number Save == */
	$('body').on('click', '.trackingSaveBtn', function() {
		
		var id = $(this).data('id');
		var trackingnum = $(this).parent().parent().find("input[name=trackingnum]").val();
		var trackinginput = $(this).parent().parent().find("input[name=trackingnum]");
		
		console.log(trackingnum);
		
		$.ajax({
			type: "post",
			dataType: 'json',
			url: "controller.php",
			data: {
				id: id,
				trackingnum: trackingnum,
				'processInvoiceTracking': 1
			},
			beforeSend: function() {
				$('.css-loading').show();
			},
			success: function(json) {
				console.log("success");
				$('.css-loading').hide();
				
				$(trackinginput).addClass("statelock");
				
			},
			error: function() {
				console.log("error updating shipping");
				$('.css-loading').hide();
			}
		});
		
		
	});
	
	/* == Tracking Number Save == */
	$('body').on('click', '.statelock', function() {
		$(this).removeClass("statelock");
	});
	
	$('#action_mode').change(function() {
        if(this.checked) {
			$(".tracking-invisible").show();
			$(".tracking-visible").hide();
        }else {
			$(".tracking-invisible").hide();
			$(".tracking-visible").show();
		}     
	});
	
	



</script>
