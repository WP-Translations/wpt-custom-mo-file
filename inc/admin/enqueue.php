<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Register admin assets
 *
 * @since 1.0.0
 */
add_action( 'admin_print_styles', '__wptcmf_load_admin_assets' );
function __wptcmf_load_admin_assets() {
	$screen = get_current_screen();
	$css_ext        = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	$js_ext         = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

	$translation_datatable = array(
			'sEmptyTable' => __( 'No data available in table', 'wpt-custom-mo-file' ),
			'sInfo' => _x( 'Showing _START_ to _END_ of _TOTAL_ entries', 'Please don\'t translate: _START_ _END_ _TOTAL_', 'wpt-custom-mo-file' ),
			'sInfoEmpty' => __( 'Showing 0 to 0 of 0 entries', 'wpt-custom-mo-file' ),
			'sInfoFiltered' => _x( 'filtered from _MAX_ total entries', 'Please don\'t translate: _MAX_', 'wpt-custom-mo-file' ),
			'sLengthMenu' => _x( 'Show _MENU_ entries', 'Please don\'t translate: _MENU_', 'wpt-custom-mo-file' ),
			'sLoadingRecords' => __( 'Loading...', 'wpt-custom-mo-file' ),
			'sProcessing' => __( 'Processing...', 'wpt-custom-mo-file' ),
			'sSearch' => __( 'Search:', 'wpt-custom-mo-file' ),
			'sZeroRecords' => __( 'No matching records found', 'wpt-custom-mo-file' ),
			'sFirst' => __( 'First', 'wpt-custom-mo-file' ),
			'sLast' => __( 'Last', 'wpt-custom-mo-file' ),
			'sNext' => __( 'Next', 'wpt-custom-mo-file' ),
			'sPrevious' => __( 'Previous', 'wpt-custom-mo-file' ),
			'sSortAscending' => __( ': activate to sort column ascending', 'wpt-custom-mo-file' ),
			'sSortDescending' => __( ': activate to sort column descending', 'wpt-custom-mo-file' ),
	);

	if ( 'tools_page_' . WPTCMF_SLUG === $screen->base ) {
		wp_enqueue_style( 'wptcmf-styles', WPTCMF_URL_CSS . 'wptcmf-styles'. $css_ext, array(), WPTCMF_VERSION );
		wp_enqueue_style( 'data-tables-styles',  WPTCMF_URL_CSS . 'data-table'. $css_ext, array(), '1.10.12' );
		wp_enqueue_script( 'data-tables-scripts',  WPTCMF_URL_JS . 'jquery.dataTables' . $js_ext, array(), '1.10.12' );
		wp_enqueue_script( 'wptcmf-scripts', WPTCMF_URL_JS . 'wptcmf-scripts' . $js_ext, array( 'jquery' ), WPTCMF_VERSION );
		wp_localize_script( 'wptcmf-scripts', 'wptcmf',	$translation_datatable );

	}
}
