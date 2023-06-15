<?php
/* 
Template Name: Archives
*/
get_header(); ?>

<div id="primary" class="site-content container">
    <div id="content" role="main">

        <?php
        echo  woocommerce_breadcrumb();
        while (have_posts()) : the_post(); ?>

            <h1 class="entry-title"><?php the_title(); ?></h1>

            <div class="entry-content">

                <?php the_content(); ?>

            </div><!-- .entry-content -->

        <?php endwhile; // end of the loop. 
        ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>