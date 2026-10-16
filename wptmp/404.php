<?php
/**
 * Not found page.
 *
 * @package Barakah_Paths
 */

get_header();
?>
<div class="wrap">
	<header class="page-intro center">
		<span class="eyebrow"><?php esc_html_e( 'Page not found', 'barakah-paths' ); ?></span>
		<h1><?php esc_html_e( 'This path leads nowhere', 'barakah-paths' ); ?></h1>
		<p><?php esc_html_e( 'The page you were looking for has moved or no longer exists. Try a search instead.', 'barakah-paths' ); ?></p>
		<?php get_search_form(); ?>
		<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'barakah-paths' ); ?></a></p>
	</header>
</div>
<?php
get_footer();
