<?php
/**
 * Spreadsheet parsing for CSV, XLS, XLSX.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Spreadsheet_Parser
 */
class Spreadsheet_Parser {

	/**
	 * Parse file into associative rows.
	 *
	 * @param string $file_path Absolute file path.
	 * @param string $extension File extension.
	 * @return array<int, array<string, string>>
	 * @throws \Exception When parsing fails.
	 */
	public function parse( $file_path, $extension ) {
		$extension = strtolower( $extension );

		switch ( $extension ) {
			case 'csv':
				return $this->parse_csv( $file_path );
			case 'xlsx':
				return $this->parse_xlsx( $file_path );
			case 'xls':
				return $this->parse_xls( $file_path );
			default:
				throw new \Exception( __( 'Unsupported file type.', 'mdr-ai-carrier-intelligence' ) );
		}
	}

	/**
	 * Parse CSV file.
	 *
	 * @param string $file_path File path.
	 * @return array<int, array<string, string>>
	 */
	private function parse_csv( $file_path ) {
		$handle = fopen( $file_path, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
		if ( false === $handle ) {
			throw new \Exception( __( 'Unable to read CSV file.', 'mdr-ai-carrier-intelligence' ) );
		}

		$headers = null;
		$rows    = array();

		while ( ( $data = fgetcsv( $handle ) ) !== false ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fgetcsv
			if ( empty( array_filter( $data, 'strlen' ) ) ) {
				continue;
			}

			if ( null === $headers ) {
				$headers = $this->normalize_headers( $data );
				continue;
			}

			$row = $this->combine_row( $headers, $data );
			if ( ! empty( array_filter( $row ) ) ) {
				$rows[] = $row;
			}
		}

		fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

		if ( empty( $rows ) ) {
			throw new \Exception( __( 'No shipment data found in file.', 'mdr-ai-carrier-intelligence' ) );
		}

		return $rows;
	}

	/**
	 * Parse XLSX via ZipArchive.
	 *
	 * @param string $file_path File path.
	 * @return array<int, array<string, string>>
	 */
	private function parse_xlsx( $file_path ) {
		if ( ! class_exists( 'ZipArchive' ) ) {
			throw new \Exception( __( 'XLSX support requires the PHP Zip extension.', 'mdr-ai-carrier-intelligence' ) );
		}

		$zip = new \ZipArchive();
		if ( true !== $zip->open( $file_path ) ) {
			throw new \Exception( __( 'Unable to open XLSX file.', 'mdr-ai-carrier-intelligence' ) );
		}

		$shared_strings = $this->read_xlsx_shared_strings( $zip );
		$sheet_xml      = $zip->getFromName( 'xl/worksheets/sheet1.xml' );

		if ( false === $sheet_xml ) {
			$zip->close();
			throw new \Exception( __( 'Unable to read worksheet from XLSX file.', 'mdr-ai-carrier-intelligence' ) );
		}

		$zip->close();

		$sheet   = simplexml_load_string( $sheet_xml );
		$matrix  = array();
		$ns      = $sheet->getNamespaces( true );
		$main_ns = isset( $ns[''] ) ? $ns[''] : 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';

		foreach ( $sheet->children( $main_ns )->sheetData->row as $row ) {
			$row_index = (int) $row['r'];
			foreach ( $row->c as $cell ) {
				$ref   = (string) $cell['r'];
				$col   = preg_replace( '/[0-9]+/', '', $ref );
				$value = '';

				if ( isset( $cell->v ) ) {
					$cell_value = (string) $cell->v;
					$type       = (string) $cell['t'];
					if ( 's' === $type && isset( $shared_strings[ (int) $cell_value ] ) ) {
						$value = $shared_strings[ (int) $cell_value ];
					} else {
						$value = $cell_value;
					}
				}

				if ( ! isset( $matrix[ $row_index ] ) ) {
					$matrix[ $row_index ] = array();
				}
				$matrix[ $row_index ][ $col ] = $value;
			}
		}

		ksort( $matrix );
		$flat_rows = array_values( array_map( array( $this, 'flatten_xlsx_row' ), $matrix ) );

		return $this->matrix_to_rows( $flat_rows );
	}

	/**
	 * Read shared strings from XLSX.
	 *
	 * @param \ZipArchive $zip Zip archive.
	 * @return string[]
	 */
	private function read_xlsx_shared_strings( $zip ) {
		$xml = $zip->getFromName( 'xl/sharedStrings.xml' );
		if ( false === $xml ) {
			return array();
		}

		$doc     = simplexml_load_string( $xml );
		$strings = array();
		$index   = 0;

		foreach ( $doc->si as $si ) {
			if ( isset( $si->t ) ) {
				$strings[ $index ] = (string) $si->t;
			} elseif ( isset( $si->r ) ) {
				$text = '';
				foreach ( $si->r as $run ) {
					$text .= (string) $run->t;
				}
				$strings[ $index ] = $text;
			} else {
				$strings[ $index ] = '';
			}
			++$index;
		}

		return $strings;
	}

	/**
	 * Flatten XLSX row keyed by column letters.
	 *
	 * @param array<string, string> $row Row data.
	 * @return string[]
	 */
	private function flatten_xlsx_row( $row ) {
		$columns = array_keys( $row );
		usort(
			$columns,
			function ( $a, $b ) {
				return $this->column_index( $a ) <=> $this->column_index( $b );
			}
		);

		$values = array();
		foreach ( $columns as $col ) {
			$values[] = $row[ $col ];
		}
		return $values;
	}

	/**
	 * Convert column letters to index.
	 *
	 * @param string $letters Column letters.
	 * @return int
	 */
	private function column_index( $letters ) {
		$letters = strtoupper( $letters );
		$index   = 0;
		$len     = strlen( $letters );
		for ( $i = 0; $i < $len; $i++ ) {
			$index = $index * 26 + ( ord( $letters[ $i ] ) - 64 );
		}
		return $index;
	}

	/**
	 * Parse legacy XLS using basic BIFF extraction fallback.
	 *
	 * @param string $file_path File path.
	 * @return array<int, array<string, string>>
	 */
	private function parse_xls( $file_path ) {
		$content = file_get_contents( $file_path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( false === $content ) {
			throw new \Exception( __( 'Unable to read XLS file.', 'mdr-ai-carrier-intelligence' ) );
		}

		$strings = array();
		$offset  = 0;
		$length  = strlen( $content );

		while ( $offset + 4 <= $length ) {
			$record_type = ord( $content[ $offset ] ) + ( ord( $content[ $offset + 1 ] ) * 256 );
			$record_size = ord( $content[ $offset + 2 ] ) + ( ord( $content[ $offset + 3 ] ) * 256 );
			$record_data = substr( $content, $offset + 4, $record_size );

			if ( 0x0204 === $record_type && $record_size >= 8 ) { // LABELSST / SST string reference patterns vary; use simple LABEL.
				// Skip complex SST parsing for minimal support.
			}

			if ( 0x0207 === $record_type || 0x00FD === $record_type ) { // STRING / LABELSST approximations.
				// Legacy XLS parsing is limited; encourage XLSX when possible.
			}

			$offset += 4 + $record_size;
		}

		// Fallback: attempt CSV-like tab delimited extraction from visible strings.
		preg_match_all( '/[\x20-\x7E]{2,}/', $content, $matches );
		$candidates = array_filter(
			$matches[0],
			function ( $str ) {
				return preg_match( '/[,;\t]/', $str ) || strlen( $str ) > 10;
			}
		);

		if ( ! empty( $candidates ) ) {
			$line = reset( $candidates );
			foreach ( $candidates as $candidate ) {
				if ( substr_count( $candidate, ',' ) >= 3 || substr_count( $candidate, "\t" ) >= 3 ) {
					$line = $candidate;
					break;
				}
			}

			$delimiter = strpos( $line, "\t" ) !== false ? "\t" : ',';
			$lines     = preg_split( '/\R/', $content );
			$matrix    = array();

			foreach ( $lines as $raw_line ) {
				if ( strlen( trim( $raw_line ) ) < 5 ) {
					continue;
				}
				$parts = str_getcsv( $raw_line, $delimiter );
				if ( count( $parts ) >= 3 ) {
					$matrix[] = $parts;
				}
			}

			if ( count( $matrix ) >= 2 ) {
				return $this->matrix_to_rows( $matrix );
			}
		}

		throw new \Exception( __( 'Unable to parse XLS file. Please save as CSV or XLSX and try again.', 'mdr-ai-carrier-intelligence' ) );
	}

	/**
	 * Convert matrix to associative rows.
	 *
	 * @param array<int, array<int, string>> $matrix Raw matrix.
	 * @return array<int, array<string, string>>
	 */
	private function matrix_to_rows( array $matrix ) {
		if ( count( $matrix ) < 2 ) {
			throw new \Exception( __( 'No shipment data found in file.', 'mdr-ai-carrier-intelligence' ) );
		}

		$headers = $this->normalize_headers( $matrix[0] );
		$rows    = array();

		for ( $i = 1, $count = count( $matrix ); $i < $count; $i++ ) {
			$row = $this->combine_row( $headers, $matrix[ $i ] );
			if ( ! empty( array_filter( $row ) ) ) {
				$rows[] = $row;
			}
		}

		if ( empty( $rows ) ) {
			throw new \Exception( __( 'No shipment data found in file.', 'mdr-ai-carrier-intelligence' ) );
		}

		return $rows;
	}

	/**
	 * Normalize header labels.
	 *
	 * @param array<int, string> $headers Raw headers.
	 * @return string[]
	 */
	private function normalize_headers( array $headers ) {
		$normalized = array();
		foreach ( $headers as $index => $header ) {
			$key = strtolower( trim( preg_replace( '/[^a-z0-9]+/', '_', (string) $header ), '_' ) );
			if ( '' === $key ) {
				$key = 'column_' . ( $index + 1 );
			}
			$normalized[] = $key;
		}
		return $normalized;
	}

	/**
	 * Combine headers with values.
	 *
	 * @param string[]             $headers Headers.
	 * @param array<int, string>   $values  Values.
	 * @return array<string, string>
	 */
	private function combine_row( array $headers, array $values ) {
		$row = array();
		foreach ( $headers as $index => $header ) {
			$row[ $header ] = isset( $values[ $index ] ) ? trim( (string) $values[ $index ] ) : '';
		}
		return $row;
	}
}
