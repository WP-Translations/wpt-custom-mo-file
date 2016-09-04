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
	$locale = get_locale();
	$theme_data = wp_get_theme();

	$wptcmf_domains[] = 'default';
	$wptcmf_domains[] = $theme_data->get( 'TextDomain' );

	if ( is_multisite() ) {
		$plugins = ( ! empty( get_site_option( 'active_sitewide_plugins' ) ) ) ? array_keys( get_site_option( 'active_sitewide_plugins' ) ) : get_option( 'active_plugins' );
	} else {
		$plugins = get_option( 'active_plugins' );
	}

	foreach ( $plugins as $plugin ) {
		$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . $plugin );
		if ( ! empty( $plugin_data['TextDomain'] ) ) {
			$wptcmf_domains[] = $plugin_data['TextDomain'];
		}
	}
	$wptcmf_domains = array_unique( array_merge( $wptcmf_domains, array_keys( (array) $l10n ) ) );

	return $wptcmf_domains;

}

/**
 * Extract textdomain and locale
 *
 * @since 1.0.0
 */
function wptcmf_extract_textdomain_locale( $value ) {
	list( $domain, $locale ) = explode( '|', $value );
	return $extract = array(
											'text_domain' => $domain,
											'locale' => $locale,
										);
}
