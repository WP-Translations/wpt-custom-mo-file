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
		__( 'Select a text domain', WPTCMF_SLUG ),
		'__wptcmf_select_textdomain_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);

	add_settings_field(
		'wptcmf_select_languages',
		__( 'Select a language', WPTCMF_SLUG ),
		'__wptcmf_select_language_field',
		'wptcmf_rules',
		'wptcmf_section_rules'
	);

	add_settings_field(
		'wptcmf_upload_mo_file',
		__( 'Upload a custom .mo file', WPTCMF_SLUG ),
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
			__( 'Rules', WPTCMF_SLUG ),
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

		$input['language'] = ( empty( $input['language'] ) ) ? 'en_US' : $input['language'];

		if ( $mo_file && empty( $mo_file['error'] ) ) {
			$new_rules = array(
				'filename' => $_FILES['wptcmf_mo_file']['name'],
				'mo_path' => $mo_file['file'],
				'text_domain' => $input['text_domain'],
				'activate' => 1,
				'language' => $input['language'],
			);
			$options['rules'][ $input['language'] ][ $input['text_domain'] ] = $new_rules;
			add_settings_error( 'wptcmf_options', 'wptcmf-file-uploaded', esc_html__( 'Rule saved !', WPTCMF_SLUG ), 'updated' );

		} else {
			add_settings_error( 'wptcmf_options', 'wptcmf-file-missing', $mo_file['error'], 'error' );
		}
	}

	if ( isset( $input['deactivate_rule'] ) ) {
		$data = wptcmf_extract_textdomain_locale( $input['deactivate_rule'] );
		$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 0;
		add_settings_error( 'wptcmf_options', 'wptcmf-deactivate-rule', __( 'Rule successfull deactivated', WPTCMF_SLUG ), 'updated' );
	}

	if ( isset( $input['activate_rule'] ) ) {
		$data = wptcmf_extract_textdomain_locale( $input['activate_rule'] );
		$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 1;
		add_settings_error( 'wptcmf_options', 'wptcmf-activate-rule', __( 'Rule successfull activated ', WPTCMF_SLUG ), 'updated' );
	}

	if ( isset( $input['delete_rule'] ) ) {
		$data = wptcmf_extract_textdomain_locale( $input['delete_rule'] );
		unlink( $options['rules'][ $data['locale'] ][ $data['text_domain'] ]['mo_path'] );
		unset( $options['rules'][ $data['locale'] ][ $data['text_domain'] ] );
		add_settings_error( 'wptcmf_options', 'wptcmf-delete-rule', __( 'Rule successfull deleted ', WPTCMF_SLUG ), 'error' );
	}

	if ( isset( $input['action_top'] ) || isset( $input['action_bottom'] ) ) {

		if ( '-1' !== $input['bulk_action_top'] || '-1' !== $input['bulk_action_bottom'] ) {

			if ( ! empty( $input['mo'] ) ) {

				$action = ( isset( $input['action_top'] ) ) ? $input['bulk_action_top'] : $input['bulk_action_bottom'];
				$count_task = count( $input['mo'] );

				switch ( $action ) {
					case 'activate':
						foreach ( $input['mo'] as $key => $mo ) {
							$data = wptcmf_extract_textdomain_locale( $mo );
							$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 1;
						}
						$message = sprintf( esc_html( _n( '%d rule successfully activated.', '%d rules successfully activated.', $count_task, WPTCMF_SLUG ) ), $count_task );
						$type = 'updated';
						break;

					case 'deactivate':
						foreach ( $input['mo'] as $key => $mo ) {
							$data = wptcmf_extract_textdomain_locale( $mo );
							$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 0;
						}
						$message = sprintf( esc_html( _n( '%d rule successfully deactivated.', '%d rules successfully deactivated.', $count_task, WPTCMF_SLUG ) ), $count_task );
						$type = 'error';
						break;

					case 'delete':
						foreach ( $input['mo'] as $key => $mo ) {
							$data = wptcmf_extract_textdomain_locale( $mo );
							unlink( $options['rules'][ $data['locale'] ][ $data['text_domain'] ]['mo_path'] );
							unset( $options['rules'][ $data['locale'] ][ $data['text_domain'] ] );
						}
						$message = sprintf( esc_html( _n( '%d rule successfully deleted.', '%d rules successfully deleted.', $count_task, WPTCMF_SLUG ) ), $count_task );
						$type = 'error';
						break;
				}
				add_settings_error( 'wptcmf_options', 'wptcmf-bulk-notice', $message, $type );

			} else {
				add_settings_error( 'wptcmf_options', 'wptcmf-empty-bulk', __( 'Please select a rule before running bulk action', WPTCMF_SLUG ), 'error' );
			}
		} else {
			add_settings_error( 'wptcmf_options', 'wptcmf-empty-bulk', __( 'Please select a action before', WPTCMF_SLUG ), 'error' );
		}
	}

	return $options;

}
