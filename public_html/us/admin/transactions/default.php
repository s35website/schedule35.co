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
<?php $transrow = $item->getPayments();?>
<style>
.loading {
	display: block;
}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Transactions</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Transactions</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group">
				<a href="index.php?do=transactions&amp;action=add" class="btn btn-light"><i class="fa fa-plus"></i> Add Record</a>
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="#"><i class="fa fa-file-excel-o"></i> Export to Excel</a></li>
					<li><a href="#"><i class="fa fa-file-pdf-o"></i> Export to PDF</a></li>
					<li class="divider"></li>
					<li><a href="#">View Sales Report</a></li>
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
									<th>Transaction ID</th>
									<th>Product Name</th>
									<th>Email Address</th>
									<th>Amount</th>
									<th>Date</th>
									<!--<th>Processor</th>-->
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$transrow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($transrow as $row):?>
								<tr>
									<td>
										<a href="index.php?do=transactions&amp;action=edit&amp;id=<?php echo $row->id;?>">
											<span class="t-overflow" style="width: 150px;"><?php echo $row->txn_id;?></span>
										</a>
									</td>
									<td>
										<a href="index.php?do=products&amp;action=edit&amp;id=<?php echo $row->pid;?>">
											<?php echo truncate($row->title,35);?>
										</a>
									</td>
									<td>
										<?php echo(formatMonies($row->price)); ?>
										<span style="display: none;">
											<?php echo($row->pp); ?>
										</span>
									</td>
									<td><?php echo date("m-d-Y", strtotime($row->created));?></td>
									<!--<td><?php echo $row->pp;?></td>-->
									<td class="c_icons">
										<?php echo isActive($row->status);?>
										<a class="btn btn-rounded btn-success btn-icon" href="index.php?do=transactions&amp;action=edit&amp;id=<?php echo $row->id;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteTransaction" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->txn_id;?>">
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
<script src="assets/js/datatables/datatables.min.js"></script>
<script src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>



<script>
	
	$(document).ready(function() {
		<?php if($transrow):?>
	    $('#tproduct').dataTable({
	    	"lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
	    	"order": [[ 4, "desc" ]],
	    	"aoColumns": [
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
	    
	    
	} );
</script>
