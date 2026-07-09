<?php
/**
 * Plugin settings helper.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Settings
 */
class Settings {

	/**
	 * Get all settings.
	 *
	 * @return array<string, mixed>
	 */
	public static function all(): array {
		$defaults = array(
			'admin_email'          => get_option( 'admin_email' ),
			'from_name'            => 'Sacred Spaces by Sharon',
			'from_email'           => get_option( 'admin_email' ),
			'booking_lead_days'    => 1,
			'booking_horizon_days' => 90,
			'booking_page_url'     => '',
		);

		$stored = get_option( 'ssb_settings', array() );
		return array_merge( $defaults, is_array( $stored ) ? $stored : array() );
	}

	/**
	 * Get a single setting.
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	public static function get( string $key, mixed $default = '' ): mixed {
		$all = self::all();
		return $all[ $key ] ?? $default;
	}

	/**
	 * Update settings.
	 *
	 * @param array<string, mixed> $data Settings data.
	 */
	public static function update( array $data ): void {
		$current = self::all();
		update_option( 'ssb_settings', array_merge( $current, $data ) );
	}
}
