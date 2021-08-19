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
	$char = get('char', '1');
	$userrow = $user->getUserByChar($char);
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
	
		<div class="row">
			<div class="col-sm-12">
				<ul class="paging">
					<li><a href="?do=user" class="page">#</a></li>
					<li><a href="?do=users&amp;char=a" class="page">a</a></li>
					<li><a href="?do=users&amp;char=b" class="page">b</a></li>
					<li><a href="?do=users&amp;char=c" class="page">c</a></li>
					<li><a href="?do=users&amp;char=d" class="page">d</a></li>
					<li><a href="?do=users&amp;char=e" class="page">e</a></li>
					<li><a href="?do=users&amp;char=f" class="page">f</a></li>
					<li><a href="?do=users&amp;char=g" class="page">g</a></li>
					<li><a href="?do=users&amp;char=h" class="page">h</a></li>
					<li><a href="?do=users&amp;char=i" class="page">i</a></li>
					<li><a href="?do=users&amp;char=j" class="page">j</a></li>
					<li><a href="?do=users&amp;char=k" class="page">k</a></li>
					<li><a href="?do=users&amp;char=l" class="page">l</a></li>
					<li><a href="?do=users&amp;char=m" class="page">m</a></li>
					<li><a href="?do=users&amp;char=n" class="page">n</a></li>
					<li><a href="?do=users&amp;char=o" class="page">o</a></li>
					<li><a href="?do=users&amp;char=p" class="page">p</a></li>
					<li><a href="?do=users&amp;char=q" class="page">q</a></li>
					<li><a href="?do=users&amp;char=r" class="page">r</a></li>
					<li><a href="?do=users&amp;char=s" class="page">s</a></li>
					<li><a href="?do=users&amp;char=t" class="page">t</a></li>
					<li><a href="?do=users&amp;char=u" class="page">u</a></li>
					<li><a href="?do=users&amp;char=v" class="page">v</a></li>
					<li><a href="?do=users&amp;char=w" class="page">w</a></li>
					<li><a href="?do=users&amp;char=x" class="page">x</a></li>
					<li><a href="?do=users&amp;char=y" class="page">y</a></li>
					<li><a href="?do=users&amp;char=z" class="page">z</a></li>
				</ul>
			</div>
		</div>
	
		<!-- Start Row -->
		<div class="row">

			
			<div class="col-md-12">
				
				<!-- Start Panel -->
				<div class="panel panel-default">
					
					<div class="panel-body table-responsive">

						<table id="tproduct" class="table display">
							<thead>
								<tr>
									<th>User</th>
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
													<br />
													<?php echo $row->name;?>
												</td>
											</tr>
										</table>
									</td>
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
								<li><a href="?do=user" class="page">#</a></li>
								<li><a href="?do=users&amp;char=a" class="page">a</a></li>
								<li><a href="?do=users&amp;char=b" class="page">b</a></li>
								<li><a href="?do=users&amp;char=c" class="page">c</a></li>
								<li><a href="?do=users&amp;char=d" class="page">d</a></li>
								<li><a href="?do=users&amp;char=e" class="page">e</a></li>
								<li><a href="?do=users&amp;char=f" class="page">f</a></li>
								<li><a href="?do=users&amp;char=g" class="page">g</a></li>
								<li><a href="?do=users&amp;char=h" class="page">h</a></li>
								<li><a href="?do=users&amp;char=i" class="page">i</a></li>
								<li><a href="?do=users&amp;char=j" class="page">j</a></li>
								<li><a href="?do=users&amp;char=k" class="page">k</a></li>
								<li><a href="?do=users&amp;char=l" class="page">l</a></li>
								<li><a href="?do=users&amp;char=m" class="page">m</a></li>
								<li><a href="?do=users&amp;char=n" class="page">n</a></li>
								<li><a href="?do=users&amp;char=o" class="page">o</a></li>
								<li><a href="?do=users&amp;char=p" class="page">p</a></li>
								<li><a href="?do=users&amp;char=q" class="page">q</a></li>
								<li><a href="?do=users&amp;char=r" class="page">r</a></li>
								<li><a href="?do=users&amp;char=s" class="page">s</a></li>
								<li><a href="?do=users&amp;char=t" class="page">t</a></li>
								<li><a href="?do=users&amp;char=u" class="page">u</a></li>
								<li><a href="?do=users&amp;char=v" class="page">v</a></li>
								<li><a href="?do=users&amp;char=w" class="page">w</a></li>
								<li><a href="?do=users&amp;char=x" class="page">x</a></li>
								<li><a href="?do=users&amp;char=y" class="page">y</a></li>
								<li><a href="?do=users&amp;char=z" class="page">z</a></li>
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
