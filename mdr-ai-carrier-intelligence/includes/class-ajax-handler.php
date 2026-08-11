<?php
/**
 * AJAX endpoints.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Ajax_Handler
 */
class Ajax_Handler {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_mdr_aci_upload', array( $this, 'handle_upload' ) );
		add_action( 'wp_ajax_nopriv_mdr_aci_upload', array( $this, 'handle_upload' ) );
	}

	/**
	 * Handle shipment file upload and report generation.
	 */
	public function handle_upload() {
		if ( ! check_ajax_referer( 'mdr_aci_upload', 'nonce', false ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Security check failed. Please refresh the page and try again.', 'mdr-ai-carrier-intelligence' ) ),
				403
			);
		}

		if ( ! $this->check_rate_limit() ) {
			wp_send_json_error(
				array( 'message' => __( 'Too many requests. Please try again later.', 'mdr-ai-carrier-intelligence' ) ),
				429
			);
		}

		if ( empty( $_FILES['shipment_file'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			wp_send_json_error(
				array( 'message' => __( 'No file uploaded.', 'mdr-ai-carrier-intelligence' ) ),
				400
			);
		}

		$file = $_FILES['shipment_file']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		try {
			$upload_handler = new Upload_Handler();
			$stored         = $upload_handler->handle( $file );

			$parser = new Spreadsheet_Parser();
			$rows   = $parser->parse( $stored['path'], $stored['extension'] );

			$generator = new Report_Generator();
			$report    = $generator->generate( $rows );

			$upload_handler->maybe_delete( $stored['path'] );

			$repository = new Report_Repository();
			$token      = $repository->store( $report );

			wp_send_json_success(
				array(
					'token'  => $token,
					'report' => $this->format_report_for_frontend( $report ),
				)
			);
		} catch ( \Exception $e ) {
			wp_send_json_error(
				array( 'message' => $e->getMessage() ),
				400
			);
		}
	}

	/**
	 * Rate limit by IP.
	 *
	 * @return bool
	 */
	private function check_rate_limit() {
		$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
		$key   = 'mdr_aci_rate_' . md5( $ip );
		$count = (int) get_transient( $key );
		$limit = (int) Settings::get_option( 'rate_limit_per_hour', 10 );

		if ( $count >= $limit ) {
			return false;
		}

		set_transient( $key, $count + 1, HOUR_IN_SECONDS );
		return true;
	}

	/**
	 * Sanitize report for JSON response.
	 *
	 * @param array<string, mixed> $report Report data.
	 * @return array<string, mixed>
	 */
	private function format_report_for_frontend( array $report ) {
		return array(
			'meta'                => $report['meta'],
			'executive_summary'   => isset( $report['executive_summary'] ) ? $report['executive_summary'] : '',
			'cost_savings'        => $report['cost_savings'],
			'carrier_performance' => $report['carrier_performance'],
			'routing'             => $report['routing'],
			'lane_analysis'       => $report['lane_analysis'],
			'service_levels'      => $report['service_levels'],
			'consolidation'       => $report['consolidation'],
			'scorecards'          => $report['scorecards'],
			'disclaimer'          => Settings::get_option( 'report_disclaimer' ),
			'signup_url'          => esc_url_raw( Settings::get_option( 'signup_url' ) ),
			'signup_text'         => Settings::get_option( 'signup_button_text' ),
			'demo_text'           => Settings::get_option( 'demo_button_text' ),
		);
	}
}
