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
				Our cannabis-infused edibles are made in a commercial kitchen in Toronto and lab tested to ensure a consistent dosage of THC.
			</p>


			<div id="bulk-pricing-calculator">
				<p class="calc">
					<a target="_blank" href="<?php echo UPLOADURL;?>page_about/ws_bb_latest.pdf?v=<?php echo(date("Ymd")); ?>" style="font-family: 'Roboto Mono', monospace;">Download Wholesale Pricing Guide</a>
				</p>
			</div>

			<p>
				For more information regarding bulk pricing
				<br/>
				Email <a href="mailto:sales@buudabomb.com">sales@buudabomb.com</a> for more info.
			</p>

		</div>

	</section>
</div>
<?php include ("ready.tpl.php"); ?>
