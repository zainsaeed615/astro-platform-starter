<?php
/**
 * Gutenberg block registration.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GutenbergBlock
 */
class GutenbergBlock {

	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Register the booking block.
	 */
	public function register_block(): void {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		wp_register_script(
			'ssb-block-editor',
			SSB_PLUGIN_URL . 'public/assets/js/block.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			SSB_VERSION,
			true
		);

		register_block_type(
			SSB_PLUGIN_DIR . 'public/block.json',
			array(
				'render_callback' => array( $this, 'render_block' ),
			)
		);
	}

	/**
	 * Render block on frontend.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 */
	public function render_block( array $attributes ): string {
		$shortcode = '[sacred_booking]';
		if ( ! empty( $attributes['showHero'] ) && false === $attributes['showHero'] ) {
			$shortcode = '[sacred_booking show_hero="false"]';
		}
		return do_shortcode( $shortcode );
	}
}
