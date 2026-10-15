<?php
/**
 * Template Name: Themes
 *
 * @package Barakah_Paths
 */

get_header();
?>
<div class="wrap">
	<header class="page-intro">
		<span class="eyebrow"><?php esc_html_e( 'Themes', 'barakah-paths' ); ?></span>
		<h1><?php single_post_title(); ?></h1>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="entry-content"><?php the_content(); ?></div>
		<?php endwhile; ?>
	</header>
	<?php
	foreach ( barakah_themes() as $t ) :
		$term = get_category_by_slug( $t['slug'] );
		$q    = $term ? new WP_Query( array( 'cat' => $term->term_id, 'posts_per_page' => 3, 'no_found_rows' => true ) ) : null;
		?>
		<section class="section section-tight">
			<div class="section-head">
				<div>
					<span class="eyebrow"><?php echo esc_html( $t['num'] ); ?></span>
					<h2><?php echo esc_html( $t['name'] ); ?></h2>
					<p><?php echo esc_html( $t['desc'] ); ?></p>
				</div>
				<a class="btn btn-ghost" href="<?php echo esc_url( barakah_cat_url( $t['slug'] ) ); ?>"><?php esc_html_e( 'View all', 'barakah-paths' ); ?></a>
			</div>
			<?php if ( $q && $q->have_posts() ) : ?>
				<div class="grid">
					<?php
					while ( $q->have_posts() ) :
						$q->the_post();
						barakah_card( 'h3' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</section>
	<?php endforeach; ?>
</div>
<?php
get_footer();
