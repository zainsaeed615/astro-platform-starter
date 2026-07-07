<?php
/**
 * Public-facing functionality.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Frontend;

use SacredSpaces\Booking\Repositories\ServiceRepository;
use SacredSpaces\Booking\Services\StripeService;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PublicFacing
 */
class PublicFacing {

	/**
	 * Set when a booking shortcode/block is rendered on the page.
	 */
	private static bool $booking_rendered = false;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_assets' ), 20 );
		add_action( 'wp_footer', array( $this, 'print_booking_config_fallback' ), 1 );

		add_shortcode( 'sacred_booking', array( $this, 'render_booking' ) );
		add_shortcode( 'sacred_calendar', array( $this, 'render_calendar' ) );
		add_shortcode( 'sacred_services', array( $this, 'render_services' ) );
	}

	/**
	 * Register styles and scripts (always, so late enqueue works).
	 */
	public function register_assets(): void {
		wp_register_style(
			'ssb-google-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Lato:wght@300;400;500&display=swap',
			array(),
			null
		);

		wp_register_style(
			'ssb-public',
			SSB_PLUGIN_URL . 'public/assets/css/public.css',
			array( 'ssb-google-fonts' ),
			SSB_VERSION
		);

		wp_register_script(
			'ssb-booking',
			SSB_PLUGIN_URL . 'public/assets/js/booking.js',
			array(),
			SSB_VERSION,
			true
		);
	}

	/**
	 * Enqueue on wp_enqueue_scripts when shortcode is detectable early.
	 */
	public function maybe_enqueue_assets(): void {
		if ( $this->should_load_assets() ) {
			$this->enqueue_booking_assets();
		}
	}

	/**
	 * Enqueue and localize all frontend booking assets.
	 */
	private function enqueue_booking_assets(): void {
		$this->register_assets();

		wp_enqueue_style( 'ssb-google-fonts' );
		wp_enqueue_style( 'ssb-public' );
		wp_enqueue_script( 'ssb-booking' );

		wp_localize_script(
			'ssb-booking',
			'ssbBooking',
			$this->get_script_data()
		);
	}

	/**
	 * Data passed to booking.js.
	 *
	 * @return array<string, mixed>
	 */
	private function get_script_data(): array {
		return array(
			'restUrl'       => esc_url_raw( rest_url( 'sacred-spaces-booking/v1' ) ),
			'nonce'         => wp_create_nonce( 'wp_rest' ),
			'stripeKey'     => StripeService::get_publishable_key(),
			'paymentReturn' => $this->get_payment_return_state(),
			'i18n'          => $this->get_i18n_strings(),
			'steps'         => $this->get_step_labels(),
			'services'      => $this->format_services_for_js(),
		);
	}

	/**
	 * Format services for JavaScript.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private function format_services_for_js(): array {
		$services = ( new ServiceRepository() )->get_active();

		return array_map(
			static function ( $s ) {
				return array(
					'id'                 => (int) $s->id,
					'name'               => $s->name,
					'slug'               => $s->slug,
					'description'        => $s->description,
					'investment_display' => $s->investment_display,
					'investment_min'     => $s->investment_min ? (float) $s->investment_min : null,
					'investment_max'     => $s->investment_max ? (float) $s->investment_max : null,
					'duration_minutes'   => (int) $s->duration_minutes,
					'payment_mode'       => $s->payment_mode,
					'payment_amount'     => $s->payment_amount ? (float) $s->payment_amount : null,
					'locations'          => explode( ',', $s->locations ),
				);
			},
			$services
		);
	}

	/**
	 * Fallback: ensure ssbBooking exists if script was enqueued late.
	 */
	public function print_booking_config_fallback(): void {
		if ( ! self::$booking_rendered ) {
			return;
		}

		if ( wp_script_is( 'ssb-booking', 'done' ) || wp_script_is( 'ssb-booking', 'enqueued' ) ) {
			return;
		}

		// Script was not enqueued — force it in the footer.
		$this->enqueue_booking_assets();
	}

	/**
	 * Check if assets should load on current page (early detection).
	 */
	private function should_load_assets(): bool {
		global $post;
		if ( ! is_singular() || ! $post ) {
			return false;
		}

		$content = $post->post_content ?? '';

		if ( has_shortcode( $content, 'sacred_booking' )
			|| has_shortcode( $content, 'sacred_calendar' )
			|| has_shortcode( $content, 'sacred_services' )
			|| has_block( 'sacred-spaces/booking', $content ) ) {
			return true;
		}

		// Elementor and other builders store content in post meta.
		$elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
		if ( is_string( $elementor_data ) && $elementor_data !== '' ) {
			if ( false !== strpos( $elementor_data, 'sacred_booking' )
				|| false !== strpos( $elementor_data, 'sacred_spaces_booking' )
				|| false !== strpos( $elementor_data, 'sacred-spaces/booking' ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Payment return state from URL.
	 *
	 * @return array<string, string>|null
	 */
	private function get_payment_return_state(): ?array {
		if ( isset( $_GET['ssb_payment'], $_GET['ref'] ) ) {
			return array(
				'status' => sanitize_text_field( wp_unslash( $_GET['ssb_payment'] ) ),
				'ref'    => sanitize_text_field( wp_unslash( $_GET['ref'] ) ),
			);
		}
		return null;
	}

	/**
	 * I18n strings for JS.
	 *
	 * @return array<string, string>
	 */
	private function get_i18n_strings(): array {
		return array(
			'chooseService'  => __( 'Choose Service', 'sacred-spaces-booking' ),
			'location'       => __( 'Location', 'sacred-spaces-booking' ),
			'calendar'       => __( 'Calendar', 'sacred-spaces-booking' ),
			'time'           => __( 'Time', 'sacred-spaces-booking' ),
			'clientDetails'  => __( 'Client Details', 'sacred-spaces-booking' ),
			'questionnaire'  => __( 'Questionnaire', 'sacred-spaces-booking' ),
			'review'         => __( 'Review', 'sacred-spaces-booking' ),
			'confirmation'   => __( 'Confirmation', 'sacred-spaces-booking' ),
			'next'           => __( 'Continue', 'sacred-spaces-booking' ),
			'back'           => __( 'Back', 'sacred-spaces-booking' ),
			'submit'         => __( 'Submit Request', 'sacred-spaces-booking' ),
			'payNow'         => __( 'Complete Payment', 'sacred-spaces-booking' ),
			'virtual'        => __( 'Virtual', 'sacred-spaces-booking' ),
			'inHome'         => __( 'In Home', 'sacred-spaces-booking' ),
			'investment'     => __( 'Investment', 'sacred-spaces-booking' ),
			'duration'       => __( 'Duration', 'sacred-spaces-booking' ),
			'minutes'        => __( 'Minutes', 'sacred-spaces-booking' ),
			'selectDate'     => __( 'Select an available date', 'sacred-spaces-booking' ),
			'selectTime'     => __( 'Select your preferred time', 'sacred-spaces-booking' ),
			'noSlots'        => __( 'No available times for this date.', 'sacred-spaces-booking' ),
			'loading'        => __( 'Loading...', 'sacred-spaces-booking' ),
			'error'          => __( 'Something went wrong. Please try again.', 'sacred-spaces-booking' ),
			'required'       => __( 'This field is required.', 'sacred-spaces-booking' ),
			'ackRequired'    => __( 'Please acknowledge the intentional design experience.', 'sacred-spaces-booking' ),
			'thankYou'       => __( 'Thank You', 'sacred-spaces-booking' ),
			'received'       => __( 'Your request has been received.', 'sacred-spaces-booking' ),
			'contactShortly' => __( "We'll contact you shortly.", 'sacred-spaces-booking' ),
			'bookingSummary' => __( 'Booking Summary', 'sacred-spaces-booking' ),
			'heroTitle'      => __( 'Begin Your Sanctuary Session', 'sacred-spaces-booking' ),
			'heroSubtitle'   => __( 'Your transformation begins with a single intentional step. Choose the experience that best supports your home and your next chapter.', 'sacred-spaces-booking' ),
		);
	}

	/**
	 * Step labels for progress bar.
	 *
	 * @return array<int, string>
	 */
	private function get_step_labels(): array {
		return array(
			__( 'Service', 'sacred-spaces-booking' ),
			__( 'Location', 'sacred-spaces-booking' ),
			__( 'Calendar', 'sacred-spaces-booking' ),
			__( 'Time', 'sacred-spaces-booking' ),
			__( 'Details', 'sacred-spaces-booking' ),
			__( 'Questionnaire', 'sacred-spaces-booking' ),
			__( 'Review', 'sacred-spaces-booking' ),
			__( 'Confirm', 'sacred-spaces-booking' ),
		);
	}

	/**
	 * Render booking wizard shortcode.
	 *
	 * @param array<string, string> $atts Attributes.
	 */
	public function render_booking( array $atts = array() ): string {
		self::$booking_rendered = true;
		$this->enqueue_booking_assets();

		$services = ( new ServiceRepository() )->get_active();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/booking-wizard.php';
		return (string) ob_get_clean();
	}

	/**
	 * Render calendar shortcode.
	 */
	public function render_calendar( array $atts = array() ): string {
		self::$booking_rendered = true;
		$this->enqueue_booking_assets();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/calendar.php';
		return (string) ob_get_clean();
	}

	/**
	 * Render services shortcode.
	 */
	public function render_services( array $atts = array() ): string {
		$this->register_assets();
		wp_enqueue_style( 'ssb-google-fonts' );
		wp_enqueue_style( 'ssb-public' );

		$services = ( new ServiceRepository() )->get_active();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/services.php';
		return (string) ob_get_clean();
	}
}
