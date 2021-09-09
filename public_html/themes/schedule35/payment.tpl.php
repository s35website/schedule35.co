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
				<?php
					if(isset($_SESSION['square_error']) && $_SESSION['square_error']!=''){
						echo $_SESSION['square_error'];
						unset($_SESSION['square_error']);
					}
				?>
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
							
							<div id="points-display" class="receipt-summary" style="max-width: 320px; display: none;">
								
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
									<a class="payment-option link" data-payment="pointspayment" id="pointspayment-opt">
										<div class="card-options">
											<img src="<?php echo THEMEURL;?>/assets/img/about/ico_wallet2.png" alt="" />
											<div class="checkout-card-label">
												Points
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
							
							<!-- Points -->
							<div class="payment-info pointspayment">
								<form method="post" action="gateways/points/ipn.php">
									
									<?php if ($urow->points_current >= ($cart->totalprice * 100)): ?>
									<h5 class="p18 t18 bold-text">Points</h5>
									<p style="max-width: 522px;">
										Use <strong><?php echo number_format($cart->totalprice * 100, 0);?>&nbsp;points</strong> to complete this purchase.*
									</p>
									<p style="max-width: 522px;font-size: 13px;color: #777;">
										*Points are not earned when purchasing with Points.
									</p>
									
									<input type="hidden" name="amount" value="<?php echo $cart->totalprice * 100;?>" />
									
									<input type="hidden" name="user_email" value="<?php echo $urow->username;?>" />
									<input type="hidden" name="user_id" value="<?php echo $user->uid;?>" />
									<input type="hidden" name="item_name" value="<?php echo $itemDetails;?>" />
									<input type="hidden" name="currency_code" value="pts" />
									<input type="hidden" name="discount_code" value="<?php echo($cart->discount_code); ?>" />
									
									<input type="hidden" name="processPointsPayment" value="1" />
									
									<button class="btn-quantum btn-loader btn med btn primary t30 p18" type="submit">
										<span>Pay with Points</span>
										<div class="circle-loader"></div>
									</button>
									<?php else:?>
									<h5 class="p18 t18 bold-text">Points <span style="letter-spacing: 0.05em; text-transform: none;">(Not Enough Points)</span></h5>
									<p style="max-width: 522px;">
										Before you can complete this purchase you need a total of <strong><?php echo number_format($cart->totalprice * 100, 0);?>&nbsp;pts </strong>. 
									</p>
									<p>Visit the <a href="<?php echo SITEURL;?>/about?p=points">Points&nbsp;Help&nbsp;Page</a> to learn more.</p>
									
									<a class="btn med btn disabled t30 p18">Pay with Points</a>
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

							<div class="creditcard-checkout-form" style="margin-top: 24px;">

										<!-- Square Payment Start-->
							<?php
								$key = $db->first("SELECT * FROM gateways WHERE name = 'square'");
								$kar = explode('/',$key->extra);
								$appId = $kar[0];
								$locId = $kar[1];
								if($key->demo == 0){
						            $paymentGatewayUrl = 'https://js.squareupsandbox.com/v2/paymentform';
						        }else{
						             $paymentGatewayUrl = 'https://js.squareup.com/v2/paymentform';
						        }  
							?>	

							<script type="text/javascript" src="<?php echo $paymentGatewayUrl; ?>"></script>
							<script type="text/javascript">
								// Set the application ID
								var applicationId = "<?php echo $appId; ?>";

								// Set the location ID
								var locationId = "<?php echo $locId; ?>";


								function buildForm(form) {
								  if (SqPaymentForm.isSupportedBrowser()) {
								    form.build();
								    form.recalculateSize();
								  }
								}
								function buildForm1() {
								    if (SqPaymentForm.isSupportedBrowser()) {
								      var paymentDiv = document.getElementById("form-container");
								      if (paymentDiv.style.display === "none") {
								          paymentDiv.style.display = "block";
								      }
								      paymentform.build();
								      paymentform.recalculateSize();
								    } else {
								      // Show a "Browser is not supported" message to your buyer
								    }
								  }
								/*
								 * function: requestCardNonce
								 *
								 * requestCardNonce is triggered when the "Pay with credit card" button is
								 * clicked
								 *
								 * Modifying this function is not required, but can be customized if you
								 * wish to take additional action when the form button is clicked.
								 */
								function requestCardNonce(event) {

								  // Don't submit the form until SqPaymentForm returns with a nonce
								  event.preventDefault();

								  // Request a nonce from the SqPaymentForm object
								  paymentForm.requestCardNonce();
								}

								// Create and initialize a payment form object
								var paymentForm = new SqPaymentForm({

								  // Initialize the payment form elements
								  applicationId: applicationId,
								  locationId: locationId,
								  inputClass: 'sq-input',
								  autoBuild: false,
								  postalCode: false,

								  // Customize the CSS for SqPaymentForm iframe elements
								  inputStyles: [{
								    fontSize: '16px',
								    fontFamily: 'Helvetica Neue',
								    padding: '16px',
								    color: '#373F4A',
								    backgroundColor: 'transparent',
								    lineHeight: '18px',
								    placeholderColor: '#CCC',
								    _webkitFontSmoothing: 'antialiased',
								    _mozOsxFontSmoothing: 'grayscale'
								  }],

								  // Initialize Apple Pay placeholder ID
								  applePay: false,

								  // Initialize Masterpass placeholder ID
								  masterpass: false,

								  // Initialize the credit card placeholders
								  cardNumber: {
								    elementId: 'sq-card-number',
								    placeholder: 'Card Number'
								  },
								  cvv: {
								    elementId: 'sq-cvv',
								    placeholder: 'CVV'
								  },
								  expirationDate: {
								    elementId: 'sq-expiration-date',
								    placeholder: 'MM/YY'
								  },
								  // SqPaymentForm callback functions
								  callbacks: {
								    /*
								     * callback function: createPaymentRequest
								     * Triggered when: a digital wallet payment button is clicked.
								     * Replace the JSON object declaration with a function that creates
								     * a JSON object with Digital Wallet payment details
								     */
								    createPaymentRequest: function () {

								      return {
								        requestShippingAddress: false,
								        requestBillingInfo: true,
								        currencyCode: "<?php echo $key->extra2; ?>",
								        countryCode: "US",
								        total: {
								          label: "MERCHANT NAME",
								          amount: "<?php echo $cart->totalprice;?>",
								          pending: false
								        },
								        lineItems: [
								          {
								            label: "Subtotal",
								            amount: "<?php echo $cart->totalprice;?>",
								            pending: false
								          }
								        ]
								      }
								    },

								    /*
								     * callback function: cardNonceResponseReceived
								     * Triggered when: SqPaymentForm completes a card nonce request
								     */
								    cardNonceResponseReceived: function (errors, nonce, cardData) {
								      if (errors) {
								        // Log errors from nonce generation to the Javascript console
								        console.log("Encountered errors:");
								        errors.forEach(function (error) {
								          console.log(' er= ' + error.message);
								          alert(error.message);
								        });

								        return;
								      }
								      // Assign the nonce value to the hidden form field
								      document.getElementById('card-nonce').value = nonce;

								      // POST the nonce form to the payment processing page
								       document.getElementById('nonce-form').submit();

								    },

								    /*
								     * callback function: unsupportedBrowserDetected
								     * Triggered when: the page loads and an unsupported browser is detected
								     */
								    unsupportedBrowserDetected: function () {
								      /* PROVIDE FEEDBACK TO SITE VISITORS */
								    },

								    /*
								     * callback function: inputEventReceived
								     * Triggered when: visitors interact with SqPaymentForm iframe elements.
								     */
								    inputEventReceived: function (inputEvent) {
								      switch (inputEvent.eventType) {
								        case 'focusClassAdded':
								          /* HANDLE AS DESIRED */
								          break;
								        case 'focusClassRemoved':
								          /* HANDLE AS DESIRED */
								          break;
								        case 'errorClassAdded':
								          document.getElementById("error").innerHTML = "Please fix card information errors before continuing.";
								          break;
								        case 'errorClassRemoved':
								          /* HANDLE AS DESIRED */
								          document.getElementById("error").style.display = "none";
								          break;
								        case 'cardBrandChanged':
								          /* HANDLE AS DESIRED */
								          break;
								        case 'postalCodeChanged':
								          /* HANDLE AS DESIRED */
								          break;
								      }
								    },

								    /*
								     * callback function: paymentFormLoaded
								     * Triggered when: SqPaymentForm is fully loaded
								     */
								    paymentFormLoaded: function () {
								      /* HANDLE AS DESIRED */
								      console.log("The form loaded!");
								    }
								  }
								});
							</script>
							<script>
								 document.addEventListener("DOMContentLoaded", function(event) {
							    if (SqPaymentForm.isSupportedBrowser()) {
							      paymentForm.build();
							      paymentForm.recalculateSize();
							    }
							  });
							</script>
							<div id="form-container">
							  <div id="sq-ccbox">
							    <form id="nonce-form" novalidate action="gateways/square/ipn.php" method="post">
							    	<div class="form-group">
													
							      <fieldset>
							      	<div class="row">
							      	<div class="col-sm-12">
							       		<div id="sq-card-number"></div>
							       	</div>

							       	<div class="row">
								        <div class="third col-6 col-md-4">
								          <div id="sq-expiration-date"></div>
								        </div>

								        <div class="third col-6 col-md-4">
								          <div id="sq-cvv"></div>
								        </div>
									</div>
							      </fieldset>
