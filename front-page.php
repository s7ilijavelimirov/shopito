<!-- FRONT PAGE -->
<?php get_header(); ?>
<?php
$args = array(
    'post_type' => 'slider',
    'post_title' => 'Pocetna',
);
$loop = new WP_Query($args);
if ($loop->have_posts()) :
    while ($loop->have_posts()) : $loop->the_post();
        get_template_part('template/slider');
    endwhile;
    wp_reset_query();
endif;
?>
<section class="product-category">
    <div class="container-fluid px-0">
        <?php if (have_rows('kategorije')) : ?>
            <div class="boxes-container">
                <?php while (have_rows('kategorije')) : the_row(); ?>

                    <?php
                    $naziv_kategorij = get_sub_field('naziv_kategorij');
                    $link_kategorije = get_sub_field('link_kategorije');
                    $color = get_sub_field('color');
                    $slika = get_sub_field('slika');
                    ?>

                    <div class="box" style="background-color:<?php echo $color; ?>">
                        <a href="<?php echo $link_kategorije; ?>">
                            <div class="boxes d-flex">
                                <?php echo $naziv_kategorij; ?>
                                <img class="img-fluid" src="<?php echo $slika; ?>">
                            </div>
                        </a>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<section class="banner">
    <div class="container">
        <img src="<?php echo the_field('slika'); ?>" class="img-fluid">
    </div>
</section>
<section class="custom-product-category">
    <div class="container px-0">
        <?php echo do_shortcode('[custom_product_slider category="premium"]'); ?>
        <?php echo do_shortcode('[custom_product_slider category="akcije"]'); ?>
        <?php echo do_shortcode('[custom_product_slider category="outlet"]'); ?>
    </div>
</section>
<section class="sliders">
    <div class="container px-0">
        <h1 class="text-center">Izdvojeni proizvodi</h1>
        <div id="features" class="custom-product-slider" data-visible-items="3">
            <div class="custom-product-slider-inner">
                <?php
                $product_ids = get_field('products'); // Replace 'products' with the name of your ACF field

                if ($product_ids) {
                    foreach ($product_ids as $product_id) {
                        $product = get_post($product_id);
                        $product_title = get_the_title($product_id);
                        $product_permalink = get_permalink($product_id);
                        $regular_price = get_post_meta($product->ID, '_regular_price', true);
                        $sale_price = get_post_meta($product->ID, '_sale_price', true);
                        $currency_symbol = get_woocommerce_currency_symbol();
                        $sku = get_post_meta($product->ID, '_sku', true);
                ?>
                        <div class="custom-product-item">
                            <a href="<?php echo esc_url($product_permalink); ?>">
                                <?php echo custom_product_thumbnail1($product); ?>
                                <div class="product-details">
                                    <h4 class="product-title"><?php echo $product_title; ?></h4>
                                    <div class="product-details">
                                        <h4 class="product-title"><?php echo $title; ?></h4>
                                        <?php if ($sku) : ?>
                                            <p class="product-sku text-center">Model: <?php echo $sku; ?></p>
                                        <?php endif; ?>
                                        <?php
                                        if ($sale_price) {
                                            $regular_price_formatted = is_numeric($regular_price) ? number_format(floatval($regular_price), 2, '.', '') : '';
                                            $regular_price_html = $regular_price_formatted !== '' ? '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>' . $regular_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></del>' : '';

                                            $sale_price_formatted = is_numeric($sale_price) ? number_format(floatval($sale_price), 2, '.', '') : '';
                                            $sale_price_html = $sale_price_formatted !== '' ? '<ins><span class="woocommerce-Price-amount amount"><bdi>' . $sale_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></ins>' : '';

                                            $price_html = $regular_price_html !== '' && $sale_price_html !== '' ? '<p class="price mb-0">' . $regular_price_html . ' ' . $sale_price_html . '</p>' : '';
                                        } else {
                                            if ($regular_price === '0.00') {
                                                $price_html = '<p class="price mb-0">' . $regular_price . '&nbsp;' . $currency_symbol . '</p>';
                                            } else {
                                                $regular_price_formatted = is_numeric($regular_price) ? number_format(floatval($regular_price), 2, '.', '') : '';
                                                $regular_price_html = $regular_price_formatted !== '' ? '<span class="woocommerce-Price-amount amount"><bdi>' . $regular_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span>' : '';

                                                $price_html = $regular_price_html !== '' ? '<p class="price mb-0">' . $regular_price_html . '</p>' : '';
                                            }
                                        }

                                        echo $price_html;
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                    }
                } else {
                    echo 'No products selected.';
                }
                ?>
            </div>
            <div class="custom-product-slider-controls">
                <button class="custom-product-slider-prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="custom-product-slider-next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
            <div class="custom-product-slider-dots"></div>
        </div>
    </div>
