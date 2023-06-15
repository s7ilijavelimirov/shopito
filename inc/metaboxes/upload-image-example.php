<?php 
/**
 * Upload image 
 *
 * @package s7design
 */

function s7design_include_myuploadscript() {
    /*
     * I recommend to add additional conditions just to not to load the scipts on each page
     * like:
     * if ( !in_array('post-new.php','post.php') ) return;
     */
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/assets/js/admin/scripts/metaboxes.js', array('jquery'), null, false );
}

add_action( 'admin_enqueue_scripts', 's7design_include_myuploadscript' );

function s7design_image_uploader_field( $name, $value = '') {
    $image = ' button">Upload image';
    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
    $display = 'none'; // display state ot the "Remove image" button

    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
        
        // $image_attributes[0] - image URL
        // $image_attributes[1] - image width
        // $image_attributes[2] - image height

        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:400px;display:block;" />';
        $display = 'inline-block';

    } 

    return '
    <div>
        <a style="max-width:300px;" href="#" class="s7design_upload_image_button' . $image . '</a>
        <input style="width:300px;" type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
        <a href="#" class="s7design_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
    </div>';
}

/*
 * Add a meta box
 */
add_action( 'admin_menu', 's7design_meta_box_add' );

function s7design_meta_box_add() {
    add_meta_box('s7designdiv', // meta box ID
        'Upload Image 2', // meta box title
        's7design_print_box', // callback function that prints the meta box HTML 
        get_post_types(), // post type where to add it
        'normal', // priority
        'high' ); // position
}

/*
 * Meta Box HTML
 */
function s7design_print_box( $post ) {
    $meta_key = 'second_featured_img';
    echo s7design_image_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );
}

/*
 * Save Meta Box data
 */
add_action('save_post', 's7_image_save');

function s7_image_save( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;

    $meta_key = 'second_featured_img';

    update_post_meta( $post_id, $meta_key, $_POST[$meta_key] );

    // if you would like to attach the uploaded image to this post, uncomment the line:
    // wp_update_post( array( 'ID' => $_POST[$meta_key], 'post_parent' => $post_id ) );

    return $post_id;
}