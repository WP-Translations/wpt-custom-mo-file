<?php

// If uninstall not called from WordPress exit.
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete WPTCMF options.
delete_option( 'wptcmf_options' );

/**
 * Remove all mo files
 *
 * @since 1.2.0
 */
function __wptcmf_rrmdir( $dir ) {

	if ( ! is_dir( $dir ) ) {
		@unlink( $dir );
		return;
	}

	if ( $globs = glob( $dir . '/*', GLOB_NOSORT ) ) {
		foreach ( $globs as $file ) {
			is_dir( $file ) ? __wptcmf_rrmdir( $file ) : @unlink( $file );
		}
	}

		@rmdir( $dir );

}

__wptcmf_rrmdir( WP_CONTENT_DIR . '/uploads/wpt-custom-mo-file/' );
