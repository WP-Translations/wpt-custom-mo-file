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

	if ( 'tools_page_wpt-custom-mo-file' === $screen->base ) {
		wp_enqueue_style( 'wptcmf-styles', WPTCMF_URL_CSS . 'wptcmf-styles.css', array(), WPTCMF_VERSION );
	}
}
