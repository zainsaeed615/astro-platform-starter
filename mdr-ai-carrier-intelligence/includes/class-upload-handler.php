<?php
/**
 * Secure file upload handling.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Upload_Handler
 */
class Upload_Handler {

	/**
	 * Handle uploaded file.
	 *
	 * @param array<string, mixed> $file $_FILES file array.
	 * @return array{path: string, extension: string}
	 * @throws \Exception On validation failure.
	 */
	public function handle( array $file ) {
		if ( empty( $file['tmp_name'] ) || ! is_uploaded_file( $file['tmp_name'] ) ) {
			throw new \Exception( __( 'Invalid upload.', 'mdr-ai-carrier-intelligence' ) );
		}

		if ( ! empty( $file['error'] ) && UPLOAD_ERR_OK !== (int) $file['error'] ) {
			throw new \Exception( __( 'Upload failed. Please try again.', 'mdr-ai-carrier-intelligence' ) );
		}

		if ( $file['size'] > Settings::max_upload_bytes() ) {
			throw new \Exception( __( 'File exceeds the maximum upload size.', 'mdr-ai-carrier-intelligence' ) );
		}

		$extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
		$allowed   = Settings::allowed_extensions();

		if ( ! in_array( $extension, $allowed, true ) ) {
			throw new \Exception( __( 'Invalid file type. Please upload CSV, XLS, or XLSX.', 'mdr-ai-carrier-intelligence' ) );
		}

		$check = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'] );
		if ( empty( $check['ext'] ) || ! in_array( strtolower( $check['ext'] ), $allowed, true ) ) {
			throw new \Exception( __( 'File type verification failed.', 'mdr-ai-carrier-intelligence' ) );
		}

		$upload_dir = $this->get_upload_dir();
		$filename   = wp_unique_filename( $upload_dir, 'mdr-aci-' . wp_generate_password( 8, false, false ) . '.' . $extension );
		$destination = trailingslashit( $upload_dir ) . $filename;

		if ( ! move_uploaded_file( $file['tmp_name'], $destination ) ) {
			throw new \Exception( __( 'Unable to store uploaded file.', 'mdr-ai-carrier-intelligence' ) );
		}

		return array(
			'path'      => $destination,
			'extension' => $extension,
		);
	}

	/**
	 * Delete processed file.
	 *
	 * @param string $path File path.
	 */
	public function maybe_delete( $path ) {
		if ( ! Settings::get_option( 'delete_after_process', 1 ) ) {
			return;
		}
		if ( file_exists( $path ) && strpos( realpath( $path ), realpath( $this->get_upload_dir() ) ) === 0 ) {
			wp_delete_file( $path );
		}
	}

	/**
	 * Get upload directory path.
	 *
	 * @return string
	 */
	public function get_upload_dir() {
		$upload = wp_upload_dir();
		$dir    = trailingslashit( $upload['basedir'] ) . 'mdr-aci';
		if ( ! file_exists( $dir ) ) {
			wp_mkdir_p( $dir );
		}
		return $dir;
	}
}
