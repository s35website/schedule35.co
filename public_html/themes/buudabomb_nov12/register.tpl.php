<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<div id="flashes">
		<?php echo(isset($_SESSION['registererror']) ? $_SESSION['registererror'] : ''); ?>
	</div>

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<section id="login" class="wrapper padded bg-lightgrey">
			
			<!-- Registration Form -->
			<div class="container max-width">
				<div class="row">
					<div class="col-sm-12">
						
						<form action="<?php echo SITEURL; ?>/ajax/user.php" class="login-wrapper form-validetta auth-form" accept-charset="UTF-8" method="post" enctype="multipart/form-data">
							
							<!-- Invite Code Form -->
							<?php if ($core->invite_only): ?>
							<div id="form-invite" class="container-overlay">
		
								<div class="login-padding">
		
									<h2 class="t0">Enter Your Invite Code</h2>
									<div class="form-group">
										<input class="field-input required tc" id="inviteCode" type="text" name="inviteCode" placeholder="Invite Code" value="<?php echo(isset($_GET['invite']) ? $_GET['invite'] : ''); ?>" data-validetta="required,minLength[2]"/>
									</div>
		
									<div class="form-group p42">
										<a id="btnInvite" class="btn-quantum btn-loader btn full-width primary t30 p18">
											<span>Check Code</span>
											<div class="circle-loader"></div>
										</a>
									</div>
		
									<div class="login-switch small">
										Need an Invite? Say less. <a href="<?php echo SITEURL;?>/invitations">Click here.</a>
									</div>
		
								</div>
							</div>
							<?php endif; ?>
							
							<div id="form-registration" class="<?php echo (($core->invite_only == 1) ? 'invisible' : ''); ?>">
							
								<div class="login-padding">
									<h2 class="t0">Sign Up</h2>
									
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<input class="field-input required" id="name" type="fname" name="fullname" placeholder="Full name" value="<?php echo(isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''); ?>" data-validetta="required,minLength[2]"/>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<input type="checkbox" id="age_very" name="age_very" value="age" data-validetta="required"><label for="age_very"><span>I am over 18 years of age</span></label>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<input id="user_email" class="field-input required" name="email" type="text" placeholder="Email" value="<?php echo(isset($_SESSION['email']) ? $_SESSION['email'] : ''); ?>" data-validetta="required,email,minLength[2]">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-12">
												<input id="user_password" class="field-input required" name="pass" type="password" placeholder="Password" minlength="6" data-validetta="required,minLength[6]">
											</div>
										</div>
									</div>
	
									
									
									<!--<div class="form-group">
										<div class="row">
											<div class="col-12">
												<input type="checkbox" id="newsletter" name="newsletter" value="1"><label for="newsletter"><span>Subscribe for updates on new products and crazy deals</span></label>
											</div>
										</div>
									</div>-->
	
									<div class="form-group p18">
										<input name="doRegisterSimple" type="hidden" value="1">
	
										<button class="btn-quantum btn-loader btn full-width primary t12 p18" type="submit">
											<span>Create an Account</span>
											<div class="circle-loader"></div>
										</button>
									</div>
								</div>
								
								<div class="login-switch small">
									Already have an account? <a href="<?php echo SITEURL;?>/login">Log in.</a>
								</div>
								
							</div>

							

						</form>
					</div>
				</div>
			</div>
		</section>

	</div>





	<?php require('components/footer-simple.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

	<?php unset($_SESSION['registererror']); ?>

	<?php unset($_SESSION['fullname']); ?>
	<?php unset($_SESSION['email']); ?>
	<?php unset($_SESSION['age_very']); ?>
</body>

</html>
