<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "item?itemname=" . $row->slug;?>
<?php require('components/head.tpl.php'); ?>

<body class="header-active header-hasborder <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>
	<?php
		$variantStock = $db->first("SELECT id, dosage FROM " . Products::pvTable . " WHERE pid = " . $row->id);
	?>
	<div id="item" class="main" data-id="<?php echo($row->id); ?>">

		<section class="wrapper textpad">
			<div class="container max-width">

				<div class="row product-page">

					<div class="col-md-6 product-photo">

						<div class="large-image">
							<div class="placeholder" data-large="<?php echo UPLOADURL;?>prod_images/<?php echo ($row->thumb);?>?v=3">
				            <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>prod_images/<?php echo ($row->thumb);?>&amp;w=25&amp;h=25&amp;s=1&amp;a=t1" class="img-small" alt='<?php echo $row->title;?>'>
				          </div>
						</div>

						<?php if($galrow):?>

						<div class="product-page-gallery">
							<ul>
								<li class="thumbnail active">
									<img alt="<?php echo $row->title;?>" data-src="<?php echo UPLOADURL;?>prod_images/<?php echo ($row->thumb);?>" src="<?php echo UPLOADURL;?>prod_images/<?php echo ($row->thumb) ? $row->thumb : "blank.png?v=1";?>" />
								</li>
								<?php foreach($galrow as $grow):?>
								<?php $url = PRODGALURL . $grow->thumb;?>
								<li class="thumbnail">
									<img alt="<?php echo $grow->caption;?>" data-src="<?php echo $url;?>" src="<?php echo $url;?>" />
								</li>
								<?php endforeach;?>


							</ul>
						</div>

						<?php endif;?>

					</div>

					<div class="col-md-5 product-details">
						
						<div class="loading-overlay" style="display: none;">
							<div class="circle-loader"></div>
						</div>

						<div class="bdaction">
							<a href="<?php echo SITEURL;?>/shop">Shop <span class="icon-chevron-right1"></span></a> 
						</div>

						<h2 class="name"><?php echo $row->title;?></h2>
						
						<div id="productsect">
							<div class="add-to-cart-wrap">

								<?php if($row->flag_multiple > 0):?>
								<select class="ddl_variants">
									<?php foreach ( $productVariants as $pvk => $pvv ) { ?>
									<option value="<?php echo $pvv->id; ?>"
										data-title="<?php echo $pvv->title; ?>"
										data-price="<?php echo $pvv->price; ?>"
										data-sale-price="<?php echo $pvv->sale_price; ?>"
										data-dosage="<?php echo $pvv->dosage; ?>">
										<?php echo $pvv->title; ?>
									</option>
									<?php } ?>
								</select>
								<?php endif;?>




								<?php if($row->flag_multiple > 0):?>
								<?php
									$pr_price = $item->getVariantsPrice( $row->id );
									$str_price = $core->formatMoney($pr_price->min_price);
									$str_sale_price = $core->formatMoney($pr_price->sale_min_price);
								?>

								<?php if($pr_price->sale_min_price > 0):?>
								<h2 class="price with-sale">
									<span class="sale-price"><?php echo $str_sale_price; ?></span>
								<?php else:?>
								<h2 class="price">
								<?php endif;?>
									<span class="og-price">
										<?php echo $str_price; ?>
									</span>
								</h2>
								
								<?php else:?>
								
								<?php 
									$str_price = $core->formatMoney($row->price);
									$str_sale_price = $core->formatMoney($row->sale_price);
									$ambassador_price = $core->formatMoney($row->price - $row->price * $ambassador_discount);
								?>
								<h2 class="price" style="width:100%">
									<?php if($ambassador_discount > 0):?>
									<span class="sale-price"><?php echo $str_price; ?></span>
									<?php echo $ambassador_price; ?>
									
									<?php if($row->soldflag == "1" || $row->stock < 1):
									else: ?>
									<span class="icon-diamond link tooltip-content-special-pricing" style="font-size: 90%;"></span>
									<div id="content-special-pricing" class="content-popover" style="display: none;">
										<h5>Special pricing unlocked!</h5>
										<p>Looks like <?php echo($ambassador_name); ?> pulled some strings and got you <strong style="white-space: nowrap;"><?php echo($ambassador_discount * 100 . "%"); ?>&nbsp;off</strong> your purchases!</p>
									</div>
									<?php endif; ?>
									
									<?php else:?>
										<?php if($row->sale_price > 0):?>
										<span class="sale-price"><?php echo $str_sale_price; ?></span>
										<?php endif;?>
										<?php echo $str_price; ?> 
									<?php endif;?>
									
									<?php if($row->soldflag == "1" || $row->stock < 1):?>
									<!--(Out of Stock)-->
									<?php endif; ?>
								</h2>

								<?php endif;?>
								<?php 
									$points = $row->points;
									
									if ($ambassador_discount > 0 ) {
										$points = $points - $points * $ambassador_discount;
									}
								 ?>
								<p>Earn <strong><?php echo $points;?> points</strong> with this purchase <span class="link icon-help-circle tooltip-content-points"></span></p>
								<div id="content-points" class="content-popover" style="display: none;">
									<h5>Reward Yourself.</h5>
									<p>Earn points towards <?php echo $core->company; ?> purchases while unlocking your full potential.</p>
								</div>
								
								
								
								

								<?php //Add to cart section; ?>
								<?php if ($user->logged_in): ?>


                				<?php if($row->soldflag == "1" || $row->stock < 1): else: ?>
								<div class="modifiers">
									
									<div class="quantity-selector clear">
										
										<div class="primary-text fl">
											Quantity
										</div>
										<div class="custom-number-input fr">
											<span class="input-number-decrement">–</span>

											<?php if($row->flag_multiple > 0):?>
											<input id="stockval" class="input-number" type="text" value="1" data-max="<?php echo ($row->stock / $variantStock->dosage);?>" data-stockval="<?php echo $variantStock->dosage;?>" readonly>
											<?php else:?>
											<input id="stockval" class="input-number" type="text" value="1" data-max="<?php echo $row->stock;?>" data-stockval="1" readonly>
											<?php endif;?>

											<span class="input-number-increment">+</span>
										</div>
									</div>
									
									
									
									
									
									
									
								</div>
								<?php endif; ?>


								<?php if($row->soldflag == "1" || $row->stock < 1):?>

								<div class="clear"></div>

					            <div class="product-sold-out-div">
					                <?php
					                $useremail = $db->first("SELECT user_email FROM " . Content::nmTable . " WHERE user_email='{$user->username}' AND pid=".$row->id);
					                if($useremail): ?>
					                <p id="soldOutMsg" class="t24">This item is currently out of stock. You'll receive an email when it's available again.</p>
									<a id="btnNotifyStop" class="t18 btn btn-loader med full-width" data-id="<?php echo $row->pid;?>" data-name="<?php echo $row->title;?>">
									    <span>Stop email notifications</span>
									    <div class="circle-loader"></div>
									</a>
									<a id="btnNotify" class="t18 btn btn-loader med full-width primary" data-id="<?php echo $row->pid;?>" data-name="<?php echo $row->title;?>" style="display: none;">
									    <span>Email me when available</span>
									    <div class="circle-loader"></div>
									</a>
					                <?php
					                else: ?>
									<p id="soldOutMsg" class="t24">This item is currently out of stock.</p>
					                <a id="btnNotify" class="t18 btn btn-loader med full-width primary" data-id="<?php echo $row->pid;?>" data-name="<?php echo $row->title;?>">
					                    <span>Email me when available</span>
					                    <div class="circle-loader"></div>
					                </a>
									<a id="btnNotifyStop" class="t18 btn btn-loader med full-width" data-id="<?php echo $row->pid;?>" data-name="<?php echo $row->title;?>" style="display: none;">
									    <span>Stop email notifications</span>
									    <div class="circle-loader"></div>
									</a>
					                <?php
					                endif;
					                ?>
					            </div>

								<?php else:?>
								<a id="btnAddtoCart" class="t12 btn med primary full-width add-to-cart btn-loader" data-id="<?php echo $row->pid;?>" data-name="<?php echo $row->title;?>">
									<span>Add to Cart</span>
									<div class="circle-loader"></div>
								</a>
								<?php endif;?>


								<?php else:?>
								
								<div class="clear"></div>

								<?php if($row->soldflag == "1" || $row->stock < 1):?>
								<div class="modifiers t18">
									
									
									<div class="quantity-selector clear">
										<div class="primary-text fl">
											Quantity
										</div>
										<div class="custom-number-input fr">
											<span class="input-number-decrement">–</span>

											<?php if($row->flag_multiple > 0):?>
											<input id="stockval" class="input-number" type="text" value="1" data-max="<?php echo ($row->stock / $variantStock->dosage);?>" data-stockval="<?php echo $variantStock->dosage;?>" readonly>
											<?php else:?>
											<input id="stockval" class="input-number" type="text" value="1" data-max="<?php echo $row->stock;?>" data-stockval="1" readonly>
											<?php endif;?>

											<span class="input-number-increment">+</span>
										</div>
									</div>
									
									
								</div>
								<?php endif; ?>
								
								<div class="sign-in-to-purchase t24">
									<a id="user_not_logged_in" class="btn full-width large p24">Login to purchase</a>
								</div>
								
							<?php endif; ?>
							</div>
						</div>
						
						
						

						<?php if($row->soldflag == "1" || $row->stock < 1):?>
							<span class="ribbon flag_soldout">Out of Stock</span>
						<?php elseif($row->flag_sale):?>
							<span class="ribbon flag_sale">On Sale</span>
						<?php endif;?>
						

						<div class="clear"></div>

						<?php echo $description = cleanOut($row->description);?>
						
						
						<?php if($row->id != "8"):?>
						
						<div class="product-attributes">
							
							<div class="row" style="font-size: 1px; text-align: center;">
								<div class="col-4 col-item-icon tooltip" title="Each piece is filled with <?php echo $row->dosage;?>mg of <em>Psilocybe cubensis</em>.">
									<span class="icon ico-shrooms"></span>
									<h6><?php echo $row->dosage;?>mg <br/>/ piece</h6>
								</div>
								<div class="col-4 col-item-icon tooltip" title="Each bag contains <?php echo $row->pieces;?> pieces.">
									<span class="icon ico-capsule ico-cat<?php echo $row->cid;?>"></span>
									<h6><?php echo $row->pieces;?> pieces <br/>/ bag</h6>
								</div>
								<div class="col-4 col-item-icon tooltip" title="<?php if($row->flag_vegan == 1):?>Vegan and <?php endif;?> Organic ingredients.">
									<span class="icon ico-organic"></span>
									<h6>
										<?php if($row->flag_vegan == 1):?>
										Vegan &amp; <br/>
										<?php endif;?>
										Organic
									</h6>
								</div>
							</div>
							
						</div>
						<?php endif;?>
						
						
						
					</div>

				</div>

			</div>
		</section>

		<?php if(cleanOut($row->body)):?>
		<section class="wrapper border-bottom textpad">

			<div class="container max-width">
				<div class="row product-page-extras">
					<?php echo $body = cleanOut($row->body);?>
				</div>
			</div>

		</section>
		<?php endif;?>

		<section class="wrapper more-products products" style="display: none;">
			<div class="container max-width text-center">
				<!-- Begin related product -->
				<?php include( "components/other-products.tpl.php");?>
			</div>
		</section>


	</div>
	
	
	
	<!-- Modals -->
	<div id="modal-login" class="modal-box" style="display: none;">
		<h2>Sign in to purchase</h2>

		<div class="row">
			<div class="col-sm-6">
				<div class="text-center option">
					<p>Already a member?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL;?>/login">Sign In</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="text-center option">
					<p>New to <?php echo $core->site_name; ?>?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL;?>/register">Sign Up</a>
				</div>
			</div>

		</div>
	</div>


	<div id="modal-notify" class="modal-box text-center" style="display: none;">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo THEMEURL;?>/assets/img/icons/ico-mail-yes.svg" style="max-width: 142px;">
				<h3 class="t12 t30">Have no fear! We'll tell you when its here.</h3>
				<p class="big">
					
					You'll receive an email notification once we re-up  on <strong style="white-space: nowrap;"><?php echo $row->title;?></strong>.
				</p>
			</div>
		</div>
	</div>
	
	<div id="modal-notify-stop" class="modal-box text-center" style="display: none;">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo THEMEURL;?>/assets/img/icons/ico-mail-no.svg" style="max-width: 142px;">
				<h3 class="t12 t30">Notifications stopped.</h3>
				<p class="big">
					You will no longer receive email notifications for <strong style="white-space: nowrap;"><?php echo $row->title;?></strong>.
				</p>
			</div>
		</div>
	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

	<script type="text/javascript">
		$(".btn-sold-out").on("click", function() {
			var options = {
				content: 'This product is currently out of stock. Follow @https://www.instagram.com/<?php echo $core->social_instagram;?> on Instagram for updates.',
				autoClose: 9400,
				attributes: {x: 'right', y: 'bottom'},
				addClass:'error'};
			new jBox('Notice', options);
		});
		
		$(".ddl_variants").change(function(){
			var price = $(this).find(":selected").data("price");
			price = "<span class='og-price'>$" + price + "</span>";
			if ($(this).find(":selected").data("sale-price") > 0) {
				var saleprice = $(this).find(":selected").data("sale-price");
				saleprice = "<span class='sale-price'>$" + saleprice + "</span> ";
				$(".price").html(saleprice + price);
			}
			else {
				$(".price").html(price);
			}
		})
		
		// change stock value
		$('.ddl_variants').change(function() {
			var newStockVal = $('.ddl_variants').find(':selected').data('dosage');
			$('#stockval').attr('data-stockval', newStockVal);
		});
		
		if( typeof $( ".ddl_variants" ) != 'undefined' ){
			$( ".ddl_variants" ).val( $(".ddl_variants option:first").val() );
			$( ".ddl_variants" ).trigger( "change" );
		}
	</script>


	<script type="text/javascript">
		
		/* == Modal boxes == */
		var modalNotLoggedIn;
		var modalNotify;
		var modalNotifyStop;
		var modalAmbassador;
		

		$( document ).ready(function() {
			// Modal pops up if user not logged in
			modalNotLoggedIn = new jBox('Modal', {
				attach: '#user_not_logged_in',
				content: $('#modal-login')
			});
			
			// Modal pops up after btn notify pressed
			modalNotify = new jBox('Modal', {
				attach: '#btnNotify',
				content: $('#modal-notify')
			});
			// Modal pops up after btn notify pressed
			modalNotifyStop = new jBox('Modal', {
				attach: '#btnNotifyStop',
				content: $('#modal-notify-stop')
			});
			
			var tooltipSpecialPricing = new jBox('Tooltip', {
				closeOnClick: 'body',
				content: $('#content-special-pricing')
			});
			
			var tooltipPoints = new jBox('Tooltip', {
				closeOnClick: 'body',
				content: $('#content-points')
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
				
				$('.tooltip-content-points').on({
					mouseenter: function () {
						openTooltipPoints($(this));
					},
					mouseleave: function () {
						tooltipPoints.close();
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
				$('.tooltip-content-points').on({
					click: function () {
						openTooltipPoints($(this));
					},
					mouseleave: function () {
						tooltipPoints.close();
					}
				});
			}
			
			// When scrolling on window close box
			$(window).scroll(function() {
				tooltipPoints.close();
				tooltipSpecialPricing.close();
			});
			
			function openTooltipSpecialPricing(el) {
				tooltipSpecialPricing.setContent($('#content-special-pricing')).open({target: el});
			}
			
			function openTooltipPoints(el) {
				tooltipPoints.setContent($('#content-points')).open({target: el});
			}
			
			
			
		});


		$( window ).resize(function() {
			modalNotLoggedIn.close();
			modalNotify.close();
			modalNotifyStop.close();
		});
		
		/* == Notify Me function == */
		$('body').on('click', '#btnNotify', function(event) {
		    event.preventDefault();
		    var id = $(this).attr("data-id"),
		    $this = $(this);
			
		    $.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/cart.php",
				data: {
					'notifyMe': 1,
					'id': id,
					'description': $(this).attr("data-name")
				},
				beforeSend: function() {
					$(".loading-overlay").show();
				},
				success: function(json) {
					$this.removeClass("loading");
					$("#btnNotify").hide();
					$("#btnNotifyStop").show();
					$("#soldOutMsg").html("This item is currently out of stock. You'll receive an email when it's available again.");
					console.log("user will be notified");
					$(".loading-overlay").fadeOut(100);
				},
				error: function() {
					$this.removeClass("loading");
					console.log("error t");
				}
			});
		
		});
		/* == Stop Notify Me function == */
		$('body').on('click', '#btnNotifyStop', function(event) {
		    event.preventDefault();
		    var id = $(this).attr("data-id"),
		    $this = $(this);
			
		    $.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/cart.php",
				data: {
					'notifyMeStop': 1,
					'id': id,
					'description': $(this).attr("data-name")
				},
				beforeSend: function() {
					$(".loading-overlay").show();
				},
				success: function(json) {
					$this.removeClass("loading");
					$("#btnNotifyStop").hide();
					$("#btnNotify").show();
					$("#soldOutMsg").html("This item is currently out of stock.");
					console.log("user will NOT be notified");
					$(".loading-overlay").fadeOut(100);
				},
				error: function() {
					$this.removeClass("loading");
					console.log("error adding notification");
				}
			});
		
		});
	</script>
	
	<!-- Mailing Modal -->
	<?php include('components/modal-mailinglist.tpl.php'); ?>
	<?php include('components/modal-ambassador.tpl.php'); ?>

</body>

</html>
