<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.0-alpha
 * @author     Thomas Griffin, Gary Jones
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Register the required plugins for this theme.
 */
function thelandscaper_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'               => 'Advanced Custom Fields Pro',
            'slug'               => 'advanced-custom-fields-pro',
            'source'             => get_template_directory() . '/bundled-plugins/advanced-custom-fields-pro.zip',
            'required'           => true,
            'version'            => '5.3.1',
            'force_activation'   => true,
            'force_deactivation' => true,
            'external_url'       => 'http://www.advancedcustomfields.com/pro/'
        ),
        array(
            'name'               => 'Breadcrumb NavXT',
            'slug'               => 'breadcrumb-navxt',
            'required'           => true,
        ),
        array(
            'name'               => 'Page Builder by SiteOrigin',
            'slug'               => 'siteorigin-panels',
            'required'           => true,
            'version'            => '2.1.2',
        ),
        array(
            'name'               => 'Portfolio Post Type',
            'slug'               => 'portfolio-post-type',
            'required'           => true,
        ),
        array(
            'name'               => 'QreativeShortcodes',
            'slug'               => 'qreativeshortcodes',
            'source'             => get_template_directory() . '/bundled-plugins/qreativeshortcodes.zip',
            'required'           => true,
            'version'            => '1.0.0',
            'external_url'       => 'http://qreativethemes.com'
        ),
        array(
            'name'               => 'Simple Page Sidebars',
            'slug'               => 'simple-page-sidebars',
            'required'           => false,
        ),
        array(
            'name'               => 'TwentyTwenty',
            'slug'               => 'twentytwenty',
            'required'           => false,
        ),
        array(
            'name'               => 'Essential Grid',
            'slug'               => 'essential-grid',
            'source'             => get_template_directory() . '/bundled-plugins/essential-grid.zip',
            'required'           => false,
            'version'            => '2.0.9',
            'external_url'       => 'http://codecanyon.net/item/essential-grid-wordpress-plugin/7563340?ref=QreativeThemes'
        ),
        array(
            'name'               => 'Black Studio TinyMCE Widget',
            'slug'               => 'black-studio-tinymce-widget',
            'required'           => false,
        ),
        array(
            'name'               => 'Contact Form 7',
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'               => 'Easy Fancybox',
            'slug'               => 'easy-fancybox',
            'required'           => false,
        ),
        array(
            'name'               => 'WooCommerce - excelling eCommerce',
            'slug'               => 'woocommerce',
            'required'           => false
        ),

    );

    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'thelandscaper_register_required_plugins' );