<?php
/**
 * Genesis Framework.
 *
 * Template Name: Billing Template
 * 
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/genesis/
 */

?>
<div class="row checkout-divider-row">
<div class="col-xs-12 col-md-7">
	<?php echo do_shortcode('[woocommerce_checkout]');?>	
</div>
<div class="col-xs-12 col-md-5">
	<h3 id="order_review_heading"><?php _e( 'Order Summary', 'woocommerce' ); ?></h3>
	<?php echo do_shortcode('[woocommerce_cart]');?>	
	
</div>

</div>
<?php
genesis();