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

							<div class="creditcard-checkout-form" style="margin-top: 12px;">

							<script src='https://libs.na.bambora.com/customcheckout/1/customcheckout.js'></script>  
							<div id="form-container" class="container">
								<?php
								  if(isset($_SESSION['bambora_error']) && $_SESSION['bambora_error']!=''){
								    echo '<div class="ipn-error">' . $_SESSION['bambora_error'] . '</div>';
								    unset($_SESSION['bambora_error']);
								  }
								?>
					<form id="checkout-form" action="gateways/bambora/ipn.php" method="post">	
						<div id="sq-ccbox">
                    
                    <div id="card-number"></div>
                    <label for="card-number" id="card-number-error" class="checkout-label"></label>

                    <div class="cvv-wrapper">
                      <div class="cvv-item">
                        <div id="card-cvv"></div>
                        <label for="card-cvv" id="card-cvv-error" class="checkout-label"></label>
                      </div>
                      <div class="cvv-item">
                        <div id="card-expiry"></div>
                        <label for="card-expiry" id="card-expiry-error" class="checkout-label"></label>
                      </div>
                    </div>

                    <input id="card-name" type="text" name="card-name" value="<?php echo isset($_POST['card-name']) ? $_POST['card-name'] : "$user->fname $user->lname" ?>" placeholder="Name on card">

                    <div id="feedback"></div>

                    <script>
                      var customCheckout = customcheckout();

                      var isCardNumberComplete = false;
                      var isCVVComplete = false;
                      var isExpiryComplete = false;

                      var customCheckoutController = {
                        init: function() {
                          console.log('checkout.init()');
                          this.createInputs();
                          this.addListeners();
                        },
                        createInputs: function() {
                          console.log('checkout.createInputs()');
                          var options = {};

                          // Create and mount the inputs
                          options.placeholder = 'Card number';
                          customCheckout.create('card-number', options).mount('#card-number');

                          options.placeholder = 'CVV';
                          customCheckout.create('cvv', options).mount('#card-cvv');

                          options.placeholder = 'MM / YY';
                          customCheckout.create('expiry', options).mount('#card-expiry');
                        },
                        addListeners: function() {
                          var self = this;

                          // listen for submit button
                          if (document.getElementById('checkout-form') !== null) {
                            document
                              .getElementById('checkout-form')
                              .addEventListener('submit', self.onSubmit.bind(self));
                          }

                          customCheckout.on('brand', function(event) {
                            console.log('brand: ' + JSON.stringify(event));

                            var cardLogo = 'none';
                            if (event.brand && event.brand !== 'unknown') {
                              var filePath =
                                'https://cdn.na.bambora.com/downloads/images/cards/' +
                                event.brand +
                                '.svg';
                              cardLogo = 'url(' + filePath + ')';
                            }
                            document.getElementById('card-number').style.backgroundImage = cardLogo;
                          });

                          customCheckout.on('blur', function(event) {
                            console.log('blur: ' + JSON.stringify(event));
                          });

                          customCheckout.on('focus', function(event) {
                            console.log('focus: ' + JSON.stringify(event));
                          });

                          customCheckout.on('empty', function(event) {
                            console.log('empty: ' + JSON.stringify(event));

                            if (event.empty) {
                              if (event.field === 'card-number') {
                                isCardNumberComplete = false;
                              } else if (event.field === 'cvv') {
                                isCVVComplete = false;
                              } else if (event.field === 'expiry') {
                                isExpiryComplete = false;
                              }
                              self.setPayButton(false);
                            }
                          });

                          customCheckout.on('complete', function(event) {
                            console.log('complete: ' + JSON.stringify(event));

                            if (event.field === 'card-number') {
                              isCardNumberComplete = true;
                              self.hideErrorForId('card-number');
                            } else if (event.field === 'cvv') {
                              isCVVComplete = true;
                              self.hideErrorForId('card-cvv');
                            } else if (event.field === 'expiry') {
                              isExpiryComplete = true;
                              self.hideErrorForId('card-expiry');
                            }

                            self.setPayButton(
                              isCardNumberComplete && isCVVComplete && isExpiryComplete
                            );
                          });

                          customCheckout.on('error', function(event) {
                            console.log('error: ' + JSON.stringify(event));

                            if (event.field === 'card-number') {
                              isCardNumberComplete = false;
                              self.showErrorForId('card-number', event.message);
                            } else if (event.field === 'cvv') {
                              isCVVComplete = false;
                              self.showErrorForId('card-cvv', event.message);
                            } else if (event.field === 'expiry') {
                              isExpiryComplete = false;
                              self.showErrorForId('card-expiry', event.message);
                            }
                            self.setPayButton(false);
                          });
                        },
                        onSubmit: function(event) {
                          var self = this;

                          console.log('checkout.onSubmit()');

                          event.preventDefault();
                          self.setPayButton(false);
                          self.toggleProcessingScreen();

                          var callback = function(result) {
                            console.log('token result : ' + JSON.stringify(result));

                            if (result.error) {
                              self.processTokenError(result.error);
                            } else {
                              self.processTokenSuccess(result.token);
                            }
                          };

                          console.log('checkout.createToken()');
                          customCheckout.createToken(callback);
                        },
                        hideErrorForId: function(id) {
                          console.log('hideErrorForId: ' + id);

                          var element = document.getElementById(id);

                          if (element !== null) {
                            var errorElement = document.getElementById(id + '-error');
                            if (errorElement !== null) {
                              errorElement.innerHTML = '';
                            }

                            var bootStrapParent = document.getElementById(id + '-bootstrap');
                            if (bootStrapParent !== null) {
                              bootStrapParent.className = 'form-group has-feedback has-success';
                            }
                          } else {
                            console.log('showErrorForId: Could not find ' + id);
                          }
                        },
                        showErrorForId: function(id, message) {
                          console.log('showErrorForId: ' + id + ' ' + message);

                          var element = document.getElementById(id);

                          if (element !== null) {
                            var errorElement = document.getElementById(id + '-error');
                            if (errorElement !== null) {
                              errorElement.innerHTML = message;
                            }

                            var bootStrapParent = document.getElementById(id + '-bootstrap');
                            if (bootStrapParent !== null) {
                              bootStrapParent.className = 'form-group has-feedback has-error ';
                            }
                          } else {
                            console.log('showErrorForId: Could not find ' + id);
                          }
                        },
                        setPayButton: function(enabled) {
                          console.log('checkout.setPayButton() disabled: ' + !enabled);

                          var payButton = document.getElementById('pay-button');
                          if (enabled) {
                            payButton.disabled = false;
                            payButton.className = 'btn btn-primary';
                          } else {
                            payButton.disabled = true;
                            payButton.className = 'btn btn-primary disabled';
                          }
                        },
                        toggleProcessingScreen: function() {
                          var processingScreen = document.getElementById('processing-screen');
                          if (processingScreen) {
                            processingScreen.classList.toggle('visible');
                          }
                        },
                        showErrorFeedback: function(message) {
                          var xMark = '\u2718';
                          this.feedback = document.getElementById('feedback');
                          this.feedback.innerHTML = xMark + ' ' + message;
                          this.feedback.classList.add('error');
                        },
                        showSuccessFeedback: function(message) {
                          var checkMark = '\u2714';
                          this.feedback = document.getElementById('feedback');
                          this.feedback.innerHTML = checkMark + ' ' + message;
                          this.feedback.classList.add('success');
                        },
                        processTokenError: function(error) {
                          error = JSON.stringify(error, undefined, 2);
                          console.log('processTokenError: ' + error);

                          this.showErrorFeedback(
                            'Error creating token: </br>' + JSON.stringify(error, null, 4)
                          );
                          this.setPayButton(true);
                          this.toggleProcessingScreen();
                        },
                        processTokenSuccess: function(token) {
                          console.log('processTokenSuccess: ' + token);

                          this.showSuccessFeedback('Success! Created token');
                          this.setPayButton(true);
                          this.toggleProcessingScreen();

                          // Use token to call payments api
                          $("#card-nonce").val(token);
                          $("#checkout-form").submit();
                          // this.makeTokenPayment(token);
                        },
                      };

                      customCheckoutController.init();
                    </script>
									<h5 class="p18 t18 bold-text">Billing Address</h5>							
										<div class="radio-box p60">
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
									<input id="pay-button" type="submit" class="btn disabled" value="Finish and Pay" disabled="true" />
                  <!--<button id="card-button" class="button-credit-card" type="button">Finish and Pay</button>-->									 
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

	<script type="text/javascript">
    $(document).ready(function() {
      $("#card-button").on("click", function(e){
        customCheckout.createToken(function (result) {
        if (result.error) {
          console.log(result.error.message);
          // display error message
        } else {
          $("#card-nonce").val(result.token);
          $("#checkout-form").submit();
        }
      });
      });
    });
		 
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
			// Added this timeout to allow bambora mount their iframes. (Bambora does not mount unvisible inputs).
