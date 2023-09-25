<?php


/* # Woocommerce
---------------------------------------------------------------------------------------------------- */


function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

/**
 * Remove Primary Navigation Menu from cart page
 */
function lit_remove_mainnav() {
    if ( ! is_cart() && !is_checkout() ) {
        return;
    }

    remove_action( 'genesis_header', 'sm_genesis_do_header' );
    add_action('genesis_header', 'lit_woocommerce_header');
}

add_action( 'genesis_before_header', 'lit_remove_mainnav' );

function lit_woocommerce_header() {
	echo '<div class="wrap">
			<div class="row woo-header-row">';

	echo '<div class="col-md-2 col-3 top-menu-logo">';

	genesis_markup( array(
		'open'    => '<div %s>',
		'context' => 'title-area',
	) );
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	
	genesis_markup( array(
		'close'    => '</div>',
		'context' => 'title-area',
	) );

	echo '</div>';
	echo '<div class="col-1 col-md-6">';
	echo '</div>';

	// Add Shopping cart, hearth, login
	echo '<div class="col-8 col-md-4 woo-nav-right">';
	echo '<p><strong>Questions?</strong> Call Us: <a href="tel:123 123 1234">123.123.1234</a></p>';
	echo '</div>';

	// End Shopping cart, hearth, login
	echo '</div></div>';
}

// * remove related product on single-product page

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// * Shipping and return policy

function liafter_after_cart_totals() {
	echo '<a href="" class="policy-link">Our shipping and return policy</a>';
	echo '<img src="'.get_stylesheet_directory_uri().'/images/website-trust-symbols@2x.png" alt="website-trust-symbols" class="trusted-symbols" />';
}
add_action( 'woocommerce_after_cart_totals', 'liafter_after_cart_totals');
add_action( 'lit_checkout_after_billing_order_summary', 'liafter_after_cart_totals');


// * Removes shipping method label
  
function lit_remove_shipping_label($label, $method) {
	if( is_cart() ) {
		$label = $method->cost == 0? wc_price(0) : wc_price( $method->cost );
	}
	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'lit_remove_shipping_label', 10, 2 );

function lit_woo_cart_disclaimer_terms() {
	echo '<div class="disclaimer-terms">';
	echo '<h3>Disclaimer & Terms of Service</h3>';
	echo '<p>Nulla vitae elit libero, a pharetra augue. Cras mattis consectetur purus sit amet fermentum. Cras mattis consectetur purus sit amet fermentum. Curabitur blandit tempus porttitor</p>';
	echo '<p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Maecenas sed diam eget risus varius blandit sit amet non magna.</p>';
	echo '</div>';
}
add_action( 'woocommerce_after_cart', 'lit_woo_cart_disclaimer_terms' );

// * checkout navigation steps

function lit_checkout_steps() {
	if( is_checkout() && !is_order_received_page() ):
	?>
	<div class="nav-steps-section">
		<div class="wrap">
			<ul>
				<li class="active"><span>Billing & Shipping</span></li>
				<li><span>Payment & Review</span></li>
				<li class="disabled"><span>Complete</span></li>
			</ul>
		</div>	
	</div>
	<?php
	endif;
}
add_action( 'genesis_after_header', 'lit_checkout_steps' );

// Order Summary on step 2
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
add_action( 'lit_checkout_billing_order_summary', 'woocommerce_order_review');

