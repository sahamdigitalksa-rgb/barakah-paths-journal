<?php
/**
 * Search results.
 *
 * @package Barakah_Paths
 */

get_header();
?>
<div class="wrap">
	<header class="page-intro">
		<span class="eyebrow"><?php esc_html_e( 'Search', 'barakah-paths' ); ?></span>
		<h1><?php printf( esc_html__( 'Results for “%s”', 'barakah-paths' ), esc_html( get_search_query() ) ); ?></h1>
		<?php get_search_form(); ?>
	</header>
	<?php if ( have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( have_posts() ) :
				the_post();
				barakah_card( 'h2' );
			endwhile;
			?>
		</div>
		<div class="pagination"><?php echo paginate_links(); // phpcs:ignore ?></div>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing matched your search. Try different words.', 'barakah-paths' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
