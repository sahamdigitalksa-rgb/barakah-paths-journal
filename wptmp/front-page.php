<?php
/**
 * Homepage. Content written on the "Home" page appears under the intro band.
 *
 * @package Barakah_Paths
 */

get_header();
$journal_url = barakah_journal_url();
$vid         = get_category_by_slug( 'videos' );
?>
<section class="hero">
	<div class="wrap hero-grid">
		<div>
			<span class="eyebrow"><?php esc_html_e( 'Singapore → Madinah', 'barakah-paths' ); ?></span>
			<h1><?php esc_html_e( 'Every path, walked with intention, holds Barakah.', 'barakah-paths' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'A family journal of our Hijrah — learnings, reflections and moments on family life, homeschooling, Arabic, culture and faith.', 'barakah-paths' ); ?></p>
			<div class="hero-actions">
				<a class="btn" href="<?php echo esc_url( $journal_url ); ?>"><?php esc_html_e( 'Read the journal', 'barakah-paths' ); ?></a>
				<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Our story', 'barakah-paths' ); ?></a>
			</div>
		</div>
		<figure><img src="<?php echo barakah_img( 'madinah-morning.jpg' ); ?>" alt="<?php esc_attr_e( 'Illustrative morning light over a Madinah street', 'barakah-paths' ); ?>" width="1024" height="1280" fetchpriority="high"></figure>
	</div>
</section>

<section class="band">
	<div class="wrap band-center">
		<span class="eyebrow"><?php esc_html_e( 'Bismillah', 'barakah-paths' ); ?></span>
		<h2><?php esc_html_e( 'This journal is not about perfection, but about intention.', 'barakah-paths' ); ?></h2>
	</div>
</section>

<?php
while ( have_posts() ) :
	the_post();
	if ( 'page' === get_post_type() && trim( get_the_content() ) ) :
		?>
		<section class="section"><div class="wrap entry-content"><?php the_content(); ?></div></section>
		<?php
	endif;
endwhile;

$latest = new WP_Query( array(
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'category__not_in'    => $vid ? array( $vid->term_id ) : array(),
) );
?>
<section class="section">
	<div class="wrap">
		<div class="section-head">
			<div><span class="eyebrow"><?php esc_html_e( 'From the journal', 'barakah-paths' ); ?></span><h2><?php esc_html_e( 'Latest reflections', 'barakah-paths' ); ?></h2></div>
			<a class="btn btn-ghost" href="<?php echo esc_url( $journal_url ); ?>"><?php esc_html_e( 'All stories', 'barakah-paths' ); ?></a>
		</div>
		<?php if ( $latest->have_posts() ) : ?>
			<div class="grid">
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					barakah_card( 'h3' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p class="note"><?php esc_html_e( 'Your first journal posts will appear here once published.', 'barakah-paths' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="band band-dark">
	<div class="wrap">
		<div class="section-head">
			<div><span class="eyebrow"><?php esc_html_e( 'Watch', 'barakah-paths' ); ?></span><h2><?php esc_html_e( 'Moments on film', 'barakah-paths' ); ?></h2></div>
			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/videos/' ) ); ?>"><?php esc_html_e( 'All videos', 'barakah-paths' ); ?></a>
		</div>
		<?php
		$videos = $vid ? new WP_Query( array( 'posts_per_page' => 2, 'cat' => $vid->term_id, 'no_found_rows' => true ) ) : null;
		if ( $videos && $videos->have_posts() ) :
			?>
			<div class="grid grid-2">
				<?php
				while ( $videos->have_posts() ) :
					$videos->the_post();
					barakah_card( 'h3' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Add a post in the "Videos" category with a YouTube link to show it here.', 'barakah-paths' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<span class="eyebrow"><?php esc_html_e( 'Themes', 'barakah-paths' ); ?></span>
		<h2><?php esc_html_e( 'What we write about', 'barakah-paths' ); ?></h2>
		<div class="grid grid-4">
			<?php foreach ( barakah_themes() as $t ) : ?>
				<a class="theme-card" href="<?php echo esc_url( barakah_cat_url( $t['slug'] ) ); ?>">
					<span class="num"><?php echo esc_html( $t['num'] ); ?></span>
					<h3><?php echo esc_html( $t['name'] ); ?></h3>
					<p><?php echo esc_html( $t['desc'] ); ?></p>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_footer();
