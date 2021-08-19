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
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Products</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Products</li>
		</ol>

		<?php if($user->is_Admin()):?>
		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=products&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Product</a>
				
				<a href="index.php?do=products&action=addmerch" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Merch</a>
			</div>
			<div class="btn-group" role="group" aria-label="...">
				<a href="#" id="notify_multiple_user" class="btn btn-success btn-lg btn-rounded">Notify Users</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->
		<?php endif;?>

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
									<th>Product Name</th>
									<th class="hide-mobile">Category</th>
									<th class="hide-mobile">Sales</th>
									<th class="hide-mobile">Status</th>
									<th>Stock</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>


							<tbody>
								<?php if(!$itemsrow):?>
								<tr>
								  <td colspan="7"><?php echo Filter::msgSingleAlert(Lang::$word->PRD_NOPROD);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($itemsrow as $row):?>
								<?php $crow = Core::getRowById(Content::cTable, $row->cid);?>
								<tr>
									<td class="c_name">
										<table class="split">
											<tr>
												<td class="pic">
													<a href="<?php echo SITEURL; ?>/item?itemname=<?php echo $row->slug;?>" target="_blank">
														<?php if($row->thumb):?>
														<img src="<?php echo UPLOADURL;?>prod_images/<?php echo $row->thumb;?>" alt="<?php echo $row->title;?>" class="avatar image"/>
														<?php else:?>
														<img src="<?php echo UPLOADURL;?>prod_images/blank.png?v=1" alt="<?php echo $row->title;?>" class="avatar image"/>
														<?php endif;?>
													</a>

												</td>
												<td>
													<a href="index.php?do=products&amp;action=edit&amp;id=<?php echo $row->id;?>">
														<?php echo $row->title;?>
													</a>
												</td>
											</tr>
										</table>
									</td>
									<td class="hide-mobile"><?php echo ($crow->name)?></td>
									<td class="hide-mobile"><?php echo ($row->sales) ? $row->sales : "0";?></td>
									<td class="hide-mobile">
										<?php echo productStatus($row->active, $row->id);?>
									</td>
									<td>
										<?php echo $row->stock;?>
									</td>
									<td class="c_icons">
										<a href="index.php?do=products&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon" data-content="<?php echo Lang::$word->GAL_TITLE;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										
										<?php if($user->is_Admin()):?>
										<a href="index.php?do=products&amp;action=gallery&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-default btn-icon" target="_blank">
											<i class="fa fa-photo"></i>
										</a>

										<a href="#" class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->PRD_DELETE;?>" data-option="deleteProduct" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->title;?>">
											<i class="fa fa-remove"></i>
										</a>
										<?php endif;?>
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




<script type="text/javascript">
	<?php if($itemsrow):?>
	$(document).ready(function() {
	    $('#tproduct').dataTable({
	      "aoColumns": [
	        null,
	        null,
	        null,
	        null,
	        null,
	        null
	      ],
	      "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
	      "order": [[ 1, "desc" ]]
	    });
	} );
	<?php endif;?>
	
	
	
	/* == Sent notification to multiple user == */
	$('body').on('click', '#notify_multiple_user', function() {
		swal({
			 title: "Notify users?",
			text: "Some users may want to know this product is available again.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Let them know",
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
					    'notifyMultipleUsers': 1,
					  },
					  beforeSend: function() {
					  	$('button.confirm').prop('disabled', true);
					  },
					  success: function(json) {
						$('button.confirm').prop('disabled', false);
					  }
					});
					swal({
						text: "Notification sent.",
						icon: "success",
						buttons: {
						    catch: {
						      text: "Ok",
						      value: "catch",
						    }
						},
					})
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
	});
</script>
