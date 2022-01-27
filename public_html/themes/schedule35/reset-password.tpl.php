<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">
	
	
	
	<?php require('components/navbar.tpl.php'); ?>
	
	<div class="main">
	
		<section id="login" class="wrapper padded bg-lightgrey">
			<div class="container max-width">
				<div class="row">
					<div class="col-sm-12">
					
						<form id="forgot_password" class="auth-form form-validetta login-wrapper password-wrapper" action="<?php echo SITEURL; ?>/ajax/user.php" accept-charset="UTF-8" method="post">
							<div class="login-padding">
								<h2 class="t0">Update Password</h2>
								
								<div id="flashes" class="p30">
									<?php echo(isset($_SESSION['resetstatus']) ? $_SESSION['resetstatus'] : ''); ?>
								</div>
								
								<div class="form-group p30">
									<input id="new_password" type="password" autocomplete="off" name="new_password" placeholder="New Password" data-validetta="required,minLength[2]" />
								</div>
								
								<div class="form-group p30">
									<input name="createNewPass" type="hidden" value="1">
									<input name="password_ResetKey" type="hidden" value="<?php echo($_GET['k']); ?>">
									<button type="submit" class="btn full-width primary">Reset Password</button>
								</div>
							</div>
							<div class="login-switch small">
								Remember your password? <a href="<?php echo SITEURL;?>/login">Log in.</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>

	</div>
	

	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	<?php unset($_SESSION['resetstatus']); ?>
</body>

</html>