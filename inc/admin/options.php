<?php
/**
 * The admin-specific functionality of the plugin.
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
 * Register options menu page.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wpt_customofile_admin_menu() {
	add_management_page(
		WPT_CUSTOMOFILE_PLUGIN_NAME,
		WPT_CUSTOMOFILE_PLUGIN_NAME,
		'manage_options',
		WPT_CUSTOMOFILE_SLUG,
		'wpt_customofile_tools_page'
	);
}
add_action( 'admin_menu', 'wpt_customofile_admin_menu' );


/**
 * Register section and settings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wpt_customofile_initialize_options() {
	$rules = get_option( 'wpt_customofile_options' );

	add_settings_section(
		'wpt_customofile_section_rules',
		'',
		'wpt_customofile_section_rules_text',
		'wpt_customofile_rules'
	);

	add_settings_field(
		'wpt_customofile_select_textdomain',
		__( 'Text domain', 'wpt-custom-mo-file' ),
		'wpt_customofile_select_textdomain_field',
		'wpt_customofile_rules',
		'wpt_customofile_section_rules'
	);

	add_settings_field(
		'wpt_customofile_select_languages',
		__( 'Language', 'wpt-custom-mo-file' ),
		'wpt_customofile_select_language_field',
		'wpt_customofile_rules',
		'wpt_customofile_section_rules'
	);

	add_settings_field(
		'wpt_customofile_upload_mo_file',
		__( 'Custom language file', 'wpt-custom-mo-file' ),
		'wpt_customofile_upload_mo_file_field',
		'wpt_customofile_rules',
		'wpt_customofile_section_rules'
	);

	register_setting(
		'wpt_customofile_options',
		'wpt_customofile_options',
		array(
			'sanitize_callback' => 'wpt_customofile_add_rule_validate',
		)
	);

	if ( isset( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {

		add_settings_section(
			'wpt_customofile_section_table',
			'',
			'wpt_customofile_section_rules_text',
			'wpt_customofile_rules_actions'
		);

		add_settings_field(
			'wpt_customofile_rules_table',
			__( 'Rules', 'wpt-custom-mo-file' ),
			'wpt_customofile_rules_table_field',
			'wpt_customofile_rules_actions',
			'wpt_customofile_section_table'
		);

	}

}
add_action( 'admin_init', 'wpt_customofile_initialize_options' );


/**
 * Validate and save settings.
 *
 * @since 1.0.0
 *
 * @param array<mixed> $input   Get all settings admin page.
 *
 * @return array<mixed>   Return validated values.
 */
