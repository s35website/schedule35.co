<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "shipping"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-checkout" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>


	<div class="main">

		<!-- Checkout / Shipping -->
		<section class="wrapper cart-padding padded mini bg-lightgrey padded-b-120">

			<!-- Checkout Nav -->
			<ul class="checkout-progress">
				<li class="active">Checkout</li>
				<li>Payment</li>
				<li>Invoice</li>
			</ul>

			<div class="container max-width extended2">

				<div class="row">
					<div class="col-sm-12 col-md-5 order-md-1">
						<div class="cart-wrapper receipt">
							
							<div class="loading-overlay">
								<div class="circle-loader"></div>
							</div>
							
							<h5>Order Summary</h5>

							<div class="mini-cart p30">
								<?php if ($content->getCartCounterBasic() == 0): ?>
								<p class="empty-text">You have no items in your cart.</p>
								<?php else: ?>
								<?php $cartdata = $content->renderCart(); ?>
								<?php if ($cartdata) : ?>
								<?php
									$coupon_data = $db->first("SELECT discount, type, coupon_applied_on, product_list FROM " . Content::cpTable . " WHERE code = '" . $db->escape($cart->discount_code) . "' AND active = '1'");
									$product_list = isset($coupon_data->product_list) ? explode(',', $coupon_data->product_list) : array();
									foreach ($cartdata as $cartrow) :
								?>
								<div class="item row flexcenter" id="row-<?php echo $cartrow->pid; ?>">
									<div class="col-3">
										<img class="block p-img" alt="<?php echo $cartrow->title; ?>" src="<?php echo UPLOADURL; ?>prod_images/<?php echo $cartrow->thumb; ?>">
									</div>
									<div class="col-9">
										<p class="p-name">
											<span><?php echo $cartrow->title;?></span>
										</p>
										<?php if ($cartrow->pvtitle): ?>
										<p class="pv-name"><span><?php echo $cartrow->pvtitle; ?></span></p>
										<?php endif ?>
										<?php $price = $cartrow->pvprice != null ? $cartrow->pvprice : $cartrow->price; ?>
										<?php
											$discount = '';
											if(in_array($cartrow->pid, $product_list)){
											if ($coupon_data->type == 0):
											$discount = number_format($price - (($price * $coupon_data->discount) / 100),2);
											else:
											if($coupon_data->discount >= $price ){
											$p_dis = $price;
											}else{
											$p_dis = number_format($coupon_data->discount, 2);
											}
											$discount = number_format($price - $p_dis,2);
											endif;
										} ?>
										<p class="p-deets"><span class="quantity"><?php echo $cartrow->qty; ?></span> x <span class="original-price <?php echo $discount != '' ? 'before-op' : ''; ?>">$<?php echo $price; ?></span><span class="new-price"><?php echo $discount != '' ? '$'.$discount : ''; ?></span></p>
									</div>
								</div>
								<?php endforeach; ?>
								<?php endif; ?>
								<?php endif ?>
							</div>


							<div class="coupon-checkout t12 p24 border-top border-bottom">
								
								<span class="t18 p6 inline-block italic">Have a Promo Code?</span>
								<div class="input-coupon<?php echo ($cart->discount_code) ? " coupon_applied": "";?>">
									<input id="discount_code" type="text" name="discount_code" autocapitalize="characters" value="<?php echo($cart->discount_code); ?>"/>
									<a class="btn primary p30" id="verify-code">
										<span class="ico-arrow-right-2"></span>
									</a>
								</div>
								
								
							</div>


							<div class="receipt-summary">
								
								<div class="t12">
									Earn <span id="pointsearned"><?php echo $cart->points;?> pts</span> with this order.
								</div>
								
								<div class="table receipt-sect">
									
									<div class="trow">
										<div class="cell">Subtotal:</div>
										<div id="stotal" class="cell"><?php echo $core->formatMoney($cart->originalprice, 2);?></div>
									</div>
									
									<div class="trow bold coupon-r" <?php echo(($cart->coupon == 0) ? 'style="display:none"': '');?>>
										<div class="cell">Discount:</div>
										<div id="cptotal" class="cell receipt-h">(<?php echo(formatMonies($cart->coupon)); ?>)</div>
									</div>
									
									
									
									<div class="trow">
										<div class="cell">Shipping:</div>
										<div id="shipping" class="cell receipt-hs"><?php echo $core->formatMoney($cart->shipping, 2); ?></div>
									</div>
									
									<div class="trow t-pad-bot">
										<div class="cell">Tax:</div>
										<div id="taxtotal" class="cell"><?php echo(formatMonies($cart->totaltax)); ?></div>
									</div>
									
									<div class="trow t-pad-top t-pad-bot">
										<div class="cell border-top border-bottom">Total:</div>
										<div id="gtotal" class="cell border-top border-bottom"><?php echo $core->formatMoney($cart->totalprice, 2);?></div>
									</div>
									
								</div>
								
								
								
							</div>


						</div>
					</div>

					<div class="col-sm-12 col-md-7 order-md-0">
						<form id="form-validetta-checkout" method="post" class="cart-wrapper">
							
							<h2 class="t0 title p42">Checkout</h2>

							<h5>Shipping Address</h5>


							<?php if ($cart->name) { $shipping_name = $cart->name; }else { $shipping_name = $row->fname . " " . $row->lname; } ?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12">
										<label for="shipping_name">Full Name</label>
										<input id="shipping_name" type="text" name="name" value="<?php echo $shipping_name;?>" data-validetta="required,minLength[2]"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-sm-12">
										<label for="shipping_country">Country</label>
										<select id="shipping_country" name="country">
											<option value="US" selected>United States</option>
											<option value="CA" disabled>Canada</option>
										</select>
									</div>
								</div>
							</div>

							<?php if ($cart->address) { $shipping_address = $cart->address; }else { $shipping_address = $row->address; } ?>
							<?php if ($cart->address2) { $shipping_address2 = $cart->address2; }else { $shipping_address2 = $row->address2; } ?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12 col-md-8">
										<label for="shipping_address_line_1">Address</label>
										<input id="shipping_address_line_1" type="text" name="address_line_1" value="<?php echo $shipping_address;?>" data-validetta="required,minLength[2]"/>
									</div>
									<div class="col-sm-12 col-md-4">
										<label for="shipping_address_line_2">Apt / Suite #</label>
										<input id="shipping_address_line_2" type="text" name="address_line_2" value="<?php echo $shipping_address2;?>" maxlength="20" />
									</div>
								</div>
							</div>

							<?php if ($cart->city) { $shipping_city = $cart->city; }else { $shipping_city = $row->city; } ?>
							<?php if ($cart->state) { $shipping_state = $cart->state; }else { $shipping_state = $row->state; } ?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12 col-md-4">
										<label for="shipping_city">City</label>
										<input id="shipping_city" type="text" name="city" value="<?php echo $shipping_city;?>" data-validetta="required,minLength[2]"/>
									</div>
									<div class="col-6 col-md-4">
										
										<label for="shipping_state">State</label>
										<select id="shipping_state" name="state" data-validetta="required">
											<option value="" disabled selected>State</option>
											
											<?php $provRow = $content->getStates(); ?>
											<?php foreach ($provRow as $prrow): ?>
											<option value="<?php echo($prrow->abbr); ?>" data-cost="<?php echo($prrow->shipping_cost); ?>" <?php echo $shipping_state == $prrow->abbr ? 'selected' : ''?>><?php echo($prrow->name); ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<?php if ($cart->zip) { $shipping_zip = $cart->zip; }else { $shipping_zip = $row->zip; } ?>
									<div class="col-6 col-md-4">
										<label for="shipping_zip">Zip Code</label>
										<input id="shipping_zip" type="text" name="shipping_zip" value="<?php echo $shipping_zip;?>" data-validetta="required,minLength[2]"/>
									</div>
								</div>
							</div>

							<?php if ($cart->phone) { $shipping_phone = $cart->phone; }else { $shipping_phone = $row->phone; } ?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12">
										<label for="shipping_telephone">Telephone (Optional)</label>
										<input id="shipping_telephone" type="text" name="shipping_telephone" value="<?php echo $shipping_phone;?>"/>
									</div>
								</div>
							</div>
							
							
							<div class="form-group">
								<label for="shipping_note">Notes / Buzzer</label>
								<textarea style="max-width: 100%;min-width: 100%;min-height: 120px;"></textarea>
							</div>


							<h5 class="t60">Shipping Options</h5>
							<?php
								
								$shipping_standard_dis = $content->calculateStandardShipping($shipping_state);
								$shipping_express_dis = $content->calculateExpressShipping($shipping_state);
								
								
								// Check if shipping is free
								if (($cart->originalprice - $cart->coupon) < $core->shipping_free_flag ) {
									$isFree = 0;
								}else {
									$isFree = 1;
								}
							 ?>
							 
							 

							<label class="radio-wrapper form-group" for="shipping_economy">
								<span class="radio-option-title">
									Expedited Shipping -
									<span id="shipping_economy_dis">
									<?php echo $core->formatMoney($shipping_standard_dis, 2); ?>
									</span>
								</span>
								<span class="radio-option-body">
									Estimated delivery <?php echo date('M j', strtotime("+4 weekdays")); ?> - <?php echo date('M j', strtotime("+10 weekdays")); ?>
								</span>
								<div class="radio-button">
									<input class="radio-option-input radio-option-shipping" type="radio" name="shipping_class" id="shipping_economy" value="0" <?php echo($cart->shipping_type != 1 ? 'checked': '');?> data-validetta="required">
									<label for="shipping_economy"></label>
								</div>


							</label>

							<label class="radio-wrapper form-group" for="shipping_two-day" style="display: none;">
								<span class="radio-option-title">
									Express Shipping - <span id="shipping_express_dis"><?php echo $core->formatMoney($shipping_express_dis); ?></span>
								</span>
								<span class="radio-option-body">
									Estimated delivery <?php echo date('M j', strtotime("+2 weekdays")); ?> - <?php echo date('M j', strtotime("+5 weekdays")); ?>
								</span>
								<div class="radio-button">
									<input class="radio-option-input radio-option-shipping" type="radio" name="shipping_class" id="shipping_two-day" value="1" <?php echo($cart->shipping_type == 1 ? 'checked': '');?> data-validetta="required">
									<label for="shipping_two-day"></label>
								</div>
							</label>
							
							<?php if ($content->getMeltable() == 1): ?>
							
								<div class="heat-warning-box">
									
									<h5 class="t24 p12">Delivery Location</h5>
									
									<p class="small">By choosing to have your products delivered to your mailbox, you agree that <strong>any melted products will not be refunded</strong>.</p>
									
									<label class="radio-wrapper form-group" for="heatwarning_0">
										<span class="radio-option-title" style="font-size: 18px;">
											Deliver <strong>directly to me<sup>1</sup></strong>.
										</span>
										<span class="radio-option-body">
											<sup>1</sup>Do not choose this option if your mailbox is outside. Melted products <strong>will not</strong> be refunded.
										</span>
										<div class="radio-button">
											<input class="radio-option-input radio-option-heatwarning" type="radio" name="heatwarning_opt" id="heatwarning_0" value="0" <?php echo(($cart->heatflag == null || $cart->heatflag == '0') ? 'checked': '');?> data-validetta="required">
											<label for="heatwarning_0"></label>
										</div>
		
									</label>
		
									<label class="radio-wrapper form-group" for="heatwarning_1">
										<span class="radio-option-title" style="font-size: 18px;">
											Ship to the <strong>local post office<sup>2</sup></strong>.
										</span>
										<span class="radio-option-body">
											<sup>2</sup>If any of your products come melted, take a photo and we'll reship your order or provide a full refund.
										</span>
										<div class="radio-button">
											<input class="radio-option-input radio-option-heatwarning" type="radio" name="heatwarning_opt" id="heatwarning_1" value="1" <?php echo(($cart->heatflag == '1') ? 'checked': '');?> data-validetta="required">
											<label for="heatwarning_1"></label>
										</div>
									</label>
								</div>
								
								
								<div id="modal-heat-warning" class="modal-box" style="display: none;">
									<div class="padding">
										<h2 class="p0">It's getting hot outside!</h2>
										
										<img src="<?php echo THEMEURL;?>/assets/img/checkout/invite_mailbox_loop.gif" alt="" />
										<p class="t30 p72 text-center">
											By choosing to have your products delivered to your mailbox, you agree that <strong>any melted products will not be refunded</strong>.
										</p>
									</div>
									<div class="modal-footer">
										<button id="btnCloseModal" class="btn disabled">Cancel</button><button id="btnContinue" class="btn primary">I understand</button>
									</div>
								</div>
								
								<input type="hidden" name="heatwarning_opt" id="heatwarning_opt" value="0" />
								
								
								<?php if ($cart->heatflag == 0): ?>
								<!-- Meltable warning -->
								<a class="btn med btn primary t30 p24" id="heat_warning_first">Continue to payment</a>
								
								<button id="continuePayment" class="continuePayment btn med btn primary btn-loader t30 p24" type="submit" style="display: none">
									<span>Continue to payment</span>
									<div class="circle-loader"></div>
								</button>
								<?php else: ?>
								<!-- Meltable warning -->
								<a class="btn med btn primary t30 p24" id="heat_warning_first" style="display: none">Continue to payment</a>
								
								<button id="continuePayment" class="continuePayment btn med btn primary btn-loader t30 p24" type="submit">
									<span>Continue to payment</span>
									<div class="circle-loader"></div>
								</button>
								<?php endif ?>

							<?php else: ?>
								<!-- Continue to payment -->
								<button id="continuePayment" class="continuePayment btn med btn primary btn-loader t30 p24" type="submit">
									<span>Continue to payment</span>
									<div class="circle-loader"></div>
								</button>
							<?php endif ?>

						</form>

						<a class="block t30 p30" href="<?php echo SITEURL; ?>/cart"><span class="icon-chevron-left"></span> Return to cart</a>
					</div>
				</div>
			</div>
		</section>

		<?php if( ($cart->originalprice - $cart->coupon) < $core->shipping_free_flag):?>
		<!-- Banner -->
		<div class="banner">
			<span class="banner-message">Free shipping on orders <a>over $<?php echo number_format($core->shipping_free_flag, 0);?></a></span>
			</span>
		</div>
		<?php endif;?>

	</div>


	<div class="footer-pad">
		<?php require('components/footer-simple.tpl.php'); ?>
	</div>
	<?php require('components/scripts.tpl.php'); ?>

	<style>
		.warning._empty input[type="radio"] + label:after {
			border-color: red;
		}
	</style>


	<script type="text/javascript">
        
		<?php if ($content->getMeltable() > 0): ?>
		// Heat warning modal
		var myModal;
		$( document ).ready(function() {
			myModal = new jBox('Modal', {
				attach: '#heat_warning_first',
				content: $('#modal-heat-warning')
			});
		});
		
		$("#btnCloseModal").on( "click", function() {
			myModal.close();
		});

		$( "#btnContinue" ).on( "click", function() {

			$("#modal-heat-warning .warning").removeClass("_empty");
			
			myModal.close();
			$("#heat_warning_first").hide();
			$('#continuePayment').show();
			$('#continuePayment').trigger('click');
		});
		
		
		$('input[type=radio][name=heatwarning_opt]').change(function() {
			if (this.value == '1') {
				$("#heatwarning_opt").val("1");
				$("#heat_warning_first").hide();
				$('#continuePayment').show();
			}else {
				$("#heatwarning_opt").val("0");
				$("#heat_warning_first").show();
				$('#continuePayment').hide();
			}
		});
		
		<?php endif;?>
		
		
		function updateDiscount() {
			if($('#discount_code').val() != ''){
				$.ajax({
					type: "post",
					url: SITEURL + "/ajax/coupon.php",
					dataType: 'json',
					data: {
						'discount_code': $('#discount_code').val()
					},
					beforeSend: function() {
						$(".loading-overlay").show();
						$("#verify-code").addClass("disabled");
						
					},
					success: function(json) {
						$(".loading-overlay").hide();
						$(".coupon-r").show();
						
						$("#verify-code").removeClass("disabled");
		
						if (json.type == "success") {
							console.log("coupon works")
							$(".original-price").removeClass("before-op");
							
							if(typeof json.discount_type != 'undefined' && json.discount_type == "product"){
								$(".new-price").empty();
								var data = json.discount_amount;
								$.each(data, function(i, item) {
									$('#row-'+i).find('.original-price').addClass('before-op');
									$('#row-'+i).find('.new-price').text('').text('$'+item);
								});
			                }
							$("#cptotal").html("(" + json.ctotal + ")").fadeIn("slow");
							$("#gtotal").html(json.gtotal).fadeIn("slow");
							$("#pointsearned").html(json.pointsearned).fadeIn("slow");
							$("#stotal").html(json.subt).fadeIn("slow");
							$("#taxtotal").html(json.tax).fadeIn("slow");
		
							$(".input-coupon").addClass("coupon_applied");
		
							$(".receipt-h").addClass("highlight");
							//$("#javascript-box").append(json.message);
		
							setTimeout(function() {
								$(".receipt-h").removeClass("highlight");
							}, 800);
						}
						else {
							$("#javascript-box").append(json.message);
						}
					},
					error: function(json) {
						console.log("Error");
					}
				});
			}
			else {
				$("#discount_code").addClass('_error _empty');
			}
		}
		
		
		function updateShippingCost() {
			var shippingType = $("input[name='shipping_class']:checked").val();
			var shipping_province_cost = $("#shipping_state").find('option:selected').data('cost');
			
			console.log(shipping_province_cost);
			
			$.ajax({
				type: "post",
				url: SITEURL + "/ajax/shipping.php",
				dataType: 'json',
				data: {
					'updateCartShipping': 1,
					'shipping_type': shippingType,
					'name': $("#shipping_name").val(),
					'country': $("#shipping_country").val(),
					'address': $("#shipping_address_line_1").val(),
					'address2': $("#shipping_address_line_2").val(),
					'city': $("#shipping_city").val(),
					'state': $("#shipping_state").val(),
					'zip': $("#shipping_zip").val(),
					'shipping_telephone': $("#shipping_telephone").val(),
					'discount_code': $("#discount_code").val()
				},
				beforeSend: function() {
					$(".loading-overlay").show();
				},
				success: function(json) {
					$(".loading-overlay").hide();
					if (json.type == "success") {
						$("#cptotal").html("(" + json.ctotal + ")").fadeIn("slow");
						$("#gtotal").html(json.gtotal).fadeIn("slow");
						$("#stotal").html(json.subt).fadeIn("slow");
						$("#taxtotal").html(json.tax).fadeIn("slow");
						$("#shipping").html(json.shipping).fadeIn("slow");
			
						$(".receipt-hs").addClass("highlight");
			
						setTimeout(function() {
							$(".receipt-hs").removeClass("highlight");
						}, 400);
					}
					else {
						$("#javascript-box").append(json.message);
					}
				},
				error: function(json) {
					console.log("ErrorUS: " + json.msg);
				}
			});
		 }
		 
		 
		 $(".radio-option-shipping").click(function() {
			updateShippingCost();
		 });
		
		/* == Shipping dynamic pricing == */
		$('#shipping_state').on('change', function(){
			var shipping_province_cost = $(this).find('option:selected').data('cost');
			console.log("shipping_province_cost" + shipping_province_cost);
			var shippingFree = <?php echo($isFree); ?>;
			
			updateShippingCost();
			
		});
		
		
		/* Checkout */
		$('#form-validetta-checkout').validetta({
			showErrorMessages : false,
			errorClass : '_error',
			onValid : function( event ) {
				event.preventDefault(); // Will prevent the submission of the form
		
				$.ajax({
					type: "post",
					dataType: 'json',
					url: SITEURL + "/ajax/checkout.php",
					data: {
						'checkout': 1,
						'name': $("#shipping_name").val(),
						'country': $("#shipping_country").val(),
						'address': $("#shipping_address_line_1").val(),
						'address2': $("#shipping_address_line_2").val(),
						'city': $("#shipping_city").val(),
						'state': $("#shipping_state").val(),
						'zip': $("#shipping_zip").val(),
						'discount_code': $("#discount_code").val(),
						'shipping_telephone': $("#shipping_telephone").val(),
						'heatwarning_opt': $("#heatwarning_opt").val()
					},
					beforeSend: function() {
						$(".continuePayment").addClass("loading");
					},
					success: function(json) {
						if (json.type == "success") {
							redirect(SITEURL + "/payment");
						}
					},
					error: function(json) {
						$(".continuePayment").removeClass("loading");
						console.log('error1 ' + json.message);
					}
				});
		
			},
			onError : function( event ){
				event.preventDefault(); // Will prevent the submission of the form
				console.log("error");
		
				var options = {
					content: 'Please make sure all fields are filled out correctly.',
					autoClose: 4200,
					attributes: {x: 'right', y: 'bottom'},
					addClass:'error'};
				new jBox('Notice', options);
		
			}
		});
		
		
		
		/* Verify Coupon Code */
		$(".input-coupon").on("click", function() {
			$(this).removeClass('coupon_applied');
		});
		
		
		/* Verify Coupon Code */
		$("#verify-code").on("click", function() {
			updateDiscount();
		});
		
		$( "#discount_code" ).keypress(function() {
			$("#discount_code").removeClass('_error _empty');
		});
		
		
		$( document ).ready(function() {
			updateShippingCost();
		});
		
		
	</script>

</body>

</html>
