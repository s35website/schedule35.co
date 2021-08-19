<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php require('components/head.tpl.php'); ?>

<body id="page-profile" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<?php if($p != ""):?>
		<?php include ("profile/" . $p . ".tpl.php"); ?>
		<?php else:?>
			<?php $p = "details"; ?>
		<?php include ("profile/details.tpl.php"); ?>
		<?php endif;?>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>



	<?php if(isset($_SESSION['referrals_success']) && !empty($_SESSION['referrals_success']) && $_SESSION['referrals_success'] == 'success'):?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		//Notice
		new jBox('Notice', {
			content: '<span class="fa fa-check" style="color:#00B16A"></span> Invite(s) sent!',
			stack: 3,
			autoClose: 2000,
			position: {
				x: 'center',
				y: 'center'
			},
			theme: 'NoticeBorder',
			color: 'black',
			animation: {
				open: 'flip',
				close: 'flip'
			}
		});

	});
	</script>
	<?php endif;?>
	
	
	<?php if(isset($_SESSION['confirmation_success']) && !empty($_SESSION['confirmation_success']) && $_SESSION['confirmation_success'] == 'success'):?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			//Notice
			new jBox('Notice', {
				content: '<span class="fa fa-check" style="color:#00B16A"></span> Confirmation email sent (may take up to 5 minutes to appear).',
				stack: 3,
				autoClose: 8000,
				position: {
					x: 'center',
					y: 'center'
				},
				theme: 'NoticeBorder',
				color: 'black',
				animation: {
					open: 'flip',
					close: 'flip'
				}
			});
		
		});
		</script>
	<?php endif;?>
	
	
	



	<?php unset($_SESSION['referrals_success']); ?>
	<?php unset($_SESSION['referrals_error']); ?>
	<?php unset($_SESSION['confirmation_success']); ?>
	<?php unset($_SESSION['confirmation_error']); ?>
	
	
	
	<?php if(isset($_SESSION['notifications_page'])):?>
	<!-- Modal boxes for Notifications page -->
	<script type="text/javascript">
		var notificationsUpdateModal;
		
		$( document ).ready(function() {
			notificationsUpdateModal = new jBox('Modal', {
				attach: '#btnShowNotificationModal',
				content: $('#modal-notificatons-update')
			});
		});
		
		$("#btnCloseModal").on( "click", function() {
			notificationsUpdateModal.close();
		});
		$( window ).resize(function() {
			notificationsUpdateModal.close();
		});
		
		
		/* == Radio button switch == */
		$("#profile-notifications .js-switch").change(function() {
			var newsletter = Number($("#newsletter").is(':checked'));
			var notifications = Number($("#notifications").is(':checked'));
			var purchase_receipts = Number($("#purchase_receipts").is(':checked'));
			var state = Number($(this).is(':checked'));
			
			if (state == 1 && $(this).attr("id") == "newsletter") {
				console.log(state);
				notificationsUpdateModal.open();
			}
		
			$.ajax({
				type: "post",
				url: SITEURL + "/ajax/user.php",
				dataType: 'json',
				data: {
					'updateNotifications': 1,
					'newsletter': newsletter,
					'notifications': notifications,
					'purchase_receipts': purchase_receipts
				},
				beforeSend: function() {
					$(".loading-overlay").show();
				},
				success: function(json) {
					$(".loading-overlay").hide();
					
				},
				error: function(json) {
					console.log("error");
				}
			});
			
		});
		
	</script>
	<?php endif;?>
	<?php unset($_SESSION['notifications_page']); ?>

</body>

</html>
