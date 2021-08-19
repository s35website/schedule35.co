<div id="top" class="clearfix">

		<!-- Start App Logo -->
		<div class="applogo">
			<a href="index.php" class="logo">Admin</a>
		</div>
		<!-- End App Logo -->

		<!-- Start Sidebar Show Hide Button -->
		<a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
		<a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
		<!-- End Sidebar Show Hide Button -->

		<!-- Start Top Menu -->
		<ul class="topmenu">
			<li><a href="../" target="_blank"><i class="fa fa-home"></i> Frontpage</a></li>
		</ul>
		<!-- End Top Menu -->

		<!-- Start Top Right -->
		<ul class="top-right">

			<li class="dropdown link">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle hdbutton">Quick Links <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="printtable.php?status=1.5" target="_blank"><i class="fa fa-file-excel-o"></i> View Table</a></li>
					<li><a href="printinventory.php" target="_blank"><i class="fa fa-file-excel-o"></i> View Inventory</a></li>
				</ul>
			</li>
			<!--
			<li class="link">
				<a class="notifications"><?php echo $user->fname . " " . $user->lname;?></a>
			</li>
			-->
			
			<li class="dropdown link">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox">
					<?php if($user->avatar):?>
					<img src="<?php echo UPLOADURL;?>avatars/<?php echo $user->avatar;?>" alt="<?php echo $user->username;?>">
					<?php else:?>
					<img src="<?php echo UPLOADURL;?>avatars/blank.png?v=1" alt="<?php echo $user->username;?>">
					<?php endif;?>
					<span class="caret"></span>
				</a>
				
				<ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
					<li role="presentation" class="dropdown-header">Profile</li>
					<li><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $user->uid;?>"><i class="fa falist fa-user"></i>My Profile</a></li>
					<li><a href="index.php?do=config"><i class="fa falist fa-wrench"></i>Settings</a></li>
					<li class="divider"></li>
					<li><a href="logout.php"><i class="fa falist fa-power-off"></i> Logout</a></li>
				</ul>
			</li>

		</ul>
		<!-- End Top Right -->

	</div>