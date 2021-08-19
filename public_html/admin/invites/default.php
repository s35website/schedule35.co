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
<?php $discrow = $content->getInvites();?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Invites</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Invites</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=invites&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Invites</a>
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
									<th>Invite Code</th>
									<th>Expiry</th>
									<th>Created</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>


							<tbody>
								<?php if(!$discrow):?>
								<tr>
								  <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->INV_NOCOUPON);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($discrow as $row):?>
								<tr>
									<td>
                    <a href="index.php?do=invites&amp;action=edit&amp;id=<?php echo $row->id;?>">
											<?php echo $row->code;?>
										</a>
                  </td>
									<td><?php echo date("F j, Y", strtotime($row->validuntil));?></td>
									<td><?php echo date("F j, Y", strtotime($row->created));?></td>
									<td class="c_icons">
										<a href="index.php?do=invites&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon" data-content="<?php echo Lang::$word->GAL_TITLE;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>

										<a href="#" class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->CPN_DELETE;?>" data-option="deleteInvite" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->title;?>">
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
		<?php if($discrow):?>
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
