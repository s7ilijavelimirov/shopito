<?php

/**
 * Theme setup
 *
 * @package s7design
 */

add_action('after_setup_theme', 's7design_theme_setup');

/**
 * Set up theme
 *
 * @return void
 */
function s7design_theme_setup()
{

	add_image_size('my-custom-size', 220, 180, true);
}

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');


//Register menu placeholder
register_nav_menus(
	array(

		'main-menu' => "Main Menu",
		'woo-menu' => "Woocommerce menu",
		'footer-menu' => "Footer Menu",
		'mobile-menu' => "Mobile menu"
	)
);


//add theme support for display Menu
add_theme_support('menus');
//add theme support for title tag
add_theme_support('title-tag');
//add theme support for post thumbnails
add_theme_support('post-thumbnails');
//add theme support for widgets
add_theme_support('widgets');
//add theme support for Yoast plugin
add_theme_support('yoast-seo-breadcrumbs');

/**
 * Add support for core custom logo.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
add_theme_support('custom-logo', array(
	'height'      => '400',
	'width'       => '100',
	'flex-width'  => true,
	'flex-height' => true,
));
/* 
 WIDGETS 
*/
function arphabet_widgets_init()
{

	register_sidebar(array(
		'name'          => 'Copyright',
		'id'            => 'footer_1',
		'before_widget' => '<div class="copyright">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => 'Footer Menu',
		'id'            => 'footer_2',
		'before_widget' => '<div class="footer-menu">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="rounded">',
		'after_title'   => '</h5>',
	));
	register_sidebar(array(
		'name'          => 'Footer Social icon',
		'id'            => 'footer_3',
		'before_widget' => '<div class="social-icon">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => 'Footer Logo',
		'id'            => 'footer_4',
		'before_widget' => '<div class="footer-logo">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => 'Footer Contact Us',
		'id'            => 'footer_5',
		'before_widget' => '<div class="contact-us">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => 'Footer image',
		'id'            => 'footer_6',
		'before_widget' => '<div class="footer-image">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<div class="sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __('WooCommerce Sidebar', 'shopito'),
		'id'            => 'woocommerce_sidebar',
		'description'   => __('Widget area for WooCommerce pages', 'shopito'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __('WooCommerce Category', 'shopito'),
		'id'            => 'woocommerce_category',
		'description'   => __('Widget area for Frontpage', 'shopito'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
}
add_action('widgets_init', 'arphabet_widgets_init');

/* 
$purifyCssEnabled = array_key_exists('purifytest',$_GET);

// when you're done, set the variable to true - you will be able to disable it anytime with just one change
 $purifyCssEnabled = true;

function dequeue_all_styles() {
    global $wp_styles;
    foreach( $wp_styles->queue as $style ) {
        wp_dequeue_style($wp_styles->registered[$style]->handle);
    }
}

if ($purifyCssEnabled) {
    // this will remove all enqueued styles in head
    add_action('wp_print_styles', 'dequeue_all_styles', PHP_INT_MAX - 1);

    // if there are any plugins that print styles in body (like Elementor),
    // you'll need to remove them as well
    add_action('elementor/frontend/after_enqueue_styles', 'dequeue_all_styles',PHP_INT_MAX);
} */

/* function enqueue_pure_styles() {
    wp_enqueue_style('pure-styles', get_stylesheet_directory_uri().'/styles.pure.css');
}

if ($purifyCssEnabled) {
    // enqueue our purified css file
    add_action('wp_print_styles', 'enqueue_pure_styles', PHP_INT_MAX);
} */