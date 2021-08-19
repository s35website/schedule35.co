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
<?php
	
	$sort = get('sort', 'featured');
	$page = get('page', '1');
	if (!is_numeric($page)) $page = 1;

	/** @var $item Products */
	$userCount = $user->countUsers("WHERE active = 1");
	$counter = new \paging\Counter($userCount, $page, 100);
	$buttons = $counter->getButtons();

	$userrow = $user->getAllUsers($page, 100);
?>
<style>
.loading {
	display: block;
}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Users</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Users</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right">
			<div class="btn-group" role="group" aria-label="...">
				<a href="index.php?do=users&action=add" class="btn btn-default btn-lg btn-rounded"><i class="fa fa-plus"></i>Add User</a>
			</div>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->
	
	
	<!-- START PRODUCT TABLE -->
	<div class="container-widget">
	
		<!-- Start Row -->
		<div class="row">

			
			<div class="col-md-12">
				
				<!-- Start Panel -->
				<div class="panel panel-default">
					
					<div class="panel-body table-responsive">

						<table id="tproduct" class="table display">
							<thead>
								<tr>
									<th>Username</th>
									<th>Full Name</th>
									<th>Created</th>
									<th class="c_center">Purchases</th>
									<th class="c_center">Status</th>
									<th class="c_icons">Actions</th>
								</tr>
							</thead>
							

							<tbody>
								<?php if(!$userrow):?>
								<tr>
									<td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->USR_NOUSER);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($userrow as $row):?>
								<tr>
									<td class="c_name">
										<table class="split">
											<tr>
												<td class="pic">
													<a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>">
														<?php if($row->avatar):?>
														<img src="<?php echo UPLOADURL;?>avatars/<?php echo $row->avatar;?>" alt="<?php echo $row->username;?>" class="image avatar"/>
														<?php else:?>
														<img src="<?php echo UPLOADURL;?>avatars/blank.png?v=1" alt="<?php echo $row->username;?>" class="image avatar"/>
														<?php endif;?>
													</a>
												
												</td>
												<td>
													<a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>">
														<?php echo $row->username;?>
													</a>
												</td>
											</tr>
										</table>
									</td>
									<td><?php echo $row->fname;?> <?php echo $row->lname;?></td>
									<td><?php echo date("Y-m-d", strtotime($row->created));?></td>
									<td class="c_center"><?php echo $row->totalitems;?></td>
									<td class="c_center">
										<?php echo userStatus($row->active, $row->id);?>
										<span style="display: none;">
											<?php if ($row->userlevel == 9) echo 'admin administrator';?>
											<?php if ($row->userlevel == 7) echo 'partner transcriber author arranger';?>
										</span>
									</td>
									
									<td class="c_icons">
										<?php echo isActive($row->status);?>
										<a class="btn btn-rounded btn-success btn-icon" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>" target="_blank">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn btn-rounded btn-danger btn-icon deleteBtn" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteUser" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->txn_id;?>">
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
					
					<div class="row">
						<div class="col-sm-12">
							<ul class="paging">
							    <?php
							    //Load pagination buttons
							    foreach ($buttons as $button) {
							        echo '<li><a href="' . $button['href'] . '" class="' . $button['class'] . '">' . $button['text'] . '</a></li>';
							    }
							    ?>
							</ul>
						</div>
					</div>
					
				</div>
				<!-- End Panel -->
				
				
				
			</div>
			
			
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
