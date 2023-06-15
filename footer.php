<?php

/**
 * Template : Footer
 *
 * @package S7design
 */
?>
</div> <!-- main -->
</body>
<footer class="page-footer">
    <div class="container">
        <div class="d-flex justify-content-center flex-column align-items-center">
            <div class="col-sm-12 col-md-12 col-lg-12 d-flex align-items-center flex-column">
                <?php if (is_active_sidebar('footer_4')) : ?>
                    <div class="footer-widget-logo" role="complementary">
                        <?php dynamic_sidebar('footer_4'); ?>
                    </div>
                <?php endif;
                ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php if (is_active_sidebar('footer_2')) : ?>
                    <div class="footer-widget-menu" role="complementary">
                        <?php dynamic_sidebar('footer_2'); ?>
                    </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer_3')) : ?>
                    <div class="footer-widget-icon" role="complementary">
                        <?php dynamic_sidebar('footer_3'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (is_active_sidebar('footer_5')) : ?>
                <div class="footer-widget-contact-us" role="complementary">
                    <?php dynamic_sidebar('footer_5'); ?>
                </div>
            <?php endif; ?>
            <?php if (is_active_sidebar('footer_6')) : ?>
                <div class="footer-widget-image" role="complementary">
                    <?php dynamic_sidebar('footer_6'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <div class="footer-widget-copyright justify-content-center d-flex align-items-end">
            <?php if (is_active_sidebar('footer_1')) : ?>

                <?php dynamic_sidebar('footer_1'); ?>

            <?php endif; ?>
        </div>
    </div>
</footer>
<div class="mobile-navigation-icon d-xl-none d-lg-none">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'woo-menu',
        'menu_id'        => 'woo-menu',
        // 'menu_class'=>'navbar-nav mr-auto',
    ));
    ?>
</div>
<?php
wp_footer(); ?>

</html>