<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to shopito-child/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
?>
<li <?php wc_product_class('', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action('woocommerce_before_shop_loop_item');

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked custom_product_thumbnail - 5
	 */



	if ($product->get_gallery_image_ids()) {
		display_sale_percentage();
		echo '<div class="content-product">';
		add_category_to_product_loop();
		echo '<a href="' . esc_url(get_permalink($product->get_id())) . '">';
		custom_product_thumbnail();
		do_action('woocommerce_shop_loop_item_title');
		//echo display_new_product_alert(); // Assuming you have a function named 'display_new_product_alert'
		echo '</a>';
		
		echo '</div>';
		echo display_brand_image_on_variable_product();
		echo '<div class="content-action">';
		
		do_action('woocommerce_after_shop_loop_item_title');
		do_action('woocommerce_after_shop_loop_item');
		echo '</div>';
	} else {
		display_sale_percentage();
		echo '<div class="content-product">';
		do_action('woocommerce_before_shop_loop_item_title');
		echo '<a href="' . esc_url(get_permalink($product->get_id())) . '">';
		do_action('woocommerce_shop_loop_item_title');
		echo '</a>';
		
		if ( $product->is_type( 'variable' ) ) {
			$brand_id    = get_post_meta( $product->get_id(), 'pwb_brand', true );
			$brand_image = wp_get_attachment_image( $brand_id, 'thumbnail' );

			// Display the brand image if available
			if ( ! empty( $brand_image ) ) {
				echo '<div class="brand-image">' . $brand_image . '</div>';
			}
		}
		
		echo '</div>';
		echo '<div class="content-action">';
		
		do_action('woocommerce_after_shop_loop_item_title');
		do_action('woocommerce_after_shop_loop_item');
		echo '</div>';
	}

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */


	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action('woocommerce_after_shop_loop_item_title');

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	// do_action('woocommerce_after_shop_loop_item');
	?>
</li>