<?php
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');
    
    
    $cart = $content->getWholesaleCart();
?>
<?php $_SESSION["pageurl"] = "wholesale?p=cart"; ?>


<div class="main">

	<!-- Checkout / Shipping -->
	<section class="wrapper cart-padding padded mini bg-lightgrey padded-b-120">

		<!-- Checkout Nav -->
		<ul class="checkout-progress">
			<li class="active">Delivery Options</li>
			<li>Payment</li>
			<li>Invoice</li>
		</ul>

		<div class="container max-width extended2">

			<div class="row">
				<div class="col-sm-12 col-md-5 order-md-1">
					<div class="cart-wrapper receipt">
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
								foreach ($cartdata as $crtrow) :
							?>
							<div class="item row flexcenter" id="row-<?php echo $crtrow->pid; ?>">
								<div class="col-3">
									<img class="block p-img" alt="<?php echo $crtrow->title; ?>" src="<?php echo UPLOADURL; ?>prod_images/<?php echo $crtrow->thumb; ?>">
								</div>
								<div class="col-9">
									<p class="p-name">
										<span><?php echo $crtrow->title;?></span>
									</p>
									<?php if ($crtrow->pvtitle): ?>
									<p class="pv-name"><span><?php echo $crtrow->pvtitle; ?></span></p>
									<?php endif ?>
									<?php $price = $crtrow->pvprice != null ? $crtrow->pvprice : $crtrow->price; ?>
									<?php
										$discount = '';
										if(in_array($crtrow->pid, $product_list)){
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
									<p class="p-deets"><span class="quantity"><?php echo $crtrow->qty; ?></span> x <span class="original-price <?php echo $discount != '' ? 'before-op' : ''; ?>">$<?php echo $price; ?></span><span class="new-price"><?php echo $discount != '' ? '$'.$discount : ''; ?></span></p>
								</div>
							</div>
							<?php endforeach; ?>
							<?php endif; ?>
							<?php endif ?>
						</div>


						<div class="coupon-checkout t12 p24 border-top">
							<div class="loading-overlay">
								<div class="circle-loader"></div>
							</div>
							<label class="t18 p6 inline-block">Employee IDN #</label>
							<div class="input-coupon<?php echo ($cart->discount_code) ? " coupon_applied": "";?>">
								<input id="discount_code" type="text" name="discount_code" autocapitalize="characters" value="<?php echo($cart->discount_code); ?>"/>
								<a class="btn primary p30" id="verify-code">
									<span class="ico-arrow-right-2"></span>
								</a>
							</div>
							
							
						</div>


						<div class="receipt-summary">
							
							<div class="table receipt-sect">
								
								<div class="trow">
									<div class="cell">Subtotal:</div>
									<div id="stotal" class="cell"><?php echo $core->formatMoney($cart->originalprice, 2);?></div>
								</div>
								
								<div class="trow bold cp-section" <?php if($cart->coupon == 0) { echo 'style="display:none"';}?>>
									<div class="cell">Discount:</div>
									<div id="cptotal" class="cell receipt-h">($<?php echo money_format('%i', $cart->coupon);?>)</div>
								</div>
							
								
								<div class="trow">
									<div class="cell">Shipping:</div>
									<div id="shipping" class="cell receipt-hs"><?php echo $core->formatMoney($cart->shipping, 2); ?></div>
								</div>
								
								
								<div class="trow t-pad-bot">
									<div class="cell">Tax:</div>
									<div id="taxtotal" class="cell">$<?php echo money_format('%i', $cart->totaltax);?></div>
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

						<h2 class="t0 title p42">Delivery Options</h2>
						
						
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label for="company">Company (C/O)</label>
									<input id="company" class="readonly" type="text" name="company" value="Torontos Dopest Dispensary" data-validetta="required,minLength[2]" readonly/>
								</div>
							</div>
						</div>
						

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
										<option value="US" disabled>United States</option>
										<option value="CA" selected>Canada</option>
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
									<input id="shipping_address_line_2" type="text" name="address_line_2" value="<?php echo $shipping_address2;?>" />
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
									<label for="shipping_state">Province</label>
									<select id="shipping_state" name="state" data-validetta="required">
										<option value="" disabled selected></option>
										<?php $provRow = $content->getProvinces(); ?>
										<?php foreach ($provRow as $prrow): ?>
										<option value="<?php echo($prrow->abbr); ?>" data-cost="<?php echo($prrow->shipping_cost); ?>" <?php echo $shipping_state == $prrow->abbr ? 'selected' : ''?>><?php echo($prrow->abbr); ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<?php if ($cart->zip) { $shipping_zip = $cart->zip; }else { $shipping_zip = $row->zip; } ?>
								<div class="col-6 col-md-4">
									<label for="shipping_zip">Postal Code</label>
									<input id="shipping_zip" type="text" name="shipping_zip" value="<?php echo $shipping_zip;?>" data-validetta="required,minLength[2]"/>
								</div>
							</div>
						</div>

						<?php if ($cart->phone) { $shipping_phone = $cart->phone; }else { $shipping_phone = $row->phone; } ?>
						<div class="form-group">
							<label for="shipping_telephone">Telephone (Optional)</label>
							<input id="shipping_telephone" type="text" name="shipping_telephone" value="<?php echo $shipping_phone;?>" />
						</div>


						<h5 class="t60">Delivery Options</h5>
						<?php
							
							$shipping_standard_dis = 0;
							$shipping_express_dis = $content->calculateWholesaleExpressShipping($shipping_state);
							
							// Check if shipping is free
							if (($cart->originalprice - $cart->coupon) < $core->shipping_free_flag ) {
								$isFree = 0;
							}else {
								$isFree = 1;
							}
						 ?>
						
						
						
						<!-- Shipping options -->
						
						
						<label class="radio-wrapper form-group" for="shipping_economy">
							<span class="radio-option-title">
								Economy Shipping - <span id="shipping_economy_dis">FREE</span>
							</span>
							<span class="radio-option-body">
								Estimated delivery <?php echo date('M j', strtotime("+4 weekdays")); ?> - <?php echo date('M j', strtotime("+10 weekdays")); ?>
							</span>
							<div class="radio-button">
								<input class="radio-option-input radio-option-shipping" type="radio" name="shipping_class" id="shipping_economy" shipping-type="economy" value="<?php echo $shipping_standard_dis;?>" <?php echo((number_format($cart->shipping, 2) == number_format($shipping_standard_dis, 2) || $cart->shipping == '0') ? 'checked': '');?> data-validetta="required">
								<label for="shipping_economy"></label>
							</div>
						</label>
						
						<label class="radio-wrapper form-group" for="shipping_two-day">
							<span class="radio-option-title">
								Express Shipping - <span id="shipping_express_dis"><?php echo $core->formatMoney($shipping_express_dis); ?></span>
							</span>
							<span class="radio-option-body">
								Estimated delivery <?php echo date('M j', strtotime("+2 weekdays")); ?> - <?php echo date('M j', strtotime("+5 weekdays")); ?>
							</span>
							<div class="radio-button">
								<input class="radio-option-input radio-option-shipping" type="radio" name="shipping_class" id="shipping_two-day" shipping-type="express" value="<?php echo $shipping_express_dis;?>" <?php echo((sprintf($cart->shipping) == sprintf($shipping_express_dis)) ? 'checked': '');?> data-validetta="required">
								<label for="shipping_two-day"></label>
							</div>
						</label>
						
						<label id="shipping_pickup_option" class="radio-wrapper form-group" for="shipping_pickup">
							<span class="radio-option-title">
								Local Pickup / Delivery - <span id="shipping_pickup_dis">FREE</span>
							</span>
							<span class="radio-option-body">
								Estimated delivery <?php echo date('M j', strtotime("+4 weekdays")); ?> - <?php echo date('M j', strtotime("+10 weekdays")); ?>
							</span>
							<div class="radio-button">
								<input class="radio-option-input radio-option-shipping" type="radio" name="shipping_class" id="shipping_pickup" shipping-type="pickup" value="<?php echo $shipping_standard_dis;?>" <?php echo((number_format($cart->shipping, 2) == number_format($shipping_standard_dis, 2) || $cart->shipping == '0') ? 'checked': '');?> data-validetta="required">
								<label for="shipping_pickup"></label>
							</div>
						</label>
						
						
						
						<button id="continuePayment" class="continuePayment btn med btn primary btn-loader t30 p24" type="submit">
							<span>Continue to payment options</span>
							<div class="circle-loader"></div>
						</button>
						
						
						

					</form>

					<a class="block t30 p30" href="<?php echo SITEURL; ?>/wholesale?p=cart"><span class="icon-chevron-left"></span> Return to cart</a>
				</div>
			</div>
		</div>
	</section>


</div>


<?php require(THEMEDIR . "/components/scripts.tpl.php"); ?>


<script type="text/javascript">
	
	function updateShippingCost() {
		
		var shippingCost = $("input[name='shipping_class']:checked").val();
		var shippingType = $("input[name='shipping_class']:checked").attr("shipping-type");
		var selected = $("#shipping_state").find('option:selected');
		
		$.ajax({
			type: "post",
			url: SITEURL + "/ajax/shipping.php",
			dataType: 'json',
			data: {
				'updateWholeCartCartShipping': 1,
				'shipping': shippingCost,
				'name': $("#shipping_name").val(),
				'country': $("#shipping_country").val(),
				'address': $("#shipping_address_line_1").val(),
				'address2': $("#shipping_address_line_2").val(),
				'city': $("#shipping_city").val(),
				'state': $("#shipping_state").val(),
				'zip': $("#shipping_zip").val(),
				'shipping_telephone': $("#shipping_telephone").val(),
				'discount_code': $("#discount_code").val(),
				'shipping_type': shippingType
			},
			success: function(json) {
				if (json.type == "success") {
					$("#cptotal").html("(" + json.ctotal + ")").fadeIn("slow");
					$("#gtotal").html(json.gtotal).fadeIn("slow");
					$("#stotal").html(json.subt).fadeIn("slow");
					$("#taxtotal").html(json.tax).fadeIn("slow");
					$("#shipping").html(json.shipping).fadeIn("slow");
		
					$(".receipt-hs").addClass("highlight");
		
					setTimeout(function() {
						$(".receipt-hs").removeClass("highlight");
					}, 800);
				}
				else {
					$("#javascript-box").append(json.message);
				}
			},
			error: function(json) {
				console.log("Error: " + json.msg);
			}
		});
	 }
	 
	 
	 $(".radio-option-shipping").click(function() {
		updateShippingCost();
	 });
	
	/* == Shipping dynamic pricing == */
	$('#shipping_state').on('change', function(){

		var selected = $(this).find('option:selected');
		var state = selected.val();
		
		
		if (state == "ON") {
			$("#shipping_pickup_option").show();
		}else {
			$("#shipping_pickup_option").hide();
		}
		
		
	});
	
	if (!$("input[name='shipping_class']:checked").val()) {
	   $( "#shipping_economy" ).trigger( "click" );
	}


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
						'wholesaleCheckout': 1,
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
							redirect(SITEURL + "/wholesale?p=payment");
						}
					},
					error: function(json) {
						$(".continuePayment").removeClass("loading");
						console.log('error ' + json.message);
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

		/* Verify Employee IDN */
		$(".input-coupon").on("click", function() {
			$(this).removeClass('coupon_applied');
		});
		
		
		/* Verify Employee IDN */
		$("#verify-code").on("click", function() {
		
			if($('#discount_code').val() != ''){
				$.ajax({
					type: "post",
					url: SITEURL + "/ajax/employee-idn.php",
					dataType: 'json',
					data: {
						'employee_idn': $('#discount_code').val(),
						'state': $("#shipping_state").val()
					},
					beforeSend: function() {
						$("#verify-code").addClass("disabled");
						$(".loading-overlay").show();
					},
					success: function(json) {
						
						$(".loading-overlay").hide();
						
						$("#verify-code").removeClass("disabled");
		
						if (json.type == "success") {
							
							$(".original-price").removeClass("before-op");
							
							if(typeof json.discount_type != 'undefined' && json.discount_type == "product"){
								$(".new-price").empty();
								var data = json.discount_amount;
								$.each(data, function(i, item) {
									$('#row-'+i).find('.original-price').addClass('before-op');
									$('#row-'+i).find('.new-price').text('').text('$'+item);
								});
			                }
							$(".cp-section").show();
							$("#cptotal").html("(" + json.ctotal + ")").fadeIn("slow");
							$("#gtotal").html(json.gtotal).fadeIn("slow");
							$("#pointsearned").html(json.pointsearned).fadeIn("slow");
							$("#stotal").html(json.subt).fadeIn("slow");
							$("#taxtotal").html(json.tax).fadeIn("slow");
		
							$(".input-coupon").addClass("coupon_applied");
		
							$(".receipt-h").addClass("highlight");
							$("#javascript-box").append(json.message);
		
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
		});
		
		$( "#discount_code" ).keypress(function() {
			$("#discount_code").removeClass('_error _empty');
		});

</script>
