<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "about?p=bulk"; ?>
<?php include ("nav-about.tpl.php"); ?>
<div class="wrapper-add">
	<section id="about-bulk" class="wrapper padded text-center container max-width narrow t30">

		<h1 class="t0">Bulk Pricing</h1>

		<div class="text-center">
			<p>
				Ordering more than usual? Check out our Wholesale Pricing Guide for 	discounted pricing on large-quantity orders.
			</p>


			<div id="bulk-pricing-calculator">
				<p class="calc">
					<a target="_blank" href="<?php echo UPLOADURL;?>page_about/s35wholesalesheet-latest.pdf?v=2<?php echo(date("Ymd")); ?>" style="font-family: 'Roboto Mono', monospace;">Download Wholesale Pricing Guide</a>
				</p>
			</div>

			<p>
				For more information regarding bulk pricing
				<br/>
				Email <a href="mailto:sales@schedule35.co">sales@schedule35.co</a> for more info.
			</p>

		</div>

	</section>
</div>
<?php include ("ready.tpl.php"); ?>
