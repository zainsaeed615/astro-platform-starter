<?php
/**
 * Elementor widget integration.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ElementorWidget
 */
class ElementorWidget {

	/**
	 * Register Elementor category.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elements manager.
	 */
	public static function register_category( $elements_manager ): void {
		$elements_manager->add_category(
			'sacred-spaces',
			array(
				'title' => esc_html__( 'Sacred Spaces', 'sacred-spaces-booking' ),
				'icon'  => 'fa fa-calendar',
			)
		);
	}

	/**
	 * Register widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager.
	 */
	public static function register( $widgets_manager ): void {
		if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}

		require_once SSB_PLUGIN_DIR . 'includes/classes/Integrations/Elementor/BookingWidget.php';
		$widgets_manager->register( new Elementor\BookingWidget() );
	}
}
