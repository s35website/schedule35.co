<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "invitations"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-about" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>


	<div class="main homepage">


		<div class="wrapper-add">
			<section id="about1" class="wrapper padded text-center container max-width narrow">
		
				<h1 class="t0 p0">Invite only</h1>
				<h4 class="t0">Because loyalty is royalty.</h4>
				
				<div class="text-left">
		
					<p>We've updated our services and are offering memberships as an invite-only basis. To sign-up and be eligible to make purchases on this website you must now have a valid invite code.</p>
		
					<p><strong>There are three (3) ways to get an invite code:</strong></p>
					
					<ol class="list p30">
						<li>Send us a DM on Instagram <a href="https://www.instagram.com/<?php echo $core->social_instagram;?>" target="_blank">@<?php echo $core->social_instagram;?></a>. Make sure to accept our follow request as soon as possible!</li>
						<li>Email us at <a href="mailto:<?php echo $core->site_email;?>"><?php echo $core->site_email;?></a> with the subject line "Need invite code". To help us verify your identity make sure to <strong>include your drivers license, or valid government ID</strong>.</li>
						<li>If you have a friend who's already a member, you can use their <a href="<?php echo SITEURL;?>//profile?p=referrals">unique invite code</a> to sign up.</li>
						<li>Sign up for our <a target="_blank" href="https://buudabomb.us16.list-manage.com/subscribe?u=8c61b824d167c4c31532f13db&id=2003fe4c7d">invitation mailing list</a>. We send new invite codes every week.</li>
					</ol>
					
					<p>* Sending us a message via Instagram is the quickest and easiest way to get an invite code. If you do not own an IG, and are emailing us for an invite code, please make sure to attach a copy of your drivers license, or valid government issued ID.</p>
					
				</div>
		
			</section>
		</div>
		
		<section id="ready" class="wrapper text-center">
			<div class="container max-width">
				<h3 class="p12 t0">
					Already have an invite code?
				</h3>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/register" class="btn med btn primary t30">Register Now</a>
					</div>
				</div>
			</div>
		</section>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

	<script src="<?php echo THEMEURL;?>/assets/js/invitepage.js"></script>
	<script>
		new cbpScroller( document.getElementById( 'cbp-so-scroller' ) );
	</script>



	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>

</body>

</html>

</html>
