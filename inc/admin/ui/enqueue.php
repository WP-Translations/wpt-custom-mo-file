<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Load admin assets
 *
 * @since 1.0.0
 */
add_action( 'admin_print_styles', '__wptcmf_load_admin_assets' );
function __wptcmf_load_admin_assets() {
	$current_screen = get_current_screen();

	wp_register_style(
		'wptcmf-admin-styles',
		WPTCMF_URL_ASSETS_CSS . 'admin-styles.css',
		array(),
		WPTCMF_VERSION
	);

	if ( isset( $current_screen ) && 'settings_page_wpt-custom-mo-file' === $current_screen->base ) {
		wp_enqueue_style( 'wptcmf-admin-styles' );
	}

}
