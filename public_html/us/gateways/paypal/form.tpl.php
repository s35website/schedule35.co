<?php
  /**
   * Paypal Form
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: form.tpl.php, v2.00 2011-04-20 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
   $cartrow = $content->getCartContent();
   $cart = $content->getCart();
?>
<div class="wojo basic button">
  <?php $url = ($row->demo == '0') ? 'www.sandbox.paypal.com' : 'www.paypal.com';?>
  <form action="https://<?php echo $url;?>/cgi-bin/webscr" class="xform" method="post" id="pp_form" name="pp_form">
    <input type="image" src="gateways/paypal/paypal_big.png" name="submit" style="vertical-align:middle;border:0;width:244px;margin-right:10px" title="Pay With Paypal" alt="" onclick="document.pp_form.submit();"/>
    <input type="hidden" name="cmd" value="_cart"/>
    <input type="hidden" name="upload" value="1" />
    <input type="hidden" name="business" value="<?php echo $row->extra;?>" />
    <input type="hidden" name="notify_url" value="<?php echo SITEURL . '/gateways/' . $row->dir;?>/ipn.php" />
    <input type="hidden" name="return" value="<?php echo SITEURL;?>/account.php" />
    <input type="hidden" name="currency_code" value="<?php echo ($row->extra2) ? $row->extra2 : $core->currency;?>" />
    <input type="hidden" name="custom" value="<?php echo $user->uid.'_'.$user->sesid;?>" />
    <input type="hidden" name="no_note" value="0" />
    <input type="hidden" name="rm" value="2" />
    <?php if($cart->coupon <> 0):?>
    <input type="hidden" name="discount_amount_cart" value="<?php echo $cart->coupon;?>" />
    <?php endif;?>
    <?php if($core->tax):?>
    <input type="hidden" name="tax_cart" value="<?php echo number_format($cart->total * $cart->tax, 2);?>" />
    <?php endif;?>
    <?php $x = 0;?>
    <?php foreach ($cartrow as $crow):?>
    <?php $x++; ?>
    <input type="hidden" name="item_name_<?php echo $x;?>" value="<?php echo cleanOut($crow->title);?>" />
    <input type="hidden" name="item_number_<?php echo $x;?>" value="<?php echo $crow->pid;?>" />
    <input type="hidden" name="quantity_<?php echo $x;?>" value="<?php echo $crow->total;?>" />
    <input type="hidden" name="amount_<?php echo $x;?>" value="<?php echo $crow->price;?>" />
    <?php endforeach;?>
    <?php unset($crow);?>
  </form>
</div>