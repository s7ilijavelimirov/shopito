<?php

/**
 * Plugin Name: Custom Product Slider
 * Description: Displays selected product categories in custom sliders.
 * Version: 1.1.2
 * Author: S7 Code & design
 * Author URI: https://s7codedesign.com/
 */

require_once('function.php');

function custom_product_slider_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'category' => 'premium',
    ), $atts, 'custom_product_slider');

    switch ($atts['category']) {
        case 'premium':

            $selected_categories = get_option('custom_product_slider_categories_premium', array());
            $selected_product_ids = get_option('custom_product_slider_product_premium', array());
            $product_order_premium = get_option('custom_product_slider_product_order_premium', 'price');

            break;
        case 'akcije':

            $selected_categories = get_option('custom_product_slider_categories_akcije', array());
            $selected_product_ids = get_option('custom_product_slider_product_akcije', array());
            $product_order_akcije = get_option('custom_product_slider_product_order_akcije', 'price');

            break;
        case 'outlet':

            $selected_categories = get_option('custom_product_slider_categories_outlet', array());
            $selected_product_ids = get_option('custom_product_slider_product_outlet', array());
            $product_order_outlet = get_option('custom_product_slider_product_order_outlet', 'price');

            break;
    }

    // Modify the $args array to include the selected product IDs
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post__in' => $selected_product_ids, // Include only selected product IDs
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $selected_categories,
            ),
        ),
    );
    switch ($atts['category']) {
        case 'premium':
            if ($product_order_premium === 'price') {
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
            } elseif ($product_order_premium === 'random') {
                $args['orderby'] = 'rand';
            } elseif ($product_order_premium === 'title') {
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
            } elseif ($product_order_premium === 'newest') {
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
            } elseif ($product_order_premium === 'oldest') {
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
            }
            break;
        case 'akcije':
            if ($product_order_akcije === 'price') {
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
            } elseif ($product_order_akcije === 'random') {
                $args['orderby'] = 'rand';
            } elseif ($product_order_akcije === 'title') {
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
            } elseif ($product_order_akcije === 'newest') {
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
            } elseif ($product_order_akcije === 'oldest') {
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
            }
            break;
        case 'outlet':
            if ($product_order_outlet === 'price') {
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
            } elseif ($product_order_outlet === 'random') {
                $args['orderby'] = 'rand';
            } elseif ($product_order_outlet === 'title') {
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
            } elseif ($product_order_outlet === 'newest') {
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
            } elseif ($product_order_outlet === 'oldest') {
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
            }
            break;
    }
    $query = new WP_Query($args);
    ob_start();
?>
    <div id="custom-product-slider-<?php echo esc_attr($atts['category']); ?>" class="custom-product-slider">
        <div class="custom-product-slider-inner">
            <?php
            $products = $query->get_posts();
            foreach ($products as $product) {
                $permalink = get_permalink($product->ID);
                $title = get_the_title($product->ID);
                $regular_price = get_post_meta($product->ID, '_regular_price', true);
                $sale_price = get_post_meta($product->ID, '_sale_price', true);
                $currency_symbol = get_woocommerce_currency_symbol();
                $thumbnail = get_the_post_thumbnail($product->ID, 'thumbnail');
            ?>
                <div class="custom-product-item">
                    <a href="<?php echo esc_url($permalink); ?>">
                        <?php echo custom_shop_product_gallery1($product, 'product-gallery-' . $product->ID); ?>
                        <div class="product-details">
                            <h4 class="product-title"><?php echo $title; ?></h4>
                            <?php
                            if ($sale_price) {
                                $regular_price_html = '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>' . $regular_price . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></del>';
                                $sale_price_html = '<ins><span class="woocommerce-Price-amount amount"><bdi>' . $sale_price . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></ins>';
                                $price_html = '<p class="price">' . $regular_price_html . ' ' . $sale_price_html . '</p>';
                            } else {
                                if ($regular_price === '0.00') {
                                    $price_html = '<p class="price">' . $regular_price . ' ' . $currency_symbol . '</p>';
                                } else {
                                    $regular_price_html = '<span class="woocommerce-Price-amount amount"><bdi>' . $regular_price . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span>';
                                    $price_html = '<p class="price">' . $regular_price_html . '</p>';
                                }
                            }

                            echo $price_html;

                            ?>
                            <?php
                            $product_id = $product->ID;
                            $brands = wp_get_post_terms($product_id, 'pwb-brand');

                            if (!empty($brands) && !is_wp_error($brands)) {
                                echo '<div class="product-brand">';
                                foreach ($brands as $brand) {
                                    $brand_logo_id = get_term_meta($brand->term_id, 'pwb_brand_image', true);
                                    $brand_logo = wp_get_attachment_image($brand_logo_id, 'thumbnail');
                                    if (!empty($brand_logo)) {
                                        echo $brand_logo;
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="custom-product-slider-controls">
            <button class="custom-product-slider-prev">&#10094;</button>
            <button class="custom-product-slider-next">&#10095;</button>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('custom_product_slider', 'custom_product_slider_shortcode');
