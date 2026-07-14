<?php
/**
 * Price-quote popup form: rendering, AJAX submit, storage, email, admin list.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Quote {

	public static function init() {
		add_action( 'wp_footer', array( __CLASS__, 'render_modal' ) );
		add_action( 'wp_ajax_mwh_submit_quote', array( __CLASS__, 'handle' ) );
		add_action( 'wp_ajax_nopriv_mwh_submit_quote', array( __CLASS__, 'handle' ) );

		// Admin list for quote requests.
		add_filter( 'manage_quote_request_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_quote_request_posts_custom_column', array( __CLASS__, 'column_content' ), 10, 2 );
		add_action( 'add_meta_boxes', array( __CLASS__, 'detail_box' ) );
	}

	/**
	 * The modal + form markup, output once in the footer.
	 */
	public static function render_modal() {
		if ( is_admin() ) {
			return;
		}
		$states = mwh_us_states();
		$land   = mwh_land_options();
		?>
		<div class="mwh-modal" id="mwh-quote-modal" aria-hidden="true">
			<div class="mwh-modal__overlay" data-mwh-close></div>
			<div class="mwh-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="mwh-quote-heading">
				<button type="button" class="mwh-modal__close" data-mwh-close aria-label="<?php esc_attr_e( 'Close', 'mw-homes' ); ?>">&times;</button>

				<h2 class="mwh-modal__title" id="mwh-quote-heading"><?php esc_html_e( 'Request', 'mw-homes' ); ?> <span><?php esc_html_e( 'a Price Quote', 'mw-homes' ); ?></span></h2>

				<div class="mwh-quote-head">
					<div class="mwh-quote-thumb" data-mwh-thumb></div>
					<div class="mwh-quote-plan">
						<h3 data-mwh-plan-title></h3>
						<div class="mwh-quote-note">
							<span class="mwh-quote-note__ico" aria-hidden="true">!</span>
							<p><strong><?php esc_html_e( 'Please note:', 'mw-homes' ); ?></strong> <?php esc_html_e( 'Fill out the fields below to request pricing on this home. One of our representatives will reach out as soon as possible. Fields marked with an asterisk * are required.', 'mw-homes' ); ?></p>
						</div>
					</div>
				</div>

				<form class="mwh-quote-form" novalidate>
					<input type="hidden" name="plan_id" value="" />
					<input type="hidden" name="plan_title" value="" />
					<?php wp_nonce_field( 'mwh_quote', 'mwh_quote_nonce' ); ?>

					<div class="mwh-form-grid">
						<p class="mwh-fld">
							<label><?php esc_html_e( 'Land Option', 'mw-homes' ); ?></label>
							<select name="land_option">
								<option value=""><?php esc_html_e( 'Select…', 'mw-homes' ); ?></option>
								<?php foreach ( $land as $k => $v ) : ?>
									<option value="<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $v ); ?></option>
								<?php endforeach; ?>
							</select>
						</p>

						<p class="mwh-fld">
							<label><?php esc_html_e( 'Trade In', 'mw-homes' ); ?></label>
							<span class="mwh-radios">
								<label><input type="radio" name="trade_in" value="Yes" /> <?php esc_html_e( 'Yes', 'mw-homes' ); ?></label>
								<label><input type="radio" name="trade_in" value="No" /> <?php esc_html_e( 'No', 'mw-homes' ); ?></label>
							</span>
						</p>

						<p class="mwh-fld">
							<label><?php esc_html_e( 'First Name', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="text" name="first_name" required placeholder="<?php esc_attr_e( 'First Name', 'mw-homes' ); ?>" />
						</p>
						<p class="mwh-fld">
							<label><?php esc_html_e( 'Last Name', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="text" name="last_name" required placeholder="<?php esc_attr_e( 'Last Name', 'mw-homes' ); ?>" />
						</p>

						<p class="mwh-fld">
							<label><?php esc_html_e( 'City', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="text" name="city" required placeholder="<?php esc_attr_e( 'City', 'mw-homes' ); ?>" />
						</p>
						<p class="mwh-fld">
							<label><?php esc_html_e( 'State', 'mw-homes' ); ?> <span class="req">*</span></label>
							<select name="state" required>
								<option value=""><?php esc_html_e( 'State…', 'mw-homes' ); ?></option>
								<?php foreach ( $states as $abbr => $name ) : ?>
									<option value="<?php echo esc_attr( $abbr ); ?>"><?php echo esc_html( $name ); ?></option>
								<?php endforeach; ?>
							</select>
						</p>

						<p class="mwh-fld">
							<label><?php esc_html_e( 'Zipcode', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="text" name="zip" required placeholder="<?php esc_attr_e( 'Zipcode', 'mw-homes' ); ?>" inputmode="numeric" />
						</p>
						<p class="mwh-fld">
							<label><?php esc_html_e( 'Email', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="email" name="email" required placeholder="<?php esc_attr_e( 'Email', 'mw-homes' ); ?>" />
						</p>

						<p class="mwh-fld">
							<label><?php esc_html_e( 'Phone', 'mw-homes' ); ?> <span class="req">*</span></label>
							<input type="tel" name="phone" required placeholder="<?php esc_attr_e( 'Phone', 'mw-homes' ); ?>" />
						</p>

						<p class="mwh-fld mwh-fld--full">
							<label><?php esc_html_e( 'Message', 'mw-homes' ); ?></label>
							<textarea name="message" rows="4" placeholder="<?php esc_attr_e( 'Custom Features', 'mw-homes' ); ?>"></textarea>
						</p>
					</div>

					<div class="mwh-form-foot">
						<div class="mwh-form-msg" role="status" aria-live="polite"></div>
						<button type="submit" class="mwh-btn mwh-btn--primary mwh-btn--block mwh-quote-submit"><?php esc_html_e( 'Submit', 'mw-homes' ); ?></button>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * AJAX submit handler.
	 */
	public static function handle() {
		check_ajax_referer( 'mwh_quote', 'nonce' );

		$required = array( 'first_name', 'last_name', 'city', 'state', 'zip', 'email', 'phone' );
		$data     = array();
		foreach ( array( 'plan_id', 'plan_title', 'land_option', 'trade_in', 'first_name', 'last_name', 'city', 'state', 'zip', 'email', 'phone', 'message' ) as $f ) {
			$data[ $f ] = isset( $_POST[ $f ] ) ? sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) : '';
		}
		$data['message'] = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
		$data['email']   = sanitize_email( $data['email'] );

		// Honeypot / validation.
		foreach ( $required as $f ) {
			if ( '' === $data[ $f ] ) {
				wp_send_json_error( array( 'message' => __( 'Please complete all required fields.', 'mw-homes' ) ) );
			}
		}
		if ( ! is_email( $data['email'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'mw-homes' ) ) );
		}

		$plan_id    = absint( $data['plan_id'] );
		$plan_title = $data['plan_title'] ? $data['plan_title'] : ( $plan_id ? get_the_title( $plan_id ) : __( 'General', 'mw-homes' ) );

		// Store.
		$post_id = wp_insert_post( array(
			'post_type'   => 'quote_request',
			'post_status' => 'publish',
			'post_title'  => sprintf( '%s %s – %s', $data['first_name'], $data['last_name'], $plan_title ),
		) );

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			foreach ( $data as $k => $v ) {
				update_post_meta( $post_id, '_q_' . $k, $v );
			}
			update_post_meta( $post_id, '_q_plan_id', $plan_id );
			update_post_meta( $post_id, '_q_plan_title', $plan_title );
		}

		self::notify( $data, $plan_id, $plan_title );

		wp_send_json_success( array( 'message' => __( 'Thank you! Your request has been sent. A representative will reach out shortly.', 'mw-homes' ) ) );
	}

	private static function notify( $data, $plan_id, $plan_title ) {
		$s     = MWH_Settings::get();
		$to    = $s['notify_email'] ? $s['notify_email'] : get_option( 'admin_email' );
		$land  = $data['land_option'] ? $data['land_option'] : '—';
		$trade = $data['trade_in'] ? $data['trade_in'] : '—';
		$link  = $plan_id ? get_permalink( $plan_id ) : '';

		$subject = sprintf( __( 'New Price Quote: %s', 'mw-homes' ), $plan_title );
		$lines   = array(
			__( 'A new price quote request was submitted.', 'mw-homes' ),
			'',
			'Home: ' . $plan_title . ( $link ? ' (' . $link . ')' : '' ),
			'Name: ' . $data['first_name'] . ' ' . $data['last_name'],
			'Email: ' . $data['email'],
			'Phone: ' . $data['phone'],
			'Location: ' . $data['city'] . ', ' . $data['state'] . ' ' . $data['zip'],
			'Land Option: ' . $land,
			'Trade In: ' . $trade,
			'Message: ' . ( $data['message'] ? $data['message'] : '—' ),
		);
		$body    = implode( "\n", $lines );

		$headers = array(
			'From: ' . $s['from_name'] . ' <' . ( get_option( 'admin_email' ) ) . '>',
			'Reply-To: ' . $data['first_name'] . ' ' . $data['last_name'] . ' <' . $data['email'] . '>',
		);

		wp_mail( $to, $subject, $body, $headers );
	}

	/* ---------- Admin list ---------- */
	public static function columns( $cols ) {
		$new = array(
			'cb'       => isset( $cols['cb'] ) ? $cols['cb'] : '',
			'title'    => __( 'Request', 'mw-homes' ),
			'q_email'  => __( 'Email', 'mw-homes' ),
			'q_phone'  => __( 'Phone', 'mw-homes' ),
			'q_loc'    => __( 'Location', 'mw-homes' ),
			'q_plan'   => __( 'Home', 'mw-homes' ),
			'date'     => __( 'Date', 'mw-homes' ),
		);
		return $new;
	}

	public static function column_content( $col, $post_id ) {
		switch ( $col ) {
			case 'q_email':
				$e = get_post_meta( $post_id, '_q_email', true );
				echo $e ? '<a href="mailto:' . esc_attr( $e ) . '">' . esc_html( $e ) . '</a>' : '—';
				break;
			case 'q_phone':
				echo esc_html( get_post_meta( $post_id, '_q_phone', true ) ?: '—' );
				break;
			case 'q_loc':
				echo esc_html( trim( get_post_meta( $post_id, '_q_city', true ) . ', ' . get_post_meta( $post_id, '_q_state', true ) . ' ' . get_post_meta( $post_id, '_q_zip', true ), ', ' ) );
				break;
			case 'q_plan':
				$pid = absint( get_post_meta( $post_id, '_q_plan_id', true ) );
				$t   = get_post_meta( $post_id, '_q_plan_title', true );
				echo $pid ? '<a href="' . esc_url( get_edit_post_link( $pid ) ) . '">' . esc_html( $t ) . '</a>' : esc_html( $t ?: '—' );
				break;
		}
	}

	public static function detail_box() {
		add_meta_box( 'mwh_quote_detail', __( 'Submission Detail', 'mw-homes' ), array( __CLASS__, 'render_detail' ), 'quote_request', 'normal', 'high' );
	}

	public static function render_detail( $post ) {
		$fields = array(
			'plan_title' => __( 'Home', 'mw-homes' ),
			'first_name' => __( 'First Name', 'mw-homes' ),
			'last_name'  => __( 'Last Name', 'mw-homes' ),
			'email'      => __( 'Email', 'mw-homes' ),
			'phone'      => __( 'Phone', 'mw-homes' ),
			'city'       => __( 'City', 'mw-homes' ),
			'state'      => __( 'State', 'mw-homes' ),
			'zip'        => __( 'Zipcode', 'mw-homes' ),
			'land_option'=> __( 'Land Option', 'mw-homes' ),
			'trade_in'   => __( 'Trade In', 'mw-homes' ),
			'message'    => __( 'Message', 'mw-homes' ),
		);
		echo '<table class="widefat striped"><tbody>';
		foreach ( $fields as $k => $label ) {
			$v = get_post_meta( $post->ID, '_q_' . $k, true );
			echo '<tr><th style="width:180px">' . esc_html( $label ) . '</th><td>' . esc_html( $v ?: '—' ) . '</td></tr>';
		}
		echo '</tbody></table>';
	}
}

MWH_Quote::init();
