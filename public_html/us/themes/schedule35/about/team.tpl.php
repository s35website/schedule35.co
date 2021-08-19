<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<?php include ("nav-about.tpl.php"); ?>
<div class="wrapper-add">
	<section id="about-bulk" class="wrapper padded text-center container max-width narrow">
	
		<h1 class="t0">Team</h1>
		
		<div class="text-center">
			<p>
				Lumi helps e-commerce companies produce memorable and sustainable packaging through its simple online platform and worldwide network of factories.
			</p>
			<p>
				Working on a story about Lumi? <br />
				Contact us: <a href="mailto:<?php echo $core->site_email;?>"><?php echo $core->site_email;?></a>
			</p>
		
		</div>
	
	</section>
</div>
<?php include ("ready.tpl.php"); ?>