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
				<a href="#faq-buudapoints" class="subnav-link">
					<span>BuudaPoints</span>
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
								<h2 class="p0">How many <?php echo $core->company; ?>'s should I eat?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>The recommended dosage for beginners is one to three gummies or one chocolate.</p>

								<p>For more occasional cannabis users, the recommended dosage is four to six gummies, or two to three chocolates.</p>

								<p>From our experiences serious potheads take seven to ten gummies or three to five chocolates, BUT we cannot in good conscience recommend this.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">When will my package arrive?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>All our packages are <strong>heat sealed</strong>, completely odorless and virtually <strong>undetectable through scent</strong>. </p>
								<p>We ship via Canada Post, and other major parcel carriers to get your <?php echo $core->company; ?>'s to you as quickly as possible. It typically takes about 5-10 business days from when you order, and you can always track it by visiting your <?php echo $core->company; ?>'s profile, or using the Shipping Confirmation email that we send as soon as your order heads out into the world.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What are the risks of taking too much?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>
									The risk of ingesting too many edibles is the same as smoking too much cannabis. You will most likely go into a weed coma and knockout for a couple of hours if you don't freak out first. But no worries, just do it somewhere safe and with people you trust and you should be good. Although there are no health dangers of taking to much, taking the right amount will ensure a good time, so try not to overdo it.
								</p>
								<p>
									Also, we recommend taking some Vitamin C to counteract the THC.
								</p>

							</div>

						</div>

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

								<p>We currently ship to all of Canada via their APO, FPO &amp; DPO addresses.</p>
								<p>At this time, we don't ship internationally, but we hope to sometime in the near future. </p>

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

								<p>Within Ontario, we offer free shipping on any order over $<?php echo number_format($core->shipping_free_flag);?>. Our standard economy option costs $<?php echo $core->shipping_standard;?>, but we're hoping to offer lower shipping costs to Canada in the future.</p>

							</div>

						</div>

					</section>

					<section class="faq-questions" id="faq-product">

						<h2 class="t0 p60 text-center">Product Questions</h2>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How long do the candy's and chocolates last before they go bad?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>If kept in a cool place, they last years before they lose their potency as any gummies and chocolates do. But why store them? Take them and enjoy yourself!
								</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Where are your products made?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>All our products are made and prepared in our commercial kitchen based out of Toronto, Canada.</p>

								<p>We take pride in each package we deliver. Our philosophy stems from our love of wholesome high quality candy and from our strong belief in the healing characteristics cannabis contains.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What is the best place to store <?php echo $core->company; ?>'s?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>The best place to store <?php echo $core->company; ?>'s is somewhere dry and cool. We recommend a cupboard, or if you don't mind the texture you can try the fridge or freezer.</p>

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

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What's the difference between chocolates and candy's?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>The main difference is taste. Gummies taste like regular gummy bears and the chocolates taste like chocolate. Although the gummies come with 10 pieces and the chocolates come with 5, the THC dosage in each bag amounts to the same.</p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Do you ever change your product prices?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>At <?php echo $core->company; ?>, we strive to offer our customers the highest quality products at the best value possible by researching, manufacturing and selling our products directly to you. As we grow, we are able to produce some products more cost effectively and try to pass on some of those savings to our customers by decreasing prices. Last year, we were able to decrease our prices by finding local THC distributors without lowering the quality of our products.</p>

								<p>Sometimes we experience an increase in price of raw ingredients and labor, but still want to continue making products that meet high quality standards. Therefore, we may need to increase prices slightly or decrease the discount we offer on larger quantities. This year we decreased the discount on larger quantities of our chocolates, while making sure that each package still costs $15 or less.</p>

								<p>Pricing is something we take very seriously and whenever we change prices, we always do it with the intent to deliver the best quality products to our customers at the best possible value.</p>

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

								<p>We currently ship to all of Canada via their APO, FPO &amp; DPO addresses.</p>
								<p>At this time, we don't ship internationally, but we hope to sometime in the near future. </p>

							</div>

						</div>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do you ship?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>All packages are vacuum sealed and sprayed with a light ceramic coating, so they're odor is virtually undetectable.</p>
								<p>If you're ordering in Canada, all orders will ship via Canada Post. You'll receive a tracking number from us in your inbox as soon as it ships!</p>

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
								<h2 class="p0">What is your return policy?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">

								<p>We love the products we've made and we think you will too. If you find that you're unhappy for any reason, just let us know so that we can help you return your products within 30 days of receipt for a 50% refund.</p>

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

								<p>If for any reason you need to receive your order in fewer than 5 business days, you can expedite the processing of your order for an additional fee. In Canada, you may pay $<?php echo $core->shipping_express;?> for our Priority Shipping method.</p>

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

								<p>Within Canada, we offer free shipping on any order over $<?php echo(round($core->shipping_free_flag));?>. Our standard economy option costs $<?php echo $core->shipping_standard;?>, but we're hoping to offer lower shipping costs to Canada in the future.</p>

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

								<p>We contribute equally to your shipping costs on all orders, regardless of the transportation mode or location. For orders outside of Ontario, the costs are significantly higher, leaving a remainder of $<?php echo $core->shipping_standard;?> or more after our contribution is applied.</p>

								<p>We want you to know that shipping costs do not change regardless of order size (unless you select an expedited option). We're committed to making sure you get your <?php echo $core->company; ?>'s on time and we're constantly looking for ways to improve the process so that we can deliver the best experience possible.</p>

							</div>

						</div>

					</section>
					
					
					<section class="faq-questions" id="faq-buudapoints">
					
						<h2 class="t0 p60 text-center">BuudaPoints Questions</h2>

						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">What are BuudaPoints?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>BuudaPoints is a royalty program designed to thank our customers for their loyalty. It allows customers to earn points that can go towards paying for purchases.</p>
							</div>
						</div>


						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How can I earn BuudaPoints?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>There are three (3) ways to earn BuudaPoints</p>
								<ol>
									<li>Make a <a href="<?php echo SITEURL;?>/shop">purchase</a>. (Earn 100 - 200 pts for every item in your cart)</li>
									<li><a href="<?php echo SITEURL;?>/profile?p=referrals">Invite your friends</a> to <?php echo $core->site_name; ?> (Earn 25 pts for every friend who signs up)</li>
									<li>Read and comment on a <a href="<?php echo SITEURL;?>/blog">blog post</a>. (Earn 5 pts)</li>
								</ol>
							</div>
						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Where can I see and track my points?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									Once logged into your account, all of your points will be displayed <a href="<?php echo SITEURL;?>/profile?p=buudapoints">in your wallet</a>. You can also keep an eye on your points balance which is showcased in the top right corner of the site. Logged in on your mobile? Click the hamburger icon in the top left to see your balance.
								</p>
							</div>
						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How much BuudaPoints do I need to make a purchase?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									100 BuudaPoints = $1. That means if your cart totals $20, you'll need 2000 BuudaPoints.
								</p>
							</div>
						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How do I make a purchase using BuudaPoints?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									To complete your purchase with BuudaPoints, choose BuudaPoints as a <a href="<?php echo SITEURL;?>/payment">Payment Option</a> during <a href="<?php echo SITEURL;?>/cart">Checkout</a>.
								</p>
							</div>
						</div>
						
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">I don’t have enough points to pay for my whole purchase. Can I use whatever points I have to reduce the cost and pay for the rest with cash? </h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									No. You must have enough points to cover the purchase price of the product(s), including shipping and applicable taxes. 
								</p>
							</div>
						</div>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">How long does it take for my points to appear in my account?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									BuudaPoints appear in your account instantly for all interactions (except purchases paid using eTransfer). For all eTransfer payments, please allow 48 hours for us to accept your payment. Once your eTransfer has been accepted, your points will be updated into your account.
								</p>
							</div>
						</div>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Can my points expire?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									No, rest assured your points will never expire! Although we hope you come back and check-in often, your points will be there waiting for you, no matter how long you leave them there!
								</p>
							</div>
						</div>
						
						<!-- masta -->
						<div class="form-validetta masta section">
							<div class="tab view">
								<h2 class="p0">Will I earn points when I use BuudaPoints to make a purchase?</h2>
								<div class="right table">
									<div class="middle">
										<span class="link expand"><span class="ico-add"></span></span>
									</div>
								</div>
							</div>
							<div class="form view grid">
								<p>
									No, you can’t earn points when you use BuudaPoints to make a purchase.
								</p>
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
	</script>

</body>

</html>
