<?php
  /**
   * Stripe Form
   *
   * @package reelance Manager
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: form.tpl.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');
	
   $cartrow = $content->getCartContent();
   $cart = $content->getCart();
?>
<div class="wojo form">
  <form method="post" id="stripe_form">
    <div class="field">
      <label>Card Number</label>
      <label class="input"> <i class="icon-append icon asterisk"></i>
        <input type="text" autocomplete="off" name="card-number" placeholder="Card Number">
      </label>
    </div>
    <div class="three fields">
      <div class="field">
        <label>CVC</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-cvc" placeholder="CVC">
        </label>
      </div>
      <div class="field">
        <label>Expiration Month</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-expiry-month" placeholder="MM">
        </label>
      </div>
      <div class="field">
        <label>Expiration Year</label>
        <label class="input"> <i class="icon-append icon asterisk"></i>
          <input type="text" autocomplete="off" name="card-expiry-year" placeholder="YYYY">
        </label>
      </div>
    </div>
    <button class="wojo positive right labeled icon button" id="dostripe" name="dostripe" type="button"><i class="right arrow icon"></i> Submit Payment</button>
    <input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />
    <input type="hidden" name="item_name" value="Checkout from <?php echo $core->company;?>" />
    <input type="hidden" name="item_number" value="<?php echo $user->uid;?>" />
    <input type="hidden" name="currency_code" value="<?php echo ($row->extra2) ? $row->extra2 : $core->currency;?>" />
    <input type="hidden" name="processStripePayment" value="1" />
  </form>
 </div>
<div id="msgholder" class="small-top-space"></div> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $('#dostripe').on('click', function () {
		$(".wojo.form").addClass('loading');
        var str = $("#stripe_form").serialize();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: SITEURL + "/gateways/stripe/ipn.php",
            data: str,
            success: function (json) {
				$(".wojo.form").removeClass('loading');
                if (json.type == "success") {
					window.location.href = SITEURL + '/account.php';
                } else {
                    $("#msgholder").html(json.message);
                }
            }
        });
        return false;
    });
});
// ]]>
</script> 