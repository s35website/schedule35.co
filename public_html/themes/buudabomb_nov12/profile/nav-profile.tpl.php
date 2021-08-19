<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
		
	$profile_arr = array("details", "orders", "buudapoints", "notifications");
	
	$p = isset($p) ? $p : 'details';
 ?>

<nav class="subnav">
	
	<label class="subnav-label" for="profile_subnav_control">Account</label>

	<a href="<?php echo SITEURL; ?>/profile" class="subnav-link<?php if(in_array($p, $profile_arr)):?> active<?php endif;?>">
		<span>Your Account</span>
	</a>
	<a href="<?php echo SITEURL; ?>/profile?p=referrals" class="subnav-link<?php if($p === 'referrals'):?> active<?php endif;?>">
		<span>Invite a Friend</span>
	</a>
	<a href="<?php echo SITEURL; ?>/logout.php" class="subnav-link">
		<span>Sign Out</span>
	</a>
</nav>