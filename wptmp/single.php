<?php
/**
 * Single journal post or video.
 *
 * @package Barakah_Paths
 */

get_header();
while ( have_posts() ) :
	the_post();
	$cats = get_the_category();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header wrap entry">
			<?php if ( $cats ) : ?><a class="eyebrow" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<p class="entry-meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time> · <?php the_author(); ?></p>
		</header>
		<?php if ( has_post_thumbnail() && ! has_post_format( 'video' ) && ! in_category( 'videos' ) ) : ?>
			<figure class="entry-thumb wrap"><?php the_post_thumbnail( 'large', array( 'fetchpriority' => 'high' ) ); ?></figure>
		<?php endif; ?>
		<div class="wrap">
			<div class="entry entry-content">
				<?php
				the_content();
				wp_link_pages();
				the_tags( '<p class="entry-meta">' . esc_html__( 'Tags: ', 'barakah-paths' ), ', ', '</p>' );
				?>
				<nav class="post-nav" aria-label="<?php esc_attr_e( 'More stories', 'barakah-paths' ); ?>">
					<span><?php previous_post_link( '%link', '← %title' ); ?></span>
					<span><?php next_post_link( '%link', '%title →' ); ?></span>
				</nav>
				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
