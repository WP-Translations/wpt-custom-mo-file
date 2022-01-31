<?php
/**
 * Provide a admin area view for the plugin
 *
 * @author     WP-Translations Team
 * @link       https://wp-translations.pro
 * @since      1.0.0
 *
 * @package    WPT_Custom_Mo_File
 * @subpackage WPT_Custom_Mo_File/inc/admin/ui
 */

defined( 'ABSPATH' ) || die( 'Cheatin&#8217; uh?' );

/**
 * Output plugin page
 *
 * @since 1.0.0
 */
function wpt_customofile_tools_page() {

	$count_domains = count( $GLOBALS['wpt_customofile_text_domains'] ); ?>

	<div class="wpt-customofile-options-page wrap">
		<header class="wpt-header">
		<div>
		<img src="<?php echo WPT_CUSTOMOFILE_IMG_URL . 'wpt-logo.svg'; ?>" />
		<a href="https://www.transifex.com/wp-translations/" class="wpt-transifex-link alignright"><?php esc_html_e( 'Join us on transifex', 'wpt-custom-mo-file' ); ?></a>
		</div>
		<p><strong><?php echo esc_html( WPT_CUSTOMOFILE_NICE_NAME ); ?></strong> - <?php esc_html_e( 'Create, activate, desactivate your own set of rules to get full control of any translations in your WordPress installation.', 'wpt-custom-mo-file' ); ?></p>
		</header>
		<h2 class="screen-reader-text" style="margin:0;">WP-Translations</h2>
		<?php settings_errors(); ?>

		<form action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'wpt_customofile_options' ); ?>
			<?php if ( 0 < $count_domains ) : ?>
			<div class="wpt-box postbox">
				<h2><?php esc_html_e( 'Add new rule', 'wpt-custom-mo-file' ); ?></h2>
				<div class="inside">
				<?php do_settings_sections( 'wpt_customofile_rules' ); ?>
				<?php submit_button( __( 'Add new rule', 'wpt-custom-mo-file' ), 'primary', 'wpt_customofile_options[wpt-customofile-add-rule]' ); ?>
				</div>
			</div>
			<?php else : ?>
			<div class="settings-error notice notice-info is-dismissible">
				<p><strong><?php esc_html_e( 'There is no available textdomain.', 'wpt-custom-mo-file' ); ?></strong></p>
			</div>
			<?php endif; ?>
			<div class="wpt-rules">
			<?php do_settings_sections( 'wpt_customofile_rules_actions' ); ?>
			</div>
		</form>

	</div>

	<?php
}

/**
 * Output rules section text
 *
 * @since 1.0.0
 */
function wpt_customofile_section_rules_text() {
	?>
	<?php
}

/**
 * Output input file field
 *
 * @since 1.0.0
 */
function wpt_customofile_upload_mo_file_field() {
	?>
	<input id="wpt_customofile_upload_mo_file" name="wpt_customofile_mo_file" type="file">
	<?php
}

/**
 * Output textdomain select field
 *
 * @since 1.0.0
 */
function wpt_customofile_select_textdomain_field() {

	$domains = $GLOBALS['wpt_customofile_text_domains'];
	asort( $domains ); ?>

	<select id="wpt_customofile_select_textdomain" name="wpt_customofile_options[text_domain]">
		<?php foreach ( $domains as $domain ) : ?>
		<option value="<?php echo esc_attr( $domain ); ?>"><?php echo esc_attr( $domain ); ?></option>
		<?php endforeach; ?>
	</select>

	<?php
}

/**
 * Output languages select field
 *
 * @since 1.0.0
 */
function wpt_customofile_select_language_field() {

	global $wp_version;
	$locale = ( $wp_version >= 4.7 ) ? get_user_locale() : get_locale();
	$args   = array(
		'id'       => 'wpt_customofile_select_languages',
		'name'     => 'wpt_customofile_options[language]',
		'selected' => $locale,
	);
	wp_dropdown_languages( $args );
}

/**
 * Output rules table
 *
 * @since 1.0.0
 */
