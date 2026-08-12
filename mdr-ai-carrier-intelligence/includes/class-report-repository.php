<?php
/**
 * Report transient storage.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Report_Repository
 */
class Report_Repository {

	const TRANSIENT_PREFIX = 'mdr_aci_report_';
	const TTL              = DAY_IN_SECONDS;

	/**
	 * Store report payload.
	 *
	 * @param array<string, mixed> $report Report data.
	 * @return string Token.
	 */
	public function store( array $report ) {
		$token = wp_generate_password( 32, false, false );
		set_transient( self::TRANSIENT_PREFIX . $token, $report, self::TTL );
		return $token;
	}

	/**
	 * Retrieve report by token.
	 *
	 * @param string $token Report token.
	 * @return array<string, mixed>|null
	 */
	public function get( $token ) {
		$token  = sanitize_key( $token );
		$report = get_transient( self::TRANSIENT_PREFIX . $token );
		return is_array( $report ) ? $report : null;
	}
}
