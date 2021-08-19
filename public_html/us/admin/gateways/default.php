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
<?php $gaterow = $content->getGateways();?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Payment Gateways</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Payment Gateways</li>
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
									<th>Gateway Name</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$gaterow):?>
								<tr>
								  <td colspan="2"><?php echo Filter::msgSingleError(Lang::$word->GTW_NOGATE);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($gaterow as $row):?>
								<tr>
									<td>
										<a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row->id;?>">
											<?php echo $row->displayname;?>
										</a>
									</td>
									<td class="c_icons">
										
										<a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon">
											<i class="fa fa-pencil"></i>
										</a>
										<!--
										<a href="#" class="btn btn-rounded btn-default btn-icon deleteBtn" data-title="<?php echo Lang::$word->SLM_DELETE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->caption;?>">
											<i class="fa fa-toggle-on"></i>
										</a>
										-->
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


