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
<?php $articlerow = $content->getBlog();?>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Blog</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Blog</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=blog&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add Article</a>
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
									<th>Article Title</th>
									<th>Author</th>
									<th>Created</th>
									<th>Published</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$articlerow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->PAG_NONEWS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($articlerow as $row):?>
								<tr>
									<td>
										<a href="index.php?do=blog&amp;action=edit&amp;id=<?php echo $row->id;?>">
											<?php echo $row->title;?>
										</a>
									</td>
									<td>
										<?php echo $row->author;?>
									</td>
									<td><?php echo date("F j, Y", strtotime($row->created));?></td>
									<td>
										<?php echo newsStatus($row->active, $row->id);?>
									</td>
									<td class="c_icons">
										
										<a href="index.php?do=blog&amp;action=edit&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="index.php?do=blog&amp;action=default&amp;id=<?php echo $row->id;?>" class="btn btn-rounded btn-success btn-icon">
											<i class="fa fa-comment"></i>
										</a>
										
										<a href="#" class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->PAG_DELETE;?>" data-option="deleteArticle" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->title;?>">
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
		
		
		<?php if($articlerow):?>
		$('#tproduct').dataTable({
			"lengthMenu": [[100, 500, 10000, -1], [100, 500, 10000, "All"]],
			"order": [[ 2, "desc" ]],
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
</script>
