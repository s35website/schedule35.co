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
<?php $faqrow = $content->getFaq();?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Pages</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Custom Pages</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=faq&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Question</a>
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
									<th width="40%">Question</th>
									<th width="40%" class="c_answer">Answer</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$faqrow):?>
								<tr>
								  <td colspan="3"><?php echo Filter::msgSingleAlert(Lang::$word->FAQ_NOFAQ);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($faqrow as $row):?>
								<tr>
									<td width="40%">
										<a href="index.php?do=faq&amp;action=edit&amp;id=<?php echo $row->id;?>">
											<?php echo $row->question;?>
										</a>
									</td>
									<td width="40%" class="c_answer">
										<div><?php echo sanitize(truncate($row->answer,50));?></div>
									</td>
									<td class="c_icons">
										
										<a href="index.php?do=faq&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon">
											<i class="fa fa-pencil"></i>
										</a>
										
										<a href="#" class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->FAQ_DELETE;?>" data-option="deleteFaq" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->question;?>>">
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
		<?php if($faqrow):?>
	    $('#tproduct').dataTable({
	    	"aoColumns": [
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
