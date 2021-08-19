<?php
  /**
   * Most Popular Items
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: navbar.tpl.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>

<!-- minicart -->
<div class="mini-cart" id="mini_cart">

	<div class="header--fixed">
		<h3 class="title appear-animation">Your Cart (<span class="count"><?php echo($content->getCartCounterBasic()); ?></span>) <a class="close-cart icon-arrow-right"></a></h3>
	</div>

    <div class="items appear-animation">
		<?php if ($content->getCartCounterBasic() == 0): ?>
		<p class="empty-text appear-animation">You have no items in your cart.</p>
		<?php else: ?>
			<?php $cartdata = $content->renderCart(); ?>
			<?php if ($cartdata) : ?>
			<?php foreach ($cartdata as $crtrow) : ?>
				<div class="item clear" data-id="<?php echo $crtrow->pid; ?>" data-pvid="<?php echo $crtrow->pvid; ?>">
					<div class="item-img">
						<img class="inline-block" alt="<?php echo $crtrow->title; ?>" src="<?php echo UPLOADURL; ?>prod_images/<?php echo $crtrow->thumb; ?>">
					</div>

					<div class="item-text">
						<p class="name"><span><?php echo $crtrow->title;?></span><span data-id="<?php echo $crtrow->pid; ?>" data-pvid="<?php echo $crtrow->pvid; ?>" class="close x-grey"><span class="icon-x block"></span></span></p>
						<?php if ($crtrow->pvtitle): ?>
						<p><span><?php echo $crtrow->pvtitle; ?></span></p>
						<?php endif ?>
						<?php $price = $crtrow->pvprice != null ? $crtrow->pvprice : $crtrow->price; ?>
						<p>
							<span class="quantity"><?php echo $crtrow->qty; ?></span> x
							
							<?php if($ambassador_discount > 0):?>
							<span class="discounted">$<?php echo money_format('%i', $price); ?></span>
							$<?php echo money_format('%i', $price - $price * $ambassador_discount); ?>
							<?php else:?>
							$<?php echo money_format('%i', $price); ?>
							<?php endif;?>
							
						</p>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif ?>
	</div>


	<div class="footer appear-animation clear"<?php if ($content->getCartCounterBasic() == 0): ?> style="display: none;"<?php endif;?>>
		<p class="footer-p">
			Subtotal: <span class="subtotal"><?php echo($content->getCartCounterCost()); ?></span>
		</p>
		<a class="button btn medium thin btn primary full-width" href="<?php echo SITEURL; ?>/cart">View Cart</a>
	</div>

</div>

<div class="mini-cart-overlay"></div>


<!-- header -->
<?php
	if (isset($pagenameModifier)) {

	}
	elseif (isset($pagename)) {
		$pagenameModifier = $pagename;
	}
	else {
		$pagenameModifier = "";
		$pagename = "";
	}
 ?>
<header class="header">
	<div class="container">
		<nav class="navbar">
			<div id="navBtn" class="burger-container">
				<div id="burger">
					<div class="bar topBar"></div>
					<div class="bar btmBar"></div>
				</div>
			</div>
			<div class="icon icon-logo"><a href="<?php echo SITEURL;?>">Home</a></div>
			
			<ul class="menu">
				
				<?php if($user->logged_in):?>
				<li id="header_avatar" class="menu-item menu-right user<?php if ($pagename == 'Account Details'): ?> active<?php endif; ?>">
					<a href="<?php echo SITEURL; ?>/profile">
						<span class="user-avatar">
							<span class="user-avatar-img" style="background-image:url(<?php echo THEMEURL;?>/assets/img/icons/avatar-img.png)"></span>
						</span>
						<span class="user-info">
							<?php echo $urow->fname;?>
							<?php 
								if (!empty($urow->lname)) {
									echo $urow->lname[0] . ".";
								}
							?>
						</span>
					</a>
					<div class="content-popover">
						<ul class="dropdown">
							<li class="nav-item user">
								<a>
									<?php echo $urow->fname;?>
									<?php 
										if (!empty($urow->lname)) {
											echo $urow->lname[0] . ".";
										}
									?>
								</a>
								<span class="member-level"><?php echo $urow->username;?></span>
							</li>
							
							<?php if($user->hasAdminAccess()):?>
							<li class="nav-item"><a href="<?php echo SITEURL;?>/admin" target="_blank">Admin</a></li>
							<?php endif;?>
							<?php if($user->is_Ambassador()):?>
							<li class="nav-item"><a href="<?php echo SITEURL;?>/ambassador" target="_blank">Ambassador Program</a></li>
							<?php endif;?>
							
							<li class="nav-item<?php if ($pagename == 'Account Details'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/profile?p=details">Account Details</a></li>
							
							<li class="nav-item<?php if ($pagename == 'Invite a Friend'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/profile?p=referrals">Invite a Friend</a></li>
							
							
							<li class="nav-item"><a href="<?php echo SITEURL;?>/logout.php">Sign Out</a></li>
						</ul>
					</div>
				</li>
				<li id="header_points" class="menu-item menu-right"><a href="<?php echo SITEURL;?>/profile?p=buudapoints"><?php echo number_format($urow->points_current, 0);?> pts</a></li>
				<?php endif;?>
				
				<li class="menu-item<?php if($pagename == 'Shop' || $pagenameModifier == 'Shop'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/shop">Shop</a></li>
				
				
				<!--
				<li id="header_about" class="menu-item has-popover<?php if($pagename == 'Help' || $pagenameModifier == 'Help' || $pagename == 'About' || $pagenameModifier == 'About' || $pagename == 'FAQs' || $pagenameModifier == 'FAQs'):?> active<?php endif;?>">
					<a class="closed" href="<?php echo SITEURL;?>/help">Info</a>
					
					<div class="content-popover">
						<ul class="dropdown">
							<li class="nav-item<?php if ($pagename == 'FAQs'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/faqs">Frequently Asked Questions</a></li>
							<li class="nav-item<?php if ($pagename == 'About' || $pagenameModifier == 'About'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/about">About Us</a></li>
						</ul>
					</div>
				</li>
				-->
				
				
				
				
				
				
				<li class="menu-item<?php if($pagename == 'FAQs' || $pagenameModifier == 'FAQs'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/faqs">FAQs</a></li>
				
				
				<li class="menu-item<?php if($pagename == 'About' || $pagenameModifier == 'About'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/about">About Us</a></li>
				
				
				
				<!--<li id="header_help" class="menu-item has-popover<?php if($pagename == 'Help'):?> active<?php endif;?>">
					<a href="<?php echo SITEURL;?>/help">Help</a>
					<div class="content-popover">
						<ul class="dropdown">
							<li class="nav-item<?php if ($pagename == 'Account Details'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/help#faq-top">Top Questions</a></li>
							<li class="nav-item<?php if ($pagename == 'Order History'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/help#faq-product">Product Questions</a></li>
							<li class="nav-item<?php if ($pagename == 'Order History'): ?> active<?php endif; ?>"><a href="<?php echo SITEURL;?>/help#faq-order">Order Questions</a></li>
						</ul>
					</div>
				</li>-->
				
				<li class="menu-item<?php if($pagename == 'Blog' || $pagenameModifier == 'Blog'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/blog">Blog</a></li>
				
				<?php if(!$user->logged_in):?>
				<li class="menu-item menu-right<?php if($pagename == 'Register'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/register">Sign Up</a></li>
				<li class="menu-item menu-right<?php if($pagename == 'Login'):?> active<?php endif;?>"><a href="<?php echo SITEURL;?>/login">Log In</a></li>
				<?php elseif($user->hasAdminAccess()):?>
				<li class="menu-item menu-right desktop-hide"><a href="<?php echo SITEURL;?>/admin">Admin</a></li>
				<?php endif;?>
				
			</ul>

			<?php
				if ($content->getCartCounterBasic() > 0) {
					$badgeActive = ' active';
				}else {
					$badgeActive = '';
				}
			 ?>

			<div id="header_cart_button" class="cart icon icon-bag">
				<a class="icon-cart" href="<?php echo SITEURL;?>/cart">
					<span class="badge<?php echo($badgeActive);?>">
						<span class="header_cart_count"><?php echo($content->getCartCounterBasic());?></span>
					</span>
				</a>
			</div>
			
		</nav>

	</div>
</header>


<!-- notification bar -->

<?php if($user->logged_in):?>
<?php if($urow->active == "n"):?>
<div class="notification-bar verify-msg">
	<div class="notification-bar-parent">
		<div class="notification-bar-child">
			To enable all features please verify your email. <a href="<?php echo SITEURL;?>/profile?p=unverified">Didn't receive an email?</a>
		</div>
	</div>
</div>
<?php endif;?>
<?php endif;?>

<!-- notification bar -->
<?php if($notification == 1):?>
<div class="notification-bar">
	<div class="notification-bar-parent">
		<div class="notification-bar-child">
			*Inventory will be restocked May 10th, 2020
		</div>
	</div>
</div>
<?php endif;?>
