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
<?php $sliderdata = $content->getSlides();?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Sliders</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Sliders</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=slider&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Slider</a>
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
									<th>Slider Caption</th>
									<th>Link</th>
									<th>Sorting</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$sliderdata):?>
								<tr>
								  <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->SLM_NOSLIDERS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($sliderdata as $row):?>
								<tr id="node-<?php echo $row->id;?>">
									<td><?php echo $row->caption;?></td>
									<td><?php echo $row->url;?></td>
									<td><?php echo $row->sorting;?></td>
									<td class="c_icons">
										
										<a href="index.php?do=slider&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon">
											<i class="fa fa-pencil"></i>
										</a>
										
										<a href="#" class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->SLM_DELETE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->caption;?>">
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
		<?php if($sliderdata):?>
	    $('#tproduct').dataTable({
	    	"aoColumns": [
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
