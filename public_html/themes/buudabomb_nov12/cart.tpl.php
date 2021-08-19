<?php
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "cart"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-cart" class="<?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

    <?php require('components/navbar.tpl.php'); ?>


	<div class="main">
	
		<section class="wrapper cart-padding padded bg-lightgrey">
		
			<div class="container max-width">
			
				<form action="/cart" method="post" novalidate="" class="cart-wrapper">
					<div class="cart-wrapper-overlay loading-overlay">
						<div class="circle-loader"></div>
					</div>
					
					<h2 class="t0 title p42">Items in Your&nbsp;Cart</h2>
					
					<table class="cart-table">
						<tbody>
							
						<?php if ($cartrow): ?>
						<?php $i = 0; ?>
						<?php foreach ($cartrow as $ccrow): ?>
						
							<?php
								$i++;
								if ($ccrow->pvid > 0) {
									$variantData = $item->getProductVariants($ccrow->pid, $ccrow->pvid);
									$price = $variantData[0]->price;
									$variantTitle = $variantData[0]->title;
									$pvid = $ccrow->pvid;
									$price = $price * $ccrow->qty;
								} else {
									$variantTitle = "";
									$price = $ccrow->productprice;
									$pvid = 0;
								}
								$productRow = $db->first("SELECT * FROM " . Products::pTable . " WHERE id = " . $ccrow->pid);
							?>
							<?php $url = ($core->seo) ? SITEURL . '/product/' . $ccrow->slug . '/' : SITEURL . '/item?itemname=' . $ccrow->slug; ?>
							
							<tr class="product-row" data-id="<?php echo $ccrow->pid; ?>" data-pvid="<?php echo $pvid; ?>">
								<td class="cart-image">
									<a class="block" href="<?php echo $url; ?>">
										<img alt="<?php echo $ccrow->title; ?> - <?php echo $ccrow->description; ?>" src="<?php echo UPLOADURL; ?>prod_images/<?php echo $ccrow->thumb; ?>">
									</a>
								</td>
								<td class="wlabel">
									<a href="<?php echo $url; ?>" class="cart-product-title block">
										<?php echo $ccrow->title; ?>
									</a>
									<?php if ($variantTitle): ?>
										<label><?php echo $variantTitle; ?></label>
									<?php endif; ?>
								</td>
								<td>
									<div class="custom-number-input div-center">
										<span class="input-number-decrement">–</span>
										<?php if ($productRow->flag_multiple > 0):?>
										<?php $variantStock = $db->first("SELECT id, dosage FROM " . Products::pvTable . " WHERE id = " . $pvid); ?>
										<input id="stockval" class="input-number" type="text" value="<?php echo $ccrow->qty; ?>" data-max="<?php echo ($productRow->stock / $variantStock->dosage);?>" data-stockval="<?php echo $variantStock->dosage;?>" readonly>
										<?php else:?>
										<input id="stockval" class="input-number" type="text" value="<?php echo $ccrow->qty; ?>" data-max="<?php echo $productRow->stock;?>" data-stockval="1" readonly>
										<?php endif;?>
										
										<span class="input-number-increment">+</span>
									</div>
								</td>
					
								<td class="wlabel text-left productTotal" data-label="Total: ">
									<?php if($ambassador_discount > 0):?>
									<span class="discounted">$<?php echo money_format('%i', $price); ?></span>
									$<?php echo money_format('%i', $price - $price * $ambassador_discount); ?>
									<?php else:?>
									$<?php echo money_format('%i', $price); ?>
									<?php endif;?>
								</td>
					
								<td class="td-icon-only">
									<a class="cart-remove icon-x block" data-id="<?php echo $ccrow->pid; ?>" data-pvid="<?php echo $pvid; ?>"></a>
								</td>
							</tr>
							
							<?php endforeach; ?>
							
							<?php unset($ccrow); ?>
							
							<?php else: ?>
							<!-- for validation purposes -->
							<tr style="display: none;">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="empty-cart" colspan="6">Your cart is empty, find some cool stuff in the <a href="<?php echo SITEURL; ?>/shop">shop</a>.</td>
							</tr>
							<?php endif; ?>
						
						</tbody>
					
					
						<tfoot>
							<tr>
								<td colspan="6" class="text-right">
									<span class="cart-subtotal-label">Subtotal</span>
									<span id="subtotal" class="cart-subtotal"><?php echo $content->getCartCounterCost(); ?></span>
								</td>
							</tr>
							<tr>
								<td colspan="6" class="text-right">
									<?php if ($cartrow): ?>
										
										<?php if ($user->logged_in): ?>
											<a class="btn primary med fr checkout" href="<?php echo SITEURL; ?>/checkout">Check out</a>
										<?php else: ?>
											<a class="btn primary med fr checkout" id="user_not_logged_in">Check out</a>
										<?php endif; ?>
									
									<?php endif; ?>
									<a class="btn med fr checkout checkout-cs" href="<?php echo SITEURL; ?>/shop">Continue Shopping</a>
									<p class="cart-text">
									    Shipping &amp; taxes calculated at checkout <br />
									    Discount code can be applied on next page
									</p>
								</td>
							</tr>
						</tfoot>
					</table>
				
				</form>
			
			
			</div>
		
		</section>
	
	</div>

	
	<?php require('components/footer-simple.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>

	<div id="modal-login" class="modal-box" style="display: none;">
		<h2>Sign in to complete checkout</h2>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="text-center option">
					<p>Already a member?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL; ?>/login">Sign In</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="text-center option">
					<p>New to <?php echo $core->site_name;?>?</p>
					<a class="btn full-width large primary" href="<?php echo SITEURL; ?>/register">Sign Up</a>
				</div>
			</div>
		
		</div>
	</div>

	<script type="text/javascript">
		var myModal;
		$(document).ready(function () {
			myModal = new jBox('Modal', {
				attach: '#user_not_logged_in',
				content: $('#modal-login')
			});
		});
		$(window).resize(function () {
			myModal.close();
		});
	</script>
</body>

</html>
