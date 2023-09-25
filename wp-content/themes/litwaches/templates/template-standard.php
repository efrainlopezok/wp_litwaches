<?php
/**
* Template Name: Standard Template
* Description: Used as a page template to show a hero banner then below shows the loop
*/

// Add specific CSS class by filter.
 
function add_standar_body_class( $classes ) {
	return array_merge( $classes, array( 'standard-template' ) );
}
add_filter( 'body_class', 'add_standar_body_class');

//* Remove .site-inner
add_filter( 'genesis_markup_site-inner', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
add_filter( 'genesis_markup_content', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

// Reposition the loop 
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'lit_standar_loop' );
add_action( 'lit_standar_inner_loop', 'genesis_do_loop' );

function lit_standar_loop() {
	?>
	<div class="site-inner">
		<div class="wrap">
			<?php do_action( 'lit_standar_inner_loop'); ?>
		</div>
	</div>
	<?php
}

genesis();