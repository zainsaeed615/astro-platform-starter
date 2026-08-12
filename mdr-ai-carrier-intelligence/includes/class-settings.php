<?php
/**
 * Plugin settings helper.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Settings
 */
class Settings {

	const OPTION_KEY = 'mdr_aci_settings';

	/**
	 * Default settings from functional spec.
	 *
	 * @return array<string, mixed>
	 */
	public static function defaults() {
		return array(
			'eyebrow'                 => 'AI-Driven Carrier Intelligence',
			'headline'                => 'Turn Shipment History into Actionable Intelligence',
			'description'             => 'Upload your historical shipment data and receive an AI-powered analysis of your transportation network. Discover cost-saving opportunities, identify stronger carrier options, compare performance, uncover hidden trends, and receive actionable recommendations to optimize your logistics operation.',
			'primary_button_text'     => 'UPLOAD SHIPMENT DATA',
			'primary_button_subtitle'   => '',
			'show_button_subtitle'      => 0,
			'demo_button_text'        => 'Schedule a Personalized Demo',
			'signup_button_text'      => 'Create Free MDR Account',
			'signup_url'              => 'https://mdr.mydrayrate.com/register',
			'logo_url'                => '',
			'button_color'            => '#DA1121',
			'button_hover_color'      => '#911A1E',
			'button_text_color'       => '#FFFFFF',
			'accent_color'            => '#3388FF',
			'background_color'        => '#09090B',
			'text_color'              => '#F8FAFC',
			'muted_text_color'        => '#8892A1',
			'modal_background_color'  => '#111827',
			'modal_overlay_color'     => '#000000',
			'card_background_color'   => '#FFFFFF',
			'card_border_color'       => '#3388FF',
			'progress_color'          => '#3388FF',
			'signup_button_color'     => '#DA1121',
			'demo_button_color'       => '#3388FF',
			'loading_overlay_color'   => '#09090B',
			'calendar_modal_background_color' => '#FFFFFF',
			'cta_color'               => '#DA1121',
			'max_upload_mb'           => 10,
			'allowed_extensions'      => 'csv,xls,xlsx',
			'delete_after_process'    => 1,
			'calendar_embed'          => '<iframe src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ1B94mQMBn-_iSHRanr1EvljFC4dxhLdSZvZjmyRWvImz-KR4L_u5Eo_IX43DUcMkBhuxOdbktS?gv=true" style="border:0;color-scheme:light;background:#ffffff;" width="100%" height="600" frameborder="0"></iframe>',
			'enable_ai_narrative'     => 0,
			'openai_api_key'          => '',
			'openai_model'            => 'gpt-4o-mini',
			'report_disclaimer'       => 'This report is generated from your uploaded shipment data and is intended for informational purposes.',
			'rate_limit_per_hour'     => 10,
		);
	}

