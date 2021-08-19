<?php
  /**
   * Scripts
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: scripts.tpl.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div id="javascript-box"></div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<script src="<?php echo THEMEURL;?>/assets/js/jquery.min-2.1.1.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="<?php echo THEMEURL;?>/assets/js/bootstrap.js"></script>-->

<script src="<?php echo THEMEURL;?>/assets/js/dropify.min.js" type="text/javascript"></script>
<script src="<?php echo THEMEURL;?>/assets/js/jquery.flexslider.min.js" type="text/javascript"></script>
<script src="<?php echo THEMEURL;?>/assets/js/validetta.js" type="text/javascript"></script>
<script src="<?php echo THEMEURL;?>/assets/js/gumshoe.min.js" type="text/javascript"></script>
<script src="<?php echo THEMEURL;?>/assets/js/jBox.min.js" type="text/javascript"></script>
<script src="<?php echo THEMEURL;?>/assets/js/switchery.min.js" type="text/javascript"></script>

<script src="<?php echo THEMEURL;?>/assets/js/main.js?r=<?php echo(date("Ymd")); ?>v200"></script>
<script src="<?php echo THEMEURL;?>/assets/js/jquery.cookie.js"></script>


<?php if(!$user->logged_in):?>
<!-- Cookie Popup -->
<div id="popup-container">
	<div id="popup-window">
		<div class="splash-bg">
			<span class="popup-warning">You must be 19 years of age or older to make a purchase from this website.</span>
			<div class="popup-buttons">
				<a id="age-yes" class="btn" href="#">I understand.</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#age-yes').click(function(){
		$('#popup-container').fadeOut();
		$('#active-popup').fadeOut();
		$.cookie("age", 1);
	});

	if ( $.cookie('age') == 1 ) {
		$('#active-popup').hide();
		$('#popup-container').hide();
	} else {
		var pageHeight = jQuery(document).height();
		$('<div id="active-popup"></div>').insertBefore('body');
		$('#active-popup').css("height", pageHeight);
		$('#popup-container').show();
	}

	if ($.cookie('noShowWelcome')) { jQuery('#popup-container').hide(); jQuery('#active-popup').hide(); }
});
</script>
<?php endif;?>