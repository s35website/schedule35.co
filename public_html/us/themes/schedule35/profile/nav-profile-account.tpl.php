<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<div class="nav-account">
	<a href="<?php echo SITEURL; ?>/profile?p=details" class="<?php if($p === 'details'):?>active<?php endif;?>">Account Details</a>
	<a href="<?php echo SITEURL; ?>/profile?p=orders" class="<?php if($p === 'orders'):?>active<?php endif;?>">Order History</a>
	<a href="<?php echo SITEURL; ?>/profile?p=points" class="<?php if($p === 'points'):?>active<?php endif;?>">Points Wallet</a>
	<a href="<?php echo SITEURL; ?>/profile?p=notifications" class="<?php if($p === 'notifications'):?>active<?php endif;?>" style="display: none;">Notifications</a>
</div>