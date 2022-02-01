<?php
/**
 * Register the stylesheets and scripts for the admin area.
 *
 * @author     WP-Translations Team
 * @link       https://wp-translations.pro
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/inc/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register admin assets.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wpt_customofile_load_admin_assets() {
	$screen  = get_current_screen();
	$css_ext = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	$js_ext  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

	wp_register_style(
		'wpt-customofile-styles',
		WPT_CUSTOMOFILE_CSS_URL . 'wpt-customofile-styles' . $css_ext,
		array(),
		WPT_CUSTOMOFILE_VERSION
	);

	wp_register_style(
		'data-tables-styles',
		WPT_CUSTOMOFILE_CSS_URL . 'data-table' . $css_ext,
		array(),
		'1.10.12'
	);

	wp_register_script(
		'data-tables-scripts',
		WPT_CUSTOMOFILE_JS_URL . 'jquery.dataTables' . $js_ext,
		array( 'jquery' ),
		'1.10.12',
		true
	);

	wp_register_script(
		'wpt-customofile-scripts',
		WPT_CUSTOMOFILE_JS_URL . 'wpt-customofile-scripts' . $js_ext,
		array( 'jquery' ),
		WPT_CUSTOMOFILE_VERSION,
		true
	);

	$translation_datatable = array(
		'sEmptyTable'     => __( 'No data available in table', 'wpt-custom-mo-file' ),
		'sInfo'           => _x( 'Showing _START_ to _END_ of _TOTAL_ entries', 'Please do not translate: _START_ _END_ _TOTAL_', 'wpt-custom-mo-file' ),
		'sInfoEmpty'      => __( 'Showing 0 to 0 of 0 entries', 'wpt-custom-mo-file' ),
		'sInfoFiltered'   => _x( 'filtered from _MAX_ total entries', 'Please do not translate: _MAX_', 'wpt-custom-mo-file' ),
		'sLengthMenu'     => _x( 'Show _MENU_ entries', 'Please do not translate: _MENU_', 'wpt-custom-mo-file' ),
		'sLoadingRecords' => __( 'Loading...', 'wpt-custom-mo-file' ),
		'sProcessing'     => __( 'Processing...', 'wpt-custom-mo-file' ),
		'sSearch'         => __( 'Search:', 'wpt-custom-mo-file' ),
		'sZeroRecords'    => __( 'No matching records found', 'wpt-custom-mo-file' ),
		'sFirst'          => __( 'First', 'wpt-custom-mo-file' ),
		'sLast'           => __( 'Last', 'wpt-custom-mo-file' ),
		'sNext'           => __( 'Next', 'wpt-custom-mo-file' ),
		'sPrevious'       => __( 'Previous', 'wpt-custom-mo-file' ),
		'sSortAscending'  => __( ': activate to sort column ascending', 'wpt-custom-mo-file' ),
		'sSortDescending' => __( ': activate to sort column descending', 'wpt-custom-mo-file' ),
	);

	if ( 'tools_page_' . WPT_CUSTOMOFILE_SLUG === $screen->base ) {

		wp_enqueue_style( 'wpt-customofile-styles' );
		wp_enqueue_style( 'data-tables-styles' );

		wp_enqueue_script( 'data-tables-scripts' );
		wp_enqueue_script( 'wpt-customofile-scripts' );

		wp_localize_script(
			'wpt-customofile-scripts',
			'wpt_customofile',
			$translation_datatable
		);
	}
}
add_action( 'admin_print_styles', 'wpt_customofile_load_admin_assets' );
