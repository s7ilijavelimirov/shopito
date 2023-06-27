<?php
// Enqueue parent and child theme styles
function shopito_child_enqueue_styles()
{
    wp_enqueue_style('shopito-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('shopito-child-style', get_stylesheet_directory_uri() . '/style.css', array('shopito-parent-style'));
}
add_action('wp_enqueue_scripts', 'shopito_child_enqueue_styles');

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 600,
        'single_image_width'    => 900,
        'gallery_thumbnail_image_width' => 900,
        'product_grid'          => array(
            'default_rows'    => 4,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

// Remove existing hooked functions from woo-values
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Add custom function
add_action('woocommerce_before_shop_loop', 'custom_before_shop_loop_content');
function display_quantity_in_mini_cart($item_quantity, $cart_item, $cart_item_key)
{
    $item_quantity .= '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $cart_item['data']->get_price()) . '</span>';
    return $item_quantity;
}

add_filter('woocommerce_widget_shopping_cart_item_quantity', 'display_quantity_in_mini_cart', 10, 3);


function custom_product_thumbnail()
{
    global $product;

    // Prilagodite prikaz slike proizvoda prema vašim potrebama
    echo '<div class="custom-product-thumbnail">';
    custom_shop_product_gallery(); // Prikazuje podrazumevanu sliku proizvoda
    echo '</div>';
}
add_action('woocommerce_template_loop_product_thumbnail', 'custom_product_thumbnail');
function add_category_to_product_loop()
{
    global $product;

    // Get product categories.
    $terms = wp_get_post_terms($product->get_id(), 'product_cat');

    $category_links = array();

    foreach ($terms as $term) {
        $category_link = get_term_link($term);
        $category_name = $term->name;

        // Check if the term has a parent category.
        if ($term->parent > 0) {
            // Get the parent category.
            $parent_term = get_term($term->parent, 'product_cat');
            $parent_category_link = get_term_link($parent_term);
            $parent_category_name = $parent_term->name;

            // Add parent and child category links to the array.
            $category_links[] = '<a href="' . esc_url($parent_category_link) . '">' . $parent_category_name . '</a>';
            $category_links[] = '<a href="' . esc_url($category_link) . '">' . $category_name . '</a>';
        } else {
            // Add only the child category link to the array.
            $category_links[] = '<a href="' . esc_url($category_link) . '">' . $category_name . '</a>';
        }
    }

    // Display category names separated by commas.
    $category_html = '<div class="category-link">' . implode(', ', $category_links) . '</div>';

    echo $category_html;
}

add_action('woocommerce_before_shop_loop_item_title', 'add_category_to_product_loop', 5);
function custom_before_shop_loop_content()
{
    // Custom HTML structure for woo-values
    echo '<div class="woo-values">';
    // Output WooCommerce result count and catalog ordering
    woocommerce_result_count();
    woocommerce_catalog_ordering();
    echo '<div class="woocommerce-pagination">';
    woocommerce_pagination();
    echo '</div>';
    echo '</div>';
}
function display_sale_percentage()
{
    global $product;

    if ($product->is_on_sale()) {
        $regular_price = (float) $product->get_regular_price();
        $sale_price = (float) $product->get_sale_price();

        if ($regular_price && $sale_price) {
            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

            echo '<div class="procentage">' . esc_html($percentage . '%') . '</div>';
        }
    }
}
function change_existing_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
        case 'RSD':
            $currency_symbol = 'RSD ';
            break;
    }
    return $currency_symbol;
}

add_filter('woocommerce_add_to_cart_fragments', 'misha_add_to_cart_fragment');

function misha_add_to_cart_fragment($fragments)
{

    $fragments['.misha-cart'] = '<a class="misha-cart">' . WC()->cart->get_cart_contents_count() . '</a>';
    return $fragments;
}

function custom_shop_product_gallery()
{
    global $product;

    // Check if the product object is available
    if (is_a($product, 'WC_Product')) {
        // Check if the product has a gallery
        if ($product->get_gallery_image_ids()) {
            $gallery_ids = $product->get_gallery_image_ids();
            $total_images = count($gallery_ids) + 1;

            // Generate a unique identifier for the gallery
            $gallery_id = 'product-gallery-' . $product->get_id();

            // Output the gallery HTML
            $output = '<div class="product-gallery" id="' . $gallery_id . '">';
            $output .= '<div class="product-gallery-images">';

            $output .= '<div class="product-gallery-image active">';
            $output .= wp_get_attachment_image($product->get_image_id(), 'woocommerce_thumbnail', false, array('class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail'));
            $output .= '</div>';

            // Gallery images
            foreach ($gallery_ids as $attachment_id) {
                $output .= '<div class="product-gallery-image">';
                $output .= wp_get_attachment_image($attachment_id, 'woocommerce_thumbnail', false, array('class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail'));
                $output .= '</div>';
            }

            $output .= '</div>'; // .product-gallery-images

            // Gallery pager dots
            $output .= '<div class="product-gallery-pager">';
            for ($i = 0; $i < $total_images; $i++) {
                $active_class = ($i === 0) ? 'active' : '';
                $output .= '<span class="product-gallery-pager-dot ' . $active_class . '" data-index="' . $i . '" data-gallery="' . $gallery_id . '"></span>';
            }
            $output .= '</div>';

            $output .= '</div>'; // .product-gallery

            echo $output;
        }
    }
}
add_filter('woocommerce_get_image_size_thumbnail', 'custom_woocommerce_thumbnail_size');

