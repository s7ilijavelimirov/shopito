<?php
/* 
@package S7design

==============================
ADMIN PAGE
==============================

*/


function s7design_add_admin_page() {
	
	//Generate Sunset Admin Page
	add_menu_page( 'S7design Theme Options', 'S7 Design', 'manage_options', 's7design_option', 's7design_theme_create_page', '', 4 );
	
	//Generate Sunset Admin Sub Pages
	add_submenu_page( 's7design_option', 'S7design Theme Options', 'General', 'manage_options', 's7design_option', 's7design_theme_create_page' );
	add_submenu_page( 's7design_option', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 's7design_option_css', 's7design_theme_settings_page');
	
	
	
}
add_action( 'admin_menu', 's7design_add_admin_page' );

//Activate custom settings
	add_action( 'admin_init', 's7design_custom_settings' );

function s7design_custom_settings() {
    register_setting( 's7design-settings-group', 'first_name' );
    register_setting( 's7design-settings-group', 'last_name' );
    register_setting( 's7design-settings-group', 'css_library' );


	add_settings_section( 's7design-sidebar-options', 'Sidebar Option', 's7design_sidebar_options', 's7design_option');
	add_settings_section( 's7design-css-options', 'CSS Option', 's7design_css_library', 's7design_option');
 
	add_settings_field( 'sidebar-name', 'Full Name', 's7design_sidebar_name', 's7design_option', 's7design-sidebar-options');
	
    add_settings_field( 'css_library', 'Libraries', 's7design_css_library_name', 's7design_option', 's7design-css-options');
}

function s7design_sidebar_options() {
	echo 'Customize your Sidebar Information';
}
function s7design_css_library() {
	echo 'Activate CSS Library';

}

function s7design_sidebar_name() {
  $firstName = esc_attr( get_option( 'first_name' ) );
	$lastName = esc_attr( get_option( 'last_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" /> <input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name" />';
}
function s7design_css_library_name() {
	?>
	<input type="radio" name="css_library" value="bootstrap" <?php checked('bootstrap', get_option('css_library'), true); ?>>Bootstrap
	<input type="radio" name="css_library" value="materialize" <?php checked('materialize', get_option('css_library'), true); ?>>Materialize
   <?php
}

function s7design_theme_create_page() {
	require_once( get_template_directory() . '/inc/templates/admin/s7options-admin.php' );
}

function s7design_theme_settings_page() {
	
  echo '<h1>S7design Custom CSS</h1>';
}