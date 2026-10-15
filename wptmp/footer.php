<?php
/**
 * Site footer.
 *
 * @package Barakah_Paths
 */
?>
</main>
<footer class="site-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div>
				<?php barakah_brand(); ?>
				<p class="footer-about"><?php esc_html_e( 'A family journal of learnings, reflections and moments on the path from Singapore to Madinah.', 'barakah-paths' ); ?></p>
			</div>
			<div>
				<h2 class="h3"><?php esc_html_e( 'Explore', 'barakah-paths' ); ?></h2>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => 'barakah_menu_fallback',
				) );
				?>
			</div>
			<div>
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-1' ); ?>
				<?php else : ?>
					<h2 class="h3"><?php esc_html_e( 'Themes', 'barakah-paths' ); ?></h2>
					<ul>
						<?php foreach ( barakah_themes() as $t ) : ?>
							<li><a href="<?php echo esc_url( barakah_cat_url( $t['slug'] ) ); ?>"><?php echo esc_html( $t['name'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<div class="footer-bottom">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