	/**
	 * Get merged settings.
	 *
	 * @return array<string, mixed>
	 */
	public static function get() {
		$stored = get_option( self::OPTION_KEY, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		return wp_parse_args( $stored, self::defaults() );
	}

	/**
	 * Get a single setting.
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	public static function get_option( $key, $default = null ) {
		$settings = self::get();
		return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
	}

	/**
	 * Sanitize a hex color with fallback.
	 *
	 * @param string $value    Raw color.
	 * @param string $fallback Fallback hex.
	 * @return string
	 */
	public static function sanitize_color( $value, $fallback ) {
		$color = sanitize_hex_color( $value );
		return $color ? $color : $fallback;
	}

	/**
	 * Build inline CSS custom properties for the full process UI.
	 *
	 * @return string
	 */
	public static function css_vars_style() {
		$s = self::get();

		$vars = array(
			'--mdr-aci-button-bg'       => self::sanitize_color( $s['button_color'], '#DA1121' ),
			'--mdr-aci-button-hover'    => self::sanitize_color( $s['button_hover_color'], '#911A1E' ),
			'--mdr-aci-button-text'     => self::sanitize_color( $s['button_text_color'], '#FFFFFF' ),
			'--mdr-aci-accent'          => self::sanitize_color( $s['accent_color'], '#3388FF' ),
			'--mdr-aci-bg'              => self::sanitize_color( $s['background_color'], '#09090B' ),
			'--mdr-aci-text'            => self::sanitize_color( $s['text_color'], '#F8FAFC' ),
			'--mdr-aci-muted'           => self::sanitize_color( $s['muted_text_color'], '#8892A1' ),
			'--mdr-aci-modal-bg'        => self::sanitize_color( $s['modal_background_color'], '#111827' ),
			'--mdr-aci-modal-overlay'   => self::sanitize_color( $s['modal_overlay_color'], '#000000' ),
			'--mdr-aci-card-bg'         => self::sanitize_color( $s['card_background_color'], '#FFFFFF' ),
			'--mdr-aci-card-border'     => self::sanitize_color( $s['card_border_color'], '#3388FF' ),
			'--mdr-aci-progress'        => self::sanitize_color( $s['progress_color'], '#3388FF' ),
			'--mdr-aci-signup-bg'       => self::sanitize_color( $s['signup_button_color'], '#DA1121' ),
			'--mdr-aci-demo-border'     => self::sanitize_color( $s['demo_button_color'], '#3388FF' ),
			'--mdr-aci-loading-overlay' => self::sanitize_color( $s['loading_overlay_color'], '#09090B' ),
			'--mdr-aci-calendar-modal-bg' => self::sanitize_color( $s['calendar_modal_background_color'], '#FFFFFF' ),
			'--mdr-aci-cta'             => self::sanitize_color( $s['cta_color'], '#DA1121' ),
		);

		$parts = array();
		foreach ( $vars as $key => $value ) {
			$parts[] = $key . ':' . $value;
		}

		return implode( ';', $parts ) . ';';
	}

	/**
	 * Allowed file extensions as array.
	 *
	 * @return string[]
	 */
	public static function allowed_extensions() {
		$raw = self::get_option( 'allowed_extensions', 'csv,xls,xlsx' );
		$ext = array_map( 'trim', explode( ',', strtolower( (string) $raw ) ) );
		return array_values( array_filter( $ext ) );
	}

	/**
	 * Max upload bytes.
	 *
	 * @return int
	 */
	public static function max_upload_bytes() {
		$mb = (int) self::get_option( 'max_upload_mb', 10 );
		return max( 1, $mb ) * 1024 * 1024;
	}

	/**
	 * Calendar embed HTML with light color-scheme for Google Calendar iframe.
	 *
	 * @return string
	 */
	public static function calendar_embed_html() {
		$html = (string) self::get_option( 'calendar_embed', '' );
		if ( '' === trim( $html ) ) {
			return '';
		}

		return preg_replace_callback(
			'/<iframe\b([^>]*)>/i',
			function ( $matches ) {
				$attrs = $matches[1];
				$inject = 'color-scheme:light;background:#ffffff';

				if ( preg_match( '/\sstyle=(["\'])(.*?)\1/i', $attrs, $style_match ) ) {
					$quote  = $style_match[1];
					$style  = rtrim( $style_match[2], '; ' );
					if ( false === stripos( $style, 'color-scheme' ) ) {
						$style .= ';' . $inject;
					}
					if ( false === stripos( $style, 'background' ) ) {
						$style .= ';background:#ffffff';
					}
					$attrs = preg_replace(
						'/\sstyle=(["\']).*?\1/i',
						' style=' . $quote . esc_attr( $style ) . $quote,
						$attrs,
						1
					);
				} else {
					$attrs .= ' style="border:0;' . esc_attr( $inject ) . '"';
				}

				return '<iframe' . $attrs . '>';
			},
			$html
		);
	}
}
