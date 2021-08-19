<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "payment"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-checkout" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<?php
		$paypal_cartrow = $content->getCartContent();
		$totalrow = $content->getCartTotal();
		$discount = $totalrow->total - $totalrow->coupon;

		if (!$paypal_cartrow)
		    redirect_to("cart");
	?>

	<div class="main">

		<section class="wrapper cart-padding padded mini bg-lightgrey padded-b-120">

			<!-- Checkout Nav -->
			<ul class="checkout-progress">
				<li class="active">Checkout</li>
				<li class="active">Payment</li>
				<li>Invoice</li>
			</ul>

			<div class="container max-width">


				<div class="row">
					<div class="col-sm-12 col-md-4 order-md-1 mobile-hide">
						<div class="cart-wrapper receipt t30">
							<h5>Order Summary</h5>

							<div id="normalpay-display" class="receipt-summary" style="max-width: 320px;">
								
								<div class="t12 border-top" style="padding-top: 12px;">
									Earn <span id="pointsearned"><?php echo $cart->points;?> pts</span> with this order.
								</div>
								
								<div class="table receipt-sect">
									
									<div class="trow">
										<div class="cell">Subtotal:</div>
										<div id="stotal" class="cell">$<?php echo number_format($cart->originalprice, 2);?></div>
									</div>
									
									<div class="trow bold">
										<div class="cell">Discount:</div>
										<div id="cptotal" class="cell">($<?php echo number_format($cart->coupon, 2);?>)</div>
									</div>
									
									<div class="trow">
										<div class="cell">Shipping:</div>
										<div id="shipping" class="cell">$<?php echo number_format($cart->shipping, 2);?></div>
									</div>
									
									
									<div class="trow t-pad-bot">
										<div class="cell">Tax:</div>
										<div id="taxtotal" class="cell">$<?php echo number_format($cart->totaltax, 2);?></div>
									</div>
									
									<div class="trow t-pad-top t-pad-bot">
										<div class="cell border-top border-bottom">Total:</div>
										<div id="gtotal" class="cell border-top border-bottom">$<?php echo number_format($cart->totalprice, 2);?></div>
									</div>
									
								</div>
								
							</div>
							
							<div id="buudapoints-display" class="receipt-summary" style="max-width: 320px; display: none;">
								
								<div class="table receipt-sect">
									
									<div class="trow">
										<div class="cell">Subtotal:</div>
										<div id="stotal" class="cell"><?php echo number_format($cart->originalprice * 100, 0);?> pts</div>
									</div>
									
									<div class="trow">
										<div class="cell">Discount:</div>
										<div id="cptotal" class="cell">(<?php echo number_format($cart->coupon * 100, 0);?> pts)</div>
									</div>
									
									<div class="trow">
										<div class="cell">Shipping:</div>
										<div id="shipping" class="cell"><?php echo number_format($cart->shipping * 100, 0);?> pts</div>
									</div>
									
									
									<div class="trow t-pad-bot">
										<div class="cell">Tax:</div>
										<div id="taxtotal" class="cell"><?php echo number_format($cart->totaltax * 100, 0);?> pts</div>
									</div>
									
									<div class="trow t-pad-top t-pad-bot">
										<div class="cell border-top border-bottom">Total:</div>
										<div id="gtotal" class="cell border-top border-bottom"><?php echo number_format($cart->totalprice * 100, 0);?> pts</div>
									</div>
									
								</div>
								
							</div>
							
							<?php if ($cart->heatflag == 1): ?>
							<p class="t0 small receipt-sect" style="border-top: none;">Ship to local post office</p>
							<?php endif ?>
							
						</div>
						
					</div>


					<div class="col-sm-12 col-md-8 order-md-0">
						<div class="cart-wrapper">

							<h2 class="t0 title p42">Payment Options</h2>

							<div class="row payment-options">

								<div class="col-payment col-sm-6 p30">
									<a class="payment-option active" data-payment="stripepayment" id="stripepayment-opt">
										<div class="card-options">
											<div class="checkout-card-wrapper">
												<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/visa-2x.png">
												<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/mastercard-2x.png">
												<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/amex-2x.png">
											</div>
											<div class="checkout-card-label">
												Credit Card
											</div>
										</div>
									</a>
								</div>
								
								
								<!--<div class="col-payment col-sm-4 p30">
									<a class="payment-option link" data-payment="etransferpayment">
										<div class="card-options">
											<img src="<?php echo THEMEURL;?>/assets/img/icons/etransfer-2x.jpg" alt="" />
											<div class="checkout-card-label">
												eTransfer
											</div>
										</div>
										
									</a>
								</div>-->
								
								
								<div class="col-payment col-sm-6 p30">
									<a class="payment-option link" data-payment="buudapayment" id="buudapayment-opt">
										<div class="card-options">
											<img src="<?php echo THEMEURL;?>/assets/img/icons/payment-buudapay.png" alt="" />
											<div class="checkout-card-label">
												BuudaPoints
											</div>
										</div>
									</a>
								</div>

								<!--TODO: Paypal receipt -->
								<!--<div class="col-payment col-sm-6 p30" style="display:none">
									<a class="payment-option disabled" data-payment="paypalpayment">
										<img src="<?php echo THEMEURL;?>/assets/img/icons/paypal-2x.png" alt="" />
										<div class="checkout-card-label">
											PayPal
										</div>
									</a>
								</div>-->


							</div>

							<?php
								$totalCartPrice = '';
								$itemDetails = '';
								$x = 0;
								foreach($paypal_cartrow as $p_crow){
									if ($x == 0) {
										$itemDetails .= cleanOut($p_crow->nickname) . " x " . cleanOut($p_crow->qty);
									}
									else {
										$itemDetails .=  ", " . cleanOut($p_crow->nickname) . " x " . cleanOut($p_crow->qty);
									}

									$x++;
								}
							?>
							<?php unset($p_crow);?>
							
							<!-- BuudaPoints -->
							<div class="payment-info buudapayment">
								<form method="post" action="gateways/buudapay/ipn.php">
									
									<?php if ($urow->points_current >= ($cart->totalprice * 100)): ?>
									<h5 class="p18 t18 bold-text">BuudaPoints</h5>
									<p style="max-width: 522px;">
										Use <strong><?php echo number_format($cart->totalprice * 100, 0);?>&nbsp;points</strong> to complete this purchase.*
									</p>
									<p style="max-width: 522px;font-size: 13px;color: #777;">
										*Points are not earned when purchasing with BuudaPoints.
									</p>
									
									<input type="hidden" name="amount" value="<?php echo $cart->totalprice * 100;?>" />
									
									<input type="hidden" name="user_email" value="<?php echo $urow->username;?>" />
									<input type="hidden" name="user_id" value="<?php echo $user->uid;?>" />
									<input type="hidden" name="item_name" value="<?php echo $itemDetails;?>" />
									<input type="hidden" name="currency_code" value="pts" />
									<input type="hidden" name="discount_code" value="<?php echo($cart->discount_code); ?>" />
									
									<input type="hidden" name="processBuudaPayment" value="1" />
									
									<button class="btn-quantum btn-loader btn med btn primary t30 p18" type="submit">
										<span>Pay with Points</span>
										<div class="circle-loader"></div>
									</button>
									<?php else:?>
									<h5 class="p18 t18 bold-text">BuudaPoints <span style="letter-spacing: 0.05em; text-transform: none;">(Not Enough Points)</span></h5>
									<p style="max-width: 522px;">
										Before you can complete this purchase you need a total of <strong><?php echo number_format($cart->totalprice * 100, 0);?>&nbsp;pts </strong>. 
									</p>
									<p>Visit the <a href="<?php echo SITEURL;?>/about?p=buudapoints">BuudaPoints&nbsp;Help&nbsp;Page</a> to learn more.</p>
									
									<a class="btn med btn disabled t30 p18">Pay with BuudaPoints</a>
									<?php endif ?>
								</form>
							</div>
							

							<!-- eTransfer -->
							<!--<div class="payment-info etransferpayment">
								<form method="post" action="gateways/etransfer/ipn.php">

									<h5 class="p18 t18 bold-text">Bank eTransfer</h5>
									
									<p style="max-width: 522px;">
										Once you place your order, you will be sent instructions on how to eTransfer the funds.
										If you are new to Interac E-transfers, please visit <a href="http://www.interac.ca/en/interac-e-transfer-consumer.html" target="_blank">www.interac.ca/en/interac-e-transfer-consumer.html</a> to read all information.
									</p>

									<input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />

									<input type="hidden" name="user_email" value="<?php echo $urow->username;?>" />
									<input type="hidden" name="user_id" value="<?php echo $user->uid;?>" />
									<input type="hidden" name="item_name" value="<?php echo $itemDetails;?>" />
									<input type="hidden" name="currency_code" value="CAD" />
									<input type="hidden" name="discount_code" value="<?php echo($cart->discount_code); ?>" />
									<input type="hidden" name="processTransferPayment" value="1" />
									
									<div class="receipt-end desktop-hide t18">
										<p>
											Total: $<?php echo number_format($cart->totalprice, 2);?>
										</p>
										<p>
											Points: +<?php echo $cart->points;?> pts
										</p>
									</div>


									<button class="btn-quantum btn-loader btn med btn primary t30 p18" type="submit">
										<span>Finish and Pay</span>
										<div class="circle-loader"></div>
									</button>

								</form>
							</div>-->


							<!-- Stripe -->
							<div class="payment-info stripepayment active">

								<h5 class="p18 t18 bold-text">Credit / Debit Card</h5>

								<form method="post" id="stripe_form" class="stripepayment" action="gateways/stripe/ipn.php">

									<div class="creditcard-checkout-form" style="margin-top: 24px;">

										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<div id="cc_wrapper">
														<span class="cc_icon"></span>
														<span class="cc_valid"></span>
														<input id="cc_number" type="text" name="card-number" value="<?php echo isset($_POST['card-number']) ? $_POST['card-number'] : '' ?>" placeholder="Card Number">
													</div>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-6 col-md-4">
													<select id="card-expiry-month" name="card-expiry-month">
														<option disabled selected value="">Month</option>
														<option value="01">01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
													</select>
												</div>
												<div class="col-6 col-md-4">
													<select id="card-expiry-year" name="card-expiry-year">
														<option value="" selected="" disabled="">Year</option>
														<option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
														<option value="<?php echo date('Y', strtotime('+1 year')); ?>"><?php echo date('Y', strtotime('+1 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+2 year')); ?>"><?php echo date('Y', strtotime('+2 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+3 year')); ?>"><?php echo date('Y', strtotime('+3 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+4 year')); ?>"><?php echo date('Y', strtotime('+4 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+5 year')); ?>"><?php echo date('Y', strtotime('+5 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+6 year')); ?>"><?php echo date('Y', strtotime('+6 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+7 year')); ?>"><?php echo date('Y', strtotime('+7 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+8 year')); ?>"><?php echo date('Y', strtotime('+8 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+9 year')); ?>"><?php echo date('Y', strtotime('+9 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+10 year')); ?>"><?php echo date('Y', strtotime('+10 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+11 year')); ?>"><?php echo date('Y', strtotime('+11 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+12 year')); ?>"><?php echo date('Y', strtotime('+12 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+13 year')); ?>"><?php echo date('Y', strtotime('+13 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+14 year')); ?>"><?php echo date('Y', strtotime('+14 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+15 year')); ?>"><?php echo date('Y', strtotime('+15 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+16 year')); ?>"><?php echo date('Y', strtotime('+16 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+17 year')); ?>"><?php echo date('Y', strtotime('+17 year')); ?></option>
														<option value="<?php echo date('Y', strtotime('+18 year')); ?>"><?php echo date('Y', strtotime('+18 year')); ?></option>
													</select>
												</div>

												<div class="col-sm-12 col-md-4">
													<input id="card-cvc" type="text" name="card-cvc" autocomplete="off" autocorrect="off"autocapitalize="off" spellcheck="false" placeholder="CVC">
													<div class="field-icons" style="display:none">
														<span class="field-icon-tooltip -info">?</span>
													</div>
													<div class="tooltip _info _hidden" style="display:none;">
														A number on the back of your card with 3 digits, or the front of your card with 4 digits.
													</div>
												</div>
											</div>
										</div>


										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<input id="card-name" type="text" name="card-name" value="<?php echo isset($_POST['card-name']) ? $_POST['card-name'] : '' ?>" placeholder="Name on card">
												</div>
											</div>
										</div>

									</div>


									<input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />

									<input type="hidden" name="user_email" value="<?php echo $urow->username;?>" />
									<input type="hidden" name="user_id" value="<?php echo $user->uid;?>" />
									<input type="hidden" name="item_name" value="<?php echo $itemDetails;?>" />
									<input type="hidden" name="currency_code" value="CAD" />
									<input type="hidden" name="processStripePayment" value="1" />
									<input type="hidden" name="discount_code" value="<?php echo($cart->discount_code); ?>" />
									
									
									<div class="receipt-end desktop-hide t18">
										<p>
											Total: $<?php echo number_format($cart->totalprice, 2);?>
										</p>
										<p>
											Points: +<?php echo $cart->points;?> pts
										</p>
									</div>
									

									<button class="btn-quantum btn-loader btn med btn primary t30 p18" type="submit">
										<span>Finish and Pay</span>
										<div class="circle-loader"></div>
									</button>

									<?php if(isset($_SESSION['stripe_error'])):?>
									<div class="error-box">
										<ul class="error list">
											<li>
												<?php echo($_SESSION['stripe_error']); ?>
											</li>
										</ul>
									</div>
									<?php endif;?>

								</form>

							</div>

						</div>
					</div>
				</div>

			</div>

		</section>

		<!-- Out of stock modal -->
        <div id="modal-out-of-stock" class="modal-box" style="display: none;">
        	<div class="padding">
        		<img src="<?php echo THEMEURL;?>/assets/img/icons/ico-openbox.svg" alt="Out of Stock!" />
        		<h2 class="t18 p0">Out of Stock!</h2>
        		<p id="out-of-stock-message" class="t18 p42 text-center"></p>
        	</div>
        </div>

	</div>


	<?php require('components/footer-simple.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	<script src="<?php echo THEMEURL;?>/assets/js/jquery.creditCardValidator.js" type="text/javascript"></script>

	<script type="text/javascript">
		
		// Show out of stock message if a product in the cart is no longer available
		<?php if (isset($errorText) && $errorText !== '' && isset($errorPartIndex) && $errorPartIndex > 0):?>
		$(document).ready(function() {
		    let string = "<?php echo $errorText; ?>";
		    $('#modal-out-of-stock').find('#out-of-stock-message').html(string);
		    let stockErrorModal = new jBox(
		        'Modal',
		        {
		            content: $('#modal-out-of-stock')
		        }
		    );
		    stockErrorModal.open();
		});
		
		<?php endif;?>
		
		
		
		
		
		
		
		$(document).ready(function() {
			
			<?php if ($urow->points_current >= ($cart->totalprice * 100)): ?>
			$( "#buudapayment-opt" ).trigger( "click" );
			$(".receipt-summary").hide();
			$("#buudapoints-display").show();
			<?php endif;?>
			
			<?php if(isset($_SESSION['stripe_error'])):?>
			$( "#stripepayment-opt" ).trigger( "click" );
			$(".receipt-summary").hide();
			$("#normalpay-display").show();
			<?php endif;?>
			
		});
		
		
		
		// Check if all products in cart are in stock before paying
        $(document).ready(function() {
            $('.btn-quantum').click(function(e) {
                e.preventDefault();
				$(this).attr("disabled", true);
                $.ajax({
                    type: 'post',
                    url: "ajax/check-product-in-stock.php",
                    dataType: 'json',
                    data: { },
                    success: function(json) {
                        if (json.type === 'error') {
                            $('#modal-out-of-stock').find('#out-of-stock-message').html(string);
                            let stockErrorModal = new jBox(
                                'Modal',
                                {
                                    content: $('#modal-out-of-stock')
                                }
                            );
                            stockErrorModal.open();
                            $('.btn-quantum').removeClass('loading');
                        } else {
                            $(e.target).parents('form').submit();
                        }
						$(this).attr("disabled", false);
                    }
                });
            });
			
			$('.payment-option.disabled').click(function() {
				new jBox('Notice', {
					content: "PayPal payment services are currently down. Follow @<?php echo $core->social_instagram;?> on instagram for updates.",
					autoClose: 5000,
					attributes: {x: 'right', y: 'bottom'},
					addClass:'error'
				});
			});
			
			$('.payment-option').click(function() {
				var paymentType = $(this).data('payment');
				if (paymentType == "buudapayment") {
					$(".receipt-summary").hide();
					$("#buudapoints-display").show();
					
				}
				else {
					$(".receipt-summary").hide();
					$("#normalpay-display").show();
				}
			});
		});
		
		
		
		
		/*Credit card client side validation*/
		$('#cc_number').validateCreditCard(function(result) {
			$('#cc_wrapper').removeClass();
			$('#cc_wrapper').addClass(result.card_type.name);
			if (result.length_valid && result.luhn_valid) {
				$('#cc_wrapper').addClass('valid');
			}
		}, {
			accept: ['visa', 'amex', 'mastercard']
		});
	</script>
	<?php unset($_SESSION['stripe_error']); ?>
</body>

</html>
