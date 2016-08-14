<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Output plugin page
 *
 * @since 1.0.0
 */
function plugin_options_page() {
	?>
	<div class="wrap">
		<h2><?php esc_html_e( WPTCMF_NICE_NAME ); ?></h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'wptcmf_options' ); ?>
			<?php do_settings_sections( 'wptcmf_rules' ); ?>
			<?php submit_button( __( 'Add new rule', 'wpt-custom-mo-file' ), 'primary', 'wptcmf-add-rule' ); ?>
			<?php do_settings_sections( 'wptcmf_table' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Output rules section text
 *
 * @since 1.0.0
 */
function wptcmf_section_rules_text() {
	?>
	<p><?php esc_html_e( 'Create your own rules to override translation', 'wpt-custom-mo-file' ); ?></p>
	<?php
}

/**
 * Output input file field
 *
 * @since 1.0.0
 */
function wptcmf_upload_mo_file_field() {
	?>
	<input id="wptcmf-upload-mo-file" name="wptcmf_mo_file" type="file">
	<?php
}

/**
 * Output textdomain select field
 *
 * @since 1.0.0
 */
function wptcmf_select_textdomain_field() {
	global $l10n;
	$rules = get_option( 'wptcmf_options' );
	$domains = array_keys( (array) $l10n );
	$domains_blacklist = array(
		'default',
	);

	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) {
		$rules_exist = array_keys( $rules['rules'] );

		if ( ! empty( $rules_exist ) ) {
			$domains_blacklist = array_unique( array_merge( $domains_blacklist, $rules_exist ) );
		}
	}
	$domains = array_diff( $domains, $domains_blacklist ); ?>

	<select id="wptcmf-select-textdomain" name="wptcmf_text_domain">
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
function wptcmf_rules_table_field() {
	$rules = get_option( 'wptcmf_options' );
	if ( isset ( $rules['rules'] ) && ! empty( $rules['rules'] ) ) : ?>

		<table class="wptcmf-rules-table">
			<thead>
				<tr>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'File path', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $rules['rules'] as $rule ) : ?>
					<tr>
						<td><?php esc_attr_e( $rule['text_domain'] ); ?></td>
						<td><?php esc_attr_e( $rule['mo_path'] ); ?></td>
						<td>
							<?php if ( 1 === $rule['activate'] ) : ?>
								<button class="button" type="submit" name="wptcmf-deactivate-rule" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></button>
							<?php else : ?>
								<button class="button" type="submit" name="wptcmf-activate-rule" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></button>
							<?php endif; ?>
							<button class="button" type="submit" name="wptcmf-delete-rule" value="<?php esc_attr_e( $rule['text_domain'] ); ?>"><?php esc_html_e( 'Delete rule', 'wpt-custom-mo-file' ); ?></button>
						</td>
						<td></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	<?php endif;
}
