<?php $arr_content = array("featured", "categories", "menus", "pages", "blog", "comments", "blog-cat", "faq"); ?>
<?php
	if (in_array($page, $arr_content)) {
	    $contentpage = true;
	}
?>

<?php $arr_warehouse = array("warehouse_distillate", "warehouse_production"); ?>
<?php
	if (in_array($page, $arr_warehouse)) {
	    $warehousepage = true;
	}
?>

<?php $arr_shop = array("products", "files", "coupons", "invites", "transactions"); ?>
<?php
	if (in_array($page, $arr_shop)) {
	    $shoppage = true;
	}
?>


<?php $products = countEntries(Products::pTable, "active", "1"); ?>

<div class="sidebar clearfix">

	<ul class="sidebar-panel nav">
		<li class="sidetitle">MAIN  </li>
		<li><a <?php echo (!$page || $page == "dashboard") ? 'class="active"' : ''; ?> href="index.php"><span class="icon"><i class="fa fa-home"></i></span>Dashboard</a></li>

		<?php if($user->is_Manager() || $user->is_Admin()):?>
		<li class="link nested">
			<a <?php echo ($shoppage) ? 'class="active"' : ''; ?>>
				<span class="icon"><i class="fa fa-shopping-cart"></i></span>Shop<span class="caret"></span>
			</a>
			<ul <?php echo ($shoppage) ? 'style="display: block"' : ''; ?>>
				<li><a <?php echo ($page == "products") ? 'class="active"' : ''; ?> href="index.php?do=products"><span class="icon hide"><i class="fa fa-tags"></i></span> Products<span class="label label-default"><?php echo($products) ?></span></a></li>
				<li><a <?php echo ($page == "coupons") ? 'class="active"' : ''; ?> href="index.php?do=coupons"><span class="icon hide"><i class="fa fa-gift"></i></span> Coupons</a></li>
				<li><a <?php echo ($page == "invites") ? 'class="active"' : ''; ?> href="index.php?do=invites">Invites</a></li>
				<?php if($user->is_Admin()):?>
				<li><a <?php echo ($page == "transactions") ? 'class="active"' : ''; ?> href="index.php?do=transactions"><span class="icon hide"><i class="fa fa-exchange"></i></span> Transactions</a></li>
				<?php endif;?>
			</ul>
		</li>
		<?php endif;?>
		
		<?php if($user->is_Writer() || $user->is_Admin()):?>
		<li class="link nested">
			<a <?php echo ($contentpage) ? 'class="active"' : ''; ?>>
				<span class="icon"><i class="fa fa-columns"></i></span>Content<span class="caret"></span>
			</a>
			<ul <?php echo ($contentpage) ? 'style="display: block"' : ''; ?>>
				<?php if($user->is_Admin()):?>
				<li><a <?php echo ($page == "featured") ? 'class="active"' : ''; ?> href="index.php?do=featured">Featured</a></li>
				<li><a <?php echo ($page == "categories") ? 'class="active"' : ''; ?> href="index.php?do=categories">Shop Categories</a></li>
				<li><a <?php echo ($page == "faq") ? 'class="active"' : ''; ?> href="index.php?do=faq">FAQs</a></li>
				<?php endif;?>
				<li><a <?php echo ($page == "blog") ? 'class="active"' : ''; ?> href="index.php?do=blog">Blog</a></li>
				<li><a <?php echo ($page == "blog-cat") ? 'class="active"' : ''; ?> href="index.php?do=blog-cat">Blog Categories</a></li>
				<li><a <?php echo ($page == "comments") ? 'class="active"' : ''; ?> href="index.php?do=comments">Comments</a></li>
			</ul>
		</li>
		<?php endif;?>
		
		<?php if($user->is_Manager() || $user->is_Admin()):?>
		<?php
			$invoiceSession = "";
			if (isset($_SESSION['invoiceSession'])) {
				$invoiceSession = "&amp;status=" . $_SESSION['invoiceSession'];
			}
		?>
		<li><a <?php echo ($page == "invoices") ? 'class="active"' : ''; ?> href="index.php?do=invoices"><span class="icon"><i class="fa fa-credit-card"></i></span>Invoices</a></li>

		<li style="display: none;"><a href="index.php?do=newsletter" <?php echo ($page == "newsletter") ? 'class="active"' : ''; ?>><span class="icon"><i class="fa fa-paper-plane-o"></i></span>Newsletter</a></li>

		<li><a <?php echo ($page == "users") ? 'class="active"' : ''; ?> href="index.php?do=users"><span class="icon"><i class="fa fa-users"></i></span>Users</a></li>
		
		<?php endif;?>
		
		
		<?php if($user->is_Manager() || $user->is_Admin()):?>
		<li class="link nested">
			<a <?php echo ($page == "reports") ? 'class="active"' : ''; ?>>
				<span class="icon"><i class="fa fa-area-chart"></i></span>Reports<span class="caret"></span>
			</a>
			<ul <?php echo ($page == "reports") ? 'style="display: block"' : ''; ?>>
				<li><a <?php echo ($action	== "revenue") ? 'class="active"' : ''; ?> href="index.php?do=reports&action=revenue">Revenue</a></li>
				<li><a <?php echo ($action == "users") ? 'class="active"' : ''; ?> href="index.php?do=reports&action=users">Users</a></li>
			</ul>
		</li>
		<?php endif;?>
		
		
		
		<?php if($user->is_Admin()):?>
		<li><a <?php echo ($page == "ambassadors") ? 'class="active"' : ''; ?> href="index.php?do=ambassadors"><span class="icon"><i class="fa fa-mortar-board"></i></span>Ambassadors</a></li>
		<?php endif;?>

	</ul>
	
	
	<?php if($user->is_Admin()):?>
	<ul class="sidebar-panel nav">
		<li class="sidetitle">CONFIGURATIONS</li>
		<li><a <?php echo ($page == "config") ? 'class="active"' : ''; ?> href="index.php?do=config"><span class="icon"><i class="fa fa-gears"></i></span>Site Settings</a></li>
		<li><a <?php echo ($page == "social") ? 'class="active"' : ''; ?> href="index.php?do=social"><span class="icon"><i class="fa fa-share-alt-square"></i></span>Social Settings</a></li>
		<li><a <?php echo ($page == "gateways") ? 'class="active"' : ''; ?> href="index.php?do=gateways"><span class="icon"><i class="fa fa-credit-card"></i></span>Payment Gateways</a></li>
	</ul>
	<?php endif;?>

</div>
