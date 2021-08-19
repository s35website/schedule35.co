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
	
	if (!$user->is_Admin()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}
?>
<style>
.loading {
	display: block;
}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Featured</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Featured</li>
		</ol>
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
									<th></th>
									<th>Product Name</th>
									<th>Transcriber</th>
									<th>Sales</th>
									<th>Created</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$itemsrow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->PRD_NOPROD);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($itemsrow as $row):?>
								
								<?php if($row->active):?>
								<tr>
									<td class="c_icons">
										<span style="display: none;"><?php echo ($row->feat) ? "Featured" : "";?></span>
										
										<div class="checkbox checkbox-success">
									        <input class="chkBtn" id="checkbox<?php echo $row->id;?>" data-id="<?php echo $row->id;?>" type="checkbox" <?php getChecked($row->feat, 1); ?>>
									        <label for="checkbox<?php echo $row->id;?>">
									           &nbsp;
									        </label>
									    </div>
									</td>
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
														"<?php echo $row->title;?>"
													</a>
													by <?php echo $row->artist;?>
												</td>
											</tr>
										</table>
									</td>
									<td><?php echo $row->alias;?></td>
									<td class="text-center"><?php echo ($row->sales) ? $row->sales : "0";?></td>
									<td><?php echo date("m-d-Y", strtotime($row->created));?></td>
								</tr>
								<?php endif;?>
								
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
	
	<div class="bottom-spinner">
		<i class="fa fa-circle-o-notch fa-spin"></i>
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
	    	"lengthMenu": [[-1, 50, 20], ["All", 50, 20]],
	    	"order": [[ 0, "desc" ]]
	    });
	    
	} );
	<?php endif;?>
	
	/* == Checkbox Modal == */
	$('body').on('click', '.chkBtn', function() {
		var id = $(this).data('id');
		var brother = $(this).parent();
		var parent = $(this).parent().parent().parent();
		
		if ($(this).prop('checked')) {
			var val = 1;
		}
		else {
			var val = 0;
		}
		
		$.ajax({
			type: 'post',
			url: "controller.php",
			dataType: 'json',
			data: {
				id: id,
				val: val,
				checkoption: "updateFeature"
			},
			beforeSend: function() {
				$(".bottom-spinner").show();
			},
			success: function(json) {
				$(".bottom-spinner").hide();
				//$(brother).prepend( '<span style="display: none;">Featured</span>' );
			}

		});
		
	});
</script>
