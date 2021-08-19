<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
	$qty = 0;
	$subtotal = 0;
?>
<?php $_SESSION["pageurl"] = "wholesale"; ?>


<div id="wholesale" class="main">
		

	<section class="wrapper t72 products" style="padding-bottom: 200px;">
	
		<div class="container max-width extended2">



			<div class="h-cat text-center">
				<h2>Wholesale Inventory</h2>
			</div>
			
			<?php if(!$productrow):?>
			<div class="row" style="font-size:1px;font-size:0;text-align:center;">

				<div class="col-sm-12">
					<?php Filter::msgSingleError(Lang::$word->PAGE_ERROR);?>
				</div>

			</div>
			<?php else:?>
			
			
			
			<?php include(THEMEDIR . "/components/pagination.tpl.php");?>
			
			
			
			<div class="row" style="font-size:1px;font-size:0;text-align:center;">
				<?php foreach($productrow as $lrow):?>
				<?php $url = ($core->seo) ? SITEURL . '/product/' . $lrow->slug . '/' : SITEURL . '/item?itemname=' . $lrow->slug;?>
				<?php 
					if ($lrow->soldflag == "1" || $lrow->stock < 20) {
						$oos = true;
					}else {
						$oos = false;
					}
					$qty = $qty + $lrow->qty;
					$subtotal = $subtotal + $lrow->qty*$lrow->cartPrice;
				 ?>
				<div class="col-sm-6 col-md-4 col-lg-3 col-product col-wholesale">
				
					<div class="product<?php echo ($oos ? ' oos' : ''); ?> <?php echo (($lrow->qty != null) ? ' active' : ''); ?>">
						<div class="item-image" data-url="<?php echo $url;?>">
							<img src="<?php echo UPLOADURL;?>prod_images/<?php echo ($lrow->thumb) ? $lrow->thumb : "blank.png";?>" alt="<?php echo $lrow->title;?>" />
						</div>

						<div class="item-info">
							<div class="product-price-container">
								<span class="product-name-text"><?php echo $lrow->title;?></span>
							</div>
							
							<div class="bottom-callout t18 p36">
								<?php if($oos):?>
								<span class="callout-text callout-text-sold">Out of Stock</span>
								<?php else:?>
								<span class="callout-text"><?php echo $lrow->dosage;?>mg THC / <?php echo $lrow->pieces;?> Pieces</span>
								<?php endif;?>
							</div>
							<div class="bottom-quantity t12 p30">
								<div class="custom-number-input wholesale-input">
									<span class="input-number-decrement">–</span>
									<input id="stockval" class="input-number" type="text" value="<?php if($lrow->qty == null) { echo "0"; }else{echo $lrow->qty;}?>" data-max="<?php echo $lrow->stock;?>" data-id="<?php echo $lrow->id;?>" data-name="<?php echo $lrow->title;?>" data-category="<?php echo $lrow->cname;?>" data-price="<?php echo $lrow->cartPrice;?>" data-stockval="20" readonly>
									<span class="input-number-increment">+</span>
								</div>
							</div>
							
						</div>

					</div>
				
				</div>
				<?php endforeach;?>
			</div>
			
			
			
			
			<?php include(THEMEDIR . "/components/pagination.tpl.php");?>
			<?php endif;?>

		</div>

	</section>
	
</div>


<footer class="footer-wholesale">
	<div class="container">
		<div class="footer-totals fl">
			<h3 class="p0">Total Units: <span class="total-units"><?php echo $qty ?></span></h3>
			<span>Subtotal: <span class="wholesale-subtotal">$<?php echo money_format('%i', $subtotal); ?></span></span>
		</div>
		<?php if($user->logged_in) { 
			if($qty < 60) {
			?>
		<a class="btn disabled fr t30 btn-loader" href="javascript:void(0)"><span>N/A (minimum order not reached)</span><div class="circle-loader"></div></a>
			<?php }else{ ?>	
		<a class="btn black wholesale-add-to-cart fr t30 btn-loader" href="javascript:void(0)"><span>Add Items</span><div class="circle-loader"></div></a>	
		<?php }}else{ ?>
			<a class="btn black fr t30 btn-loader" href="/login"><span>Login to purchase</span><div class="circle-loader"></div></a>
		<?php } ?>
	</div>
	
</footer>

<?php require(THEMEDIR . "/components/scripts.tpl.php"); ?>

<script type="text/javascript">
	// Check if click was triggered on or within #menu_content
	var wholeSaleCart = [];
	$( document ).ready(function() {
		$('.product').click(function(evt){
			if ($(evt.target).closest('.bottom-quantity').length) {
				return;
			}else {
				if (!$(this).hasClass("oos")) {
					$(this).toggleClass("active");
				}
			}
		
		});
		
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