<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php require('components/head.tpl.php'); ?>

<body id="page-about" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<?php if($p == "email-whitelist"):?>
		<?php include ("support/email-whitelist.tpl.php"); ?>
		<?php elseif($p == "email-whitelist-yahoo"):?>
		<?php include ("support/email-whitelist-yahoo.tpl.php"); ?>
		<?php else:?>
		<?php $p = "support"; ?>
		<?php include ("support/support.tpl.php"); ?>
		<?php endif;?>
	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

</body>

</html>
