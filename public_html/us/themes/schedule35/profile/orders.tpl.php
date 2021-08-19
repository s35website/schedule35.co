<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $inrow = $item->getUserInvoices(); ?>
<?php include ("nav-profile.tpl.php"); ?>
<div id="profile-orders" class="wrapper padded bg-lightgrey">

	<div class="container max-width narrow page details">

		<h2 class="t0 p60 text-center">Order History</h2>
		
		<?php include ("nav-profile-account.tpl.php"); ?>


		<?php if(!$inrow):?>

		<div class="empty">
			<p class="p30">You haven't placed any orders yet.</p>
			<a class="btn med btn primary" href="<?php echo SITEURL;?>/shop">Explore Products</a>
		</div>


		<?php else:?>
		<?php foreach ($inrow as $row):?>
		<div class="form-validetta masta order-history" data-id="<?php echo($row->id); ?>">
			<div class="tab view">
				<h2 class="p0">
					<?php echo date("M j, Y", strtotime($row->created));?> -
					<?php if($row->pp == "Points"):?>
					<?php echo number_format($row->totalprice, 0);?> pts
					<?php else:?>
					<?php echo(formatMonies($row->totalprice)); ?>
					<?php endif;?>
				</h2>

				<div class="right table">
					<div class="middle">
						<span class="link edit">View</span>
						<span class="link cancel">Cancel</span>
					</div>
				</div>
			</div>

			<div class="form view grid">

				<div class="row">
					<div class="col-sm-12">
						<p class="p0">
							<strong>Order #:</strong> <a target="_blank" href="<?php echo SITEURL;?>/receipt?tx=<?php echo($row->invid); ?>"><?php echo($row->invid); ?></a>
						</p>
						<p>
							<?php
								if ($row->status == 1) {
									$status = Lang::$word->SHIP_1;
								}
								elseif ($row->status == 1.2) {
									$status = Lang::$word->SHIP_1;
								}
								elseif ($row->status == 1.5) {
									$status = Lang::$word->SHIP_1;
								}
								elseif ($row->status == 2) {
									$status = Lang::$word->SHIP_2;
								}
								elseif ($row->status == 3) {
									$status = Lang::$word->SHIP_3 . " (Tracking <a target='_blank' href='https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=" . $row->trackingnum . "'>#" . $row->trackingnum . "</a>)";
								}
								else {
									$status = Lang::$word->SHIP_0;
								}
							?>
							<strong>Status #:</strong> <?php echo($status); ?>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">

						<div class="border-top p18 t18">

							<table>
								<tbody>
									<?php $receiptProducts = $item->getReceiptProducts($row->invid); ?>
									<?php if($receiptProducts):?>
									<?php foreach ($receiptProducts as $prow):?>
									<tr>
										<td class="name">
											<?php echo($prow->title); ?>
										</td>
										<td class="quantity">
											Qty: <?php echo($prow->item_qty); ?>
										</td>
										<?php if($row->pp == "Points"):?>
										<td class="price-per">
											<?php echo number_format($prow->price, 0);?> pts
										</td>
										<td class="price">
											<?php echo number_format($prow->price * $prow->item_qty, 0);?> pts
										</td>
										<?php else:?>
										<td class="price-per">
											$<?php echo number_format($prow->price, 2);?>
										</td>
										<td class="price">
											$<?php echo number_format($prow->price * $prow->item_qty, 2);?>
										</td>
										<?php endif;?>
									</tr>
									<?php endforeach;?>
									<?php unset($prow);?>
									<?php endif;?>
								</tbody>
							</table>
						</div>

						<div class="border-top">

							<div class="order-totals">
								<?php if($row->pp == "Points"):?>
								<table class="p0">
									<tbody>
										<tr>
											<td class="totals">
												Subtotal
											</td>
											<td class="amount">
												<?php echo number_format($row->originalprice, 0);?> pts
											</td>
										</tr>
										<tr>
											<td class="totals">
												Shipping
											</td>
											<td class="amount">
												<?php echo number_format($row->shipping, 0);?> pts
											</td>
										</tr>
										<?php if($row->coupon > 0):?>
										<tr>
											<td class="totals">
												Discount
											</td>
											<td class="amount">
												<?php echo number_format($row->coupon, 0);?> pts
											</td>
										</tr>
										<?php endif;?>
										<tr>
											<td class="totals">
												Tax
											</td>
											<td class="amount">
												<?php echo number_format($row->totaltax, 0);?> pts
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td class="totals">
												<strong class="block t18 t18">Total (CDN)</strong>
											</td>
											<td class="amount">
												<strong class="block t18 t18"><?php echo number_format($row->totalprice, 0);?> pts</strong>
											</td>
										</tr>
									</tfoot>
								</table>
								<?php else:?>
								<table class="p0">
									<tbody>
										<tr>
											<td class="totals">
												Subtotal
											</td>
											<td class="amount">
												$<?php echo number_format($row->originalprice, 2);?>
											</td>
										</tr>
										<tr>
											<td class="totals">
												Shipping
											</td>
											<td class="amount">
												$<?php echo number_format($row->shipping, 2);?>
											</td>
										</tr>
										<?php if($row->coupon > 0):?>
										<tr>
											<td class="totals">
												Discount
											</td>
											<td class="amount">
												$<?php echo number_format($row->coupon, 2);?>
											</td>
										</tr>
										<?php endif;?>
										<tr>
											<td class="totals">
												Tax
											</td>
											<td class="amount">
												$<?php echo number_format($row->totaltax, 2);?>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td class="totals">
												<strong class="block t18 t18">Total (CDN)</strong>
											</td>
											<td class="amount">
												<strong class="block t18 t18">$<?php echo number_format($row->totalprice, 2);?></strong>
											</td>
										</tr>
									</tfoot>
								</table>
								<?php endif;?>
							</div>

						</div>




					</div>
				</div>

			</div>

		</div>
		<?php endforeach;?>
		<?php endif;?>
	</div>

</div>
