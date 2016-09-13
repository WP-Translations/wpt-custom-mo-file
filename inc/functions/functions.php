<?php
/**
 * Helper functions
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/inc/functions
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Filter for upload_dir
 *
 * @param  array $upload_dir 	get upload_dir params.
 * @return array      				new directory subdir/path/url.
 * @since 1.0.0
 */
function wpt_customofile_filter_upload_dir( $upload_dir ) {
		$upload_dir['subdir'] = '/wpt-custom-mo-file';
		$upload_dir['path'] = $upload_dir['basedir'] . '/wpt-custom-mo-file';
		$upload_dir['url'] = $upload_dir['baseurl'] . '/wpt-custom-mo-file';

		return $upload_dir;
}

/**
 * Extract textdomain and locale
 *
 * @param  string $value get concat value from button.
 * @return array        return array text_domain/locale.
 * @since 1.0.0
 */
function wpt_customofile_extract_textdomain_locale( $value ) {
	list( $domain, $locale ) = explode( '|', $value );
	return $extract = array(
											'text_domain' => $domain,
											'locale' => $locale,
										);
}
