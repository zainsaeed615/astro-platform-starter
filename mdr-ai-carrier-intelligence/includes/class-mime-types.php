<?php
/**
 * Allowed MIME types for spreadsheet uploads.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Mime_Types
 */
class Mime_Types {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'upload_mimes', array( $this, 'allow_spreadsheet_mimes' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'fix_spreadsheet_filetypes' ), 10, 4 );
	}

	/**
	 * Register CSV/XLS/XLSX mime types.
	 *
	 * @param array<string, string> $mimes Existing mimes.
	 * @return array<string, string>
	 */
	public function allow_spreadsheet_mimes( $mimes ) {
		$mimes['csv']  = 'text/csv';
		$mimes['xls']  = 'application/vnd.ms-excel';
		$mimes['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
		return $mimes;
	}

	/**
	 * Ensure WordPress recognizes spreadsheet extensions.
	 *
	 * @param array<string, string|false> $data     File data.
	 * @param string                      $file     File path.
	 * @param string                      $filename Filename.
	 * @param string[]|null               $mimes    Allowed mimes.
	 * @return array<string, string|false>
	 */
	public function fix_spreadsheet_filetypes( $data, $file, $filename, $mimes ) {
		$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

		$map = array(
			'csv'  => array(
				'type' => 'text/csv',
				'ext'  => 'csv',
			),
			'xls'  => array(
				'type' => 'application/vnd.ms-excel',
				'ext'  => 'xls',
			),
			'xlsx' => array(
				'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'ext'  => 'xlsx',
			),
		);

		if ( isset( $map[ $ext ] ) && in_array( $ext, Settings::allowed_extensions(), true ) ) {
			$data['ext']  = $map[ $ext ]['ext'];
			$data['type'] = $map[ $ext ]['type'];
		}

		return $data;
	}
}
