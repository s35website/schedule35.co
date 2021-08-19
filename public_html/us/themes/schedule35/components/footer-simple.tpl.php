<?php
  /**
   * Footer
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: footer-simple.tpl.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>

<footer class="wrapper">
	<div class="container max-width">

		<div class="row t18">
			<div class="col-sm-6">
				<div class="text-left t18">
					<img class="footer-logo" src="<?php echo THEMEURL;?>/assets/img/logo-dark.svg" alt="<?php echo $core->company;?> Logo" />
					&copy; <?php echo $core->company;?> <?php echo date("Y"); ?> All Rights Reserved
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="text-right social">
					
					
					<a href="https://www.instagram.com/<?php echo $core->social_instagram;?>" title="Instagram" target="_blank" class="ico-instagram"></a>
					
					<!--<a href="<?php echo $core->social_youtube;?>" title="YouTube" target="_blank"  class="ico-youtube"></a>
					
					<a href="<?php echo $core->social_twitter;?>" title="Twitter" target="_blank" class="ico-twitter"></a>-->
					
					
					
					<!--<a class="footer-ig" href="https://www.instagram.com/buudabomb_" title="Instagram" target="_blank">
						<span class="icon ico-instagram"></span>
						<span>Find us on Instagram</span>
					</a>-->
					
				</div>
			</div>
		</div>

	</div>
</footer>