function wpt_customofile_add_rule_validate( $input ) {
	$options = get_option( 'wpt_customofile_options' );

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	if ( isset( $input['wpt-customofile-add-rule'] ) && isset( $_FILES['wpt_customofile_mo_file']['name'] ) ) {

		add_filter( 'upload_dir', 'wpt_customofile_filter_upload_dir' );
		$mo_file = wp_handle_upload(
			$_FILES['wpt_customofile_mo_file'], // phpcs:ignore
			array(
				'test_form' => false,
				'mimes'     => array( 'mo' => 'application/octet-stream' ),
			)
		);
		remove_filter( 'upload_dir', 'wpt_customofile_filter_upload_dir' );

		$input['language'] = ( empty( $input['language'] ) ) ? 'en_US' : $input['language'];

		if ( $mo_file && empty( $mo_file['error'] ) ) {
			$new_rules = array(
				'filename'    => $_FILES['wpt_customofile_mo_file']['name'], // phpcs:ignore
				'mo_path'     => $mo_file['file'],
				'text_domain' => $input['text_domain'],
				'activate'    => 1,
				'language'    => $input['language'],
			);
			$options['rules'][ $input['language'] ][ $input['text_domain'] ] = $new_rules;
			add_settings_error( 'wpt_customofile_options', 'wpt-customofile-file-uploaded', esc_html__( 'Rule saved!', 'wpt-custom-mo-file' ), 'updated' );

		} else {
			add_settings_error( 'wpt_customofile_options', 'wpt-customofile-file-missing', $mo_file['error'], 'error' );
		}
	}

	if ( isset( $input['deactivate_rule'] ) ) {
		$data = wpt_customofile_extract_textdomain_locale( $input['deactivate_rule'] );
		$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 0;
		add_settings_error( 'wpt_customofile_options', 'wpt-customofile-deactivate-rule', __( 'Rule successfull deactivated', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $input['activate_rule'] ) ) {
		$data = wpt_customofile_extract_textdomain_locale( $input['activate_rule'] );
		$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 1;
		add_settings_error( 'wpt_customofile_options', 'wpt-customofile-activate-rule', __( 'Rule successfull activated', 'wpt-custom-mo-file' ), 'updated' );
	}

	if ( isset( $input['delete_rule'] ) ) {
		$data = wpt_customofile_extract_textdomain_locale( $input['delete_rule'] );
		unlink( $options['rules'][ $data['locale'] ][ $data['text_domain'] ]['mo_path'] );
		unset( $options['rules'][ $data['locale'] ][ $data['text_domain'] ] );
		add_settings_error( 'wpt_customofile_options', 'wpt-customofile-delete-rule', __( 'Rule successfull deleted', 'wpt-custom-mo-file' ), 'error' );
	}

	if ( isset( $input['action_top'] ) || isset( $input['action_bottom'] ) ) {

		if ( '-1' !== $input['bulk_action_top'] || '-1' !== $input['bulk_action_bottom'] ) {

			if ( ! empty( $input['mo'] ) ) {

				$action     = ( isset( $input['action_top'] ) ) ? $input['bulk_action_top'] : $input['bulk_action_bottom'];
				$count_task = count( $input['mo'] );
				$message    = '';
				$type       = '';

				switch ( $action ) {
					case 'activate':
						foreach ( $input['mo'] as $mo ) {
							$data = wpt_customofile_extract_textdomain_locale( $mo );
							$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 1;
						}
						$message = sprintf(
							esc_html(
								/* translators: %d: Rules count. */
								_n(
									'%d rule successfully activated.',
									'%d rules successfully activated.',
									$count_task,
									'wpt-custom-mo-file'
								)
							),
							$count_task
						);

						$type = 'updated';
						break;

					case 'deactivate':
						foreach ( $input['mo'] as $mo ) {
							$data = wpt_customofile_extract_textdomain_locale( $mo );
							$options['rules'][ $data['locale'] ][ $data['text_domain'] ]['activate'] = 0;
						}
						$message = sprintf(
							esc_html(
								/* translators: %d: Rules count. */
								_n(
									'%d rule successfully deactivated.',
									'%d rules successfully deactivated.',
									$count_task,
									'wpt-custom-mo-file'
								)
							),
							$count_task
						);

						$type = 'error';
						break;

					case 'delete':
						foreach ( $input['mo'] as $mo ) {
							$data = wpt_customofile_extract_textdomain_locale( $mo );
							unlink( $options['rules'][ $data['locale'] ][ $data['text_domain'] ]['mo_path'] );
							unset( $options['rules'][ $data['locale'] ][ $data['text_domain'] ] );
						}
						$message = sprintf(
							esc_html(
								/* translators: %d: Rules count. */
								_n(
									'%d rule successfully deleted.',
									'%d rules successfully deleted.',
									$count_task,
									'wpt-custom-mo-file'
								)
							),
							$count_task
						);

						$type = 'error';
						break;
				}
				add_settings_error( 'wpt_customofile_options', 'wpt-customofile-bulk-notice', $message, $type );

			} else {
				add_settings_error( 'wpt_customofile_options', 'wpt-customofile-empty-bulk', __( 'Please select a rule before running bulk action', 'wpt-custom-mo-file' ), 'error' );
			}
		} else {
			add_settings_error( 'wpt_customofile_options', 'wpt-customofile-empty-bulk', __( 'Please select a action before', 'wpt-custom-mo-file' ), 'error' );
		}
	}

	return $options;

}
