<?php
/**
 * WPT Custom Mo File
 *
 * @package     WordPress\Plugins\WPT Custom Mo File
 * @author      WP-Translations Team
 * @link        https://github.com/WP-Translations/wpt-custom-mo-file
 * @version     1.0.0
 *
 * @copyright   2016 WP-Translations Team
 * @license     http://creativecommons.org/licenses/GPL/2.0/ GNU General Public License, version 2 or higher
 *
 * @wordpress-plugin
 * Plugin Name: WPT Custom Mo File
 * Plugin URI:  https://wordpress.org/plugins/wpt-custom-mo-file/
 * Description: Override text-domain with your own mo file
 * Version:     1.0.0
 * Author:      WP-Translations Team
 * Author URI:  http://www.wp-translations.org/
 * Text Domain: wpt-custom-mo-file
 * Domain Path: /languages
 * Copyright:   2016 WP-Translations Team
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

define( 'WPTCMF_VERSION', 				'1.0.0' );
define( 'WPTCMF_SLUG', 						'wpt-custom-mo-file' );
define( 'WPTCMF_NICE_NAME', 			'WPT Custom Mo File' );
define( 'WPTCMF_FILE', 						__FILE__ );
define( 'WPTCMF_URL', 						plugin_dir_url( WPTCMF_FILE ) );
define( 'WPTCMF_PATH', 						realpath( plugin_dir_path( WPTCMF_FILE ) ) . '/' );
define( 'WPTCMF_INC_PATH', 				realpath( WPTCMF_PATH . 'inc' ) . '/' );
define( 'WPTCMF_ADMIN_PATH', 			realpath( WPTCMF_INC_PATH . 'admin' ) . '/' );
define( 'WPTCMF_ADMIN_UI_PATH', 	realpath( WPTCMF_ADMIN_PATH . 'ui' ) . '/' );
define( 'WPTCMF_FUNCTIONS_PATH', 	realpath( WPTCMF_INC_PATH . 'functions' ) . '/' );
define( 'WPTCMF_URL_ASSETS',  		WPTCMF_URL . 'assets/' );
define( 'WPTCMF_URL_CSS',  				WPTCMF_URL_ASSETS . 'css/' );
define( 'WPTCMF_URL_IMG',  				WPTCMF_URL_ASSETS . 'images/' );
define( 'WPTCMF_OVERWRITE_DIR',		WP_CONTENT_DIR . '/uploads/wpt-custom-mo-file/' );

/**
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', 'wptcmf_init' );
function wptcmf_init() {

	load_plugin_textdomain( WPTCMF_SLUG, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if ( is_admin() ) {
		require( WPTCMF_FUNCTIONS_PATH . 'functions.php' );
		require( WPTCMF_ADMIN_PATH . 'enqueue.php' );
		require( WPTCMF_ADMIN_PATH . 'options.php' );
		require( WPTCMF_ADMIN_UI_PATH . 'options.php' );
	}

}

/**
 * Tell WP what to do when plugin is activated
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, '__wptcmf_activation' );
function __wptcmf_activation( $network_wide ) {
	if ( is_multisite() && $network_wide ) {
		global $wpdb;

		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ) as $blog_id ) {
				switch_to_blog( $blog_id );
				add_option( 'wptcmf_options', '' );
				restore_current_blog();
		}
	} else {
		add_option( 'wptcmf_options', '' );
	}

}

/**
 * Add wptcmf_options when a new blog is create
 *
 * @since  1.0.0
 */
add_action( 'wpmu_new_blog', '__wptcmf_new_blog', 10, 6 );
function __wptcmf_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	if ( is_plugin_active_for_network( WPTCMF_SLUG . '/' . WPTCMF_SLUG . '.php' ) ) {
		switch_to_blog( $blog_id );
		add_option( 'wptcmf_options', '' );
		restore_current_blog();
	}
}

/**
 * Load overwrites rules
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', '__wptcmf_overwrite_domains', 0 );
function __wptcmf_overwrite_domains() {
	$options = get_option( 'wptcmf_options' );
	$locale = get_locale();

	if ( isset ( $options['rules'][ $locale ] ) && ! empty( $options['rules'][ $locale ] ) ) {
		foreach ( $options['rules'][ $locale ] as $rule ) {
			if ( 1 === $rule['activate'] && $locale === $rule['language'] ) {
				unload_textdomain( $rule['text_domain'] );
				load_textdomain( $rule['text_domain'], $rule['mo_path'] );
			}
		}
	}

}
