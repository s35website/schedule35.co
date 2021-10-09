<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "shop"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="header-active header-hasborder <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>
	
	


	<div id="shop" class="main">
		
		<?php if($ambassador_discount > 0):?>
		<section class="wrapper ambassador-note">
			
			<div class="container max-width narrow2 bg-grey">
				<div class="row">
					<div class="col-sm-3 text-center">
						<h1 class="ambassador-note-icon">
							<span class="icon-diamond"></span>
						</h1>
					</div>
					<div class="col-sm-9">
						<h3 style="margin-top: 12px;">Special Pricing Unlocked!</h3>
						<p>You've unlocked <?php echo($ambassador_discount * 100 . "%"); ?> off by using the ambassador code: <span style="text-transform: uppercase;"><?php echo($ambassador_code); ?></span></p>
					</div>
				</div>
			</div>
			
		</section>
		<?php endif;?>
		
		

		<?php foreach($row as $crow):?>
		<?php $catrow = $content->renderCategories($crow->slug, $crow->id);?>
		<?php if($catrow):?>
		<section class="wrapper t72 products">

			<div class="container max-width extended2">

				

				<div class="h-cat text-center">
					<h2><?php echo($crow->name); ?></h2>
					<!-- <p><?php echo($crow->description); ?></p> -->
				</div>

				<div class="row" style="font-size:1px;font-size:0;text-align:center;">

					<?php foreach($catrow as $lrow):?>
					<?php $url = ($core->seo) ? SITEURL . '/product/' . $lrow->slug . '/' : SITEURL . '/item?itemname=' . $lrow->slug;?>
					<div class="col-sm-12 col-md-6 col-product">

						<div class="product">
							<a class="item-image" href="<?php echo $url;?>">
								<img src="<?php echo UPLOADURL;?>prod_images/<?php echo ($lrow->thumb) ? $lrow->thumb : "blank.png?v=1";?>?v=3" alt="<?php echo $lrow->title;?>" />
								<div class="item-hover">
									<button class="btn black add-to-cart">Add to Cart</button>
								</div>
							</a>
							
							<div class="item-info">
								<div class="product-price-container">
									<span class="product-name-text"><?php echo $lrow->title;?></span>
									
									<span class="product-divider">|</span>
									
									<?php if($ambassador_discount > 0):?>
									<span class="price-text">
										<span class="discounted"><?php echo $core->formatMoney($lrow->price);?></span>
										<?php echo $core->formatMoney($lrow->price - $lrow->price * $ambassador_discount);?> <span class="icon-diamond link tooltip-content-special-pricing" style="font-size: 90%;"></span>
									</span>
									<?php else:?>
										<span class="price-text">
											
											<?php if($lrow->sale_price > 0):?>
											<span class="discounted"><?php echo $core->formatMoney($lrow->sale_price); ?></span>
											<?php endif;?>
											<?php echo $core->formatMoney($lrow->price);?> 
										</span>
									<?php endif;?>
								</div>
								<div class="bottom-callout" style="display: none;">
									<?php if($lrow->soldflag == "1" || $lrow->stock < 1):?>
									<span class="callout-text callout-text-sold">Out of Stock</span>
									<?php else:?>
									<span class="callout-text"><?php echo $lrow->dosage;?>mg x <?php echo $lrow->pieces;?> Pieces</span>
									<?php endif;?>
								</div>
							</div>
							<?php if($lrow->soldflag == "1" || $lrow->stock < 1):?>
							<a class="btn t6 p12" href="<?php echo $url;?>">Sold Out</a>
							<?php else:?>
							<a class="btn primary t6 p12" href="<?php echo $url;?>">Select</a>
							<?php endif;?>

						</div>



					</div>

					<?php endforeach;?>


				</div>

				

			</div>

		</section>
		<?php endif;?>
		<?php endforeach;?>
		
		<?php if($ambassador_discount > 0):?>
		<div id="content-special-pricing" class="content-popover" style="display: none;">
			<p>Looks like <?php echo($ambassador_name); ?> pulled some strings and got you <strong style="white-space: nowrap;"><?php echo($ambassador_discount * 100 . "%"); ?>&nbsp;off</strong> your purchases!</p>
		</div>
		<?php endif;?>
		
	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	<!-- Mailing Modal -->
	<?php include('components/modal-mailinglist.tpl.php'); ?>
	<!-- Ambassador Modal -->
	<?php include('components/modal-ambassador.tpl.php'); ?>
	
	<script type="text/javascript">
		
		$( document ).ready(function() {
			
			var tooltipSpecialPricing = new jBox('Tooltip', {
				closeOnClick: 'body',
				content: $('#content-special-pricing')
			});
			
			
			windowsize = $(window).width();
			if (windowsize > 768) {
				$('.tooltip-content-special-pricing').on({
					mouseenter: function () {
					  openTooltipSpecialPricing($(this));
					},
					mouseleave: function () {
					 tooltipSpecialPricing.close();
					}
				});
			}else {
				$('.tooltip-content-special-pricing').on({
					click: function () {
					  openTooltipSpecialPricing($(this));
					},
					mouseleave: function () {
					 tooltipSpecialPricing.close();
					}
				});
			}
			
			function openTooltipSpecialPricing(el) {
			  tooltipSpecialPricing.setContent($('#content-special-pricing')).open({target: el});
			}
		});
	</script>
</body>

</html>
