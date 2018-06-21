<?php
/**
* Bulmascores functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Bulmascores
*/

if ( ! function_exists( 'bulmascores_setup' ) ) :
	/**
	* Sets up theme defaults and registers support for various WordPress features.
	*
	* Note that this function is hooked into the after_setup_theme hook, which
	* runs before the init hook. The init hook is too late for some features, such
	* as indicating support for post thumbnails.
	*/
	function bulmascores_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Bulmascores, use a find and replace
		* to change 'bulmascores' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'bulmascores', get_template_directory() . '/languages' );

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
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bulmascores' ),
		) );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bulmascores_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		* Add support for core custom logo.
		* @link https://codex.wordpress.org/Theme_Logo
		*/
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		//width equal to fullhd container and 16:9 aspect ratio
		add_image_size( 'bulmascores_full', 1344, 760, true );

		//width equal to fullhd container and 16:9 aspect ratio
		add_image_size( 'bulmascores_square', 600, 600, true );

		//width equal to desktop container
		add_image_size( 'bulmascores_thumbnail', 960, 600, true );
	}
endif;
add_action( 'after_setup_theme', 'bulmascores_setup' );

// Remove WordPress version number
remove_action( 'wp_head', 'wp_generator' );

// Add navbar-item class to the_custom_logo()
add_filter( 'get_custom_logo', 'custom_logo_class' );
function custom_logo_class( $logo ) {

	$logo = str_replace( 'custom-logo-link', 'custom-logo-link navbar-item', $logo );

	return $logo;
}

/**
* Set the content width in pixels, based on the theme's design and stylesheet.
* Priority 0 to make it available to lower priority callbacks.
* @global int $content_width
*/
function bulmascores_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bulmascores_content_width', 640 );
}
add_action( 'after_setup_theme', 'bulmascores_content_width', 0 );

/**
* Register widget area.
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/
function bulmascores_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bulmascores' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bulmascores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s menu-list">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title menu-label">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bulmascores_widgets_init' );

// Enqueue scripts and styles.
function bulmascores_scripts() {
	wp_enqueue_style( 'bulmascores-bulma-css', '//cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css', array(), null );
	wp_enqueue_style( 'bulmascores-fontawesome', '//use.fontawesome.com/releases/v5.0.13/css/all.css', array(), null );
	wp_enqueue_style( 'bulmascores-overrides-style', get_template_directory_uri() . '/assets/css/bulmascores.min.css', array(), null );
	wp_enqueue_script( 'bulmascores-burger-js', get_template_directory_uri() . '/assets/js/bulma_nav_burger.js', array(), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_front_page() ) {
		wp_enqueue_style( 'bulmascores-flickity-css', '//unpkg.com/flickity@2/dist/flickity.min.css', array(), null );
		wp_enqueue_script( 'bulmascores-flickity-js', '//unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array(), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'bulmascores_scripts' );

// Implement the Custom walker.
require get_template_directory() . '/inc/class-bulma-walker.php';

// Implement the Custom pagination.
require get_template_directory() . '/inc/bulma-pagination.php';

// Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
