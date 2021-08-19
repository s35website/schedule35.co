<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
	
	if ($urow->active =="y") {
		redirect_to('profile');
	}
	
?>
<?php include ("nav-profile.tpl.php"); ?>

<div id="profile-orders" class="wrapper padded bg-lightgrey">

	<div class="container max-width narrow page details">

		<h2 class="t0 p42 text-center">Please verify your email.</h2>
		
		
		
		<form action="<?php echo SITEURL; ?>/ajax/controller.php" method="post" name="referral-form" class="form-validetta validate text-center" novalidate>
			<p class="med">
				Please verify your email address with the confirmation email we sent to:
			</p>
			
			<p class="big">
				<span class="strong"><?php echo $urow->username;?></span>
			</p>
			
			<input name="sendConfirmation" type="hidden" value="1">
			<input name="email" id="email" value="<?php echo($urow->username); ?>" type="hidden"/>
			<input name="name" id="name" value="<?php echo($urow->fname); ?> <?php echo($urow->lname); ?>" type="hidden"/>
			<p class="med">
			Didn't receive the email? Check your Spam folder, it may have been caught by a filter...
			
			<p class="med">If you still don't see it, you can <button class="btn inline" type="submit">resend the confirmation email</button>.</p>
			
			<button type="submit" class="btn primary med t30 p42">Resend email confirmation</button>
			
			<p>Don't forget to add our email addresses to your <a href="<?php echo SITEURL;?>/support?p=email-whitelist">whitelist</a>.</p>
		</form>

	</div>

</div>
