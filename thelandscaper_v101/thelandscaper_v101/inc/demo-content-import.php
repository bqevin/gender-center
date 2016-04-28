<?php
/**
 * Version 0.0.3
 *
 */

if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'TheLandscaper_Theme_Demo_Data_Importer' ) ) {

    require_once( get_template_directory() . '/radium-one-click-demo-install/importer/radium-importer.php' ); //load admin theme data importer

	class TheLandscaper_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

        /**
		 * Set framewok
		 *
		 * options that can be used are 'default', 'radium' or 'optiontree'
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'radium';

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name  = 'my_theme_options_name'; // ignore
		public $theme_options_file_name = 'theme_options.txt'; // ignore
		public $widgets_file_name = 'widgets.json';
		public $content_demo_file_name = 'content.xml';

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = trailingslashit( get_template_directory() . '/demo-files/' );

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$main_menu	   = get_term_by('name', 'Primary Navigation', 'nav_menu');
			$services_menu = get_term_by('name', 'Services Menu', 'nav_menu');
			$footer_menu   = get_term_by('name', 'Footer Menu', 'nav_menu');

			set_theme_mod( 'nav_menu_locations', array(
					'primary' => $main_menu->term_id,
					'services-menu' => $services_menu->term_id,
					'footer-menu' => $footer_menu->term_id
				)
			);

			$this->flag_as_imported['menus'] = true;

			// Set the front page and blog page
			$set_front_page = get_page_by_title( 'Front Page' )->ID;
			$set_blog_page  = get_page_by_title( 'Blog' )->ID;

			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $set_front_page );
			update_option( 'page_for_posts', $set_blog_page );

			// Empty default breadcrumbs seperator
			add_option( 'bcn_options', array( 'hseparator' => '' ) );

			// Force the logo in the customizer
			set_theme_mod( 'qt_logo', get_template_directory_uri() . '/assets/images/logo.png' );
			set_theme_mod( 'qt_logo_retina', get_template_directory_uri() . '/assets/images/logo_2x.png' );

		}

	}

	new TheLandscaper_Theme_Demo_Data_Importer;
}