<?php
/**
 * Admin area bootstrap.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin
 */
class Admin {

	public function __construct() {
		new AdminMenu();
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_assets( string $hook ): void {
		if ( strpos( $hook, 'sacred-spaces' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'ssb-google-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Lato:wght@300;400;500&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'ssb-admin',
			SSB_PLUGIN_URL . 'admin/assets/css/admin.css',
			array(),
			SSB_VERSION
		);

		wp_enqueue_script(
			'ssb-admin',
			SSB_PLUGIN_URL . 'admin/assets/js/admin.js',
			array( 'jquery' ),
			SSB_VERSION,
			true
		);

		wp_localize_script(
			'ssb-admin',
			'ssbAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'ssb_admin_nonce' ),
				'i18n'    => array(
					'saved'   => __( 'Saved successfully.', 'sacred-spaces-booking' ),
					'error'   => __( 'An error occurred.', 'sacred-spaces-booking' ),
					'confirm' => __( 'Are you sure?', 'sacred-spaces-booking' ),
				),
			)
		);
	}
}
