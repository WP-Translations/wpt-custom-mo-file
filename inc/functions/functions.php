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
