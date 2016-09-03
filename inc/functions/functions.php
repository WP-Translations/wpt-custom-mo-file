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
	$locale = get_locale();
	if ( 'en_US' === $locale ) {
		add_filter( 'locale', '__wptcmf_hack_locale' );
		$wptcmf_domains[] = 'default';
		$theme_data = wp_get_theme();
		$wptcmf_domains[] = $theme_data->get( 'TextDomain' );
	}
	global $l10n;

	$plugins = ( is_multisite() ) ? array_keys( get_site_option( 'active_sitewide_plugins' ) ) : get_option( 'active_plugins' );

	foreach ( $plugins as $plugin ) {
		$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . $plugin );
		if ( ! empty( $plugin_data['TextDomain'] ) ) {
			$wptcmf_domains[] = $plugin_data['TextDomain'];
		}
	}
	$wptcmf_domains = array_unique( array_merge( $wptcmf_domains, array_keys( (array) $l10n ) ) );
	remove_filter( 'locale', '__wptcmf_hack_locale' );

	return $wptcmf_domains;

}

/**
 * Change locale when en_US to load global $l10n
 *
 * @since 1.0.0
 */
function __wptcmf_hack_locale() {
	return 'fr_FR'; // Why not !
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
