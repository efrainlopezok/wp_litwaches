<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/genesis/
 */


function single_product_testimonials() {
	get_template_part( 'content', 'testimonials' );
}
add_action( 'genesis_after_content_sidebar_wrap', 'single_product_testimonials' );

// This file handles single entries, but only exists for the sake of child theme forward compatibility.
genesis();