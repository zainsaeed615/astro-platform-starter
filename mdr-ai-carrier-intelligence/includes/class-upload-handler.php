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
			$message = $this->upload_error_message( (int) $file['error'] );
			throw new \Exception( $message );
		}

		if ( $file['size'] > Settings::max_upload_bytes() ) {
			throw new \Exception( __( 'File exceeds the maximum upload size.', 'mdr-ai-carrier-intelligence' ) );
		}

		$extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
		$allowed   = Settings::allowed_extensions();

		if ( ! in_array( $extension, $allowed, true ) ) {
			throw new \Exception( __( 'Invalid file type. Please upload CSV, XLS, or XLSX.', 'mdr-ai-carrier-intelligence' ) );
		}

		if ( ! $this->validate_mime( $file['tmp_name'], $extension ) ) {
			throw new \Exception( __( 'File type verification failed.', 'mdr-ai-carrier-intelligence' ) );
		}

		$upload_dir  = $this->get_upload_dir();
		$filename    = wp_unique_filename( $upload_dir, 'mdr-aci-' . wp_generate_password( 8, false, false ) . '.' . $extension );
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
	 * Validate file MIME type.
	 *
	 * @param string $tmp_path  Temp file path.
	 * @param string $extension Expected extension.
	 * @return bool
	 */
	private function validate_mime( $tmp_path, $extension ) {
		$allowed_mimes = array(
			'csv'  => array( 'text/csv', 'text/plain', 'application/csv', 'application/vnd.ms-excel' ),
			'xls'  => array( 'application/vnd.ms-excel', 'application/octet-stream' ),
			'xlsx' => array( 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream', 'application/zip' ),
		);

		if ( ! isset( $allowed_mimes[ $extension ] ) ) {
			return false;
		}

		if ( function_exists( 'finfo_open' ) ) {
			$finfo = finfo_open( FILEINFO_MIME_TYPE );
			if ( $finfo ) {
				$detected = finfo_file( $finfo, $tmp_path );
				finfo_close( $finfo );
				if ( $detected && in_array( $detected, $allowed_mimes[ $extension ], true ) ) {
					return true;
				}
			}
		}

		$check = wp_check_filetype_and_ext( $tmp_path, 'file.' . $extension );
		if ( ! empty( $check['ext'] ) && $check['ext'] === $extension ) {
			return true;
		}

		// CSV is often detected as text/plain — allow if extension matches and content looks tabular.
		if ( 'csv' === $extension ) {
			return $this->looks_like_csv( $tmp_path );
		}

		if ( 'xlsx' === $extension && class_exists( 'ZipArchive' ) ) {
			$zip = new \ZipArchive();
			$ok  = $zip->open( $tmp_path );
			if ( true === $ok ) {
				$has_sheet = false !== $zip->locateName( 'xl/worksheets/sheet1.xml' );
				$zip->close();
				return $has_sheet;
			}
		}

		return false;
	}

	/**
	 * Basic CSV structure check.
	 *
	 * @param string $path File path.
	 * @return bool
	 */
	private function looks_like_csv( $path ) {
		$handle = fopen( $path, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
		if ( false === $handle ) {
			return false;
		}
		$line = fgets( $handle );
		fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
		if ( false === $line ) {
			return false;
		}
		return (bool) preg_match( '/[,;\t]/', $line );
	}

	/**
	 * Map PHP upload error codes to messages.
	 *
	 * @param int $code Error code.
	 * @return string
	 */
	private function upload_error_message( $code ) {
		switch ( $code ) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				return __( 'File exceeds the maximum upload size.', 'mdr-ai-carrier-intelligence' );
			case UPLOAD_ERR_PARTIAL:
				return __( 'Upload was interrupted. Please try again.', 'mdr-ai-carrier-intelligence' );
			case UPLOAD_ERR_NO_FILE:
				return __( 'No file uploaded.', 'mdr-ai-carrier-intelligence' );
			default:
				return __( 'Upload failed. Please try again.', 'mdr-ai-carrier-intelligence' );
		}
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

		if ( ! file_exists( $path ) ) {
			return;
		}

		$real_path = wp_normalize_path( (string) realpath( $path ) );
		$real_dir  = wp_normalize_path( (string) realpath( $this->get_upload_dir() ) );

		if ( $real_path && $real_dir && 0 === strpos( $real_path, $real_dir ) ) {
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
