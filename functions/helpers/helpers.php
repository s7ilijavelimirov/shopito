<?php
/*
 * S7design sanitize checkbox function
 */
function S7design_sanitize_checkbox( $checked ) {

    // Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );

}


// /* META BOX FIELD UNSANITAZE */

// /*
//  * fetch meta data fields
//  * */
// function s7_get_field($fieldName) {
//     global $post;
// 	$field = get_post_meta( $post->ID, $value, true );
// 	if ( ! empty( $field ) ) {
// 		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
// 	} else {
// 		return false;
// 	}
// }

/* 
 *  param: $fieldName - always have to be in serialized format
*/
function s7_get_serialized_fields($fieldName) {
	global $post;
	$fields = unserialize( get_post_meta( $post->ID, $fieldName, true ));

	return $fields;
}

function s7_get_image_field($fieldName, $size) {
    global $post;
    $attachment_id =  get_post_meta( $post->ID, $fieldName,true );
    $media = wp_get_attachment_image_src($attachment_id, $size);

    return $media;
}

function s7_get_media_field($fieldName) {
    global $post;
    $attachment_id =  get_post_meta( $post->ID, $fieldName,true );
    $media_url =  get_attached_file( $attachment_id , '_wp_attached_file',false );

    return $media_url;
}
// /* 
//   THIS FUNCTION AUTOMATICLLY INCLUDE SCRIPT ON THE SPECIFIC PAGE
//    in assets/js create script with prefix 'page-'  and call file as link of page
//    e.g.   url: /contact-us  , file name : page-contact-us.js 
//   */ 
// function getScriptByPage() {
//     $dir    = get_template_directory() .'/dist/js';

//     $files = scandir($dir);
//    foreach($files as $file) {
//     if(preg_match("/^page-(.+)-build\.js$/", $file, $reg))  { 
//         $page_name = $reg[1]; // substr($file, 0, -9);
       
//         if(is_page($page_name)) {
    
//             wp_register_script( $page_name.'-script',    get_template_directory_uri() . '/dist/js/'.$file, array( ), '1.0.0', TRUE );
//             wp_enqueue_script( $page_name.'-script');
       
//       }
//     }
//    }
// //die();
// }