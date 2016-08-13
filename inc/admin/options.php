<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Register options menu page
 *
 * @since 1.0.0
 */
add_action( 'admin_menu', 'wptcmf_admin_menu' );
function wptcmf_admin_menu() {
	add_management_page(
		WPTCMF_NICE_NAME,
		WPTCMF_NICE_NAME,
		'manage_options',
		WPTCMF_SLUG,
		'plugin_options_page'
	);
}

/**
 * Register section and settings
 *
 * @since 1.0.0
 */
add_action( 'admin_init', 'wptcmf_initialize_options' );
function wptcmf_initialize_options() {
	$rules = get_option( 'wptcmf_options' );

	add_settings_section(
		'wptcmf_section_rules',
		'',
		'wptcmf_section_rules_text',
		'wptcmf_rules'
	);

	add_settings_field(
		'wptcmf-upload-mo-file',
		__( 'Upload your .mo file', 'wpt-custom-mo-file' ),
		'wptcmf_upload_mo_file_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);

	add_settings_field(
		'wptcmf-select-textdomain',
		__( 'Select text domain', 'wpt-custom-mo-file' ),
		'wptcmf_select_textdomain_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);

	add_settings_section(
		'wptcmf_section_table',
		'',
		'',
		'wptcmf_table'
	);

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {
		add_settings_field(
			'wptcmf-rules-table',
			__( 'Rules', 'wpt-custom-mo-file' ),
			'wptcmf_rules_table_field',
			'wptcmf_table',
			'wptcmf_section_table'
		);
	}

	register_setting( 'wptcmf_options', 'wptcmf_options', 'wptcmf_options_validate' );
}

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
 * Save settings
 *
 * @since 1.0.0
 */
function wptcmf_options_validate( $input ) {
	$options = get_option( 'wptcmf_options' );

	if ( ! function_exists( 'wp_handle_upload' ) ) {
			 require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	if ( isset( $_POST['wptcmf-add-rule'] ) ) {
		add_filter( 'upload_dir', '__wpcmf_filter_upload_dir' );
		$mo_file = wp_handle_upload( $_FILES['wptcmf_mo_file'], array( 'test_form' => false, 'mimes' => array( 'mo' => 'application/octet-stream' ) ) );
		remove_filter( 'upload_dir', '__wpcmf_filter_upload_dir' );

		if ( $mo_file && empty( $mo_file['error'] ) ) {
			$new_rules = array(
				'mo_path' => $mo_file['file'],
				'text_domain' => $_POST['wptcmf_text_domain'],
				'activate' => 1,
			);
			$options['rules'][ $_POST['wptcmf_text_domain'] ] = $new_rules;

			add_settings_error( 'wptcmf_options', 'wptcmf-file-uploaded', esc_html__( 'Rule saved !', 'wpt-custom-mo-file' ), 'updated' );
			return $options;

		} else {
			add_settings_error( 'wptcmf_options', 'wptcmf-file-missing', $mo_file['error'], 'error' );
		}
	}

	if ( isset( $_POST['wptcmf-deactivate-rule'] ) ) {
		$options['rules'][ $_POST['wptcmf-deactivate-rule'] ]['activate'] = 0;
		add_settings_error( 'wptcmf_options', 'wptcmf-deactivate-rule', __( 'Rule successfull deactivated ', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $_POST['wptcmf-activate-rule'] ) ) {
		$options['rules'][ $_POST['wptcmf-activate-rule'] ]['activate'] = 1;
		add_settings_error( 'wptcmf_options', 'wptcmf-activate-rule', __( 'Rule successfull activated ', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $_POST['wptcmf-delete-rule'] ) ) {
		unlink( $options['rules'][ $_POST['wptcmf-delete-rule'] ]['mo_path'] );
		unset( $options['rules'][ $_POST['wptcmf-delete-rule'] ] );
		add_settings_error( 'wptcmf_options', 'wptcmf-delete-rule', __( 'Rule successfull deleted ', 'wpt-custom-mo-file' ), 'error' );
	}

	return $options;

}
