<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "faqs"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<div class="hero-nav" id="help_page">
			<h1>Got Questions?</h1>
			<p class="tagline">We're here to help. <span class="mobile-block">Contact us at any&nbsp;time.</span></p>
			<div class="contact">
				<a href="mailto:<?php echo $core->support_email; ?>" target="_blank"><span class="ico-email" style="font-size: 33px;bottom: -10px;position: relative;margin-right: 4px;margin-left: -2px;"></span> <?php echo $core->support_email; ?></a>
			</div>
		</div>


		<div class="subNavSelect"></div>
		<nav class="subnav subnav-faq" data-gumshoe-header>
			<label class="subnav-label">FAQs</label>

			<div data-gumshoe>
				<a href="#faq-top" class="subnav-link active">
					<span>Top Questions</span>
				</a>
				<a href="#faq-product" class="subnav-link ">
					<span>Product</span>
				</a>
				<a href="#faq-order" class="subnav-link">
					<span>Orders</span>
				</a>
			</div>
		</nav>

		<div class="wrapper-add">
			<div class="wrapper bg-lightgrey">

				<div class="container page faq">

					<section class="faq-questions" id="faq-top">

						<h2 class="t0 p60 text-center">Top Questions</h2>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do I sign up?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								
								<p>To sign up to this website, you'll need an <a href="<?php echo SITEURL;?>/invitations">invite code</a> first.</p>	
								
								<p>After you've obtained an invite code, you can register at <a href="<?php echo SITEURL;?>/register"><?php echo $core->site_name;?>/register</a>.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Should I take 100mg doses or 200mg doses?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>If you’re completely new to psilocybin, we recommend starting off with a 100mg dose. You can slowly ramp up once you’ve become acclimated to the effects and transition to a 200mg dose. Everyone is unique, so your preferred dosage to hit that sweet spot for productivity, creativity, and focus may differ.</p>

							</div>

						</div>
						
						<div id="whenwillmypackagearrive" style="position: relative;top: -60px;">
						</div>
						<!-- masta -->
						<div class="form-validetta masta section" id="whenwillmypackagearrive_faq">
							<div class="tab view">
								<h2 class="p0">When will my package arrive?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>We ship via USPS, and other major parcel carriers to get your <?php echo $core->company; ?>'s to you as quickly as possible. It typically takes about 5-10 business days from when you order, and you can always track it by visiting your <?php echo $core->company; ?>'s profile, or using the Shipping Confirmation email that we send as soon as your order heads out into the world.</p>
								
								<p>
									<strong>USPS is responding to an unprecedented amount of parcel shipments due to the COVID-19 pandemic and you may experience some delays with your package</strong>. Please use the provided tracking information for the most up to date information on your package. 
								</p>
								<p>
									We're still here to support and answer any questions you may have. Thanks for your patience and understanding!
								</p>
							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Can I take <?php echo $core->company;?> Microdose supplement if I have dietary restrictions?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>
									Our capsules are vegan, organic, and free of preservatives and common allergens. Our magic mushrooms are grown from a gluten-free substrate. 
								</p>

							</div>

						</div>

						<!-- masta -->
						<div id="wheredoweship" style="position: relative;top: -60px;">
						</div>
						<div class="form-validetta masta section" id="wheredoweship_faq">
							<div class="tab view">
								<h2 class="p0">Where do you ship?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We currently ship to the following states: California, Oregon, Washington, and Colorado. </p>
								<p>As laws around psychedelics ease up, we’ll be working hard to get our products and services to the rest of the U.S. Sign up to our mailing list to get notified of when Schedule35 comes to your State. </p>
								<p><strong>We use USPS to get your orders to your doorstep. Due to the ongoing COVID-19 pandemic, you may experience some shipping delays. In the meantime, use the provided tracking number to check on the status of your package.</strong></p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Do you offer free shipping?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We offer free shipping on any order over $<?php echo number_format($core->shipping_free_flag);?>. Our standard economy option costs $<?php echo $core->shipping_standard;?>, but we're hoping to offer lower shipping costs in the future.</p>

							</div>

						</div>

					</section>

					<section class="faq-questions" id="faq-product">

						<h2 class="t0 p60 text-center">Product Questions</h2>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What is the shelf life?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>When stored in a dark dry place at room temperature, <?php echo $core->company; ?> microdose capsules can last anywhere from 2-3 years until eventually losing some of their efficacy.
								</p>

							</div>

						</div>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Where do you source your mushrooms?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>Our mushrooms are locally-sourced and organically grown using grain substrate and coconut coir. We pride ourselves on no BS (literally).
								</p>

							</div>

						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How frequently should I take <?php echo $core->company; ?> products?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>Please refer to our <a href="<?php echo SITEURL;?>/about?p=microdosing">microdosing guide</a> for answers.
								</p>

							</div>

						</div>
						
						
						

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What strain of magic mushrooms do you use?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>Our <?php echo $core->company; ?> microdose product is produced using the Golden Teacher strain of <em>Psilocybe cubensis</em>.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Do you test any of your products on animals?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We do not perform animal testing on any of our products, and that will never change. Some of us here in the office admittedly like to test new products on ourselves from time to time, but we promise we do that by choice! Why test on animals when we can test it on ourselves? It's more fun that way.
								</p>

							</div>

						</div>

					</section>

					<section class="faq-questions" id="faq-order">

						<h2 class="t0 p60 text-center">Order Questions</h2>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Where do you ship?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We currently ship to all of CA, CO, OR and WA via their APO, FPO &amp; DPO addresses.</p>
								<p>At this time, we don't ship internationally, but we hope to sometime in the near future. </p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do you ship your packages? </h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>All orders are securely and discretely packed with no way of seeing what is inside and shipped via USPS.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do I change or cancel my order?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We try to fill and send your order as quickly as possible, which may limit our ability to add items to your order or prevent a package from shipping. Definitely reach out to us with a specific request and we'll do our best to accommodate. You can reach us via email at <a href="mailto:<?php echo $core->support_email; ?>"><?php echo $core->support_email; ?></a>.</p>
								<!--<p> You can reach us at (###) ###.#### from 10am-6pm EST, 7 days a week.</p>-->

							</div>

						</div>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How can I pay?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>Currently, we only accept credit card payments. We’re hoping to offer more channels of payment in the future. </p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What is your return policy?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>In order to maintain a level of discretion, we do not accept any returns of product. If you are unsatisfied with your product for any reason, please let us know and we will offer a 50% refund. </p>

							</div>

						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Do you offer discounts on bulk purchases?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								
								<p>
									YES! Please refer to our <a href="<?php echo SITEURL;?>/about?p=bulk">wholesale pricing guide</a> for more information.
									
									
								</p>

							</div>

						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do your reward points work? </h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>Please refer to our <a href="<?php echo SITEURL;?>/about?p=points">points program guide</a> for answers.
								</p>

							</div>

						</div>


						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">I need my order fast! Can I pay for expedited shipping?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>If for any reason you need to receive your order in fewer than 5 business days, you can expedite the processing of your order for an additional fee. Expedited services cost $<?php echo $core->shipping_express;?> for our Priority Shipping method.</p>

							</div>

						</div>


						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Can I send a gift from <?php echo $core->company; ?>'s to my friends?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>The fact that you're asking this question likely means that you're an exceptionally caring and classy person. You can (and should) send <?php echo $core->company; ?>'s as a gift to your friends and loved ones. Just be sure to change your shipping address at checkout — unless you wanted to gift it to yourself, that is. You'll need to place individual orders if more than one shipping address is required.</p>

							</div>

						</div>


						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Do you offer free shipping?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>Within the United States, we offer free shipping on any order over $<?php echo(round($core->shipping_free_flag));?>. Our standard economy option costs $<?php echo $core->shipping_standard;?>, but we're hoping to offer lower shipping costs in the future.</p>

							</div>

						</div>


						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Why does my order have a shipping fee?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We contribute to your shipping costs on all orders, regardless of the transportation mode or location. For orders outside of local areas, the costs are significantly higher, leaving a remainder of $<?php echo $core->shipping_standard;?> or more after our contribution is applied.</p>

								<p>We want you to know that shipping costs do not change regardless of order size (unless you select an expedited option). We're committed to making sure you get your <?php echo $core->company; ?>'s on time and we're constantly looking for ways to improve the process so that we can deliver the best experience possible.</p>

							</div>

						</div>

					</section>
					
					
					
					
				
				</div>

			</div>
		</div>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

	<script type="text/javascript">

		function sticky_relocate() {
			var window_top = $(window).scrollTop();
			var div_top = 0;

			if ($(window).width() < 767) {
				div_top = $('.subNavSelect').offset().top - 60;
			} else {
				div_top = $('.subNavSelect').offset().top;
			}

			if (window_top > div_top) {
				$('.main').addClass('stick');
			} else {
				$('.main').removeClass('stick');
			}
		}

		$(function() {
			$(window).scroll(sticky_relocate);
			sticky_relocate();
		});

		gumshoe.init();
		
		
		// Add hash
		if (window.location.hash == "#wheredoweship") {
			$("#wheredoweship_faq").addClass("show");
			$("#wheredoweship_faq .form").show();
		}
	</script>

</body>

</html>
