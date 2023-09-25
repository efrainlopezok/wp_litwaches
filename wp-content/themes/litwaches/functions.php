<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Start plugins
include_once( get_stylesheet_directory() . '/plugins/init.php' );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Lit Waches' );
define( 'CHILD_THEME_URL', 'http://litwaches.com' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' , 1);
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-quicksand', '//fonts.googleapis.com/css?family=Quicksand:300,400,500,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-opensans', '//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i',array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'slick-script', get_stylesheet_directory_uri().'/lib/js/slick/slick.js', array( 'jquery' ), false, true );

	wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri().'/lib/js/slick/slick.css', array(), false, 'all' );
	wp_enqueue_style( 'slick-theme-style', get_stylesheet_directory_uri().'/lib/js/slick/slick-theme.css', array('slick-style'), false, 'all' );

	wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri().'/lib/js/custom.js', array( 'jquery' ), false, true );

	wp_enqueue_script( 'video-script', get_stylesheet_directory_uri().'/lib/js/video.js', array( 'jquery' ), false, true );
	wp_localize_script( "custom-script", "ajaxurl", array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Put genesis styles after other plugins styles
 * @uses genesis_meta  <genesis/lib/css/load-styles.php>
*/ 
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 90 );


//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


/* # Header Schema
---------------------------------------------------------------------------------------------------- */

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
function custom_site_title() { 
	$logo = get_field( 'logo', 'option' );
	echo '<a class="retina logo" href="'.get_bloginfo('url').'" title="Lit Waches"><img src="'.$logo.'" alt="logo"/></a>';
}
add_action( 'genesis_site_title', 'custom_site_title' );




remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );
//add in the new header markup - prefix the function name - here sm_ is used
add_action( 'genesis_header', 'sm_genesis_header_markup_open', 5 );
add_action( 'genesis_header', 'sm_genesis_header_markup_close', 15 );
add_action( 'genesis_header', 'sm_genesis_do_header' );
//New Header functions
function sm_genesis_header_markup_open() {
	
	genesis_markup( array(
		'html5'   => '<header %s>',
		'context' => 'site-header',
	) );
	// Added in content
	echo '<div class="header-ghost"></div>';
	// genesis_structural_wrap( 'header' );
}
function sm_genesis_header_markup_close() {
	genesis_structural_wrap( 'header', 'close' );
	genesis_markup( array(
		'close'   => '</header>',
		'context' => 'site-header',
    ) );
   
}
function sm_genesis_do_header() {
	global $wp_registered_sidebars;
	// print_r($header_options);
	echo '<div class="wrap">
			<div class="hamburger-right"><span></span><span></span><span></span></div>
			<div class="row">';
	echo '<div class="col-2 top-menu-logo">';
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
	echo '<div class="col-8 col-md-7 top-menu-center">';
	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		genesis_markup( array(
			'open'    => '<div %s>' . genesis_sidebar_title( 'header-right' ),
			'context' => 'header-widget-area',
		) );
			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			// echo '<button type="button" class="responsive-menu mobile-show">
			// 		<span class="icon-bar"></span>
			// 		<span class="icon-bar"></span>
			// 		<span class="icon-bar"></span>
			// 	</button>';

		genesis_markup( array(
			'close'   => '</div>',
			'context' => 'header-widget-area',
		) );
	}
	echo '</div>';
	// Add Shopping cart, hearth, login
	echo '<div class="col-2 col-md-3 top-menu-socials">';
	echo '<ul class="list-operations">';
	echo '<li><a href="'.get_site_url().'/my-account"><img src="'.get_stylesheet_directory_uri().'/images/person.png" /></a></li>';
	echo '<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/images/hearth.png" /></a></li>';
	echo '<li><a href="'.get_site_url().'/cart"><img src="'.get_stylesheet_directory_uri().'/images/cart.png" /></a></li>';
	echo '</ul>';
	echo '</div>';
	// End Shopping cart, hearth, login
	echo '</div></div>';
}

remove_action( 'genesis_footer', 'genesis_do_footer' );

function genesis_custom_footer() {
	// Add Shopping cart, hearth, login
	echo '<div class="footer-bottom-socials">';
	echo '<ul class="list-operations">';
	echo '<li><a href="'.get_site_url().'/my-account"><img src="'.get_stylesheet_directory_uri().'/images/person.png" /></a></li>';
	echo '<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/images/hearth.png" /></a></li>';
	echo '<li><a href="'.get_site_url().'/cart"><img src="'.get_stylesheet_directory_uri().'/images/cart.png" /></a></li>';
	echo '</ul>';
	echo '</div>';
}
add_action( 'genesis_footer', 'genesis_custom_footer');

/* # Custom hero header
---------------------------------------------------------------------------------------------------- */
function display_page_featured_image() {
	$hero_block	= get_field('header_hero');
    if( $hero_block['hero_content'] && $hero_block['hero_image'] ):
        ?>
        <section class="section-hero" style="background-image: url('<?php echo $hero_block['hero_image']?>')">
                <div class="wrap">
                    <div class="hero-content">
 
                        <?php echo do_shortcode($hero_block['hero_content']); ?>
                        <?php if(isset($hero_block['hero_button']['title'])): ?>
                        <?php echo do_shortcode('[button color="red" url="'
                        		. $hero_block['hero_button']['url'].'" target="'
                        		. $hero_block['hero_button']['target'].'"]'
                        		. $hero_block['hero_button']['title'].'[/button]');
                        ?>
                        <?php endif; ?>
					</div>
                </div>
        </section>
        <?php
    endif;
}
add_action( 'genesis_after_header', 'display_page_featured_image' );

/* # Remove Pages Title
---------------------------------------------------------------------------------------------------- */
remove_action('genesis_entry_header', 'genesis_do_post_title');


include(get_stylesheet_directory() . '/lib/woocommerce-functions.php');

