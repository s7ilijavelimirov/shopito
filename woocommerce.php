<?php

/**
 * Template Name: WooCommerce Page
 *
 * This template is used to display the WooCommerce account page.
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Check if WooCommerce is active
        if (class_exists('WooCommerce')) {
            woocommerce_content();
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>