<?php
/**
 * functions and definitions
 */

 
/** ===============
 * definitions
 */
define( 'THEME_NAME', 'EDD Starter Theme' ); // place your theme name between the single quotes
define( 'THEME_VERSION', '1.0.0' ); // keep your theme version updated from here and the style.css file


if ( ! function_exists( 'edds_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function edds_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'edds', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	
	// add a hard cropped (for uniformity) image size for the product grid
	add_image_size( 'product-img', 540, 360, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'header'	=> __( 'Header Menu', 'edds' ),
		'main'		=> __( 'Main Menu', 'edds' ),
	) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
}
endif; // edds_setup
add_action( 'after_setup_theme', 'edds_setup' );


/** ===============
 * Register widgetized area and update sidebar with default widgets.
 */
function edds_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'edds' ),
		'id'            => 'sidebar-primary',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
	register_sidebar( array(
		'name'          => __( 'EDD Sidebar', 'edds' ),
		'id'            => 'sidebar-edd',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
}
add_action( 'widgets_init', 'edds_widgets_init' );


/** ===============
 * Enqueue scripts and styles.
 */
function edds_scripts() {
	wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri() . '/inc/fonts/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'edds-style', get_stylesheet_uri() );
	wp_enqueue_script( 'edds-navigation', get_template_directory_uri() . '/inc/js/navigation.js', array(), THEME_VERSION, true );
	wp_enqueue_script( 'edds-skip-link-focus-fix', get_template_directory_uri() . '/inc/js/skip-link-focus-fix.js', array(), THEME_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'edds_scripts' );


/** ===============
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/** ===============
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/** ===============
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/** ===============
 * Adjust excerpt length
 */
function edds_custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'edds_custom_excerpt_length', 999 );


/** ===============
 * Replace excerpt ellipses with new ellipses and link to full article
 */
function edds_excerpt_more( $more ) {
	if ( is_page_template( 'edd_templates/edd-store-front.php' ) || is_archive( 'download') ) {
		return '...';
	} else {
		return '...</p> <div class="continue-reading"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . get_theme_mod( 'edds_read_more', __( 'Read More &rarr;', 'edds' ) ) . '</a></div>';
	}
}
add_filter( 'excerpt_more', 'edds_excerpt_more' );


/** ===============
 * Add .top class to the first post in a loop
 */
function edds_first_post_class( $classes ) {
	global $wp_query;
	if ( 0 == $wp_query->current_post )
		$classes[] = 'top';
	return $classes;
}
add_filter( 'post_class', 'edds_first_post_class' );


/** ===============
 * Only show regular posts in search results
 */
function edds_search_filter( $query ) {
	if ( $query->is_search && ! is_admin )
		$query->set( 'post_type', 'post' );
	return $query;
}
add_filter( 'pre_get_posts','edds_search_filter' );


/** ===============
 * Download taxonomy display count - matches customizer store front settings
 */
function edds_download_tax_count( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
		return;
	if ( $query->is_tax( 'download_category' ) || $query->is_tax( 'download_tag' ) ) {
		$query->set( 'posts_per_page', intval( get_theme_mod( 'edds_store_front_count', 8 ) ) );
		return;
	}
}
add_action( 'pre_get_posts', 'edds_download_tax_count' );


/** ===============
 * Allow comments on downloads
 */
function edds_edd_add_comments_support( $supports ) {
	$supports[] = 'comments';
	return $supports;	
}
add_filter( 'edd_download_supports', 'edds_edd_add_comments_support' );

	
/** ===============
 * No purchase button below download content
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );