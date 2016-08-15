<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Filter for upload_dir
 *
 * @since 1.0.0
 */
function __wpcmf_filter_upload_dir( $dirs ) {
		$dirs['subdir'] = '/wpt-custom-mo-file';
		$dirs['path'] = $dirs['basedir'] . '/wpt-custom-mo-file';
		$dirs['url'] = $dirs['baseurl'] . '/wpt-custom-mo-file';

		return $dirs;
}

/**
 * Create available textdomains array
 *
 * @since 1.0.0
 */
function wptcmf_get_domains() {
	global $l10n;
	$plugins = get_option( 'active_plugins' );
	$rules = get_option( 'wptcmf_options' );
	$domains_blacklist = array( 'default', 'debug-bar-localization', 'query-monitor', 'wpt-custom-mo-file', 'feedpress' );

	foreach ( $plugins as $plugin ) {
		$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . $plugin );
		if ( ! empty( $plugin_data['TextDomain'] ) ) {
			$wptcmf_domains[] = $plugin_data['TextDomain'];
		}
	}
	$wptcmf_domains = array_unique ( array_merge( $wptcmf_domains, array_keys( $l10n ) ) );

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {
		$rules_exist = array_keys( $rules['rules'] );
		if ( ! empty( $rules_exist ) ) {
				$domains_blacklist = array_unique( array_merge( $domains_blacklist, $rules_exist ) );
		}
		$wptcmf_domains = array_diff( $wptcmf_domains, $domains_blacklist );
	}

	return $wptcmf_domains;

}
