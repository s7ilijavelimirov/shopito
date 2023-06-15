<?php
/**
 * Admin scripts
 *
 * @package s7design
 */

/**
 * Admin scripts
 */
function s7design_admin_scripts() {

    if ( is_admin() ) {
       // wp_enqueue_script( 'shopkeeper-customizer', get_template_directory_uri() . '/js/admin/customizer.js', array( 'jquery' ), '1.0.0', TRUE );
        wp_enqueue_script( 'shopkeeper-notices',    get_template_directory_uri() . '/dist/js/admin-build.js', array( 'jquery' ), '1.0.0', TRUE );
    }
}
add_action( 'admin_enqueue_scripts', 's7design_admin_scripts' );
