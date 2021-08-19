<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "help"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main"> 
		<section class="wrapper text-center padded">

			<div class="help-options container max-width t42 p42">
				<div class="row">
					
					
					
					<div class="col-sm-6">
						<div class="text-center option">
							<h2 class="title t12 p24">Have a question?</h2>
							
							<a class="block med p6" href="<?php echo SITEURL;?>/faqs#faq-top">Frequently Asked Questions</a>
							<a class="block med p6" href="<?php echo SITEURL;?>/faqs#faq-product">Product Questions</a>
							<a class="block med p6" href="<?php echo SITEURL;?>/faqs#faq-order">Order Questions</a>
							<a class="block med p12" href="<?php echo SITEURL;?>/faqs#faq-buudapoints">BuudaPoint Questions</a>
							
							<!--<a class="btn full-width large black p24" href="<?php echo SITEURL;?>/faqs">See FAQs</a>-->
						</div>
					</div>
					
					
					<div class="col-sm-6">
						<div class="text-center option">
							<h2 class="title t12 p24">About Us</h2>
							
							<a class="block med p6" href="<?php echo SITEURL;?>/about">Our Story</a>
							<a class="block med p6" href="<?php echo SITEURL;?>/about?p=buudapoints">BuudaPoints Info</a>
							<a class="block med p6" href="<?php echo SITEURL;?>/about?p=dosage">Dosage Guide</a>
							<a class="block med p12" href="<?php echo SITEURL;?>/about?p=bulk">Bulk Pricing</a>
							
							<!--<a class="btn full-width large black p24" href="<?php echo SITEURL;?>/about">Find Out</a>-->
						</div>
					</div> 
					
				</div>
			</div>

		</section>
		
		<section id="ready" class="wrapper text-center">
			<div class="container max-width">
				<h3 class="p12 t0">
					Ready to try some&nbsp;Edibles?
				</h3>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/shop" class="btn med primary t30">Shop <?php echo $core->company; ?>s</a>
						<!--<a href="#" class="btn med primary t30">Contact Us</a>-->
					</div>
				</div>
			</div>
		</section>
		

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

</body>

</html>
