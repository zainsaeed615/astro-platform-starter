<?php
/**
 * Admin menu registration.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AdminMenu
 */
class AdminMenu {

	/**
	 * Menu pages configuration.
	 *
	 * @var array<int, array<string, string>>
	 */
	private array $pages = array();

	public function __construct() {
		$this->pages = array(
			array( 'slug' => 'sacred-spaces', 'title' => 'Dashboard', 'callback' => 'dashboard' ),
			array( 'slug' => 'sacred-spaces-bookings', 'title' => 'Bookings', 'callback' => 'bookings' ),
			array( 'slug' => 'sacred-spaces-calendar', 'title' => 'Calendar', 'callback' => 'calendar' ),
			array( 'slug' => 'sacred-spaces-services', 'title' => 'Services', 'callback' => 'services' ),
			array( 'slug' => 'sacred-spaces-availability', 'title' => 'Availability', 'callback' => 'availability' ),
			array( 'slug' => 'sacred-spaces-payments', 'title' => 'Payments', 'callback' => 'payments' ),
			array( 'slug' => 'sacred-spaces-questionnaires', 'title' => 'Questionnaires', 'callback' => 'questionnaires' ),
			array( 'slug' => 'sacred-spaces-reports', 'title' => 'Reports', 'callback' => 'reports' ),
			array( 'slug' => 'sacred-spaces-settings', 'title' => 'Settings', 'callback' => 'settings' ),
			array( 'slug' => 'sacred-spaces-emails', 'title' => 'Email Templates', 'callback' => 'emails' ),
		);

		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * Register admin menu.
	 */
	public function register_menu(): void {
		add_menu_page(
			__( 'Sacred Spaces', 'sacred-spaces-booking' ),
			__( 'Sacred Spaces', 'sacred-spaces-booking' ),
			'manage_options',
			'sacred-spaces',
			array( $this, 'render_dashboard' ),
			'dashicons-calendar-alt',
			26
		);

		foreach ( $this->pages as $index => $page ) {
			if ( 0 === $index ) {
				continue;
			}

			add_submenu_page(
				'sacred-spaces',
				$page['title'],
				$page['title'],
				'manage_options',
				$page['slug'],
				array( $this, 'render_' . $page['callback'] )
			);
		}
	}

	/**
	 * Render a page template.
	 *
	 * @param string $template Template name.
	 */
	private function render( string $template ): void {
		$file = SSB_PLUGIN_DIR . 'admin/templates/' . $template . '.php';
		if ( file_exists( $file ) ) {
			include $file;
		}
	}

	public function render_dashboard(): void { $this->render( 'dashboard' ); }
	public function render_bookings(): void { $this->render( 'bookings' ); }
	public function render_calendar(): void { $this->render( 'calendar' ); }
	public function render_services(): void { $this->render( 'services' ); }
	public function render_availability(): void { $this->render( 'availability' ); }
	public function render_payments(): void { $this->render( 'payments' ); }
	public function render_questionnaires(): void { $this->render( 'questionnaires' ); }
	public function render_reports(): void { $this->render( 'reports' ); }
	public function render_settings(): void { $this->render( 'settings' ); }
	public function render_emails(): void { $this->render( 'emails' ); }
}
