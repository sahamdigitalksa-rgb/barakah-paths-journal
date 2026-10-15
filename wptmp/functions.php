<?php
/**
 * Barakah Paths theme functions.
 *
 * @package Barakah_Paths
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BARAKAH_VERSION', '1.0.0' );

function barakah_setup() {
	load_theme_textdomain( 'barakah-paths', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array( 'height' => 140, 'width' => 280, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-formats', array( 'video' ) );
	add_image_size( 'barakah-card', 800, 600, true );

	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'barakah-paths' ),
		'footer'  => __( 'Footer menu', 'barakah-paths' ),
	) );

	add_theme_support( 'editor-color-palette', array(
		array( 'name' => 'Ink', 'slug' => 'ink', 'color' => '#2b2620' ),
		array( 'name' => 'Cream', 'slug' => 'cream', 'color' => '#f6f1e8' ),
		array( 'name' => 'Sand', 'slug' => 'sand', 'color' => '#e9e0d0' ),
		array( 'name' => 'Clay', 'slug' => 'clay', 'color' => '#b5714a' ),
		array( 'name' => 'Sage', 'slug' => 'sage', 'color' => '#7c8a6b' ),
		array( 'name' => 'Gold', 'slug' => 'gold', 'color' => '#c9a24b' ),
	) );
}
add_action( 'after_setup_theme', 'barakah_setup' );

function barakah_content_width() {
	$GLOBALS['content_width'] = 720;
}
add_action( 'after_setup_theme', 'barakah_content_width', 0 );

/** Styles and a tiny deferred menu script. Fonts use display=swap. */
function barakah_assets() {
	wp_enqueue_style( 'barakah-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500&family=Inter:wght@400;500;600&display=swap', array(), null );
	wp_enqueue_style( 'barakah-style', get_stylesheet_uri(), array( 'barakah-fonts' ), BARAKAH_VERSION );
	wp_enqueue_script( 'barakah-nav', get_template_directory_uri() . '/assets/js/nav.js', array(), BARAKAH_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'barakah_assets' );

function barakah_resource_hints( $urls, $type ) {
	if ( 'preconnect' === $type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'barakah_resource_hints', 10, 2 );

/** Remove front-end bloat. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

function barakah_widgets() {
	register_sidebar( array(
		'name'          => __( 'Footer', 'barakah-paths' ),
		'id'            => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'barakah_widgets' );

/** True when a dedicated SEO plugin handles meta tags. */
function barakah_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' );
}

function barakah_meta_description() {
	if ( is_front_page() ) {
		$text = get_bloginfo( 'description' );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 30, '…' );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$text = term_description() ? wp_strip_all_tags( term_description() ) : single_term_title( '', false ) . ' — ' . get_bloginfo( 'name' );
	} else {
		$text = get_bloginfo( 'description' );
	}
	return trim( preg_replace( '/\s+/', ' ', (string) $text ) );
}

function barakah_current_url() {
	if ( is_singular() ) {
		return get_permalink();
	}
	global $wp;
	return trailingslashit( home_url( $wp->request ) );
}

/**
 * Built-in SEO tags: description, canonical (archives), Open Graph, Twitter, JSON-LD.
 * Turns itself off when Yoast, Rank Math, AIOSEO, SEOPress or The SEO Framework is active.
 */
function barakah_seo_head() {
	if ( barakah_seo_plugin_active() ) {
		return;
	}
	$desc  = barakah_meta_description();
	$title = wp_get_document_title();
	$url   = barakah_current_url();
	$image = '';
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	} elseif ( has_custom_logo() ) {
		$image = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
	}

	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	if ( ! is_singular() && ! is_search() && ! is_404() ) {
		echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	}
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="' . ( is_single() ? 'article' : 'website' ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	echo '<meta name="twitter:card" content="' . ( $image ? 'summary_large_image' : 'summary' ) . '">' . "\n";

	$graph = array(
		array(
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => get_bloginfo( 'name' ),
			'description'     => get_bloginfo( 'description' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		),
	);
	if ( is_single() ) {
		$post    = get_queried_object();
		$article = array(
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title( $post ),
			'description'      => $desc,
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'author'           => array( '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', $post->post_author ) ),
			'mainEntityOfPage' => get_permalink( $post ),
			'isPartOf'         => array( '@id' => home_url( '/#website' ) ),
		);
		if ( $image ) {
			$article['image'] = $image;
		}
		$graph[] = $article;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'barakah_seo_head', 1 );

