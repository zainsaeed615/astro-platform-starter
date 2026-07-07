<?php
/**
 * Elementor Booking Widget.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Integrations\Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BookingWidget
 */
class BookingWidget extends Widget_Base {

	public function get_name(): string {
		return 'sacred_spaces_booking';
	}

	public function get_title(): string {
		return esc_html__( 'Sacred Spaces Booking', 'sacred-spaces-booking' );
	}

	public function get_icon(): string {
		return 'eicon-calendar';
	}

	public function get_categories(): array {
		return array( 'sacred-spaces' );
	}

	public function get_keywords(): array {
		return array( 'booking', 'sacred', 'appointment', 'calendar' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'sacred-spaces-booking' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_hero',
			array(
				'label'        => esc_html__( 'Show Hero Section', 'sacred-spaces-booking' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'sacred-spaces-booking' ),
				'label_off'    => esc_html__( 'No', 'sacred-spaces-booking' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'widget_type',
			array(
				'label'   => esc_html__( 'Display', 'sacred-spaces-booking' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'booking',
				'options' => array(
					'booking'  => esc_html__( 'Full Booking Wizard', 'sacred-spaces-booking' ),
					'calendar' => esc_html__( 'Calendar Only', 'sacred-spaces-booking' ),
					'services' => esc_html__( 'Services List', 'sacred-spaces-booking' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$type     = $settings['widget_type'] ?? 'booking';

		$shortcodes = array(
			'booking'  => '[sacred_booking]',
			'calendar' => '[sacred_calendar]',
			'services' => '[sacred_services]',
		);

		echo do_shortcode( $shortcodes[ $type ] ?? '[sacred_booking]' );
	}
}
