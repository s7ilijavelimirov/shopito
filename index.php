<?php

/**
 * Template : Default template for theme
 *
 * @package S7design
 */

get_header();
if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>
 
 <?php
    endwhile;
endif;
get_footer(); ?>
