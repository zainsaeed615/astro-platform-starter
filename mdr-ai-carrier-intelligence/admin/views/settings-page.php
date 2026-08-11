<?php
/**
 * Admin settings page view.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
?>
<div class="wrap mdr-aci-admin">
	<h1><?php esc_html_e( 'MDR AI Carrier Intelligence', 'mdr-ai-carrier-intelligence' ); ?></h1>
	<p class="description">
		<?php
		printf(
			/* translators: %s: shortcode */
			esc_html__( 'Add the shortcode %s to any page or Elementor HTML widget to display the AI Carrier Intelligence section.', 'mdr-ai-carrier-intelligence' ),
			'<code>[mdr_ai_carrier_intelligence]</code>'
		);
		?>
	</p>

	<form method="post" action="options.php">
		<?php settings_fields( 'mdr_aci_settings_group' ); ?>

		<h2 class="title"><?php esc_html_e( 'Branding & Copy', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="mdr_aci_eyebrow"><?php esc_html_e( 'Eyebrow / Subheadline', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[eyebrow]" id="mdr_aci_eyebrow" type="text" class="regular-text" value="<?php echo esc_attr( $settings['eyebrow'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_headline"><?php esc_html_e( 'Headline', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[headline]" id="mdr_aci_headline" type="text" class="large-text" value="<?php echo esc_attr( $settings['headline'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_description"><?php esc_html_e( 'Description', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><textarea name="mdr_aci_settings[description]" id="mdr_aci_description" class="large-text" rows="4"><?php echo esc_textarea( $settings['description'] ); ?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_logo_url"><?php esc_html_e( 'Logo URL', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[logo_url]" id="mdr_aci_logo_url" type="url" class="regular-text" value="<?php echo esc_url( $settings['logo_url'] ); ?>" placeholder="https://..." /></td>
			</tr>
		</table>

		<h2 class="title"><?php esc_html_e( 'Process Colors', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Customize colors for the upload button, modal, loading screen, report cards, and CTAs.', 'mdr-ai-carrier-intelligence' ); ?></p>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><?php esc_html_e( 'Upload Button', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Background', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[button_color]" type="color" value="<?php echo esc_attr( $settings['button_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Hover', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[button_hover_color]" type="color" value="<?php echo esc_attr( $settings['button_hover_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Text', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[button_text_color]" type="color" value="<?php echo esc_attr( $settings['button_text_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Section & Text', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Background', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[background_color]" type="color" value="<?php echo esc_attr( $settings['background_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Text', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[text_color]" type="color" value="<?php echo esc_attr( $settings['text_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Muted', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[muted_text_color]" type="color" value="<?php echo esc_attr( $settings['muted_text_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Accent & Progress', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Accent', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[accent_color]" type="color" value="<?php echo esc_attr( $settings['accent_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Progress Bar', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[progress_color]" type="color" value="<?php echo esc_attr( $settings['progress_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Upload Modal', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Background', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[modal_background_color]" type="color" value="<?php echo esc_attr( $settings['modal_background_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Overlay', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[modal_overlay_color]" type="color" value="<?php echo esc_attr( $settings['modal_overlay_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Report Cards', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Tint', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[card_background_color]" type="color" value="<?php echo esc_attr( $settings['card_background_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Border', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[card_border_color]" type="color" value="<?php echo esc_attr( $settings['card_border_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Report CTAs', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Signup Button', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[signup_button_color]" type="color" value="<?php echo esc_attr( $settings['signup_button_color'] ); ?>" /></label>
					&nbsp;
					<label><?php esc_html_e( 'Demo Button', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[demo_button_color]" type="color" value="<?php echo esc_attr( $settings['demo_button_color'] ); ?>" /></label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Loading Screen', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td>
					<label><?php esc_html_e( 'Overlay', 'mdr-ai-carrier-intelligence' ); ?> <input name="mdr_aci_settings[loading_overlay_color]" type="color" value="<?php echo esc_attr( $settings['loading_overlay_color'] ); ?>" /></label>
				</td>
			</tr>
		</table>

		<h2 class="title"><?php esc_html_e( 'Call-to-Action Buttons', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="mdr_aci_primary_button_text"><?php esc_html_e( 'Primary Upload Button', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[primary_button_text]" id="mdr_aci_primary_button_text" type="text" class="large-text" value="<?php echo esc_attr( $settings['primary_button_text'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_primary_button_subtitle"><?php esc_html_e( 'Upload Button Subtitle', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td>
					<input name="mdr_aci_settings[primary_button_subtitle]" id="mdr_aci_primary_button_subtitle" type="text" class="regular-text" value="<?php echo esc_attr( $settings['primary_button_subtitle'] ?? '' ); ?>" />
					<p class="description">
						<label><input name="mdr_aci_settings[show_button_subtitle]" type="checkbox" value="1" <?php checked( 1, (int) ( $settings['show_button_subtitle'] ?? 0 ) ); ?> /> <?php esc_html_e( 'Show subtitle under button text (off = single-line button)', 'mdr-ai-carrier-intelligence' ); ?></label>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_demo_button_text"><?php esc_html_e( 'Demo Button Text', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[demo_button_text]" id="mdr_aci_demo_button_text" type="text" class="regular-text" value="<?php echo esc_attr( $settings['demo_button_text'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_signup_button_text"><?php esc_html_e( 'Signup Button Text', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[signup_button_text]" id="mdr_aci_signup_button_text" type="text" class="regular-text" value="<?php echo esc_attr( $settings['signup_button_text'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_signup_url"><?php esc_html_e( 'Signup URL', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[signup_url]" id="mdr_aci_signup_url" type="url" class="regular-text" value="<?php echo esc_url( $settings['signup_url'] ); ?>" /></td>
			</tr>
		</table>

		<h2 class="title"><?php esc_html_e( 'Upload Settings', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="mdr_aci_max_upload_mb"><?php esc_html_e( 'Max Upload Size (MB)', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[max_upload_mb]" id="mdr_aci_max_upload_mb" type="number" min="1" max="50" value="<?php echo esc_attr( (string) $settings['max_upload_mb'] ); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_allowed_extensions"><?php esc_html_e( 'Allowed Extensions', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[allowed_extensions]" id="mdr_aci_allowed_extensions" type="text" class="regular-text" value="<?php echo esc_attr( $settings['allowed_extensions'] ); ?>" /><p class="description"><?php esc_html_e( 'Comma-separated, e.g. csv,xls,xlsx', 'mdr-ai-carrier-intelligence' ); ?></p></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Delete Files After Processing', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td><label><input name="mdr_aci_settings[delete_after_process]" type="checkbox" value="1" <?php checked( 1, (int) $settings['delete_after_process'] ); ?> /> <?php esc_html_e( 'Remove uploaded files after report generation', 'mdr-ai-carrier-intelligence' ); ?></label></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_rate_limit_per_hour"><?php esc_html_e( 'Rate Limit (per IP / hour)', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[rate_limit_per_hour]" id="mdr_aci_rate_limit_per_hour" type="number" min="1" value="<?php echo esc_attr( (string) $settings['rate_limit_per_hour'] ); ?>" /></td>
			</tr>
		</table>

		<h2 class="title"><?php esc_html_e( 'Google Calendar Demo Modal', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="mdr_aci_calendar_embed"><?php esc_html_e( 'Calendar Embed HTML', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><textarea name="mdr_aci_settings[calendar_embed]" id="mdr_aci_calendar_embed" class="large-text code" rows="6"><?php echo esc_textarea( $settings['calendar_embed'] ); ?></textarea></td>
			</tr>
		</table>

		<h2 class="title"><?php esc_html_e( 'Report Settings', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<table class="form-table" role="presentation">
			<tr>
				<th scope="row"><label for="mdr_aci_report_disclaimer"><?php esc_html_e( 'Report Disclaimer', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><textarea name="mdr_aci_settings[report_disclaimer]" id="mdr_aci_report_disclaimer" class="large-text" rows="3"><?php echo esc_textarea( $settings['report_disclaimer'] ); ?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'AI Narrative (Optional)', 'mdr-ai-carrier-intelligence' ); ?></th>
				<td><label><input name="mdr_aci_settings[enable_ai_narrative]" type="checkbox" value="1" <?php checked( 1, (int) $settings['enable_ai_narrative'] ); ?> /> <?php esc_html_e( 'Enable OpenAI executive summary enrichment', 'mdr-ai-carrier-intelligence' ); ?></label></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_openai_api_key"><?php esc_html_e( 'OpenAI API Key', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[openai_api_key]" id="mdr_aci_openai_api_key" type="password" class="regular-text" value="<?php echo esc_attr( $settings['openai_api_key'] ); ?>" autocomplete="off" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="mdr_aci_openai_model"><?php esc_html_e( 'OpenAI Model', 'mdr-ai-carrier-intelligence' ); ?></label></th>
				<td><input name="mdr_aci_settings[openai_model]" id="mdr_aci_openai_model" type="text" class="regular-text" value="<?php echo esc_attr( $settings['openai_model'] ); ?>" /></td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
