<?php
/**
 * Template Name: Guides (shop landing)
 *
 * Shows WooCommerce products when WooCommerce is active; otherwise the page text.
 *
 * @package Barakah_Paths
 */

get_header();
?>
<div class="wrap">
	<header class="page-intro">
		<span class="eyebrow"><?php esc_html_e( 'Digital guides', 'barakah-paths' ); ?></span>
		<h1><?php single_post_title(); ?></h1>
		<p><?php esc_html_e( 'Practical guides from our own journey, available to download.', 'barakah-paths' ); ?></p>
	</header>
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<div class="entry-content"><?php the_content(); ?></div>
		<?php
	endwhile;
	if ( class_exists( 'WooCommerce' ) ) {
		echo do_shortcode( '[products limit="12" columns="3" orderby="date"]' );
	} else {
		echo '<p class="note">' . esc_html__( 'Install WooCommerce and add downloadable products to show your guides here.', 'barakah-paths' ) . '</p>';
	}
	?>
</div>
<?php
get_footer();
