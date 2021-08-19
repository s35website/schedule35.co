<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "wholesale"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-wholesale" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<?php if($p != ""):?>
		<?php include ("wholesale/" . $p . ".tpl.php"); ?>
	<?php else:?>
		<?php $p = "wholesale"; ?>
		<?php include ("wholesale/default.tpl.php"); ?>
	<?php endif;?>
	
	
	<div id="modal-login" class="modal-box" style="display: none;">
		<h2>Sign in to complete checkout</h2>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="text-center option">
					<p>Already a member?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL; ?>/login">Sign In</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="text-center option">
					<p>New to <?php echo $core->site_name;?>?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL; ?>/register">Sign Up</a>
				</div>
			</div>
		
		</div>
	</div>
	
	<script type="text/javascript">
		var myModal;
		$(document).ready(function () {
			myModal = new jBox('Modal', {
				attach: '#user_not_logged_in',
				content: $('#modal-login')
			});
		});
		$(window).resize(function () {
			myModal.close();
		});
	</script>
	

</body>

</html>
