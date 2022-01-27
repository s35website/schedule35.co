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
						<form class="login-wrapper form-validetta auth-form" accept-charset="UTF-8" method="post" autocomplete="off">
							<div class="login-padding">
								<h2 class="t0">Login</h2>
								
								<div id="flashes" class="p30">
									<?php echo(isset($_SESSION['registererror']) ? $_SESSION['registererror'] : ''); ?>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-12">
											<input id="user_email" class="field-input required" type="text" name="username" autocomplete="off" data-validetta="required,email,minLength[2]" placeholder="Email Address" value=""/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-12">
											<input id="user_password" class="field-input required" type="password" name="password" minlength="4" autocomplete="off" data-validetta="required" placeholder="Password" value=""/>
											<a class="small block t12" href="<?php echo SITEURL;?>/forgot-password">Forgot your password?</a>
										</div>
									</div>
								</div>

								<div class="form-group p24">
									<input name="doLogin" type="hidden" value="1" />

									<button class="btn-quantum btn-loader btn full-width primary t12 p12" type="submit">
										<span>Log In</span>
										<div class="circle-loader"></div>
									</button>

								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-12">
											<input type="checkbox" id="remember_me" name="remember_me"><label for="remember_me"><span>Keep me signed in until I sign out</span></label>
										</div>
									</div>
								</div>

							</div>

							<div class="login-switch small">
								New to <?php echo $core->company; ?>? <a href="<?php echo SITEURL;?>/register">Sign up!</a>
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
</body>

</html>
