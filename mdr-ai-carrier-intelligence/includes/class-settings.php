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
			'eyebrow'              => 'AI-Driven Carrier Intelligence',
			'headline'             => 'Turn Shipment History into Actionable Intelligence',
			'description'          => 'Upload your historical shipment data and receive an AI-powered analysis of your transportation network. Discover cost-saving opportunities, identify stronger carrier options, compare performance, uncover hidden trends, and receive actionable recommendations to optimize your logistics operation.',
			'primary_button_text'    => 'UPLOAD SHIPMENT DATA',
			'primary_button_subtitle' => 'Get Your Free AI Report',
			'demo_button_text'     => 'Schedule a Personalized Demo',
			'signup_button_text'   => 'Create Free MDR Account',
			'signup_url'           => 'https://mdr.mydrayrate.com/register',
			'logo_url'             => '',
			'accent_color'         => '#3388FF',
			'cta_color'            => '#DA1121',
			'background_color'     => '#09090B',
			'max_upload_mb'        => 10,
			'allowed_extensions'   => 'csv,xls,xlsx',
			'delete_after_process' => 1,
			'calendar_embed'       => '<iframe src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ1B94mQMBn-_iSHRanr1EvljFC4dxhLdSZvZjmyRWvImz-KR4L_u5Eo_IX43DUcMkBhuxOdbktS?gv=true" style="border:0;" width="100%" height="600" frameborder="0"></iframe>',
			'enable_ai_narrative'  => 0,
			'openai_api_key'       => '',
			'openai_model'         => 'gpt-4o-mini',
			'report_disclaimer'    => 'This report is generated from your uploaded shipment data and is intended for informational purposes.',
			'rate_limit_per_hour'  => 10,
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
}
