<?php
/**
 * @package The Landscaper
 * @author QreativeThemes.com
 */


/**
 * Define the version for js and css files
 */
define( 'THELANDSCAPER_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140;
}

/* ACF Functions */
require_once( get_template_directory() . '/inc/acf.php' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 if( ! function_exists( 'thelandscaper_wp_setup' ) ) {
	function thelandscaper_wp_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on The Landscaper, use a find and replace
		 * to change 'the-landscaper-wp' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'the-landscaper-wp', get_template_directory() . '/languages' );

		/*
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * WooCommerce Support.
		 */
		add_theme_support( 'woocommerce' );
		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 848, 480, true );

		// Jumbotron Slider Sizes
		add_image_size( 'thelandscaper-home-slider-l', 1920, 730, true );
		add_image_size( 'thelandscaper-home-slider-m', 960, 320, true );
		add_image_size( 'thelandscaper-home-slider-s', 480, 160, true );

		// Featured Page Thumb Size
		add_image_size( 'thelandscaper-featured-thumb', 360, 240, true );
		add_image_size( 'thelandscaper-featured-large', 850, 567, true );

		// News Block Widget Image Size
		add_image_size( 'thelandscaper-news-large', 848, 448, true );
		add_image_size( 'thelandscaper-news-small', 360, 200, true );

		// All Gallery Image Sizes
		add_image_size( 'thelandscaper-project-images', 653, 375, true );
		add_image_size( 'thelandscaper-project-images-l', 1170, 650, true );
		add_image_size( 'thelandscaper-project-images-m', 720, 400, true );
		add_image_size( 'thelandscaper-project-images-s', 480, 265, true );
	

		/*
		 * This theme uses wp_nav_menu() in one location.
		 */
		add_theme_support( 'menus' );
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'the-landscaper-wp' ) );
		register_nav_menu( 'services-menu', esc_html__( 'Services Menu', 'the-landscaper-wp' ) );
		register_nav_menu( 'footer-menu', esc_html__( 'Footer Menu', 'the-landscaper-wp' ) );

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

		/*
		 *  Set up the WordPress core custom background feature.
		 */
		add_theme_support( 'custom-background', apply_filters( 'thelandscaper_custom_background', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/*
		 * Add excerpt support for pages
		 */
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Add CSS for TinyMCE editor
		 */
		add_editor_style();

	}
	add_action( 'after_setup_theme', 'thelandscaper_wp_setup' );
}

/**
 * Enqueue CSS Files
 */
if ( ! function_exists( 'thelandscaper_enqueue_styles' ) ) {
	function thelandscaper_enqueue_styles() {
		wp_enqueue_style( 'thelandscaper-main', get_stylesheet_uri(), array(), THELANDSCAPER_VERSION, null );
	}
	add_action( 'wp_enqueue_scripts', 'thelandscaper_enqueue_styles' );
}

/** 
 * Enqueue the Google Fonts
 * @see /inc/theme-actions.php
 */
if( ! function_exists( 'thelandscaper_google_font' ) ) {
	function thelandscaper_google_font() {
	    wp_enqueue_style( 'thelandscaper-fonts', thelandscaper_fonts_slug(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'thelandscaper_google_font' );
}

/**
 * Enqueue JS scripts
 */
if( ! function_exists( 'thelandscaper_enqueue_scripts' ) ) {
	function thelandscaper_enqueue_scripts() {
		$url_prefix = is_ssl() ? 'https:' : 'http:';

		wp_enqueue_script( 'thelandscaper-modernizr', get_template_directory_uri() . '/assets/js/modernizr-custom.js', array(), '', null );
		wp_enqueue_script( 'thelandscaper-respimg', get_template_directory_uri() . '/assets/js/respimage.min.js', array(), '1.2.0', false );
		wp_enqueue_script( 'thelandscaper-maps', $url_prefix . '//maps.googleapis.com/maps/api/js', null, true );
		wp_enqueue_script( 'thelandscaper-main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery', 'underscore' ), THELANDSCAPER_VERSION, true );

		// Get Theme path, used for requirejs
		wp_localize_script( 'thelandscaper-main', 'TheLandscaper', array(
			'themePath'  => get_template_directory_uri(),
		) );

		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'thelandscaper_enqueue_scripts' );
}

/**
 *  Enqueue admin scripts and styles.
 */
if ( ! function_exists( 'thelandscaper_admin_scripts' ) ) {
	function thelandscaper_admin_scripts( $hook ) {
		
		// Only include the admin CSS and JS below on this pages
		if( in_array( $hook, array( 'post-new.php', 'post.php', 'edit.php', 'widgets.php' ) ) ) {

			// JS
			wp_enqueue_script( 'thelandscaper-testimonials', get_template_directory_uri() . '/assets/js/widgets/testimonials.js', array( 'jquery', 'underscore', 'backbone' ) );
			wp_enqueue_script( 'thelandscaper-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery', 'underscore', 'backbone' ) );
		}

		// CSS
		wp_enqueue_style( 'thelandscaper-admin-style', get_template_directory_uri() . '/assets/css/admin.css' );
	}
	add_action( 'admin_enqueue_scripts', 'thelandscaper_admin_scripts' );
}

/**
 * Get all the theme files from the /inc folder
 *
 */

 /* Theme Filters Functions */
require_once( get_template_directory() . '/inc/theme-filters.php' );

/* Theme Actions Functions */
require_once( get_template_directory() . '/inc/theme-actions.php' );

/* Theme Sidebar Area's */
require_once( get_template_directory() . '/inc/theme-sidebars.php' );

/* Theme Custom Widgets */
require_once( get_template_directory() . '/inc/theme-widgets.php' );

/* Theme Live Customizer */
require_once( get_template_directory() . '/inc/customizer.php' );

/* Basic WooCommerce Integration */
require_once( get_template_directory() . '/inc/woocommerce.php' );

/* Theme Custom Comments */
require_once( get_template_directory() . '/inc/custom-comments.php' );

/* Aria Walker Menu */
require_once( get_template_directory() . '/inc/aria_walker_nav_menu.php' );


/**
 * Get all the theme files only used in admin area
 */
if ( is_admin() ) {

	/* One Click Demo Content Install */
	require_once( get_template_directory() . '/inc/demo-content-import.php' );

	/* Class TGM Plugin Activation  */
	require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php' );

	/* TGM Required Plugins  */
	require_once( get_template_directory() . '/inc/tgm-plugin-activation.php' );

	/* Envato Automatic Updates */
	require_once( get_template_directory() . '/inc/theme-automatic-updates.php' );
}