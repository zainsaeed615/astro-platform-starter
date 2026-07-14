<?php
/**
 * Settings screen (Floor Plans → Settings).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Settings {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	public static function menu() {
		add_submenu_page(
			'edit.php?post_type=home_plan',
			__( 'MW Homes Settings', 'mw-homes' ),
			__( 'Settings', 'mw-homes' ),
			'manage_options',
			'mwh-settings',
			array( __CLASS__, 'render' )
		);
	}

	public static function register() {
		register_setting( 'mwh_settings_group', 'mwh_settings', array( __CLASS__, 'sanitize' ) );
	}

	public static function sanitize( $input ) {
		return array(
			'notify_email' => isset( $input['notify_email'] ) ? sanitize_email( $input['notify_email'] ) : get_option( 'admin_email' ),
			'from_name'    => isset( $input['from_name'] ) ? sanitize_text_field( $input['from_name'] ) : get_bloginfo( 'name' ),
			'offered_by'   => isset( $input['offered_by'] ) ? sanitize_text_field( $input['offered_by'] ) : '',
			'auto_single'  => ( isset( $input['auto_single'] ) && 'on' === $input['auto_single'] ) ? 'on' : 'off',
			'disclaimer'   => isset( $input['disclaimer'] ) ? sanitize_textarea_field( $input['disclaimer'] ) : '',
		);
	}

	public static function get() {
		return wp_parse_args( get_option( 'mwh_settings', array() ), array(
			'notify_email' => get_option( 'admin_email' ),
			'from_name'    => get_bloginfo( 'name' ),
			'offered_by'   => get_bloginfo( 'name' ),
			'auto_single'  => 'on',
			'disclaimer'   => '',
		) );
	}

	public static function render() {
		$s = self::get();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'MW Homes Settings', 'mw-homes' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'mwh_settings_group' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="mwh_notify_email"><?php esc_html_e( 'Quote notification email', 'mw-homes' ); ?></label></th>
						<td>
							<input type="email" id="mwh_notify_email" name="mwh_settings[notify_email]" value="<?php echo esc_attr( $s['notify_email'] ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'Price-quote submissions are emailed here. Separate multiple addresses with commas.', 'mw-homes' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="mwh_from_name"><?php esc_html_e( 'Email "from" name', 'mw-homes' ); ?></label></th>
						<td><input type="text" id="mwh_from_name" name="mwh_settings[from_name]" value="<?php echo esc_attr( $s['from_name'] ); ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="mwh_offered_by"><?php esc_html_e( 'Default "Offered by"', 'mw-homes' ); ?></label></th>
						<td>
							<input type="text" id="mwh_offered_by" name="mwh_settings[offered_by]" value="<?php echo esc_attr( $s['offered_by'] ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'Used on any home that has no per-plan "Offered by" value.', 'mw-homes' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Single page layout', 'mw-homes' ); ?></th>
						<td>
							<label><input type="checkbox" name="mwh_settings[auto_single]" value="on" <?php checked( $s['auto_single'], 'on' ); ?> /> <?php esc_html_e( 'Automatically show the full single layout on Floor Plan pages', 'mw-homes' ); ?></label>
							<p class="description"><?php esc_html_e( 'Leave on for ready-to-use single pages. Turn off if you build your own single-plan template in Elementor Theme Builder using the “Home: Full Single Layout” widget (or other MW Homes widgets).', 'mw-homes' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="mwh_disclaimer"><?php esc_html_e( 'Disclaimer text', 'mw-homes' ); ?></label></th>
						<td>
							<textarea id="mwh_disclaimer" name="mwh_settings[disclaimer]" rows="4" class="large-text"><?php echo esc_textarea( $s['disclaimer'] ); ?></textarea>
							<p class="description"><?php esc_html_e( 'Shown at the bottom of single floor-plan pages (PLEASE NOTE). Leave blank for the built-in default.', 'mw-homes' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

MWH_Settings::init();
