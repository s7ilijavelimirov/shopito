<?php 
// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Products', 'text_domain' ),
		'name_admin_bar'        => __( 'Products', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Products', 'text_domain' ),
		'add_new_item'          => __( 'Add New Product', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Product', 'text_domain' ),
		'edit'                  => __( 'Edit Product', 'text_domain' ),
		'edit_item'             => __( 'Edit Product', 'text_domain' ),
		'update_item'           => __( 'Update Product', 'text_domain' ),
		'view_item'             => __( 'View Product', 'text_domain' ),
		'view_items'            => __( 'View Products', 'text_domain' ),
		'search_items'          => __( 'Search Product', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'description'           => __( 'Description', 'text_domain' ),
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-admin-site-alt3',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'products' ), //array( 'slug' => '/', 'with_front' => false ), if we dont want show in url params
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => 6,
		'supports'           => array( 'title',  'thumbnail','editor' ,'page-attributes','excerpt','post-formats')
		//'taxonomies'            => array( 'category', 'post_tag' ),
		
	
	);
	register_post_type( 'product', $args );

}
add_action( 'init', 'custom_post_type', 0 );

/* 
  new category that belongs only product cpt
*/
/* https://wordpress.stackexchange.com/questions/116115/adding-the-category-to-the-admin-column-for-a-custom-post-type */
function tr_create_my_taxonomy() {

    register_taxonomy(
        'product-category',
        'product',
        array(
            'label' => __( 'Category' ),
            'rewrite' => array( 'slug' => 'product-category' ),
			'hierarchical' => true,
			'show_admin_column' => true,
		),
	
    );
}
add_action( 'init', 'tr_create_my_taxonomy' );

function tr_create_product_tags_taxonomy() {

    register_taxonomy(
        'product-tags',
        'product',
        array(
            'hierarchical'  => false, 
			'label'         => __( 'Product Tags','taxonomy general name'), 
			'singular_name' => __( 'Tag', 'taxonomy general name' ), 
			'rewrite'       => true, 
			'query_var'     => true ,
			'show_admin_column' => true,
        )
    );
};

add_action( 'init', 'tr_create_product_tags_taxonomy' );