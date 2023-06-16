<?php

/**
 * Template : Header
 *
 * @package S7design
 */

use Automattic\WooCommerce\Admin\RemoteInboxNotifications\ProductCountRuleProcessor;
use Automattic\WooCommerce\Admin\RemoteInboxNotifications\Transformers\Count;
use Automattic\WooCommerce\StoreApi\Routes\V1\CartItems;

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<!--=== META TAGS ===-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="author" content="Name">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!--=== LINK TAGS ===-->

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>">

	<!-- Pingback URL -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<!--=== TITLE ===-->
	<title><?php bloginfo('name'); ?><?php wp_title(' - ', true, 'left'); ?></title>

	<!--=== WP_HEAD() ===-->
	<?php wp_head(); ?>
</head>

<header id="navbar">
	<nav id="main-nav" class="nav-wrapper container">
		<div class="logo-img d-flex flex-column flex-sm-column flex-lg-row">
			<?php
			$custom_logo_id = get_theme_mod('custom_logo');
			$logo_image_url = wp_get_attachment_image_url($custom_logo_id, 'full');
			?>

			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<img class="img-fluid" src="<?php echo esc_url($logo_image_url); ?>" alt="<?php bloginfo('name'); ?>">
			</a>
			<div class="d-block w-100">
				<div class="search">
					<?php echo do_shortcode('[aws_search_form]'); ?>
					<?php /* Right Menu */

					wp_nav_menu(array(
						'theme_location' => 'woo-menu',
						'menu_id'        => 'woo-menu',
						'menu_class' => 'd-none d-lg-flex'
					));
					?>
					<a class="misha-cart"><?php echo WC()->cart->get_cart_contents_count() ?></a>
				</div>
				<?php /* Right Menu */

				wp_nav_menu(array(
					'theme_location' => 'main-menu',
					'menu_id'        => 'main-menu',
					'menu_class' => 'd-none d-lg-flex'
				));

				?>
			</div>

		</div>

	</nav>
	<div class="mymenu">
		<div class="mobile-menu-toggle">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<nav class="mobile-menu-1">
			<?php  /* menu */
			wp_nav_menu(array(
				'theme_location'  => 'mobile-menu',
			));
			?>
		</nav>
	</div>
</header>

<body>
	<div <?php body_class('mybody'); ?>>
		<div class="mini-cart d-none d-lg-block">
			<div class="widget_shopping_cart_content">
				<?php
				$template_path = 'woocommerce/cart/mini-cart.php';
				$template = locate_template($template_path, false, false);
				if ($template) {
					load_template($template, false);
				} else {
					wc_get_template($template_path);
				}
				?>
			</div>
		</div>