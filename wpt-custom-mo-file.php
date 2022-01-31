<?php
/**
 * WPT Custom Mo File
 *
 * @package     WPT_Custom_Mo_File
 * @author      WP-Translations Team
 * @link        https://github.com/WP-Translations/wpt-custom-mo-file
 * @version     1.1.0
 *
 * @copyright   2016 WP-Translations Team
 * @license     https://creativecommons.org/licenses/GPL/2.0/ GNU General Public License, version 2 or higher.
 *
 * @wordpress-plugin
 * Plugin Name: WPT Custom Mo File
 * Plugin URI:  https://wordpress.org/plugins/wpt-custom-mo-file/
 * Description: A powerful WordPress plugin that let you use your own translation .mo files. Simple as that.

 * Version:     1.1.0
 * Author:      WP-Translations Team
 * Author URI:  https://wp-translations.pro/
 * Text Domain: wpt-custom-mo-file
 * Domain Path: /languages
 * Copyright:   2016 WP-Translations Team
 */

defined( 'ABSPATH' ) || die( 'Cheatin&#8217; uh?' );

define( 'WPT_CUSTOMOFILE_VERSION', '1.1.0' );
define( 'WPT_CUSTOMOFILE_SLUG', 'wpt-custom-mo-file' );
define( 'WPT_CUSTOMOFILE_NICE_NAME', 'WPT Custom Mo File' );
define( 'WPT_CUSTOMOFILE_FILE', __FILE__ );
define( 'WPT_CUSTOMOFILE_URL', plugin_dir_url( WPT_CUSTOMOFILE_FILE ) );
define( 'WPT_CUSTOMOFILE_PATH', realpath( plugin_dir_path( WPT_CUSTOMOFILE_FILE ) ) . '/' );
define( 'WPT_CUSTOMOFILE_INC_PATH', realpath( WPT_CUSTOMOFILE_PATH . 'inc' ) . '/' );
define( 'WPT_CUSTOMOFILE_ADMIN_PATH', realpath( WPT_CUSTOMOFILE_INC_PATH . 'admin' ) . '/' );
define( 'WPT_CUSTOMOFILE_ADMIN_UI_PATH', realpath( WPT_CUSTOMOFILE_ADMIN_PATH . 'ui' ) . '/' );
define( 'WPT_CUSTOMOFILE_FUNCTIONS_PATH', realpath( WPT_CUSTOMOFILE_INC_PATH . 'functions' ) . '/' );
define( 'WPT_CUSTOMOFILE_ASSETS_URL', WPT_CUSTOMOFILE_URL . 'assets/' );
define( 'WPT_CUSTOMOFILE_CSS_URL', WPT_CUSTOMOFILE_ASSETS_URL . 'css/' );
define( 'WPT_CUSTOMOFILE_JS_URL', WPT_CUSTOMOFILE_ASSETS_URL . 'js/' );
define( 'WPT_CUSTOMOFILE_IMG_URL', WPT_CUSTOMOFILE_ASSETS_URL . 'images/' );

/**
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0.0
 */
function wpt_customofile_init() {

	load_plugin_textdomain( 'wpt-custom-mo-file', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if ( is_admin() ) {
		require( WPT_CUSTOMOFILE_FUNCTIONS_PATH . 'functions.php' );
		require( WPT_CUSTOMOFILE_ADMIN_PATH . 'enqueue.php' );
		require( WPT_CUSTOMOFILE_ADMIN_PATH . 'options.php' );
		require( WPT_CUSTOMOFILE_ADMIN_UI_PATH . 'options.php' );
	}

}
add_action( 'plugins_loaded', 'wpt_customofile_init' );

/**
 * Log available textdomains
 *
 * @param  string $domain  Unique identifier for retrieving translated strings.
 * @param  string $mo_file Path to the .mo file.
 * @since 1.0.0
 */
function wpt_customofile_log_textdomain( $domain, $mo_file ) {

	if ( ! isset( $GLOBALS['wpt_customofile_text_domains'][ $domain ] ) ) {
		$GLOBALS['wpt_customofile_text_domains'][ $domain ] = $domain;
	}

}
add_action( 'load_textdomain', 'wpt_customofile_log_textdomain', 10, 2 );

/**
 * Tell WP what to do when plugin is activated
 *
 * @param  boolean $network_wide Whether to enable the plugin for all sites in the network or just the current site. Multisite only.
 * @since 1.0.0
 */
function wpt_customofile_activation( $network_wide ) {

	if ( is_multisite() && $network_wide ) {
		global $wpdb;
		// @codingStandardsIgnoreStart
		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			// @codingStandardsIgnoreEnd
			add_option( 'wpt_customofile_options', array() );
			restore_current_blog();
		}
	} else {
		add_option( 'wpt_customofile_options', array() );
	}

}
register_activation_hook( __FILE__, 'wpt_customofile_activation' );

/**
 * Add wpt_customofile_options when a new blog is create
 *
 * @param  int    $blog_id Blog ID of the created blog.
 * @param  int    $user_id User ID of the user creating the blog.
 * @param  string $domain  Domain used for the new blog.
 * @param  string $path    Path to the new blog.
 * @param  int    $site_id Site ID. Only relevant on multi-network installs.
 * @param  array  $meta    Meta data. Used to set initial site options.
 * @since 1.0.0
 */
function wpt_customofile_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	if ( is_plugin_active_for_network( WPT_CUSTOMOFILE_SLUG . '/' . WPT_CUSTOMOFILE_SLUG . '.php' ) ) {
		// @codingStandardsIgnoreStart
		switch_to_blog( $blog_id );
		// @codingStandardsIgnoreEnd
		add_option( 'wpt_customofile_options', '' );
		restore_current_blog();
	}
}
add_action( 'wpmu_new_blog', 'wpt_customofile_new_blog', 10, 6 );

/**
 * Load overwrites rules
 *
 * @since 1.0.0
 */
function wpt_customofile_overwrite_domains() {

	global $wp_version;
	$options = get_option( 'wpt_customofile_options' );
	$locale  = ( $wp_version >= 4.7 ) ? get_user_locale() : get_locale();

	if ( isset( $options['rules'][ $locale ] ) && ! empty( $options['rules'][ $locale ] ) ) {
		foreach ( $options['rules'][ $locale ] as $rule ) {
			if ( 1 === $rule['activate'] && $locale === $rule['language'] ) {
				unload_textdomain( $rule['text_domain'] );
				load_textdomain( $rule['text_domain'], $rule['mo_path'] );
			}
		}
	}

}
add_action( 'init', 'wpt_customofile_overwrite_domains', 0 );
