<?php if($user->logged_in && $urow->newsletter != 1):?>
<!-- Show notification settings update -->
<!-- Show notification settings update -->
	<div id="modal-notificatons-update" class="modal-box" style="display: none;">
		<div class="padding">
			<img src="<?php echo THEMEURL;?>/assets/img/icons/ico4-mail.png" style="width: 142px; height: 138px;">
			<h3 class="text-center t30 p18">Deals and news delivered to your inbox</h3>
			
			<p class="text-center big p48">
				<!--We don't send a lot of emails but when we do, it'll be for a CRAZY deal or a new product.-->
				Join the mailing list and get <strong>5% OFF</strong> forever!
			</p>
		</div>
		<div class="modal-footer">
			<button id="btnCloseModal" class="btn disabled" style="cursor: pointer!important;">Not interested</button><a id="btnSettings" href="<?php echo SITEURL;?>/mailinglist" class="btn primary fr">Subscribe now</a>
		</div>
	</div>
	<script type="text/javascript">
		var notificationsUpdateModal;
		
		$( document ).ready(function() {
			notificationsUpdateModal = new jBox('Modal', {
				content: $('#modal-notificatons-update')
			});
		});
		
		$("#btnCloseModal").on( "click", function() {
			notificationsUpdateModal.close();
			$.cookie('newsletterpopupcookie', '1', { expires: 2 });
			console.log("newsletter cookie created");
		});
		
		
		$(document).ready(function(){
			if ( $.cookie('newsletterpopupcookie') == 1 ) {
				notificationsUpdateModal.close();
			} else {
				notificationsUpdateModal.open();
			}
		});
		
	</script>

<?php endif;?>