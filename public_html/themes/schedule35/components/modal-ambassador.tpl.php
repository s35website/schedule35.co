<?php if(isset($_GET['amb'])):?>
<?php if(isset($_SESSION['ambmodal']) && $_SESSION["ambmodal"] != 0):?>

	<!-- Show notification settings update -->
	<div id="modal-ambassador" class="modal-box text-center" style="display: none;">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo THEMEURL;?>/assets/img/icons/ico4-crown.png" style="width: 160px;height: 158px;">
				<h3 class="t30">Ambassador Powers in Effect.</h3>
				<p class="big">
					
					Looks like <?php echo($ambassador_name); ?> pulled some strings and got you  <strong style="white-space: nowrap;"><?php echo($ambassador_discount * 100 . "%"); ?>&nbsp;off</strong> your purchases!
				</p>
				
				<a id="btnCloseAmbassadorModal" class="btn med btn primary t30">Awesome Shmwaesome!</a>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		
		var modalAmbassador;
		
		$( document ).ready(function() {
			// Modal pops up after btn notify pressed
			modalAmbassador = new jBox('Modal', {
				content: $('#modal-ambassador')
			});
			
			modalAmbassador.open();
		});
		
		$("#btnCloseAmbassadorModal").on( "click", function() {
			modalAmbassador.close();
		});
		
		$( window ).resize(function() {
			modalAmbassador.close();
		});
		
	</script>
	
<?php $_SESSION["ambmodal"] = 0; ?>
	
<?php endif;?>
<?php endif;?>