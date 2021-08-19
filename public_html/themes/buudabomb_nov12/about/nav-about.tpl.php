<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<div class="subNavSelect"></div>
<nav class="subnav subnav2">
	<label class="subnav-label">About</label>

	<a href="<?php echo SITEURL; ?>/about" class="subnav-link<?php if($p === 'company'):?> active<?php endif;?>">
		<span>Our Story</span>
	</a>
	
	<a href="<?php echo SITEURL; ?>/about?p=buudapoints" class="subnav-link<?php if($p === 'buudapoints'):?> active<?php endif;?>">
		<span>BuudaPoints Info</span>
	</a>
	<!--<a href="<?php echo SITEURL; ?>/about?p=mission" class="subnav-link<?php if($p === 'mission'):?> active<?php endif;?>">
		<span>Our Mission</span>
	</a>-->
	<a href="<?php echo SITEURL; ?>/about?p=dosage" class="subnav-link<?php if($p === 'dosage'):?> active<?php endif;?>">
		<span>Dosage Guide</span>
	</a>
	<a href="<?php echo SITEURL; ?>/about?p=bulk" class="subnav-link<?php if($p === 'bulk'):?> active<?php endif;?>">
		<span>Bulk Pricing</span>
	</a>
	<a style="display: none;" href="<?php echo SITEURL; ?>/about?p=team" class="subnav-link<?php if($p === 'team'):?> active<?php endif;?>">
		<span>Team</span>
	</a>
</nav>