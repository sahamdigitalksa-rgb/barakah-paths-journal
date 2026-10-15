<?php
/**
 * Journal (posts page), category archives and general fallback.
 *
 * @package Barakah_Paths
 */

get_header();
$current = is_category() ? get_queried_object()->slug : '';
?>
<div class="wrap">
	<header class="page-intro">
		<span class="eyebrow"><?php esc_html_e( 'The journal', 'barakah-paths' ); ?></span>
		<h1>
			<?php
			if ( is_category() || is_tag() || is_tax() ) {
				single_term_title();
			} elseif ( is_archive() ) {
				echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
			} else {
				esc_html_e( 'Learnings, reflections & moments', 'barakah-paths' );
			}
			?>
		</h1>
		<?php if ( is_category() && category_description() ) : ?>
			<div><?php echo wp_kses_post( category_description() ); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'Stories from our family\'s Hijrah, gathered by theme.', 'barakah-paths' ); ?></p>
		<?php endif; ?>
	</header>

	<ul class="filter" aria-label="<?php esc_attr_e( 'Filter by theme', 'barakah-paths' ); ?>">
		<li><a class="<?php echo $current ? '' : 'active'; ?>" href="<?php echo esc_url( barakah_journal_url() ); ?>"><?php esc_html_e( 'All', 'barakah-paths' ); ?></a></li>
		<?php foreach ( barakah_themes() as $t ) : ?>
			<li><a class="<?php echo $current === $t['slug'] ? 'active' : ''; ?>" href="<?php echo esc_url( barakah_cat_url( $t['slug'] ) ); ?>"><?php echo esc_html( $t['name'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>

	<?php if ( have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( have_posts() ) :
				the_post();
				barakah_card();
			endwhile;
			?>
		</div>
		<nav class="pagination" aria-label="<?php esc_attr_e( 'Pages', 'barakah-paths' ); ?>"><?php echo paginate_links( array( 'mid_size' => 1 ) ); ?></nav>
	<?php else : ?>
		<p><?php esc_html_e( 'No stories here yet.', 'barakah-paths' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
