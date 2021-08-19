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
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Invoice Tracking (Last 3 months)</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="index.php?do=invoices">Invoices</a></li>
			<li class="active">Invoice Tracking</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right" style="display: block!important;">
			<div class="btn-group">
				<a id="packs_shipped" class="btn btn-light">
					Packs Shipped
				</a>
				<a id="packs_packaged" class="btn btn-light">
					Packs Packaged
				</a>
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span><?php echo($statusDisplay); ?></span>
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
        		<ul class="dropdown-menu pull-right" role="menu">
					<li><a class="btnToggleInvoice" data-toggle="4" href="index.php?do=invoices&amp;action=tracking&amp;status=4">All Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="3" href="index.php?do=invoices&amp;action=tracking&amp;status=3">Shipped Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="2" href="index.php?do=invoices&amp;action=tracking&amp;status=2">Packaged Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="1.5" href="index.php?do=invoices&amp;action=tracking&amp;status=1.5">Labelled Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="1" href="index.php?do=invoices&amp;action=tracking&amp;status=1">Paid Invoices</a></li>
					<li><a class="btnToggleInvoice" data-toggle="0" href="index.php?do=invoices&amp;action=tracking&amp;status=0">Unpaid Invoices</a></li>
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
									<th class="hide-mobile">Invoices ID</th>
									<th>Status</th>
									<th>Name</th>
									<th>Date</th>
									<th>Tracking #</th>
								</tr>
							</thead>


							<tbody>
								<?php if(!$inrow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($inrow as $row):?>
								<tr>
									<td class="hide-mobile">
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
										<div style="font-size: 9px; text-transform: uppercase;opacity: 0.5;">
											<?php
											if ($row->shipping >= $core->shipping_express) {
												echo("<span style='font-weight:bold;'>Express</span>");
											}
											?>
										</div>
									</td>
									<td>
										<a class="t-overflow" style="width: 150px;" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>">
											<span><?php echo $row->name;?></span>
										</a>
										<div>
											<?php echo($row->zip); ?>
										</div>
										
									</td>
									
									<td class="hide-mobile"><?php echo date("Y-m-d g:i a", strtotime($row->created));?></td>	
									<td>
										<?php if($row->trackingnum):?>
										<input class="statelock" type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
										<?php else:?>
										<input type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
										<?php endif;?>
										<a class="btn btn-rounded btn-option5 btn-icon trackingSaveBtn" data-id="<?php echo $row->id;?>" style="margin-left: 10px;margin-right: 10px;">
											<i class="fa fa-save"></i>
										</a>
										
										<?php echo isActive($row->status);?>
										<a class="btn btn-rounded btn-success btn-icon" href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteInvoice" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->invid;?>">
											<i class="fa fa-remove"></i>
										</a>
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

<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>

<script type="text/javascript" src="assets/js/datatables/jquery.table2excel.min.js"></script>

<script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.min.js?v2.1.2"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>


<script>

	$(document).ready(function() {
		<?php if($inrow):?>
	    $('#tproduct').dataTable({
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
	



</script>
