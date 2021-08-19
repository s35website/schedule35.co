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

<script src="<?php echo THEMEURL;?>/assets/js/main.js?r=<?php echo(date("Ymd")); ?>v2"></script>
<script src="<?php echo THEMEURL;?>/assets/js/jquery.cookie.js"></script>

<script type="text/javascript">
	
	$.getJSON( "https://api.ipregistry.co/?key=cj1vry502jywll", function (json) {
	   
		var countryCode = json['location']['country']['code'];
		console.log(countryCode);
		
		if (countryCode == "CA") {
			if ( $.cookie('countrycookie') != 1 ) {
				$('#active-popup-country').show();
				$('#popup-country').show();
			}
		}
	   
	});

</script>

<!-- Cookie Popup -->
<div id="active-popup-country" style="display: none;"></div>
<div class="popup-container" id="popup-country" style="display: none;">
	<div class="popup-window">
		<div class="splash-bg">
			<h2 class="popup-warning p18 t12">Select your store</h2>
			<span class="p30">Which store would you like to continue shopping&nbsp;from?</span>
			<div class="popup-buttons row">
				<div class="country col-6">
					<a class="p12 block country-canada" href="#">
						<img src="<?php echo THEMEURL;?>/assets/img/flags/canada.svg" alt="" />
					</a>
					<a class="btn inline" href="#">Shop Canada</a>
				</div>
				<div class="country col-6">
					<a class="p12 block country-unitedstates" href="#">
						<img src="<?php echo THEMEURL;?>/assets/img/flags/unitedstates.svg" alt="" />
					</a>
					<a class="btn inline country-unitedstates" href="#">Shop US</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('.country-unitedstates').click(function(){
	$('#popup-country').fadeOut();
	$('#active-popup-country').fadeOut();
	$.cookie("countrycookie", 1);
});
$('.country-canada').click(function(){
	window.location = "https://www.schedule35.co";
});




</script>



<?php if(!$user->logged_in):?>
<!-- Cookie Popup -->
<div class="popup-container" id="popup-agewarning">
	<div class="popup-window">
		<div class="splash-bg">
			<span class="popup-warning">You must be 21 years of age or older to make a purchase from this website.</span>
			<div class="popup-buttons">
				<a id="age-yes" class="btn" href="#">I understand.</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#age-yes').click(function(){
		$('#popup-agewarning').fadeOut();
		$('#active-popup').fadeOut();
		$.cookie("age", 1);
	});

	if ( $.cookie('age') == 1 ) {
		$('#active-popup').hide();
		$('#popup-agewarning').hide();
	} else {
		var pageHeight = jQuery(document).height();
		$('<div id="active-popup"></div>').insertBefore('body');
		$('#active-popup').css("height", pageHeight);
		$('#popup-agewarning').show();
	}

	if ($.cookie('noShowWelcome')) { jQuery('#popup-agewarning').hide(); jQuery('#active-popup').hide(); }
});
</script>
<?php endif;?>