function custom_woocommerce_thumbnail_size($size)
{
    return array(
        'width'  => '900',
        'height' => '900',
        'crop'   => 1,
    );
}
function remove_image_sizes($sizes)
{
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);

    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_image_sizes');
add_filter('max_srcset_image_width', function ($max_width) {
    return 1;
});
function custom_woocommerce_gallery_thumbnail_size($size)
{
    // Set the desired width and height for the gallery thumbnails
    $thumbnail_size = array(960, 960);

    return $thumbnail_size;
}
add_filter('woocommerce_single_product_image_thumbnail_size', 'custom_woocommerce_gallery_thumbnail_size');


function display_product_short_description()
{
    global $product;

    // Check if the product has a short description
    if (!$product->get_short_description()) {
        return;
    }

    // Output the short description
    echo '<div class="product-short-description">';
    echo apply_filters('woocommerce_short_description', $product->get_short_description());
    echo '</div>';

    // Output the shop loop item title
    //do_action('woocommerce_shop_loop_item_title');
}
add_action('woocommerce_shop_loop_item_title', 'display_product_short_description', 15);


add_action('woocommerce_after_shop_loop_item_title', 'quadlayers_new_product_badge', 3);

function quadlayers_new_product_badge()
{
    global $product;

    // Set the number of days for a product to be considered new
    $newness_days = 10;

    // Get the creation date of the product
    $created_date = strtotime($product->get_date_created());

    // Calculate the cutoff date for considering a product new
    $cutoff_date = strtotime('-' . $newness_days . ' days');

    // Check if the product is new
    if ($created_date > $cutoff_date) {
        echo '<span class="itsnew onsale">' . esc_html__('NOVO', 'woocommerce') . '</span>';
    }
}
// function custom_pwb_brands_in_loop() {
//     // Custom logic for brands in the loop
//     global $product;

//     // Get the brand ID for the product
//     $brand_id = get_post_meta($product->get_id(), '_brand', true);

//     // Get the brand image URL
//     $image_url = wp_get_attachment_image_url(get_term_meta($brand_id, 'pwb_brand_image_id', true), 'thumbnail');

//     if (!empty($image_url)) {
//         // Output the brand image with a link to the brand archive
//         echo '<a href="' . get_term_link($brand_id, 'pwb-brand') . '"><img src="' . esc_url($image_url) . '" alt="Brand Image"></a>';
//     }
// }
function display_variations_as_products_on_shop_page($q)
{
    if (is_shop() || is_product_category()) {
        $q->set('post_type', array('product', 'product_variation', 'pwb-brand'));
    }
}
add_action('woocommerce_product_query', 'display_variations_as_products_on_shop_page');

function display_brand_image_on_variable_product()
{
    global $product;

    // Check if the product is a variable product
    if ($product && $product->is_type('variable')) {
        $parent_id    = $product->get_parent_id();
        $brand_id     = get_post_meta($parent_id, '_brand', true);
        $brand_image  = wp_get_attachment_image($brand_id, 'thumbnail');

        // Display the brand image if available
        if (!empty($brand_image)) {
            echo '<div class="brand-image">' . $brand_image . '</div>';
        }
    }
}

// add_filter('allow_empty_comment', '__return_true');
// add_action('woocommerce_after_shop_loop_item', 'get_star_rating' );
// function get_star_rating()
// {
//     global $woocommerce, $product;
//     $average = $product->get_average_rating();

//     echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
// }
function modify_woocommerce_single_product_summary()
{
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 15);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 30);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40);
}

add_action('init', 'modify_woocommerce_single_product_summary');
function display_product_rating_stars()
{
    global $product;

    if ($product->get_average_rating()) {
        echo '<div class="star-rating" role="img" aria-label="Rated ' . $product->get_average_rating() . ' out of 5">';
        echo wc_get_rating_html($product->get_average_rating());
        echo '</div>';
    } else {
        echo '<div class="star-rating" role="img" aria-label="Not Rated Yet">';
        echo wc_get_rating_html(0);
        echo '</div>';
    }
}

add_action('woocommerce_before_shop_loop_item_title', 'display_product_rating_stars', 5);
add_action('woocommerce_single_product_summary', 'display_product_rating_stars', 5);
// function display_product_rating_stars() {
//     global $product;

//     if ( $product->get_average_rating() ) {
//         echo '<div class="star-rating" role="img" aria-label="Rated ' . $product->get_average_rating() . ' out of 5">';
//         echo wc_get_rating_html( $product->get_average_rating() );
//         echo '</div>';
//     } else {
//         echo '<div class="star-rating" role="img" aria-label="Not Rated Yet">';
//         echo wc_get_rating_html( 0 );
//         echo '</div>';
//     }
// }
// add_action( 'woocommerce_single_product_summary', 'display_product_rating_stars', 25 );