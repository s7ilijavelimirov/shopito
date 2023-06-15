<?php

/**
 * WooCommerce Template
 *
 * This file serves as the main template for WooCommerce pages.
 * It will handle the rendering of various WooCommerce pages like the shop, cart, checkout, etc.
 *
 * @package shopito
 */

get_header(); ?>

<div class="container">
    <?php
    if (class_exists('WooCommerce')) {
        if (is_account_page()) {
            // Account Page
            wc_get_template('myaccount/my-account.php');
        } elseif (is_shop()) {
            // Account Page
            wc_get_template('woocommerce/archive-product.php');
        } elseif (is_product_category()) {
            // Category
            wc_get_template('woocommerce/archive-product.php');
        } elseif (is_checkout()) {
            // Checkout Page
            global $checkout;
            if ($checkout == null) {
                $checkout = WC()->checkout();
            }
            wc_get_template('checkout/form-checkout.php', array('checkout' => $checkout));
        } elseif (is_cart()) {
            // Cart Page
            woocommerce_breadcrumb();
            wc_get_template('cart/cart.php');
        } else {
            // Default Content
            woocommerce_breadcrumb();
            woocommerce_content();
        }
    } else {
        // WooCommerce is not active, display a message or fallback content
        echo 'WooCommerce is not active.';
    }
    ?>
</div>

<?php get_footer();