//      setTimeout(function(){
//        $( "#pointspayment-opt" ).trigger( "click" );
//        $(".receipt-summary").hide();
//        $("#points-display").show();
//        $(".creditcard-checkout-form").hide();}, 
//      200);
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
		
		
		
		

	</script>
  <style>

#checkout-form {
    position: relative;
    margin: auto;
}
#form-container {
	padding: 0;
}

#checkout-form label.checkout-label {
    display: block;
    min-height: 20px;
    font-size: 12px;
    font-weight: 500;
	margin: 0;
    padding: 0;
    color: red;
}

#card-number, #card-cvv, #card-expiry, #card-name {
    background-color: #FFF;
    display: block;
    width: calc(100%);
    border-radius: 3px;
    border: 1px solid #CFCFCF;
    padding: 14px 60px 13px 20px;
    margin: auto;
    transition: all 100ms ease-out;
}
#pay-button {
	font-size: 19px;
	padding: 18px 50px;
	border-radius: 40px;
	border: none;
	font-weight: 500;
	height: auto;
	line-height: 30px;
}
.cvv-wrapper {
  display: flex;
  gap: 15px;
  justify-content: space-around;
  width: calc(100%);
  padding: 14px 60px 13px 20px;
  margin: auto;
  padding: 0;
}
#card-cvv, #card-expiry {
  width: 100%;
}
.ipn-error {
  text-align: center;
  background-color: #FF7377;
  color: white;
}
/* card images are added to card number */
#card-number {
    background-image: none;

    background-origin: content-box;
    background-position: calc(100% + 40px) center;
    background-repeat: no-repeat;
    background-size: contain;
}

/* buttons */
.btn {
    vertical-align: top;
}

.btn {
    position: relative;
    border: none;
    border-radius: 4px;
	background-color: #e45c49;
	border-color: #e45c49;
	color: #ffffff;
    display: inline-block;
    transition: all 100ms ease-out;
}

.btn:hover, .btn:active {
    background-color: #de422c;
	border-color: #de422c;
	color: #fff;
}

.btn:active {
    background-color: #de422c;
	border-color: #de422c;
	color: #fff;
}

.btn:disabled {
    background-color: rgba(255, 255, 255, 1);
    border: 1px solid rgba(120, 71, 181, 1);
    color: rgba(120, 71, 181, 1);
}

/* feedback is displayed after tokenization */
#feedback {
    position: relative;
    left: 15px;
    display: inline-block;
    background-color: transparent;
    border: 0px solid rgba(200, 200, 200, 1);
    border-radius: 4px;
    transition: all 100ms ease-out;
    padding: 11px;
}

#feedback.error {
    color: red;
    border: 1px solid;
}

#feedback.success {
    color: seagreen;
    border: 1px solid;
}

  </style>
	<?php unset($_SESSION['bambora_error']); ?>
</body>

</html>
