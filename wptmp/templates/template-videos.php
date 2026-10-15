<?php
/**
 * Template Name: Videos
 *
 * Lists posts in the "Videos" category. Optional page text shows above the grid.
 *
 * @package Barakah_Paths
 */

get_header();
$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$vid   = get_category_by_slug( 'videos' );
$q     = $vid ? new WP_Query( array( 'cat' => $vid->term_id, 'paged' => $paged, 'posts_per_page' => 9 ) ) : null;
?>
<div class="wrap">
	<header class="page-intro">
		<span class="eyebrow"><?php esc_html_e( 'Watch', 'barakah-paths' ); ?></span>
		<h1><?php single_post_title(); ?></h1>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="entry-content"><?php the_content(); ?></div>
		<?php endwhile; ?>
	</header>
	<?php if ( $q && $q->have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
				barakah_card();
			endwhile;
			?>
		</div>
		<nav class="pagination"><?php echo paginate_links( array( 'total' => $q->max_num_pages, 'current' => $paged ) ); ?></nav>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No videos yet. Create a post, choose the "Videos" category, paste a YouTube link into it and set a featured image.', 'barakah-paths' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
