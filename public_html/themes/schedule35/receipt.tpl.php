<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>

<?php require('components/head.tpl.php'); ?>

<body id="page-checkout" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main">

		<section class="wrapper cart-padding padded mini bg-lightgrey padded-b-120">


			<?php if($receiptInvoice && ($receiptInvoice->user_id == $urow->id || $user->hasAdminAccess()) ):?>
			
			<!-- Checkout Nav -->
			<ul class="checkout-progress">
				<li class="active">Checkout</li>
				<li class="active">Payment</li>
				<li class="active">Invoice</li>
			</ul>

			<div class="container invoice">

				<div class="pay-card">
					
					<div class="card-overview">

						<div class="overview-body">
							<div class="purchase-overview">

								<h3 class="p30">
									<?php if($receiptInvoice->pp == 'eTransfer' && $receiptInvoice->status == 0):?>
									You're almost finished!
									<?php else:?>
									Payment Completed!
									<?php endif;?>
								</h3>


								<?php if($receiptInvoice->pp == 'Points'):?>
								<p class="border-bottom p0" style="padding-bottom: 12px;">
									Thank you for paying with <strong>points</strong>. We hope your experience has been legendary.
								</p>
								<?php elseif($receiptInvoice->pp != 'eTransfer'):?>
								<p>
									Please note that all orders made on this website will appear as <strong>[LIVING NORMALLY]</strong> on your credit card.
								</p>
								
								<div class="card-points t30">
									<h4>Points Earned</h4>
									<span class="points">+<?php echo($receiptInvoice->points); ?> pts</span>
								</div>
								<?php elseif($receiptInvoice->pp == 'eTransfer' && $receiptInvoice->status != 0):?>
								<p>
									The e-Transfer for this order has successfully been accepted and your order is now on its way!
								</p>
								
								<div class="card-points t24">
									<h4>Points Earned</h4>
									<span class="points">+<?php echo($receiptInvoice->points); ?> pts</span>
								</div>
								<?php else:?>
								<p>
									To start enjoying your <?php echo $core->company; ?>'s send an e-Transfer to <span class="bold-text"><?php echo $core->payment_email;?></span> with the following details:
								</p>
								
								<div class="card-points t30">
									<h4>Points To Be Earned</h4>
									<span class="points">+<?php echo($receiptInvoice->points); ?> pts</span>
								</div>
								
								<table class="receipt p0">
									<tr>
										<td>Amount:</td>
										<td>$<?php echo($receiptInvoice->totalprice); ?></td>
									</tr>
									<tr>
										<td>Question:</td>
										<td>Order #: <?php echo($receiptInvoice->invid); ?></td>
									</tr>
									<tr>
										<td>Answer:</td>
										<td>buuda420</td>
									</tr>
								</table>
								<?php endif;?>
								
								<table>
									<tbody>
										<?php $receiptProducts = $item->getReceiptProducts($receiptid); ?>
										<?php if($receiptProducts):?>
										<?php foreach ($receiptProducts as $prow):?>
										<tr>
											<td class="name">
												<?php echo($prow->title); ?>
											</td>
											<td class="quantity">
												Qty: <?php echo($prow->item_qty); ?>
											</td>
										</tr>
										<?php endforeach;?>
										<?php unset($prow);?>
										<?php endif;?>
									</tbody>
								</table>
							</div>
							<?php if($receiptInvoice->status == '1'):?>
							<div class="descriptor">
								<p>Your order has been received. We'll send you an email to let you know when it's been shipped.</p>
							</div>
							<?php elseif($receiptInvoice->status == '2'):?>
							<div class="descriptor">
								<p>Your order has been packaged and is getting ready to be picked up.</p>
							</div>
							<?php elseif($receiptInvoice->status == '1.5'):?>
							<div class="descriptor">
								<p>Your order has been packaged and is getting ready to be picked up.</p>
							</div>
							<?php elseif($receiptInvoice->status == '3'):?>
							<div class="descriptor">
								<p>
									This order has been shipped. <br/>
									<span class="descriptor-track">Tracking #: <a target="_blank" href="https://www.canadapost.ca/trackweb/en#/search?searchFor=<?php echo $receiptInvoice->trackingnum;?>"><?php echo $receiptInvoice->trackingnum;?></a></span>
								</p>
								
							</div>
							<?php endif;?>
						</div>
						
						
						
						<?php if($receiptInvoice->pp == 'Points'):?>
						<footer class="overview-footer">
							<span class="site inline-block">
								<img style="display: block; float: left; width: 30px;opacity: 0.6;" src="<?php echo THEMEURL;?>/assets/img/about/ico_wallet2.svg">
							</span>
						</footer>
						<?php elseif($receiptInvoice->pp != 'eTransfer'):?>
						<footer class="overview-footer">
							<span class="site inline-block">
								<a class="inline-block checkout-cards">
									<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/visa-2x.png">
									<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/mastercard-2x.png">
									<img class="checkout-card-image" src="<?php echo THEMEURL;?>/assets/img/cards/amex-2x.png">
								</a>
							</span>
						</footer>
						<?php else:?>
						<footer class="overview-footer">
							<span class="site inline-block">
								<?php if($receiptInvoice->pp == 'PayPal'):?>
								<a class="inline-block" href="http://www.interac.ca/en/interac-e-transfer-consumer.html" target="_blank"><img class="logo" src="<?php echo THEMEURL;?>/assets/img/icons/paypal-2x.png"></a>
								<?php else:?>
								<a class="inline-block" href="http://www.interac.ca/en/interac-e-transfer-consumer.html" target="_blank"><img class="logo" src="<?php echo THEMEURL;?>/assets/img/icons/etransfer-2x.jpg"></a>
								<?php endif;?>
							</span>
							<span class="invoice-id">Invoice #: <?php echo($receiptInvoice->invid); ?></span>
						</footer>
						<?php endif;?>
					</div>
					<div class="card-breakdown">
						<div class="card-breakdown--header mobile-hide">
							<h2>Invoice</h2>
						</div>
						<ul class="card-breakdown--list">
							<li>
								<div class="list-content">
									<p>
										Full name:
										<span class="list-bold"><?php echo($receiptInvoice->name); ?></span>
									</p>
								</div>
							</li>
							<li>
								<div class="list-content">
									<p>
										Shipping Details:
										<span class="list-bold">

										<?php if($receiptInvoice->address2):?><?php echo(ucwords(strtolower($receiptInvoice->address2))); ?> - <?php endif;?><?php echo(ucwords(strtolower($receiptInvoice->address))); ?> <br />
										<?php echo(ucwords(strtolower($receiptInvoice->city))); ?>, <?php echo(ucwords(strtolower($receiptInvoice->state))); ?>, <?php echo(strtoupper($receiptInvoice->zip)); ?>
										</span>
									</p>
								</div>
							</li>
							<li>
								<div class="list-content">
									<p>
										Shipping Option:
										<?php if($receiptInvoice->shipping == $core->shipping_standard):?>
										<span class="list-bold">Economy Shipping</span>
										<?php elseif($receiptInvoice->shipping >= $core->shipping_express):?>
										<span class="list-bold">Express Shipping</span>
										<?php else:?>
										<span class="list-bold">Economy Shipping</span>
										<?php endif;?>
									</p>
								</div>
							</li>
							<li>
								<div class="list-content">
									<p>
										<?php
										if ($receiptInvoice->heatflag == 1) {
											echo("Ship to local post office");
										}
										?>
									</p>
								</div>
							</li>
						</ul>
					</div>
					
					
				</div>
				<div class="circle"></div>

			</div>
			
						
			<?php else:?>
			<div class="container max-width narrow">
				<h2>Something happened...</h2>
				<p>
					Something happened while trying to retrieve your receipt. Email our friendly support team <a href="mailto:<?php echo $core->support_email;?>"><?php echo $core->support_email;?></a> for assistance.
				</p>
			</div>
			
			<?php endif;?>
		</section>

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>



	<script type="text/javascript">
	var mantis = mantis || [];
	mantis.push(['analytics', 'load', {
		advertiser: '59c1f2dff3e0da15892933c0',
		transaction: '<?php echo($receiptInvoice->invid); ?>', // set this to a unique value (if applicable), such as a purchase id, to trace our conversions to your system (make sure to change the transaction= in the pixel below as well
		revenue: '<?php echo($receiptInvoice->totalprice); ?>' // set to a decimal amount (ie: "99.99") on your thank you page that represents the total purchase amount (make sure to add revenue= in the pixel below as well, ie: transaction=123&revenue=99.99)
	}]);
	</script>
	<script type="text/javascript" data-cfasync="false" src="https://assets.mantisadnetwork.com/analytics.min.js" async></script>
	<noscript><img src="//mantodea.mantisadnetwork.com/analytics/pixel?advertiser=59c1f2dff3e0da15892933c0&transaction=<?php echo($receiptInvoice->invid); ?>&revenue=<?php echo($receiptInvoice->totalprice); ?>" /></noscript>
</body>

</html>
