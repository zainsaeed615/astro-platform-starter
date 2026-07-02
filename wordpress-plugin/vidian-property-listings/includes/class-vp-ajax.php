<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Ajax {

	public function __construct() {
		add_action( 'wp_ajax_vp_submit_inquiry', array( $this, 'handle' ) );
		add_action( 'wp_ajax_nopriv_vp_submit_inquiry', array( $this, 'handle' ) );
	}

	public function handle() {
		check_ajax_referer( 'vp_inquiry_nonce', 'nonce' );

		$property_id = isset( $_POST['property_id'] ) ? intval( $_POST['property_id'] ) : 0;
		$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone       = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$message     = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

		if ( empty( $name ) || empty( $email ) ) {
			wp_send_json_error( array( 'message' => 'Naam aur Email zaroori hain.' ) );
		}
		if ( ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => 'Sahi email address dalein.' ) );
		}

		$property_title = $property_id ? get_the_title( $property_id ) : 'Website';
		$property_url   = $property_id ? get_permalink( $property_id ) : home_url( '/' );
		$property_loc   = $property_id ? get_post_meta( $property_id, '_vp_location', true ) : '';
		$property_price = $property_id ? get_post_meta( $property_id, '_vp_price', true ) : '';
		$to = $property_id ? get_post_meta( $property_id, '_vp_notify_email', true ) : '';
		if ( empty( $to ) ) {
			$to = get_option( 'vp_default_notify_email', get_option( 'admin_email' ) );
		}
		$subject = get_option( 'vp_email_subject', 'New Property Inquiry' ) . ' — ' . $property_title;

		$body  = "New inquiry received:\n\n";
		$body .= "Property: {$property_title}\n";
		$body .= "Property ID: {$property_id}\n";
		$body .= "Property URL: {$property_url}\n";
		$body .= "Location: {$property_loc}\n";
		$body .= "Price: {$property_price}\n\n";
		$body .= "Name: {$name}\n";
		$body .= "Email: {$email}\n";
		$body .= "Phone: {$phone}\n";
		$body .= "Message:\n{$message}\n";

		$headers = array( 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$name} <{$email}>" );

		$sent = wp_mail( $to, $subject, $body, $headers );

		if ( $sent ) {
			wp_send_json_success( array( 'message' => 'Shukriya! Aapki inquiry bhej di gayi hai, jald hi rabta karenge.' ) );
		} else {
			wp_send_json_error( array( 'message' => 'Mail bhejne me masla hua, dobara koshish karein.' ) );
		}
	}
}
