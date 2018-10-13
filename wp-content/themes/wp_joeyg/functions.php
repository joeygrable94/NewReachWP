<?php
/**
 * wpjp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// SETUP
if ( ! function_exists( 'wpjg_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wpjg_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wpjp, use a find and replace
		 * to change 'wpjp' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wpjp', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );

		/**
		 * Register navigation menus
		 */
		register_nav_menus( array(
			'navigation_primary' => 'Navigation Primary',
			'navigation_secondary' => 'Navigation Secondary',
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wpjg_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 140,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * sets a global var with an array
		 * handles excluding all posts
		 * that are not portfolio posts
		 */
		global $not_portfolio_posts;
		$not_portfolio_posts = array('1', '12', '13', '15', '48');

	}
endif;
add_action( 'after_setup_theme', 'wpjg_setup' );





/**
 * WOOCOMMERCE
 * e-commerce support
 */
function wpjg_add_woocommerce_support() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 500,
		'single_image_width'    => 800,
		'product_grid'          => array(
			'default_rows'    => 4,
			'min_rows'        => 3,
			'max_rows'        => 5,
			'default_columns' => 4,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	));
	add_theme_support( 'wc-product-gallery-lightbox' );
}
add_action( 'after_setup_theme', 'wpjg_add_woocommerce_support' );





/**
 * DISPLAY meta boxes fix
 */
add_filter('acf/settings/remove_wp_meta_box', '__return_false');





/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpjg_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'wpjg_content_width', 640 );
}
add_action( 'after_setup_theme', 'wpjg_content_width', 0 );





/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpjg_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Footer', 'wpjp' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Add widgets here.', 'wpjp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="sidebar-footer-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpjg_widgets_init' );





/**
 * Enqueue scripts and styles.
 */
function wpjg_scripts() {

	/* CSS */
	wp_enqueue_style( 'wpjp-style', get_template_directory_uri() . '/assets/css/styles.min.css' );

	/* JS */
	wp_enqueue_script( 'wpjp-scripts', get_template_directory_uri() . '/assets/js/scripts.min.js' );

	/** COMMENTS **/
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }

}
add_action( 'wp_enqueue_scripts', 'wpjg_scripts' );





/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * [shortcodes] which enhance the theme admin editor [/shortcodes]
 */
require get_template_directory() . '/inc/template-shortcodes.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Functions which enhance the WOOCOMMERCE SHOP by hooking into WordPress.
 */
require get_template_directory() . '/inc/shop-functions.php';




