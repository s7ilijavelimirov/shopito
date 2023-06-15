<?php

/**
 * Template : Default template for theme
 *
 * @package S7design
 */

get_header();
if (have_posts()) : ?>
    <div class="container">
        <?php while (have_posts()) :
            the_post(); ?>
            <h1><?php echo the_title(); ?></h1>
            <?php echo the_content(); ?>
        <?php
        endwhile; ?>
    </div>
<?php endif;
get_footer(); ?>