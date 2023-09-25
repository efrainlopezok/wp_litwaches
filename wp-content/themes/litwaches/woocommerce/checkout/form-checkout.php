<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="content-tabpane">

	  <?php if ( $checkout->get_checkout_fields() ) : ?>

	  	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<!-- Step 1 tab -->
		<div id="checkout_billing_shipping_tab" class="content-tab active">

			<div class="row checkout-divider-row">
				<div class="col-md-7">
					<h2 class="heading"><?php _e( 'Information', 'woocommerce' ); ?></h2>
				</div>
				<div class="col-md-5"></div>

				<div class="col-xs-12 col-md-7">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>

					<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
						<div class="woo-addons-shipping_method">

							<!--<h2 class="heading">Shipping Method</h2>
							<p class="lit-step1-shipping-info">$0.00 - We Pay Shipping!</p>-->

              <div id="step1_shipping_methods">
  							<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

  							<!--<?php wc_cart_totals_shipping_html(); ?>-->

  							<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
              </div>

						</div>
					<?php endif; ?>

				</div>
				<div class="col-xs-12 col-md-5">
					<div class="woo-addon-box woo-order-summary">
						<h2 id="order_review_heading" ><?php _e( 'Order Summary', 'woocommerce' ); ?></h2>
						<hr>

						<?php do_action( 'lit_checkout_billing_order_summary' ); ?>

						<button type="button" class="button" id="checkpout_btn_step1">Continue To Payment Method</button>

						<?php do_action( 'lit_checkout_after_billing_order_summary' ); ?>
					</div>
						
				</div>

			</div>

		</div>
		<!-- End Step 1 tab -->

		<!-- Step 2 tab -->
		<div id="checkout_payment_review_tab" class="content-tab payment-review-tab">
			<div class="row checkout-divider-row">
				<div class="col-md-7">
					<h2 class="heading">Payment & Review</h2>
				</div>
				<div class="col-md-5"></div>

				<div class="col-md-7">
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

				<div class="col-md-5">
					<div class="woo-addon-box woo-order-summary">
						<h2 id="order_review_heading" ><?php _e( 'Order Summary', 'woocommerce' ); ?></h2>
						<hr>

						<?php //do_action( 'lit_checkout_billing_order_summary' ); ?>
						<?php wc_get_template( 'checkout/review-order_step2.php', array(
									'checkout' => WC()->checkout(),
								) ); ?>

						<div class="form-check">
							<input type="checkbox" id="check_step2">
							<label for="check_step2">Terms of Service</label>
							<a class="checkout-terms-service-link" target="__blank" href="<?php echo get_site_url(null, '/terms-service') ?>">show terms</a>
						</div>

						<button class="button" id="checkpout_btn_step2">PLACE MY 100% SECURE ORDER NOW</button>
						<button class="button" type="button" id="checkout_btn_backto_step1">BACK TO BILLING & SHIPPING</button>

						<?php do_action( 'lit_checkout_after_billing_order_summary' ); ?>
					</div>

					<div class="lit-address-summary lit-address-shipping">
						<h3>Ship to</h3>
						<p>Av ecologica Central Park<br>Apartment #1, Of. #2</p>
					</div>
					<div class="lit-step2-summary-text" id="step2_summary_shipping">
						<h3>Shipping Method</h3>
						<p class="lit-step2-shipping-method">There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help</p>
					</div>
				</div>
			</div>
			
		</div>
		<!-- End Step 2 tab -->

		<div id="checkout_success_tab" class="content-tab">
			
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	  <?php endif; ?>


	</div>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
