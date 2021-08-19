<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php include ("nav-profile.tpl.php"); ?>

<div id="profile-orders" class="wrapper padded bg-lightgrey">

	<div class="container max-width narrow page details">

		<h2 class="t0 p42 text-center">Invite a Friend</h2>
		<p class="p6 text-center">
			Share your invite code with friends and family and earn 25 pts: <span class="strong"><?php echo($urow->invite_code); ?></span>
		</p>
		<p class="p12 text-center">
			You have
			<strong>
			<?php if ($urow->invites > 0): ?>
				<?php echo($urow->invites); ?>
			<?php else: ?>
				0
			<?php endif; ?>
			</strong>
			invite(s) left.
		</p>
		<p class="p30 text-center" style="opacity: 0.7;font-style: italic;">
			<small>* Invite codes only valid for individuals 19 years of age or older</small>
		</p>

		<!-- Mailing list signup -->
		<section class="wrapper text-center">

			<div class="container max-width narrow3">

				<form action="<?php echo SITEURL; ?>/ajax/controller.php" method="post" name="referral-form" class="form-validetta validate" novalidate>
					<div class="form-group">
						<input id="recipients" type="text" name="recipients" autocomplete="off" data-validetta="required,minLength[2]" placeholder="Email addresses (separate emails by commas)" value="">
					</div>


					<input name="processReferrals" type="hidden" value="1">
					<input name="invitecode" id="invitecode" value="<?php echo($urow->invite_code); ?>" type="hidden"/>
					<input name="email" id="email" value="<?php echo($urow->username); ?>" type="hidden"/>
					<input name="name" id="name" value="<?php echo($urow->fname); ?> <?php echo($urow->lname); ?>" type="hidden"/>

					<button type="submit" class="btn full-width primary t30">Send Invites</button>
				</form>

				<!-- <p class="small t30 text-left" style="font-size: 14px;line-height: 24px;font-style: italic;">* For every friend who signs up and makes a purchase, you'll be entered in a contest to win $1000, 20 x Gummy Bears, 10 x Cookies and Cream, and 10 x Milk Chocolate. Contest runs until May 26, 2018.</p> -->

				<!--<p class="small t30 text-left" style="font-size: 14px;line-height: 24px;font-style: italic;">* For every friend who signs up and makes a purchase, you'll receive a $10 credit towards your next purchase, no minimum order required!</p>
				-->
			</div>

		</section>

	</div>

</div>
