<?php
/**
 * Standard page (About, Contact…). Works with the block editor and Elementor.
 *
 * @package Barakah_Paths
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="wrap">
			<header class="page-intro">
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			</header>
			<?php if ( has_post_thumbnail() ) : ?><figure class="entry-thumb"><?php the_post_thumbnail( 'large' ); ?></figure><?php endif; ?>
			<div class="entry entry-content"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;
get_footer();
