<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Settings {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'register' ) );
	}

	public function menu() {
		add_submenu_page( 'edit.php?post_type=vp_property', 'Property Settings', 'Settings', 'manage_options', 'vp-settings', array( $this, 'page' ) );
	}

	public function register() {
		register_setting( 'vp_settings_group', 'vp_default_notify_email' );
		register_setting( 'vp_settings_group', 'vp_email_subject' );
	}

	public function page() {
		?>
		<div class="wrap">
			<h1>Property Listings — Settings</h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'vp_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th><label for="vp_default_notify_email">Default Inquiry Notification Email</label></th>
						<td>
							<input type="email" id="vp_default_notify_email" name="vp_default_notify_email" class="regular-text" value="<?php echo esc_attr( get_option( 'vp_default_notify_email', get_option( 'admin_email' ) ) ); ?>" />
							<p class="description">Jab koi property page pr "Request Information" form fill kare to inquiry is email pr jayegi (agar us property me alag email set nahi ki gayi).</p>
						</td>
					</tr>
					<tr>
						<th><label for="vp_email_subject">Email Subject Line</label></th>
						<td>
							<input type="text" id="vp_email_subject" name="vp_email_subject" class="regular-text" value="<?php echo esc_attr( get_option( 'vp_email_subject', 'New Property Inquiry' ) ); ?>" />
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
