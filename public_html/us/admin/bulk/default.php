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
	
	$fromdate = date("Y-m-d H:i:s", strtotime("-3 month"));
	$inrow = $item->getBulkOrders($fromdate, 4);
?>
<style>
	.loading {
		display: block;
	}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Bulk Orders (Last 3 months)</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Bulk</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=bulk&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>New Bulk Order</a>
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
									<th>Invoice ID</th>
									<th>Status</th>
									<th>C/O</th>
									<th>Date</th>
									<th class="c_icons hide-mobile">Actions</th>
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
									<td>
										<a class="t-block" href="index.php?do=bulk&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
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
										<a href="index.php?do=bulk&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
										<?php
									        if ($row->status == 3) {
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
										<div>
											<?php echo($row->zip); ?>
										</div>
									</td>
									<td>
										<a class="t-overflow" style="width: 150px;" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>">
											<span><?php echo $row->name;?></span>
										</a>
										<div>
											<?php echo($row->company); ?>
										</div>
									</td>
									<td class="hide-mobile">
										<a class="t-block" href="index.php?do=bulk&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
											<?php echo date("Y-m-d", strtotime($row->created));?>
										</a>
										<div class="hide">
											<?php
												$userDetails = $user->getUserInfoWithID($row->user_id);
												echo $userDetails->username;
											?>
										</div>
									</td>
									<td class="c_icons hide-mobile">
										<?php echo isActive($row->status);?>
										<a class="btn btn-rounded btn-success btn-icon" href="index.php?do=bulk&amp;action=edit&amp;tx=<?php echo $row->invid;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteInvoice" data-id="<?php echo $row->invid;?>" data-name="<?php echo $row->invid;?>">
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

<script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>


<script>

	$(document).ready(function() {
		<?php if($inrow):?>
	    $('#tproduct').dataTable({
	    	"lengthMenu": [[100, 500, 10000, -1], [100, 500, 10000, "All"]],
	    	"order": [[ 4, "desc" ]],
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


	    /* == Export table to spreadsheet == */
	    $("#btnExport").click(function(){
	      $("#tproduct").table2excel({
	        // exclude CSS class
	        exclude: ".noExl",
	        name: "Invoice Worksheet",
	        filename: "invoices" //do not include extension
	      });
	    });

	} );

</script>
