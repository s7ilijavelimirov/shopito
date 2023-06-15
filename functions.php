<?php

// Helpers.
require_once get_template_directory() . '/functions/helpers/helpers.php';

// Admin setup.
require_once get_template_directory() . '/functions/admin/admin-setup.php';
require_once get_template_directory() . '/functions/admin/admin-styles.php';
require_once get_template_directory() . '/functions/admin/admin-scripts.php';

// Theme setup.
include_once get_template_directory() . '/functions/theme/theme-setup.php';
include_once  get_template_directory() . '/functions/theme/theme-styles.php';
include_once  get_template_directory() . '/functions/theme/theme-scripts.php';

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

/* Disable WordPress widget block editor */
add_filter('use_widgets_block_editor', '__return_false');

add_filter('the_content', 'remove_autop_for_image', 0);

function remove_autop_for_image($content)
{
  global $post;

  if (is_singular('image'))
    remove_filter('the_content', 'wpautop');

  return $content;
}
/* 
 Auto-install and activate necessery plugins 
*/
/* 
require_once( get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php' );
require_once( get_template_directory() . '/inc/tgm/plugins.php' );
 */


/* ACTIVATE KIRKI PLUGIN FOR CUSTOMIZER FIELDS */
// require_once( get_template_directory() . '/inc/class-kirki-installer-section.php' );


/*  CUSTOMIZERS */
require_once get_template_directory() . '/inc/customizer/header-panel.php';

/*  CUSTOM POST TYPES */
//require_once get_template_directory() . '/inc/posttypes/product-post-type.php';

/*  META BOX FIELDS */
// require_once get_template_directory() . '/inc/metaboxes/repeater-fields.php';
// require_once get_template_directory() . '/inc/metaboxes/upload-media-example.php';

/* 
 * Jovana had a conflict with this function when she installed "Contact Form 7" plugin.   
*/
//require_once get_template_directory() . '/inc/metaboxes/upload-image-example.php';


require get_template_directory() . '/inc/woocommerce.php';






// Add theme support for WooCommerce product gallery
add_action('after_setup_theme', 'your_theme_wc_gallery_support');

function your_theme_wc_gallery_support()
{
  add_theme_support('wc-product-gallery-zoom');       // Enable zoom functionality
  add_theme_support('wc-product-gallery-lightbox');   // Enable lightbox functionality
  add_theme_support('wc-product-gallery-slider');     // Enable slider functionality
}

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);