<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">
	
	<?php require('components/navbar.tpl.php'); ?>
	
	<div class="main">
		
		<?php include ("profile/nav-profile.tpl.php"); ?>
		
		<section id="login" class="wrapper padded bg-lightgrey">
			<div class="container max-width">
				<div class="row">
					<div class="col-sm-12">
					
						<div class="max-width narrow2 text-center">
							<div class="login-padding">
								
								
								<?php if($confirmEmail):?>
								<h2 class="t0">Email address confirmed</h2>
								
								<p>Thank you for confirming <a><?php echo $confirmEmail->username;?></a> as your email address!</p>
								
								<div class="row">
									<div class="col-sm-12">
										
										<?php if($user->logged_in):?>
											<a href="<?php echo SITEURL;?>/shop" class="btn med primary t30">Shop <?php echo $core->company; ?>s</a>
										<?php else:?>
											<a href="<?php echo SITEURL;?>/login" class="btn med primary t30">Sign in to Account</a>
										<?php endif;?>
										
									</div>
								</div>
								
								<?php else:?>
								
								<h2 class="t0">Something went wrong...</h2>
								
								<p>Can't find an email attached to this verification key. Please contact <a href="mailto:<?php echo $core->support_email; ?>"><?php echo $core->support_email; ?></a></p>
								
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>
	

	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	<?php unset($_SESSION['confirmstatus']); ?>
</body>

</html>