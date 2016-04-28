<?php 
/**
 * Check for theme updates
 */

if( !function_exists( 'thelandscaper_automatic_updates' ) ) {
    function thelandscaper_automatic_updates() {

        // Get the username and API key from the theme customizer 
        $username = get_theme_mod( 'qt_automatic_updates_username' );
        $api_key  = get_theme_mod( 'qt_automatic_updates_api_key' );

        // Only load the upgrader if username and API key are set
        if( !empty( $username ) && !empty( $api_key ) ) {
            load_template( get_template_directory() . '/inc/class-envato-wordpress-theme-upgrader.php' );

            if( class_exists( 'Envato_WordPress_Theme_Updater' ) ) {
                new Envato_WordPress_Theme_Updater( $username, $api_key, 'QreativeThemes' );
            }
        }
    }
    add_action( 'admin_init', 'thelandscaper_automatic_updates' );
}