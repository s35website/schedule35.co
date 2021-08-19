<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');

	$inrow = $item->getUserInvoices();
	
	$_SESSION['notifications_page'] = 'true';
?>
<?php include ("nav-profile.tpl.php"); ?>
<div id="profile-notifications" class="wrapper padded bg-lightgrey">

	<div class="container max-width narrow page details">

		<h2 class="t0 p60 text-center">Email Notifications</h2>

		<?php include ("nav-profile-account.tpl.php"); ?>
		
		<div class="masta">
			
			<div class="loading-overlay bg-lightgrey">
				<div class="circle-loader"></div>
			</div>
			
			<div class="view body">
				<!--<div class="p-option">
					<div class="p-title">
						<h2>Newsletter</h2>
						<span>Promotions, new products, contests and other relevant stuff.</span>
					</div>
					<span class="s-checkbox">
						<input type="checkbox" class="js-switch" id="newsletter" name="newsletter" value="1" <?php echo ($urow->newsletter==1 ? 'checked' : '');?> >
					</span>
				</div>-->
				<div class="p-option">
					<div class="p-title">
						<h2>Notifications</h2>
						<span>We'll let you know when out fo stock products are available again.</span>
					</div>
					<span class="s-checkbox">
						<input type="checkbox" class="js-switch" id="notifications" name="notifications" value="1" <?php echo ($urow->notifications==1 ? 'checked' : '');?> >
					</span>
				</div>
				
				<div class="p-option">
					<div class="p-title">
						<h2>Purchase Receipts</h2>
						<span>Purchase receipts, invoices and refunds.</span>
					</div>
					<span class="s-checkbox">
						<input type="checkbox" class="js-switch" id="purchase_receipts" name="purchase_receipts" value="1" <?php echo ($urow->purchase_receipts==1 ? 'checked' : '');?> >
					</span>
				</div>
				
			</div>
		</div>
		
		
		<!-- New masta for notifcaiton button -->
		<div class="masta">
			<div class="view body">
				<p class="t30 text-center">Not receiving our emails? <br/><a id="btnShowNotificationModal" class="link">Here's how to receive important email messages.</a></p>
			</div>
		</div>
		
	</div>

</div>


<div id="modal-notificatons-update" class="modal-box" style="display: none;">
	<div class="padding">
		
		<img src="<?php echo THEMEURL;?>/assets/img/icons/email-not.png" style="height: 122px;" />
		<h3 class="text-center">How to Receive Emails</h3>
		
		<p class="text-center">
			Sometimes our emails end up in your spam folders, which is super annoying! That's why we've created a tutorial on adding our email addresses to your trusted contacts for the 3 largest webmail providers:
		</p>
		<p class="text-center p30">
			<a target="_blank" href="<?php echo SITEURL;?>/support?p=email-whitelist#whitelist-gmail">Gmail</a> / <a target="_blank" href="<?php echo SITEURL;?>/support?p=email-whitelist#whitelist-yahoo">Yahoo</a> / <a target="_blank" href="<?php echo SITEURL;?>/support?p=email-whitelist#whitelist-hotmail">Hotmail / Outlook</a>
		</p>
		<p class="text-center p18">
			<a id="btnCloseModal" class="btn primary">I'm good to go!</a>
		</p>
		
		
	</div>
</div>
