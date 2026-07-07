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

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_shortcode( 'sacred_booking', array( $this, 'render_booking' ) );
		add_shortcode( 'sacred_calendar', array( $this, 'render_calendar' ) );
		add_shortcode( 'sacred_services', array( $this, 'render_services' ) );
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function enqueue_assets(): void {
		if ( ! $this->should_load_assets() ) {
			return;
		}

		wp_enqueue_style(
			'ssb-google-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Lato:wght@300;400;500&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'ssb-public',
			SSB_PLUGIN_URL . 'public/assets/css/public.css',
			array(),
			SSB_VERSION
		);

		wp_enqueue_script(
			'ssb-booking',
			SSB_PLUGIN_URL . 'public/assets/js/booking.js',
			array(),
			SSB_VERSION,
			true
		);

		wp_localize_script(
			'ssb-booking',
			'ssbBooking',
			array(
				'restUrl'          => esc_url_raw( rest_url( 'sacred-spaces-booking/v1' ) ),
				'nonce'            => wp_create_nonce( 'wp_rest' ),
				'stripeKey'        => StripeService::get_publishable_key(),
				'paymentReturn'    => $this->get_payment_return_state(),
				'i18n'             => $this->get_i18n_strings(),
				'steps'            => $this->get_step_labels(),
			)
		);
	}

	/**
	 * Check if assets should load on current page.
	 */
	private function should_load_assets(): bool {
		global $post;
		if ( ! is_singular() || ! $post ) {
			return false;
		}
		$content = $post->post_content ?? '';
		return has_shortcode( $content, 'sacred_booking' )
			|| has_shortcode( $content, 'sacred_calendar' )
			|| has_shortcode( $content, 'sacred_services' )
			|| has_block( 'sacred-spaces/booking', $content );
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
			'chooseService'    => __( 'Choose Service', 'sacred-spaces-booking' ),
			'location'         => __( 'Location', 'sacred-spaces-booking' ),
			'calendar'         => __( 'Calendar', 'sacred-spaces-booking' ),
			'time'             => __( 'Time', 'sacred-spaces-booking' ),
			'clientDetails'    => __( 'Client Details', 'sacred-spaces-booking' ),
			'questionnaire'    => __( 'Questionnaire', 'sacred-spaces-booking' ),
			'review'           => __( 'Review', 'sacred-spaces-booking' ),
			'confirmation'     => __( 'Confirmation', 'sacred-spaces-booking' ),
			'next'             => __( 'Continue', 'sacred-spaces-booking' ),
			'back'             => __( 'Back', 'sacred-spaces-booking' ),
			'submit'           => __( 'Submit Request', 'sacred-spaces-booking' ),
			'payNow'           => __( 'Complete Payment', 'sacred-spaces-booking' ),
			'virtual'          => __( 'Virtual', 'sacred-spaces-booking' ),
			'inHome'           => __( 'In Home', 'sacred-spaces-booking' ),
			'investment'       => __( 'Investment', 'sacred-spaces-booking' ),
			'duration'         => __( 'Duration', 'sacred-spaces-booking' ),
			'minutes'          => __( 'Minutes', 'sacred-spaces-booking' ),
			'selectDate'       => __( 'Select an available date', 'sacred-spaces-booking' ),
			'selectTime'       => __( 'Select your preferred time', 'sacred-spaces-booking' ),
			'noSlots'          => __( 'No available times for this date.', 'sacred-spaces-booking' ),
			'loading'          => __( 'Loading...', 'sacred-spaces-booking' ),
			'error'            => __( 'Something went wrong. Please try again.', 'sacred-spaces-booking' ),
			'required'         => __( 'This field is required.', 'sacred-spaces-booking' ),
			'ackRequired'      => __( 'Please acknowledge the intentional design experience.', 'sacred-spaces-booking' ),
			'thankYou'         => __( 'Thank You', 'sacred-spaces-booking' ),
			'received'         => __( 'Your request has been received.', 'sacred-spaces-booking' ),
			'contactShortly'   => __( "We'll contact you shortly.", 'sacred-spaces-booking' ),
			'bookingSummary'   => __( 'Booking Summary', 'sacred-spaces-booking' ),
			'heroTitle'        => __( 'Begin Your Sanctuary Session', 'sacred-spaces-booking' ),
			'heroSubtitle'     => __( 'Your transformation begins with a single intentional step. Choose the experience that best supports your home and your next chapter.', 'sacred-spaces-booking' ),
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
		$this->enqueue_assets_for_shortcode();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/booking-wizard.php';
		return (string) ob_get_clean();
	}

	/**
	 * Render calendar shortcode.
	 */
	public function render_calendar( array $atts = array() ): string {
		$this->enqueue_assets_for_shortcode();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/calendar.php';
		return (string) ob_get_clean();
	}

	/**
	 * Render services shortcode.
	 */
	public function render_services( array $atts = array() ): string {
		$services = ( new ServiceRepository() )->get_active();

		ob_start();
		include SSB_PLUGIN_DIR . 'public/templates/services.php';
		return (string) ob_get_clean();
	}

	/**
	 * Force enqueue when shortcode renders after wp_enqueue_scripts.
	 */
	private function enqueue_assets_for_shortcode(): void {
		if ( ! wp_style_is( 'ssb-public', 'enqueued' ) ) {
			$this->enqueue_assets();
			wp_enqueue_style( 'ssb-public' );
			wp_enqueue_script( 'ssb-booking' );
		}
	}
}
