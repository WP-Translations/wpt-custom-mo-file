<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Output plugin page
 *
 * @since 1.0.0
 */
function __wptcmf_tools_page() {
	$count_domains = count( wptcmf_get_domains() ); ?>

	<div class="wrap">
		<h2><?php esc_html_e( WPTCMF_NICE_NAME ); ?></h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'wptcmf_options' ); ?>
			<?php if ( 0 < $count_domains ) : ?>
				<?php do_settings_sections( 'wptcmf_rules' ); ?>
				<?php submit_button( __( 'Add new rule', 'wpt-custom-mo-file' ), 'primary', 'wptcmf_options[wptcmf-add-rule]' ); ?>
			<?php else : ?>
				<div class="settings-error notice notice-info is-dismissible"><p><strong><?php  esc_html_e( 'There is no textdomain or all available domains are already overwritten. ', 'wpt-custom-mo-file' ); ?></strong></p></div>
			<?php endif; ?>
			<?php do_settings_sections( 'wptcmf_rules_actions' ); ?>
		</form>
	</div>

	<?php
}

/**
 * Output rules section text
 *
 * @since 1.0.0
 */
function __wptcmf_section_rules_text() {
	?>
	<p><?php esc_html_e( 'Create your own rules to override translation', 'wpt-custom-mo-file' ); ?></p>
	<?php
}

/**
 * Output input file field
 *
 * @since 1.0.0
 */
function __wptcmf_upload_mo_file_field() {
	?>
	<input id="wptcmf_upload_mo_file" name="wptcmf_mo_file" type="file">
	<?php
}

/**
 * Output textdomain select field
 *
 * @since 1.0.0
 */
function __wptcmf_select_textdomain_field() {
	$domains = wptcmf_get_domains(); ?>

	<select id="wptcmf_select_textdomain" name="wptcmf_options[text_domain]">
		<?php foreach ( $domains as $domain ) : ?>
			<option value="<?php esc_attr_e( $domain ); ?>"><?php echo esc_attr_e( $domain ); ?></option>
		<?php endforeach; ?>
	</select>

	<?php
}

/**
 * Output rules table
 *
 * @since 1.0.0
 */
function __wptcmf_rules_table_field() {
	global $l10n;
	$rules = get_option( 'wptcmf_options' );
	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) : ?>

		<table class="wptcmf-rules-table">
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Filename', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $rules['rules'] as $rule ) : ?>
					<tr>
						<td><?php esc_attr_e( $rule['text_domain'] ); ?></td>
						<td><?php esc_attr_e( $rule['filename'] ); ?></td>
						<td>
							<?php if ( 1 === $rule['activate'] ) : ?>
								<button class="button" type="submit" name="wptcmf_options[deactivate_rule]" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></button>
							<?php else : ?>
								<button class="button" type="submit" name="wptcmf_options[activate_rule]" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></button>
							<?php endif; ?>
							<button class="button" type="submit" name="wptcmf_options[delete_rule]" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Delete rule', 'wpt-custom-mo-file' ); ?></button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	<?php endif;
}
