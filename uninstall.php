<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http:wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 */

defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete WPT_CUSTOMOFILE options.
if ( is_multisite() && $network_wide ) {
	global $wpdb;
	// @codingStandardsIgnoreStart
	foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			// @codingStandardsIgnoreEnd
			delete_option( 'wpt_customofile_options' );
			restore_current_blog();
	}
} else {
	delete_option( 'wpt_customofile_options' );
}

/**
 * Remove all mo files
 *
 * @param string $dir filename.
 * @since 1.0.0
 */
function _wpt_customofile_rrmdir( $dir ) {

	if ( ! is_dir( $dir ) ) {
		// @codingStandardsIgnoreStart
		unlink( $dir );
		// @codingStandardsIgnoreEnd
		return;
	}

	if ( $globs = glob( $dir . '/*', GLOB_NOSORT ) ) {
		foreach ( $globs as $file ) {
			// @codingStandardsIgnoreStart
			is_dir( $file ) ? _wpt_customofile_rrmdir( $file ) : unlink( $file );
			// @codingStandardsIgnoreEnd
		}
	}
	// @codingStandardsIgnoreStart
	rmdir( $dir );
	// @codingStandardsIgnoreStart
}

_wpt_customofile_rrmdir( WP_CONTENT_DIR . '/uploads/wpt-custom-mo-file/' );
