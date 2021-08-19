<?php
  /**
   * Most Popular Items
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: other-products.tpl.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  $otherrow = $item->renderOtherProducts($row->id);
?>
<!-- Recent Items-->
<?php if($otherrow && count($otherrow) >= 1):?>

	<h4 class="t60 p12"><a href="<?php echo SITEURL;?>/shop">Other things you can enjoy...</a></h4>

	<div class="row">
		<?php $i = 0; ?>
		<?php foreach ($otherrow as $orow):?>
		<?php if (++$i > 3) break; ?>

		<?php $url = ($core->seo) ? SITEURL . '/product/' . $orow->slug . '/' : SITEURL . '/item?itemname=' . $orow->slug;?>


		<div class="col-sm-4">
			<a class="product p12" href="<?php echo $url;?>">
				<div class="item-image">
					<img src="<?php echo UPLOADURL;?>prod_images/<?php echo ($orow->thumb) ? $orow->thumb : "blank.png?v=1";?>" alt="<?php echo $orow->title;?>" />
				</div>
				<div class="item-info hide">
					<div class="product-price-container">
						<span class="product-name-text"><?php echo $orow->title;?></span>
					</div>
				</div>
			</a>
		</div>

		<?php endforeach;?>

		<div style="clear:both;"> </div>
	</div>

<?php unset($orow);?>


<?php endif;?>
