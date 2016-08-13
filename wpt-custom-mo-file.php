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
define( 'WPTCMF_URL_ASSETS',  		WPTCMF_URL . 'assets/' );
define( 'WPTCMF_URL_ASSETS_CSS',	WPTCMF_URL_ASSETS . 'css/' );

/**
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0.0
 */
function wptcmf_init() {

	load_plugin_textdomain( 'wpt-custom-mo-file', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	if ( is_admin() ) {
		require( WPTCMF_ADMIN_UI_PATH . 'enqueue.php' );
		require( WPTCMF_ADMIN_PATH . 'options.php' );
		require( WPTCMF_ADMIN_UI_PATH . 'options.php' );
	}

}
add_action( 'plugins_loaded', 'wptcmf_init' );

/**
 * Tell WP what to do when plugin is activated
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'wptcmf_activation' );
function wptcmf_activation() {
	add_option( 'wptcmf_options', array( 'rules' ), '', 'no' );
}

/**
 * Filters whether to override the .mo file loading.
 *
 * @since 1.0.0
 *
 * @param bool   $override Whether to override the .mo file loading. Default false.
 * @param string $domain   Text domain. Unique identifier for retrieving translated strings.
 * @param string $mofile   Path to the MO file.
 */
add_filter( 'override_load_textdomain', 'wptcmf_override_default_language_files', 10, 3 );
function wptcmf_override_default_language_files( $override, $domain, $mofile ) {
	global $l10n, $l10n_unloaded;

	do_action( 'load_textdomain', $domain, $mofile );
	$mofile = apply_filters( 'load_textdomain_mofile', $mofile, $domain );
	if ( ! is_readable( $mofile ) ) {
		return false;
	}

	$mo = new MO();
	if ( ! $mo->import_from_file( $mofile ) ) {
		return false;
	}
	if ( isset( $l10n[ $domain ] ) ) {
		$mo->merge_with( $l10n[ $domain ] );
	}
	unset( $l10n_unloaded[ $domain ] );
	$l10n[ $domain ] = &$mo;
	return true;
}

/**
 * Loop rules to setup override
 *
 * @since 1.0.0
 *
 */
add_action( 'plugins_loaded', 'wptcmf_load_rules' );
function wptcmf_load_rules() {
	$rules = get_option( 'wptcmf_options' );

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {
		foreach ( $rules['rules'] as $rule ) {
			if ( 1 === $rule['activate'] ) {
				wptcmf_override_default_language_files( $override = true, $rule['text_domain'], $rule['mo_path'] );
			}
		}
	}

}
