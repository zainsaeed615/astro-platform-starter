<?php
/**
 * Main plugin orchestrator.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking;

use SacredSpaces\Booking\Admin\Admin;
use SacredSpaces\Booking\Api\RestController;
use SacredSpaces\Booking\Api\AjaxHandler;
use SacredSpaces\Booking\Frontend\PublicFacing;
use SacredSpaces\Booking\Integrations\ElementorWidget;
use SacredSpaces\Booking\Integrations\GutenbergBlock;
use SacredSpaces\Booking\Database\Upgrader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plugin
 */
class Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Get singleton instance.
	 */
	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Run the plugin.
	 */
	public function run(): void {
		load_plugin_textdomain( 'sacred-spaces-booking', false, dirname( SSB_PLUGIN_BASENAME ) . '/languages' );

		Upgrader::maybe_upgrade();

		new Admin();
		new PublicFacing();
		new RestController();
		new AjaxHandler();
		new GutenbergBlock();

		add_action( 'elementor/widgets/register', array( ElementorWidget::class, 'register' ) );
		add_action( 'elementor/elements/categories_registered', array( ElementorWidget::class, 'register_category' ) );
	}
}
