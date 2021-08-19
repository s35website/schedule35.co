<?php
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');
    
    // Just to preview data:
    $cartrow = $content->getWholesaleCartContent(false);
?>
<?php $_SESSION["pageurl"] = "wholesale?p=cart"; ?>


<div class="main">

	<section class="wrapper cart-padding padded bg-white">
	
		<div class="container max-width">
		
			<form action="/cart" method="post" novalidate="" class="cart-wrapper" style="border: 1px solid #d2d2d2; margin-bottom:100px">
				<div class="cart-wrapper-overlay loading-overlay">
					<div class="circle-loader"></div>
				</div>
				
				<h2 class="t0 title p42">Review Order</h2>
				
				<table class="cart-table">
					<tbody>
						
					<?php if ($cartrow): ?>
					<?php $i = 0;
						  $totalUnit = 0;
					 ?>
					<?php foreach ($cartrow as $ccrow): ?>
					
						<?php
							$i++;
							$price = $ccrow->unit_price;
							if ($ccrow->pvid > 0) {
								$variantData = $item->getProductVariants($ccrow->pid, $ccrow->pvid);
								$variantTitle = $variantData[0]->title;
								$pvid = $ccrow->pvid;
								$total_price = $price * $ccrow->qty;
							} else {
								$variantTitle = "";
								$total_price = $price * $ccrow->qty;
								$pvid = 0;
							}
							$totalUnit = $totalUnit + $ccrow->qty;
							$productRow = $db->first("SELECT products.id as id, products.title, products.stock, products.soldflag, products.slug, products.thumb,products.flag_multiple, categories.name as cname FROM " . Products::pTable . " inner join categories on products.cid = categories.id WHERE products.id = " . $ccrow->pid);
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
								<div class="custom-number-input wholesale-input div-center">
									<span class="input-number-decrement">–</span>
									<?php if ($productRow->flag_multiple > 0):?>
									<?php $variantStock = $db->first("SELECT id, dosage FROM " . Products::pvTable . " WHERE id = " . $pvid); ?>
									<input id="stockval" class="input-number" type="text" value="<?php echo $ccrow->qty; ?>" data-max="<?php echo ($productRow->stock / $variantStock->dosage);?>" data-stockval="<?php echo $variantStock->dosage;?>" readonly>
									<?php else:?>
									<input id="stockval" class="input-number" type="text" value="<?php echo $ccrow->qty; ?>" data-max="<?php echo $productRow->stock;?>" data-stockval="1" data-id="<?php echo $productRow->id;?>" data-name="<?php echo $productRow->title;?>" data-category="<?php echo $productRow->cname;?>" data-price="<?php echo $price;?>" readonly>
									<?php endif;?>
									<span class="input-number-increment">+</span>
								</div>
							</td>
				
							<td class="wlabel text-left productTotal" data-label="Total: ">
								$<span class="unit-price"><?php echo money_format('%i', $price); ?></span>/unit
								<!--x  = $<?php echo money_format('%i', $total_price); ?>-->
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
							<td colspan="3" class="text-right">
								<p class="cart-text">
								    Once your invoice is generated <br />
								    you will be contacted with further instructions on how to complete your order.
								</p>
							</td>
							<td colspan="3" class="text-right">
								<span class="cart-subtotal-label">Subtotal</span>
								<span id="subtotal" class="cart-subtotal"><?php echo $content->getWholesaleCartCounterCost(); ?></span>
							</td>
						</tr>
					</tfoot>
				</table>
			
			</form>
		
		
		</div>
	
	</section>

</div>

<footer class="footer-wholesale">
	<div class="container">
		<div class="footer-totals fl">
			<h3 class="p0">Total Units: <span class="total-units"><?php echo $totalUnit ?></span></h3>
			<span>Subtotal: <span class="wholesale-subtotal"><?php echo $content->getWholesaleCartCounterCost(); ?></span></span>
		</div>
		
		<a class="btn black wholesale-add-to-cart fr t30 btn-loader" style="margin-left: 10px;" href="javascript:void(0)"><span>Choose Delivery Options</span><div class="circle-loader"></div></a>
		<a class="btn fr checkout checkout-cs t30" href="<?php echo SITEURL; ?>/wholesale">Back to Inventory</a>
	</div>
	
</footer>


<?php require(THEMEDIR . "/components/scripts.tpl.php"); ?>

<script type="text/javascript">
	// Check if click was triggered on or within #menu_content
	var wholeSaleCart = [];
	$( document ).ready(function() {
		
		$(".input-number").each(function() {
		
		var id = $(this).attr("data-id");
		var description = $(this).attr("data-name");
		var category = $(this).attr("data-category");
		var value = $(this).val();
		var price = $(this).attr("data-price");
		var cartItem = new Object();
		cartItem["id"] = id;
		cartItem["qty"] = parseInt(value);
		cartItem["description"] = description;
		cartItem["price"] = parseFloat(price);
		if(cartItem["qty"] > 0){
		wholeSaleCart.push(cartItem);
		}
  			
		});
	});
	
</script>