<!-- 
							      <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Finish and Pay</button>
										 -->
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<input id="card-name" type="text" name="card-name" value="<?php echo isset($_POST['card-name']) ? $_POST['card-name'] : '' ?>" placeholder="Name on card">
												</div>
											</div>
										</div>
										
										<h5 class="p18 t18 bold-text">Billing Address</h5>
										
										
										<div class="radio-box p18">
											<label class="radio-wrapper form-group" for="billing_address_same">
												<span class="radio-option-title">
													Same as shipping address
												</span>
												<div class="radio-button">
													<input class="radio-option-input radio-option-shipping" type="radio" name="billing_address_opt" id="billing_address_same" value="0" data-validetta="required" checked>
													<label for="billing_address_same"></label>
												</div>
				
				
											</label>
				
											<label class="radio-wrapper form-group" for="billing_address_different">
												<span class="radio-option-title">
													Use a different billing address
												</span>
												<div class="radio-button">
													<input class="radio-option-input radio-option-shipping" type="radio" name="billing_address_opt" id="billing_address_different" value="1" data-validetta="required">
													<label for="billing_address_different"></label>
												</div>
											</label>
											
											<!-- Enter billing address -->
											<div id="billing_info" style="padding: 24px 20px 6px; background: #f4f4f4;border-top: 1px solid #dfdfdf; display: none;">
												<div class="form-group">
													<div class="row">
														<div class="col-sm-12">
															<input id="billing_email" type="text" name="billing_email" placeholder="Email">
														</div>
													</div>
													<div class="row">
														<div class="col-sm-7">
															<input id="billing_address" type="text" name="billing_address" placeholder="Address">
														</div>
														<div class="col-sm-5">
															<input id="billing_address2" type="text" name="billing_address2" placeholder="Apt / Suite # (Optional)">
														</div>
													</div>
													<div class="row">
														<div class="col-sm-12">
															<input id="billing_city" type="text" name="billing_city" placeholder="City">
														</div>
													</div>
													
													<div class="row">
														
														<div class="col-12 col-md-4">
															<select id="billing_country" name="billing_country">
																<option value="US" disabled>United States</option>
																<option value="CA" selected>Canada</option>
															</select>
														</div>
														<div class="col-12 col-md-4">
															<select id="billing_state" name="billing_state" data-validetta="required">
																<option value="" disabled selected>Province</option>
																
																<?php $provRow = $content->getProvinces(); ?>
																<?php foreach ($provRow as $prrow): ?>
																<option value="<?php echo($prrow->abbr); ?>"><?php echo($prrow->abbr); ?></option>
																<?php endforeach; ?>
															</select>
														</div>
														<div class="col-12 col-md-4">
															<input id="billing_zip" type="text" name="billing_zip" placeholder="Postal code" data-validetta="required,minLength[2]"/>
														</div>							
													</div>
												</div>
											</div>
											<!-- / Enter billing address -->
											
										</div>
										
										
									</div>


									<input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />

									<input type="hidden" name="user_email" value="<?php echo $urow->username;?>" />
									<input type="hidden" name="user_id" value="<?php echo $user->uid;?>" />
									<input type="hidden" name="item_name" value="<?php echo $itemDetails;?>" />
									<input type="hidden" name="currency_code" value="CAD" />
									<input type="hidden" name="discount_code" value="<?php echo($cart->discount_code); ?>" />
									
									
									<div class="receipt-end desktop-hide t42 p30">
										
										
										
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
												<div class="cell border-top">Total:</div>
												<div id="gtotal" class="cell border-top">$<?php echo number_format($cart->totalprice, 2);?></div>
											</div>
											
										</div>
										
										
									</div>
									

									 <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Finish and Pay</button>
									 <div id="error"></div>
								  <input type="hidden" id="amount" name="amount" value="<?php echo number_format($cart->totalprice, 2);?>">
							      <input type="hidden" id="card-nonce" name="nonce">
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
		
		
		
		$('input:radio[name="billing_address_opt"]').change(
			function(){
				if ($(this).is(':checked') && $(this).val() == '1') {
					// append goes here
					$("#billing_info").show();
				}
				else {
					$("#billing_info").hide();
				}
		});
		
		
		
		$(document).ready(function() {
			
			<?php if ($urow->points_current >= ($cart->totalprice * 100)): ?>
			$( "#pointspayment-opt" ).trigger( "click" );
			$(".receipt-summary").hide();
			$("#points-display").show();
			$(".creditcard-checkout-form").hide();			
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
				if (paymentType == "pointspayment") {
					$(".receipt-summary").hide();
					$("#points-display").show();
					$(".creditcard-checkout-form").hide();
				}
				else {
					$(".receipt-summary").hide();
					$("#normalpay-display").show();
					$(".creditcard-checkout-form").show();
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