</section>
<section class="sliders">
    <div class="container px-0">
        <h1 class="text-center">Mozda vas interesuje</h1>
        <div id="features" class="custom-product-slider" data-visible-items="3">
            <div class="custom-product-slider-inner">
                <?php
                $product_ids = get_field('maybe'); // Replace 'products' with the name of your ACF field

                if ($product_ids) {
                    foreach ($product_ids as $product_id) {
                        $product = get_post($product_id);
                        $product_title = get_the_title($product_id);
                        $product_permalink = get_permalink($product_id);
                        $regular_price = get_post_meta($product->ID, '_regular_price', true);
                        $sale_price = get_post_meta($product->ID, '_sale_price', true);
                        $currency_symbol = get_woocommerce_currency_symbol();
                        $sku = get_post_meta($product->ID, '_sku', true);
                        $sale_percentage = '';
                        if ($regular_price && $sale_price) {
                            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                            $sale_percentage = '<div class="procentage">' . esc_html($percentage . '%') . '</div>';
                        }
                ?>
                        <div class="custom-product-item">
                            <a href="<?php echo esc_url($product_permalink); ?>">
                                <?php echo custom_product_thumbnail1($product); ?>
                                <div class="product-details">
                                    <h4 class="product-title"><?php echo $product_title; ?></h4>
                                    <div class="product-details">
                                        <h4 class="product-title"><?php echo $title; ?></h4>
                                        <?php 
                                        
                                        
                                        if ($sku) : ?>
                                            <p class="product-sku text-center">Model: <?php echo $sku; ?></p>
                                        <?php endif; ?>
                                        <?php
                                        if ($sale_price) {
                                            $regular_price_formatted = is_numeric($regular_price) ? number_format(floatval($regular_price), 2, '.', '') : '';
                                            $regular_price_html = $regular_price_formatted !== '' ? '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi>' . $regular_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></del>' : '';

                                            $sale_price_formatted = is_numeric($sale_price) ? number_format(floatval($sale_price), 2, '.', '') : '';
                                            $sale_price_html = $sale_price_formatted !== '' ? '<ins><span class="woocommerce-Price-amount amount"><bdi>' . $sale_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span></ins>' : '';

                                            $price_html = $regular_price_html !== '' && $sale_price_html !== '' ? '<p class="price mb-0">' . $regular_price_html . ' ' . $sale_price_html . '</p>' : '';
                                        } else {
                                            if ($regular_price === '0.00') {
                                                $price_html = '<p class="price mb-0">' . $regular_price . '&nbsp;' . $currency_symbol . '</p>';
                                            } else {
                                                $regular_price_formatted = is_numeric($regular_price) ? number_format(floatval($regular_price), 2, '.', '') : '';
                                                $regular_price_html = $regular_price_formatted !== '' ? '<span class="woocommerce-Price-amount amount"><bdi>' . $regular_price_formatted . '&nbsp;<span class="woocommerce-Price-currencySymbol">' . $currency_symbol . '</span></bdi></span>' : '';

                                                $price_html = $regular_price_html !== '' ? '<p class="price mb-0">' . $regular_price_html . '</p>' : '';
                                            }
                                        }

                                        echo $price_html;
                                        echo $sale_percentage; // Display the sale percentage
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php
                    }
                } else {
                    echo 'No products selected.';
                }
                ?>
            </div>
            <div class="custom-product-slider-controls">
                <button class="custom-product-slider-prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="custom-product-slider-next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
            <div class="custom-product-slider-dots"></div>
        </div>
    </div>
</section>
<?php get_footer();
?>