function wpt_customofile_rules_table_field() {

	global $l10n, $wp_version;
	$rules  = get_option( 'wpt_customofile_options' );
	$locale = ( $wp_version >= 4.7 ) ? get_user_locale() : get_locale();

	if ( isset( $rules['rules'] ) && ! empty( $rules['rules'] ) ) : ?>

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'wpt-custom-mo-file' ); ?></label>
				<select name="wpt_customofile_options[bulk_action_top]" id="bulk-action-selector-top">
					<option value="-1"><?php esc_html_e( 'Bulk actions', 'wpt-custom-mo-file' ); ?></option>
					<option value="activate"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></option>
					<option value="deactivate"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></option>
					<option value="delete"><?php esc_html_e( 'Delete', 'wpt-custom-mo-file' ); ?></option>
				</select>
				<button name="wpt_customofile_options[action_top]" class="button" type="submit"><?php esc_html_e( 'Apply', 'wpt-custom-mo-file' ); ?></button>
			</div>
		</div>

		<table id="wpt-customofile-rules-table" class="wp-list-table widefat plugins">
			<thead>
				<tr>
					<td id="cb" class="column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1"><?php esc_html_e( 'Select All', 'wpt-custom-mo-file' ); ?></label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Language', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Filename', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ( $rules['rules'] as $lang ) : ?>
					<?php foreach ( $lang as $rule ) : ?>
						<tr class="<?php if ( 1 === $rule['activate'] ) { esc_attr_e( 'active' ); }?>">
							<th scope="row" class="check-column">
								<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $rule['text_domain'] . '-' . $rule['language'] ); ?>"><?php esc_html_e( 'Select&nbsp;', 'wpt-custom-mo-file' ); ?><?php echo esc_html( $rule['text_domain'] ); ?></label>
								<input name="wpt_customofile_options[mo][]" id="cb-select-<?php echo esc_attr( $rule['text_domain'] . '-' . $rule['language'] ); ?>" value="<?php echo esc_attr( $rule['text_domain'] . '|' . $rule['language'] ); ?>" type="checkbox">
							</th>
							<td><?php echo esc_attr( $rule['text_domain'] ); ?></td>
							<td><?php echo esc_attr( $rule['language'] ); ?></td>
							<td><?php echo esc_attr( $rule['filename'] ); ?></td>
							<td>
								<?php if ( 1 === $rule['activate'] ) : ?>
									<button class="button wpt-customofile-button wpt-customofile-button-deactivate" type="submit" name="wpt_customofile_options[deactivate_rule]" value="<?php echo esc_attr( $rule['text_domain'] . '|' . $rule['language'] ); ?>"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></button>
								<?php else : ?>
									<button class="button wpt-customofile-button wpt-customofile-button-activate" type="submit" name="wpt_customofile_options[activate_rule]" value="<?php echo esc_attr( $rule['text_domain'] . '|' . $rule['language'] ); ?>"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></button>
								<?php endif; ?>
								<button class="button wpt-customofile-button wpt-customofile-button-delete" type="submit" name="wpt_customofile_options[delete_rule]" value="<?php echo esc_attr( $rule['text_domain'] . '|' . $rule['language'] ); ?>"><?php esc_html_e( 'Delete rule', 'wpt-custom-mo-file' ); ?></button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>

			<tfoot>
				<tr>
					<td id="cb" class="column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th scope="col"><?php esc_html_e( 'Text domain', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Language', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Filename', 'wpt-custom-mo-file' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Actions', 'wpt-custom-mo-file' ); ?></th>
				</tr>
			</tfoot>
		</table>

		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-bottom" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'wpt-custom-mo-file' ); ?></label>
				<select name="wpt_customofile_options[bulk_action_bottom]" id="bulk-action-selector-bottom">
					<option value="-1"><?php esc_html_e( 'Bulk actions', 'wpt-custom-mo-file' ); ?></option>
					<option value="activate"><?php esc_html_e( 'Activate', 'wpt-custom-mo-file' ); ?></option>
					<option value="deactivate"><?php esc_html_e( 'Deactivate', 'wpt-custom-mo-file' ); ?></option>
					<option value="delete"><?php esc_html_e( 'Delete', 'wpt-custom-mo-file' ); ?></option>
				</select>
				<button name="wpt_customofile_options[action_bottom]" class="button" type="submit"><?php esc_html_e( 'Apply', 'wpt-custom-mo-file' ); ?></button>
			</div>
		</div>

	<?php endif;

}

/**
 * Custom footer text left
 *
 * @param  string $text Get default text.
 * @return return filterd text.
 * @since 1.0.0
 */
function wpt_customofile_filter_admin_footer_text( $text ) {

	$screen = get_current_screen();

	if ( 'tools_page_' . WPT_CUSTOMOFILE_SLUG !== $screen->base ) {
		return $text;
	} else {
		$link_1 = '<a href="https://wp-translations.pro/" target="_blank">WP-Translations</a>';
		$link_2 = '<a target="_blank" href="https://wordpress.org/support/plugin/wpt-custom-mo-file#postform">';
		$link_3 = '</a>';
		$change = str_replace(
			array(
				'[stars]',
				'[wp.org]',
			),
			array(
				'<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/wpt-custom-mo-file#postform" >&#9733;&#9733;&#9733;&#9733;&#9733;</a>',
				'<a target="_blank" href="https://wordpress.org/plugins/wpt-custom-mo-file/" >wordpress.org</a>',
			),
			esc_html_x(
				'Add your [stars] on [wp.org] to spread the love.',
				'Please do not translate [stars] and [wp.org]',
				'wpt-custom-mo-file'
			)
		);

		return sprintf(
			/* translators: 1: Site link, 2: Open link, 3: Close link. */
			esc_html__( 'Visit %1$s Community website | %2$sContact Support%3$s | %4$s', 'wpt-custom-mo-file' ),
			$link_1,
			$link_2,
			$link_3,
			$change
		);
	}
}
add_filter( 'admin_footer_text', 'wpt_customofile_filter_admin_footer_text' );

/**
 * Custom footer text right
 *
 * @param  string $text Get default text.
 * @return return filterd text.
 * @since 1.0.0
 */
function wpt_customofile_filter_update_footer( $text ) {

	$screen = get_current_screen();

	if ( 'tools_page_' . WPT_CUSTOMOFILE_SLUG !== $screen->base ) {
		return $text;
	} else {
		$translate = sprintf( '<a class="wpt-customofile-footer-link" href="https://translate.wordpress.org/projects/wp-plugins/wpt-custom-mo-file" title="%s"><span class="dashicons dashicons-translation"></span></a>', esc_html__( 'Help us with Translations', 'wpt-custom-mo-file' ) );
		$version   = esc_html__( 'Version:&nbsp;', 'wpt-custom-mo-file' ) . WPT_CUSTOMOFILE_VERSION;
		return $translate . $version;
	}
}
add_filter( 'update_footer', 'wpt_customofile_filter_update_footer', 15 );
