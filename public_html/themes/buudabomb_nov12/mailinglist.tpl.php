<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "newsletter"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-newsletter" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<div class="wrapper-add">
			
			
			
			
			<section id="newsletter" class="wrapper padded bg-lightgrey">
				<div class="container max-width">
					<div class="row">
						<div class="col-sm-12">
							<div class="login-wrapper" style="max-width: 620px;">
								<div class="text-center">
									
									<div class="container-newsletter">
										<?php include('components/newsletter-svg.tpl.php'); ?>
									</div>
									
									<h2>Subscribe to our mailing&nbsp;list <br/>(and receive 5% off forever)</h2>
									<p class="p30">We don't send a lot of emails but when we do, it'll be for either a CRAZY deal or a new product. Once you sign up, you'll receive a promo code on the thank you page.
									</p>
									
									<!-- Begin Mailchimp Signup Form -->
									<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
									<style type="text/css">
										#mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; }
										#mc_embed_signup .button {
											height: 48px;
											line-height: 48px;
											padding: 0 35px;
											font-size: 15px;
											background: #232323;
											margin-top: 30px;
										}
										#mc_embed_signup .mc-field-group {
											width: 100%;
										}
										/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
										We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
									</style>
									<div id="mc_embed_signup">
										<form action="https://buudabomb.us16.list-manage.com/subscribe/post?u=8c61b824d167c4c31532f13db&amp;id=2003fe4c7d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
											<div id="mc_embed_signup_scroll">
												
												
												<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
												<div class="mc-field-group">
													<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
													</label>
													<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
												</div>
												<div class="mc-field-group">
													<label for="mce-FNAME">First Name </label>
													<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
												</div>
												<div id="mce-responses" class="clear">
													<div class="response" id="mce-error-response" style="display:none"></div>
													<div class="response" id="mce-success-response" style="display:none"></div>
												</div>
												<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
												<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8c61b824d167c4c31532f13db_2003fe4c7d" tabindex="-1" value=""></div>
												<div class="clear">
													<input id="btnSubscribe" type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
												</div>
											</div>
										</form>
									</div>
	
								</div>
	
							</div>
						</div>
					</div>
				</div>
			</section>
			
		</div>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	
	
	
	
	
	<script type="text/javascript">
		
		/* == Notify Me function == */
		$('body').on('click', '#btnSubscribe', function(event) {
			
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/user.php",
				data: {
					'updateNewsletterFlag': 1
				},
				beforeSend: function() {
					
				},
				success: function(json) {
					console.log("Flag set");
				},
				error: function() {
					console.log("error t");
				}
			});
		});
		
	</script>
</body>

</html>
