<?php
/**
 * Site header.
 *
 * @package Barakah_Paths
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#f6f1e8">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'barakah-paths' ); ?></a>
<header class="site-header">
	<div class="wrap header-inner">
		<?php barakah_brand(); ?>
		<button class="nav-toggle" aria-expanded="false" aria-controls="primary-nav"><?php esc_html_e( 'Menu', 'barakah-paths' ); ?></button>
		<nav id="primary-nav" class="main-nav" aria-label="<?php esc_attr_e( 'Primary', 'barakah-paths' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => 'barakah_menu_fallback',
			) );
			?>
		</nav>
	</div>
</header>
<main id="content" class="site-main">