/** Keep search results and 404s out of search engines. */
function barakah_robots( $robots ) {
	if ( is_search() || is_404() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'barakah_robots' );

/** The four journal themes (created as categories on activation). */
function barakah_themes() {
	return array(
		array( 'name' => __( 'Family life', 'barakah-paths' ), 'slug' => 'family-life', 'num' => '01', 'desc' => __( 'The ordinary days that make up the journey.', 'barakah-paths' ) ),
		array( 'name' => __( 'Homeschooling', 'barakah-paths' ), 'slug' => 'homeschooling', 'num' => '02', 'desc' => __( 'Lessons, rhythms, and learning together.', 'barakah-paths' ) ),
		array( 'name' => __( 'Arabic & culture', 'barakah-paths' ), 'slug' => 'arabic-culture', 'num' => '03', 'desc' => __( 'Language, customs, and a sense of place.', 'barakah-paths' ) ),
		array( 'name' => __( 'Faith', 'barakah-paths' ), 'slug' => 'faith', 'num' => '04', 'desc' => __( 'Reflections on intention and everyday life.', 'barakah-paths' ) ),
	);
}

function barakah_activate() {
	foreach ( barakah_themes() as $t ) {
		if ( ! term_exists( $t['slug'], 'category' ) ) {
			wp_insert_term( $t['name'], 'category', array( 'slug' => $t['slug'], 'description' => $t['desc'] ) );
		}
	}
	if ( ! term_exists( 'videos', 'category' ) ) {
		wp_insert_term( __( 'Videos', 'barakah-paths' ), 'category', array( 'slug' => 'videos', 'description' => __( 'Short films from our journey.', 'barakah-paths' ) ) );
	}
}
add_action( 'after_switch_theme', 'barakah_activate' );

function barakah_img( $file ) {
	return esc_url( get_template_directory_uri() . '/assets/images/' . $file );
}

function barakah_cat_url( $slug ) {
	$term = get_category_by_slug( $slug );
	return $term ? get_category_link( $term ) : home_url( '/category/' . $slug . '/' );
}

function barakah_journal_url() {
	$id = (int) get_option( 'page_for_posts' );
	return $id ? get_permalink( $id ) : home_url( '/' );
}

/** Post card for journal, videos, archives. */
function barakah_card( $heading = 'h2' ) {
	$heading = in_array( $heading, array( 'h2', 'h3' ), true ) ? $heading : 'h2';
	$cats    = get_the_category();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
		<a class="card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'barakah-card', array( 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
			}
			?>
		</a>
		<?php if ( $cats ) : ?><span class="card-cat"><?php echo esc_html( $cats[0]->name ); ?></span><?php endif; ?>
		<<?php echo $heading; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $heading; ?>>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
	</article>
	<?php
}

/** Inline brand mark (no extra request). */
function barakah_mark() {
	return '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M8 34c6-4 8-10 12-16s8-10 12-12"/><path d="M20 6c-2 4-2 8 0 12"/><circle cx="20" cy="22" r="1.6" fill="currentColor"/></svg>';
}

function barakah_brand() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a class="brand" href="%1$s" rel="home">%2$s<span class="brand-name">%3$s</span><span class="brand-tag">%4$s</span></a>',
		esc_url( home_url( '/' ) ),
		barakah_mark(), // phpcs:ignore -- static SVG.
		esc_html( get_bloginfo( 'name' ) ),
		esc_html__( 'SINGAPORE · MADINAH', 'barakah-paths' )
	);
}

/** Default menu until one is assigned in Appearance > Menus. */
function barakah_menu_fallback() {
	$links = array(
		array( home_url( '/' ), __( 'Home', 'barakah-paths' ) ),
		array( home_url( '/journal/' ), __( 'Journal', 'barakah-paths' ) ),
		array( home_url( '/videos/' ), __( 'Videos', 'barakah-paths' ) ),
		array( home_url( '/themes/' ), __( 'Themes', 'barakah-paths' ) ),
		array( home_url( '/about/' ), __( 'About', 'barakah-paths' ) ),
		array( home_url( '/shop/' ), __( 'Guides', 'barakah-paths' ) ),
	);
	echo '<ul>';
	foreach ( $links as $l ) {
		echo '<li><a href="' . esc_url( $l[0] ) . '">' . esc_html( $l[1] ) . '</a></li>';
	}
	echo '</ul>';
}

/** Journal: 9 per page, videos kept on their own page. */
function barakah_query( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( $q->is_home() ) {
		$vid = get_category_by_slug( 'videos' );
		if ( $vid ) {
			$q->set( 'category__not_in', array( $vid->term_id ) );
		}
		$q->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', 'barakah_query' );
