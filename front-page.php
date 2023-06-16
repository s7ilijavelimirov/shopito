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
    <div class="container">
        <?php echo do_shortcode('[custom_product_slider category="premium"]'); ?>
        <?php echo do_shortcode('[custom_product_slider category="akcije"]'); ?>
        <?php echo do_shortcode('[custom_product_slider category="outlet"]'); ?>
    </div>
</section>
<?php get_footer();
?>