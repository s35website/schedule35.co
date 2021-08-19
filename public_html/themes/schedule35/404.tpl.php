<?php
  /**
   * Index
   *
   * @package FBC Studio
   * @author @author s35.com
   * @copyright 2014
   * @version $Id: index.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "404"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<div class="hero-nav" id="error_page">
			<h1>Oops, we missed a spot.</h1>
			<p class="tagline">We couldn't find the page you're looking for. If you think this is an error, please contact us.</p>
			<div class="contact">
				<a href="mailto:<?php echo $core->support_email;?>" target="_blank"><span class="ico-email" style="font-size: 33px;bottom: -9px;position: relative;margin-right: 4px;margin-left: -2px;"></span> <?php echo $core->support_email;?></a>
			</div>
		</div>

		<!-- Featured Products -->
		<section class="wrapper t72 products">

			<div class="container max-width narrow">

				<div class="h-cat text-center">
					<h2>Featured Products</h2>
				</div>

				<div class="row">
					<?php $i = 0; ?>
					<?php if($latest):?>
					<?php foreach($latest as $lrow):?>
					<?php if (++$i > 3) break; ?>
					<?php $url = ($core->seo) ? SITEURL . '/product/' . $lrow->slug . '/' : SITEURL . '/item?itemname=' . $lrow->slug;?>
					<div class="col-sm-4">
						<div class="product" href="<?php echo $url;?>">
							<a class="item-image">
								<img src="<?php echo UPLOADURL;?>prod_images/<?php echo ($lrow->thumb) ? $lrow->thumb : "blank.png?v=1";?>" alt="<?php echo $lrow->title;?>" />
							</a>
							<div class="item-info">
								<div class="product-price-container">
									<span class="product-name-text"><?php echo $lrow->title;?></span>
									<span class="price-text"><?php echo $core->formatMoney($lrow->price);?></span>
								</div>
								<div class="bottom-callout">
									<span class="callout-text"><?php echo $lrow->dosage;?>mg THC / <?php echo $lrow->pieces;?> Pieces</span>
								</div>
							</div>
						</div>
					</div>

					<?php endforeach;?>
					<?php endif;?>

				</div>

				<div class="text-center">

				</div>

			</div>

		</section>

		<!-- Ready -->
		<section id="ready" class="wrapper text-center">
			<div class="container max-width">
				<h3 class="p12 t0">
					Ready to shop?
				</h3>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/shop" class="btn med primary t30">Shop <?php echo $core->company; ?>'s</a>
						<!--<a href="#" class="btn med t30">Contact Us</a>-->
					</div>
				</div>
			</div>
		</section>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

</body>

</html>
