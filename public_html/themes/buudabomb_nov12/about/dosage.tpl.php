<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "about?p=dosage"; ?>
<?php include ("nav-about.tpl.php"); ?>
<div class="wrapper-add">
	<section id="about-press" class="wrapper padded text-center container max-width narrow t30">
	
		<h1 class="t0">Dosage Guide</h1>
		
		<div class="text-left">
			<p>
				Remember to be patient. <?php echo $core->company; ?>'s take 40-50 minutes to&nbsp;kick&nbsp;in.
			</p>
			
			
			<table class="table-dosage text-left t42 p42">
				<tbody>
					<tr>
						<td class="level">
							<h2 class="level">20mg</h2>
						</td>
						<td class="level-description">
							<span>Add a little kick to your day.</span>
						</td>
						<td class="level-img">
							
							<img class="dosage-level-icon" src="<?php echo UPLOADURL;?>page_about/20mg.gif" alt="20mg" />
						</td>
					</tr>
					<tr>
						<td class="level">
							<h2 class="level">40mg</h2>
						</td>
						<td class="level-description">
							<span>Ok ok ok! Feelin' nice now.</span>
						</td>
						<td class="level-img"> 
							<img class="dosage-level-icon" src="<?php echo UPLOADURL;?>page_about/40mg.gif" alt="40mg" />
						</td>
					</tr>
					<tr>
						<td class="level">
							<h2 class="level">60mg</h2>
						</td>
						<td class="level-description">
							<span>Find a couch, you're about to get lifted.</span>
						</td>
						<td class="level-img">
							<img class="dosage-level-icon" src="<?php echo UPLOADURL;?>page_about/60mg.gif" alt="60mg" />
						</td>
					</tr>
					<tr>
						<td class="level">
							<h2 class="level">80mg</h2>
						</td>
						<td class="level-description">
							<span>You're either on the road to enlightenment or to Narnia. Or both.</span>
						</td>
						<td class="level-img">
							<img class="dosage-level-icon" src="<?php echo UPLOADURL;?>page_about/80mg.gif" alt="80mg"/>
						</td>
					</tr>
					<tr>
						<td class="level">
							<!--<img class="gummy-icon" src="<?php echo THEMEURL;?>/assets/img/gummybear_green.svg" alt="Cannabis infused Gummy Bear Edible" />-->
							<h2 class="level">100mg</h2>
						</td>
						<td class="level-description">
							<span>See unicorns and enjoy travelling space without the hassle of joining NASA.</span>
						</td>
						<td class="level-img">
							<img class="dosage-level-icon" src="<?php echo UPLOADURL;?>page_about/100mg.gif" alt="100mg" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<small>
				* As much as we'd like you to enjoy as much BuudaBomb's as possible, we cannot in good conscience recommend taking more than 10 gummies (or 5 chocolates) at the same time.
			</small>
		
		</div>
	
	</section>
</div>
<?php include ("ready.tpl.php"); ?>