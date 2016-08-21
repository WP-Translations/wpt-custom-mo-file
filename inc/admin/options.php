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
		'__wptcmf_tools_page'
	);
}

/**
 * Register section and settings
 *
 * @since 1.0.0
 */
add_action( 'admin_init', '__wptcmf_initialize_options' );
function __wptcmf_initialize_options() {
	$rules = get_option( 'wptcmf_options' );

	add_settings_section(
		'wptcmf_section_rules',
		'',
		'__wptcmf_section_rules_text',
		'wptcmf_rules'
	);

	add_settings_field(
		'wptcmf_select_textdomain',
		__( 'Select text domain', 'wpt-custom-mo-file' ),
		'__wptcmf_select_textdomain_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);

	add_settings_field(
		'wptcmf_upload_mo_file',
		__( 'Upload your .mo file', 'wpt-custom-mo-file' ),
		'__wptcmf_upload_mo_file_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);
	register_setting( 'wptcmf_options', 'wptcmf_options', '__wptcmf_add_rule_validate' );

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {

		add_settings_section(
			'wptcmf_section_table',
			'',
			'',
			'wptcmf_rules_actions'
		);

		add_settings_field(
			'wptcmf_rules_table',
			__( 'Rules', 'wpt-custom-mo-file' ),
			'__wptcmf_rules_table_field',
			'wptcmf_rules_actions',
			'wptcmf_section_table'
		);

	}

}

/**
 * Save settings
 *
 * @since 1.0.0
 */
function __wptcmf_add_rule_validate( $input ) {
	$options = get_option( 'wptcmf_options' );

	if ( ! function_exists( 'wp_handle_upload' ) ) {
			 require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	if ( isset( $input['wptcmf-add-rule'] ) ) {

		add_filter( 'upload_dir', '__wpcmf_filter_upload_dir' );
		$mo_file = wp_handle_upload( $_FILES['wptcmf_mo_file'], array( 'test_form' => false, 'mimes' => array( 'mo' => 'application/octet-stream' ) ) );
		remove_filter( 'upload_dir', '__wpcmf_filter_upload_dir' );

		if ( $mo_file && empty( $mo_file['error'] ) ) {
			$new_rules = array(
				'filename' => $_FILES['wptcmf_mo_file']['name'],
				'mo_path' => $mo_file['file'],
				'text_domain' => $input['text_domain'],
				'activate' => 1,
			);
			$options['rules'][ $input['text_domain'] ] = $new_rules;
			add_settings_error( 'wptcmf_options', 'wptcmf-file-uploaded', esc_html__( 'Rule saved !', 'wpt-custom-mo-file' ), 'updated' );

		} else {
			add_settings_error( 'wptcmf_options', 'wptcmf-file-missing', $mo_file['error'], 'error' );
		}
	}

	if ( isset( $input['deactivate_rule'] ) ) {
		$options['rules'][ $input['deactivate_rule'] ]['activate'] = 0;
		add_settings_error( 'wptcmf_options', 'wptcmf-deactivate-rule', __( 'Rule successfull deactivated', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $input['activate_rule'] ) ) {
		$options['rules'][ $input['activate_rule'] ]['activate'] = 1;
		add_settings_error( 'wptcmf_options', 'wptcmf-activate-rule', __( 'Rule successfull activated ', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $input['delete_rule'] ) ) {
		unlink( $options['rules'][ $input['delete_rule'] ]['mo_path'] );
		unset( $options['rules'][ $input['delete_rule'] ] );
		add_settings_error( 'wptcmf_options', 'wptcmf-delete-rule', __( 'Rule successfull deleted ', 'wpt-custom-mo-file' ), 'error' );
	}

	return $options;

}