// Add quantiy to Checkout
function add_quantity( $product_title, $cart_item, $cart_item_key ) {
	/* Checkout page check */
	if (  is_checkout() ) {
		/* Get Cart of the user */
		$cart     = WC()->cart->get_cart();
			foreach ( $cart as $cart_key => $cart_value ){
			   if ( $cart_key == $cart_item_key ){
					$product_id = $cart_item['product_id'];
					$_product   = $cart_item['data'] ;
					
					/* Step 1 : Add delete icon */
					$return_value = sprintf(
					  '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
					  esc_url( wc_get_cart_remove_url( $cart_key ) ),
					  __( 'Remove this item', 'woocommerce' ),
					  esc_attr( $product_id ),
					  esc_attr( $_product->get_sku() )
					);
					
					/* Step 2 : Add product name */
					$return_value .= '&nbsp; <span class = "product_name" >' . $product_title . '</span>' ;
					
					/* Step 3 : Add quantity selector */
					if ( $_product->is_sold_individually() ) {
					  $return_value .= sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_key );
					} else {
					  $return_value .= woocommerce_quantity_input( array(
						  'input_name'  => "cart[{$cart_key}][qty]",
						  'input_value' => $cart_item['quantity'],
						  'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
						  'min_value'   => '1'
						  ), $_product, false );
					}
					return $return_value;
				}
			}
	}else{
		/*
		 * It will return the product name on the cart page.
		 * As the filter used on checkout and cart are same.
		 */
		$_product   = $cart_item['data'] ;
		$product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
		if ( ! $product_permalink ) {
			$return_value = $_product->get_title() . '&nbsp;';
		} else {
			$return_value = sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title());
		}
		return $return_value;
	  }
}
add_filter ('woocommerce_cart_item_name', 'add_quantity' , 10, 3 );

function lit_change_cart_coupon_label($couponLabel) {
  return 'DISCOUNT';
}
add_filter( 'woocommerce_cart_totals_coupon_label', 'lit_change_cart_coupon_label');


function load_ajax() {
		if ( !is_user_logged_in() ){
			add_action( 'wp_ajax_nopriv_update_order_review', 'update_order_review' );
		} else{
			add_action( 'wp_ajax_update_order_review', 'update_order_review' );
		}
}
add_action( 'init', 'load_ajax' );

/* Add js at the footer */
function add_quanity_js()	{
	if ( is_checkout() ) {
	  wp_enqueue_script( 'checkout_script', get_stylesheet_directory_uri(). '/lib/js/add_quantity.js', '', '', false );
	  wp_enqueue_style( 'checkout_style', get_stylesheet_directory_uri().'/lib/stylesheets/change-quantity-on-checkout.css', '', '', false ); 
	  $localize_script = array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	  );
	  wp_localize_script( 'checkout_script', 'add_quantity', $localize_script );
	}
}
add_action( 'wp_footer', 'add_quanity_js', 10 );

function update_order_review() {
	$values = array();
	parse_str($_POST['post_data'], $values);
	$cart = $values['cart'];
	foreach ( $cart as $cart_key => $cart_value ){
		WC()->cart->set_quantity( $cart_key, $cart_value['qty'], false );
		WC()->cart->calculate_totals();
		woocommerce_cart_totals();
	}
	wp_die();
}


// * Change checkout default fields

function lit_checkout_custom_labels( $fields ) {
	// error_log(print_r($fields, true));
	$fields['address_1']['label'] = 'Street Address';
	$fields['city']['label'] = 'City';
	$fields['state']['label'] = 'State';
	$fields['postcode']['label'] = 'Zip Code';
	//unset($fields['postcode']);
	return $fields;
}
add_filter( 'woocommerce_default_address_fields' , 'lit_checkout_custom_labels' );


// * checkout thank you page and testimoniald section 
remove_all_actions( 'woocommerce_thankyou');

function lit_woocommerce_thankyou($order_id) {
	if(  is_order_received_page() ) {
		echo '<div class="related-bought-products">';
		echo '<div class="wrap">';
		echo '<h3>Customers Who bought This Item Also Bought</h3>';
		echo do_shortcode( '[recent_products limit="4"]', true );
		echo '</div>';
		echo '</div>';
	}

	if( is_checkout() && !is_order_received_page()) {
		get_template_part( 'content', 'testimonials' );
	}
}

add_action( 'genesis_before_footer', 'lit_woocommerce_thankyou', 1);

add_filter('woocommerce_cart_no_shipping_available_html', 'lit_show_cart_no_shipping');
function lit_show_cart_no_shipping($text) {
	$text = '$0.00';
	return $text;
}


