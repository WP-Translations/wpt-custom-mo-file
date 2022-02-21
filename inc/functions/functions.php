<?php
/**
 * Helper functions
 *
 * @author     WP-Translations Team
 * @link       https://wp-translations.pro
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/inc/functions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Filter for upload_dir.
 *
 * @since 1.0.0
 *
 * @param array<mixed> $upload_dir   Get upload_dir params.
 *
 * @return array<mixed>   New directory subdir/path/url.
 */
function wpt_customofile_filter_upload_dir( $upload_dir ) {

	$upload_dir['subdir'] = '/' . WPT_CUSTOMOFILE_SLUG;
	$upload_dir['path']   = $upload_dir['basedir'] . '/' . WPT_CUSTOMOFILE_SLUG;
	$upload_dir['url']    = $upload_dir['baseurl'] . '/' . WPT_CUSTOMOFILE_SLUG;

	// Prepare uploads folder.
	wpt_customofile_upload_dir_prepare( strval( $upload_dir['path'] ) );

	return $upload_dir;
}


/**
 * Prepare uploads folder.
 * Check if folder exist and has empty index, create both if don't exist.
 *
 * @since 1.2.0
 *
 * @param string $upload_dir_path   Upload folder data.
 *
 * @return void
 */
function wpt_customofile_upload_dir_prepare( $upload_dir_path ) {

	// Checks if the content folder exists.
	if ( ! is_dir( $upload_dir_path ) ) {

		// Create the content folder.
		mkdir( $upload_dir_path, 0755, true );

	}

	// Checks if index exists.
	if ( ! is_file( $upload_dir_path . '/index.php' ) ) {

		// Add empty index file.
		copy( WPT_CUSTOMOFILE_PATH . 'index.php', $upload_dir_path . '/index.php' );

	}

}


/**
 * Extract textdomain and locale.
 *
 * @since 1.0.0
 *
 * @param string $value   Get concat value from button.
 *
 * @return array<mixed>   Array text_domain/locale.
 */
function wpt_customofile_extract_textdomain_locale( $value ) {
	list( $domain, $locale ) = explode( '|', $value );
	return array(
		'text_domain' => $domain,
		'locale'      => $locale,
	);
}
