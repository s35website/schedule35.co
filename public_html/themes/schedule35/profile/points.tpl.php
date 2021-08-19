<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php include ("nav-profile.tpl.php"); ?>
<div id="profile-details" class="wrapper padded">

	<div class="container page details">
	
		<h2 class="t0 p60 text-center">Points Wallet</h2>
		
		<?php include ("nav-profile-account.tpl.php"); ?>

		<!-- Mailing list signup -->
		<section class="wrapper text-center">

			<div class="container max-width narrow2 wallet">
				
				
				<div class="wallet-pocket current">
					<h4>Current Points <span class="icon-help-circle tooltip" title="The amount of points currently in your wallet."></span></h4>
					<h4 class="points"><?php echo $urow->points_current;?> pts</h4>
				</div>
				<div class="wallet-pocket">
					<h4>Lifetime Points <span class="icon-help-circle tooltip" title="The amount of points you've earned in your lifetime."></span></h4>
					<h4 class="points"><span><?php echo $urow->points_lifetime;?> pts</h4>
				</div>
				<div class="wallet-end">
					Want to learn how to earn more Points? <a href="<?php echo SITEURL;?>/about?p=points">Click Here</a>
				</div>
				
			</div>

		</section>
		
		
	</div>
	
</div>