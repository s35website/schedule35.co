<?php
  /**
   * Most Popular Items
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: footer.tpl.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>

<footer class="wrapper">
	<div class="container max-width">
		
		<div class="row">
			<div class="col-6 col-sm-3 p18">
				<ul class="footer-list">
					<li><h5>BuudaBomb</h5></li>
					<li><a href="<?php echo SITEURL;?>/shop">Shop</a></li>
					<li><a href="<?php echo SITEURL;?>/blog">Blog</a></li>
					<li><a href="<?php echo SITEURL;?>/help">FAQs</a></li>
					<li><a href="<?php echo SITEURL;?>/invitations">Get Invitations</a></li>
				</ul>
			</div>
			<div class="col-6 col-sm-3 p18">
				<ul class="footer-list">
					<li><h5>About Us</h5></li>
					<li><a href="<?php echo SITEURL;?>/about">Our Story</a></li>
					<li><a href="<?php echo SITEURL;?>/about?p=buudapoints">BuudaPoints Info</a></li>
					<li><a href="<?php echo SITEURL;?>/about?p=dosage">Dosage Guide</a></li>
					<li><a href="<?php echo SITEURL;?>/about?p=bulk">Bulk Pricing</a></li>
				</ul>
			</div>
			<div class="col-sm-6 p18">
				<ul class="footer-list">
					<li><h5>Join the mailing list and get 5% off forever!</h5></li>
				</ul>
				
				<div class="t12">
				
					<form action="https://buudabomb.us16.list-manage.com/subscribe/post?u=8c61b824d167c4c31532f13db&amp;id=2003fe4c7d" method="post" name="mc-embedded-subscribe-form" class="validate footer-newsletter" target="_blank" novalidate>
						<input type="email" value="" placeholder="Enter your email to subscribe" name="EMAIL" class="required email input-newsletter"><button type="submit" value="Subscribe" name="subscribe" class="button btn-mail"><span class="ico-email-send"></span></button>
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8c61b824d167c4c31532f13db_ad48cd6370" tabindex="-1" value=""></div>
					</form>
				</div>
				
				<div class="social t24">
					
					
					<a href="https://www.instagram.com/<?php echo $core->social_instagram;?>" title="Instagram" target="_blank" class="ico-instagram"></a>
					
					<a href="<?php echo $core->social_youtube;?>" title="YouTube" target="_blank"  class="ico-youtube"></a>
					
					<a href="<?php echo $core->social_twitter;?>" title="Twitter" target="_blank" class="ico-twitter"></a>
					
				</div>
			</div>
		</div>

		<div class="row t30" style="display: none;">
			<div class="col-sm-12">
				<div class="footer-text">
					&copy; <?php echo $core->company;?> <?php echo date("Y"); ?> All Rights Reserved <br />
				</div>
			</div>
		</div>

	</div>
</footer>
