<?php 

 
function s7design_slider_sanitize( $value ) {

    if ( ! in_array( $value, array( 'Uncategorized','category' ) ) )    
    return $value;

}
	
function s7design_header_settings_fucntion( $wp_customize ){

	
	/* NEWS SETTINGS */
	$wp_customize->add_panel( 'header_panel', array(
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
		'title'      => __('Header', 'S7design'),
	) );
	
		/* News Settings */
		$wp_customize->add_section( 'news_settings' , array(
			'title'      => __('Settings', 'S7design'),
			'panel'  => 'header_panel',
			'description'=> '<p>Go To back and select <strong>Section Contacts Setting</strong> and select news category for fornt page.</p>',
		) );

	
			
		/* section content */
		$wp_customize->add_section( 'topbar_header' , array(
			'title'      => __('Top Bar', 'S7design'),
			'panel'  => 'header_panel'
		) );
            
        	// slider enable
			$wp_customize->add_setting( 'topbar_enable' , array(
                'default'    => true,
                'sanitize_callback' => 'S7design_sanitize_checkbox',
                'type'=>'theme_mod'
                ));
    
            $wp_customize->add_control('topbar_enable' , array(
                'label' => __('Enable Top Bar','S7design'),
                'section' => 'topbar_header',
                'type'=>'checkbox',
            ) );
            $wp_customize->add_setting( 'S7design_option[topbar_section_backgorund_color]' , array(
                'default'    => '',
                'sanitize_callback' => 'sanitize_text_field',
                'type'=>'option'
                ));
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize , 'S7design_option[topbar_section_backgorund_color]' , array(
                'label' => __('Section Background Color','S7design'),
                'section' => 'topbar_header',
                'settings'=>'S7design_option[topbar_section_backgorund_color]'
            ) ) );

            $wp_customize->add_setting( 'S7design_option[topbar_section_text_color]' , array(
                'default'    => '',
                'sanitize_callback' => 'sanitize_text_field',
                'type'=>'option',
                'default' => '#000',

                ));
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize , 'S7design_option[topbar_section_text_color]' , array(
                'label' => __('Text Color','S7design'),
                'section' => 'topbar_header',
                'settings'=>'S7design_option[topbar_section_text_color]'
            ) ) );
            
         
		/* section background */
            $wp_customize->add_section( 'news_background' , array(
                'title'      => __('Header Background', 'S7design'),
                'panel'  => 'header_panel'
            ) );
		
			// news section background color
			$wp_customize->add_setting( 'radon_option[news_section_backgorund_color]' , array(
			'default'    => '',
			'sanitize_callback' => 'sanitize_text_field',
			'type'=>'option'
			));
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize , 'radon_option[news_section_backgorund_color]' , array(
			'label' => __('Section Background Color','S7design'),
			'section' => 'news_background',
			'settings'=>'radon_option[news_section_backgorund_color]'
			) ) );
			

}
add_action( 'customize_register', 's7design_header_settings_fucntion' );

function radon_get_post_category(){

    $cats = get_categories();
  
	$arr = array();

	foreach($cats as $cat){

		$arr[$cat->term_id] = $cat->name;

	}

	return $arr;

}