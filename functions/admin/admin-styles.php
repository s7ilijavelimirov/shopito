<?php
/**
 * Admin styles
 *
 * @package s7design
 */

 /**
  * Admin styles
  */
function s7design_admin_styles() {

    // Enqueue Main Font
    if ( is_admin() ) {

        wp_enqueue_style( 's7design_admin_styles', get_template_directory_uri() . '/dist/css/admin.min.css', false, '1.0.0', 'all' );

    }
}
add_action( 'admin_enqueue_scripts', 's7design_admin_styles' );

?>
