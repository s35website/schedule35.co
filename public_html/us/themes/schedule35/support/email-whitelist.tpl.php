<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<div class="wrapper-add">
	<section id="about-mission" class="wrapper padded text-center container max-width narrow">
	
		<h1 class="t0">Why you don't receive our emails</h1>
		
		<div class="text-left">
			<p>
				Sometimes our emails end up in your spam folders, which is super annoying! That's why we've created a tutorial on adding our email addresses to your trusted contacts for the 4 largest webmail providers:
			</p>
			
			<h3 id="whitelist-gmal" class="t42">Gmail </h3>
			<p>
				When you use Gmail, you need to add the address to your Google contacts. Here’s how:
			</p>
			<ol class="list p42">
				<li>In your Google account, click on the service overview and open Contacts.</li>
				<li>In Contacts, click on New contact.</li>
				<li>Fill in <strong><?php echo $core->site_email; ?></strong> for the email address (make sure to also include <?php echo $core->payment_email; ?> and <?php echo $core->support_email; ?> as well).</li>
				<li>Google automatically saves the contact.</li>
			</ol>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/gmail-screen-1.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/gmail-screen-2.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			
			
			<h3 id="whitelist-yahoo" class="t60">Yahoo </h3>
			<p>
				Adding our address to Yahoo contacts is easy as 1, 2, 3:
			</p>
			<ol class="list p42">
				<li>In your Yahoo account, click on New contact.</li>
				<li>Fill in <strong><strong><?php echo $core->site_email; ?></strong> for the email address (make sure to also include <?php echo $core->payment_email; ?> and <?php echo $core->support_email; ?> as well).</li>
				<li>Click on Save.</li>
			</ol>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/yahoo-screen-1.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/yahoo-screen-2.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/yahoo-screen-3.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			
			
			<h3 id="whitelist-hotmail" class="t60">Outlook / Hotmail </h3>
			<p>
				In Outlook.com you can add us to your People:
			</p>
			<ol class="list p42">
				<li>Click on the services overview and open People.</li>
				<li>Create a new contact.</li>
				<li>Fill in <strong><?php echo $core->site_email; ?></strong> for the email address (make sure to also include <?php echo $core->payment_email; ?> and <?php echo $core->support_email; ?> as well).</li>
				<li>Click on Save.</li>
			</ol>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/outlook-screen-1.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
			
			<div class="support-video">
				<video width="100%" autoplay muted loop>
				  <source src="<?php echo UPLOADURL;?>support/outlook-screen-2.mp4" type="video/mp4">
				  Your browser does not support the video tag.
				</video>
			</div>
		
		</div>
	
	</section>
</div>