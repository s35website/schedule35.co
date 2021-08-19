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

						
						
						
						<table id="twholesale" class="table display">
							
							<thead>
								<tr>
									<th>Invoice ID</th>
									<th>Due Date</th>
									<th style="width: 120px;">Status</th>
									<th class="c_center">Paid</th>
									
									<th class="c_center" colspan="9">Flavours</th>
									
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
											<span class="t-overflow" style="width: 150px;"><?php echo $row->name;?></span>
											<span class="t-block-absolute"><?php echo $row->name;?></span>	
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
											buudabomb@gmail.com
										</div>
										<div class="hide">
																						 
											<span style="display: none;">
												Cash
											</span>
										</div>
									</td>
									
									
									
									
									<td>
									<?php echo date("Y-m-d", strtotime($row->created));?>
									</td>
									
									<td style="width: 120px;">
										<div class="btn-group">
											<button type="button" class="btn btn-light">Waiting</button>
											<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#">Waiting</a></li>
												<li><a href="#">Packed</a></li>
												<li><a href="#">Delivered</a></li>
											</ul>
										</div>
									</td>
									
									<td class="c_center">
										<div class="checkbox checkbox-success">
									        <input class="chkBtn" id="checkbox10" data-id="10" type="checkbox" <?php if ($row->status == 1) { echo 'checked';}?>>
									        <label for="checkbox10">
									           &nbsp;
									        </label>
									    </div>
									</td>
									
									<?php 
									$receiptProducts = $item->getWholesaleReceiptProducts($row->invid);
									$strawberry_yogurt_explosion_qty = 0;
									$apple_gummies_qty = 0;
									$strawberry_gummies_qty = 0;
									$mango_gummies_qty = 0;
									$peach_gummies_qty = 0;
									$grape_gummies_qty = 0;
									$blue_raspberry_gummies_qty = 0;
									$watermelon_blast_qty = 0;
									$himalayan_salt_dark_chocolate_qty = 0;
									?>

									<?php 
									foreach ($receiptProducts as $prow) {
											switch ($prow->slug) {
												case "strawberry-yogurt-gummies":
													$strawberry_yogurt_explosion_qty = $prow->item_qty;
													break;
												case "frosted-green-gummy-bears":
													$apple_gummies_qty = $prow->item_qty;
													break;
												case "frosted-red-gummy-bears":
													$strawberry_gummies_qty = $prow->item_qty;
													break;
												case "frosted-mango-gummy-bears":
													$mango_gummies_qty = $prow->item_qty;
													break;
												case "frosted-peach-gummy-bears":
													$peach_gummies_qty = $prow->item_qty;
													break;
												case "frosted-grape-gummy-bears":
													$grape_gummies_qty = $prow->item_qty;
													break;
												case "frosted-blueraspberry-gummy-bears":
													$blue_raspberry_gummies_qty = $prow->item_qty;
													break;
												case "watermelon-blast-gummies":
													$watermelon_blast_qty = $prow->item_qty;
													break;
												case "pink-salt-dark-chocolate":
													$himalayan_salt_dark_chocolate_qty = $prow->item_qty;
													break;
											}
										}
									?>
									
									<td class="c_center" style="background-color: #85d263;color: #000;font-weight: bold;"><?php echo $apple_gummies_qty ?></td>
									<td class="c_center" style="background-color: #e22122;color: #000;font-weight: bold;"><?php echo $strawberry_gummies_qty ?></td>
									<td class="c_center" style="background-color: #e9d334;color: #000;font-weight: bold;"><?php echo $mango_gummies_qty ?></td>
									<td class="c_center" style="background-color: #eea182;color: #000;font-weight: bold;"><?php echo $peach_gummies_qty ?></td>
									<td class="c_center" style="background-color: #a64d78;color: #000;font-weight: bold;"><?php echo $grape_gummies_qty ?></td>
									<td class="c_center" style="background-color: #3e84c6;color: #000;font-weight: bold;"><?php echo $blue_raspberry_gummies_qty ?></td>
									<td class="c_center" style="background-color: #d5a6bd;color: #000;font-weight: bold;"><?php echo $watermelon_blast_qty ?></td>
									<td class="c_center" style="background-color: #ff97e4;color: #000;font-weight: bold;"><?php echo $strawberry_yogurt_explosion_qty ?></td>
									<td class="c_center" style="background-color: #6f472f;color: #000;font-weight: bold;"><?php echo $himalayan_salt_dark_chocolate_qty ?></td>
									
									
									<td class="c_icons hide-mobile">
										<a class="btn btn-rounded btn-success btn-icon" href="index.php?do=bulk&amp;action=edit&amp;tx=<?php echo $row->invid;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										
										<a class="btn btn-rounded btn-primary btn-icon" href="index.php?do=bulk&amp;action=edit&amp;tx=1181219094411" target="_blank">
											<i class="fa fa-print"></i>
										</a>
									</td>
								</tr>
								
								<?php endforeach;?>
								<?php unset($row);?>
								<?php endif;?>
								
							</tbody>
						</table>
						
						
						<div>
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th style="padding-right: 10px;">Total</th>
										<th>Due Today</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Green Apple</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Strawberry</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Mango</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Peach</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Grape</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Blue Raspberry</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Watermelon</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>Strawberry Yogurt Exp.</td>
										<td>360</td>
										<td>220</td>
									</tr>
									<tr>
										<td>H.S. Dark Chocolate</td>
										<td>360</td>
										<td>220</td>
									</tr>
								</tbody>
								
								
							</table>
						</div>

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
	    $('#twholesale').dataTable({
	    	"lengthMenu": [[100, 500, 10000, -1], [100, 500, 10000, "All"]],
	    	"order": [[ 4, "desc" ]],
	    	"aoColumns": [
	    		{
	    			"orderSequence": ["null"]
	    		},
	    		null,
	    		{
	    			"orderSequence": ["null"]
	    		},
	    		{
	    			"orderSequence": ["null"]
	    		},
	    		null,
				null,
				null,
				null,
				null,
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
	      $("#twholesale").table2excel({
	        // exclude CSS class
	        exclude: ".noExl",
	        name: "Invoice Worksheet",
	        filename: "invoices" //do not include extension
	      });
	    });

	} );

</script>
