<?php
/**
 * Analytics-based carrier intelligence report generator.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Report_Generator
 */
class Report_Generator {

	/**
	 * Column alias map.
	 *
	 * @var array<string, string[]>
	 */
	private $aliases = array(
		'carrier'   => array( 'carrier', 'carrier_name', 'vendor', 'trucking_company', 'scac' ),
		'origin'    => array( 'origin', 'pickup', 'pickup_city', 'from', 'port', 'origin_city' ),
		'destination' => array( 'destination', 'delivery', 'delivery_city', 'to', 'dest', 'destination_city' ),
		'cost'      => array( 'cost', 'rate', 'amount', 'price', 'total_cost', 'spend', 'charge', 'total' ),
		'date'      => array( 'date', 'ship_date', 'shipment_date', 'pickup_date', 'delivery_date' ),
		'transit'   => array( 'transit', 'transit_days', 'transit_time', 'days_in_transit' ),
		'status'    => array( 'status', 'service_level', 'on_time', 'delivery_status' ),
		'lane'      => array( 'lane', 'lane_id', 'route' ),
		'weight'    => array( 'weight', 'lbs', 'tonnage' ),
		'volume'    => array( 'volume', 'containers', 'loads', 'shipments' ),
	);

	/**
	 * Generate full report from parsed rows.
	 *
	 * @param array<int, array<string, string>> $rows Parsed rows.
	 * @return array<string, mixed>
	 */
	public function generate( array $rows ) {
		$mapped = $this->map_rows( $rows );
		$meta   = array(
			'total_shipments' => count( $mapped ),
			'generated_at'    => gmdate( 'c' ),
			'date_range'      => $this->date_range( $mapped ),
		);

		$report = array(
			'meta'           => $meta,
			'cost_savings'   => $this->cost_savings( $mapped ),
			'carrier_performance' => $this->carrier_performance( $mapped ),
			'routing'        => $this->routing_improvements( $mapped ),
			'lane_analysis'  => $this->lane_analysis( $mapped ),
			'service_levels' => $this->service_level_trends( $mapped ),
			'consolidation'  => $this->consolidation_opportunities( $mapped ),
			'scorecards'     => $this->carrier_scorecards( $mapped ),
		);

		if ( Settings::get_option( 'enable_ai_narrative' ) && Settings::get_option( 'openai_api_key' ) ) {
			$report = $this->maybe_enrich_with_ai( $report, $mapped );
		}

		return $report;
	}

	/**
	 * Map raw rows to canonical fields.
	 *
	 * @param array<int, array<string, string>> $rows Rows.
	 * @return array<int, array<string, mixed>>
	 */
	private function map_rows( array $rows ) {
		$mapped = array();
		foreach ( $rows as $row ) {
			$item = array(
				'carrier'     => $this->find_value( $row, 'carrier' ),
				'origin'      => $this->find_value( $row, 'origin' ),
				'destination' => $this->find_value( $row, 'destination' ),
				'cost'        => $this->parse_number( $this->find_value( $row, 'cost' ) ),
				'date'        => $this->find_value( $row, 'date' ),
				'transit'     => $this->parse_number( $this->find_value( $row, 'transit' ) ),
				'status'      => $this->find_value( $row, 'status' ),
				'lane'        => $this->find_value( $row, 'lane' ),
				'raw'         => $row,
			);

			if ( empty( $item['lane'] ) && ! empty( $item['origin'] ) && ! empty( $item['destination'] ) ) {
				$item['lane'] = $item['origin'] . ' → ' . $item['destination'];
			}

			$mapped[] = $item;
		}
		return $mapped;
	}

	/**
	 * Find value by alias group.
	 *
	 * @param array<string, string> $row Row.
	 * @param string                $key Alias key.
	 * @return string
	 */
	private function find_value( array $row, $key ) {
		if ( ! isset( $this->aliases[ $key ] ) ) {
			return '';
		}
		foreach ( $this->aliases[ $key ] as $alias ) {
			if ( isset( $row[ $alias ] ) && '' !== trim( $row[ $alias ] ) ) {
				return trim( $row[ $alias ] );
			}
		}
		foreach ( $row as $column => $value ) {
			foreach ( $this->aliases[ $key ] as $alias ) {
				if ( false !== strpos( $column, $alias ) && '' !== trim( $value ) ) {
					return trim( $value );
				}
			}
		}
		return '';
	}

	/**
	 * Parse numeric value.
	 *
	 * @param string $value Raw value.
	 * @return float
	 */
	private function parse_number( $value ) {
		$clean = preg_replace( '/[^0-9.\-]/', '', (string) $value );
		return is_numeric( $clean ) ? (float) $clean : 0.0;
	}

	/**
	 * Potential cost savings section.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function cost_savings( array $rows ) {
		$costs = array_filter( array_column( $rows, 'cost' ), function ( $c ) {
			return $c > 0;
		} );

		$total_spend = array_sum( $costs );
		$avg_cost    = ! empty( $costs ) ? $total_spend / count( $costs ) : 0;
		$median      = $this->median( $costs );
		$outliers    = array_filter(
			$rows,
			function ( $row ) use ( $median ) {
				return $row['cost'] > 0 && $row['cost'] > ( $median * 1.2 );
			}
		);

		$potential_savings = 0;
		foreach ( $outliers as $row ) {
			$potential_savings += max( 0, $row['cost'] - $median );
		}

		$savings_pct = $total_spend > 0 ? round( ( $potential_savings / $total_spend ) * 100, 1 ) : 0;

		return array(
			'title'       => __( 'Potential Cost Savings', 'mdr-ai-carrier-intelligence' ),
			'summary'     => sprintf(
				/* translators: 1: savings amount, 2: percentage */
				__( 'We identified approximately $%1$s in potential savings (%2$s%% of total spend) by aligning high-cost shipments to median lane pricing.', 'mdr-ai-carrier-intelligence' ),
				number_format( $potential_savings, 0 ),
				$savings_pct
			),
			'metrics'     => array(
				array( 'label' => __( 'Total Spend Analyzed', 'mdr-ai-carrier-intelligence' ), 'value' => '$' . number_format( $total_spend, 0 ) ),
				array( 'label' => __( 'Average Cost / Load', 'mdr-ai-carrier-intelligence' ), 'value' => '$' . number_format( $avg_cost, 0 ) ),
				array( 'label' => __( 'Potential Savings', 'mdr-ai-carrier-intelligence' ), 'value' => '$' . number_format( $potential_savings, 0 ) ),
				array( 'label' => __( 'High-Cost Outliers', 'mdr-ai-carrier-intelligence' ), 'value' => (string) count( $outliers ) ),
			),
			'insights'    => array(
				sprintf( __( '%d shipments priced above 120%% of the median cost.', 'mdr-ai-carrier-intelligence' ), count( $outliers ) ),
				__( 'Renegotiating top outlier lanes could unlock immediate margin improvement.', 'mdr-ai-carrier-intelligence' ),
				__( 'Consider routing repeat lanes to lower-cost carriers with comparable service.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Carrier performance section.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function carrier_performance( array $rows ) {
		$carriers = array();
		foreach ( $rows as $row ) {
			$name = $row['carrier'] ?: __( 'Unknown Carrier', 'mdr-ai-carrier-intelligence' );
			if ( ! isset( $carriers[ $name ] ) ) {
				$carriers[ $name ] = array( 'loads' => 0, 'spend' => 0, 'transit' => array(), 'on_time' => 0 );
			}
			$carriers[ $name ]['loads']++;
			$carriers[ $name ]['spend'] += $row['cost'];
			if ( $row['transit'] > 0 ) {
				$carriers[ $name ]['transit'][] = $row['transit'];
			}
			if ( $this->is_on_time( $row['status'] ) ) {
				$carriers[ $name ]['on_time']++;
			}
		}

		uasort(
			$carriers,
			function ( $a, $b ) {
				return $b['loads'] <=> $a['loads'];
			}
		);

		$top = array_slice( $carriers, 0, 5, true );
		$list = array();
		foreach ( $top as $name => $data ) {
			$avg_transit = ! empty( $data['transit'] ) ? round( array_sum( $data['transit'] ) / count( $data['transit'] ), 1 ) : 0;
			$on_time_pct = $data['loads'] > 0 ? round( ( $data['on_time'] / $data['loads'] ) * 100 ) : 0;
			$list[] = array(
				'name'        => $name,
				'loads'       => $data['loads'],
				'spend'       => '$' . number_format( $data['spend'], 0 ),
				'avg_transit' => $avg_transit ? $avg_transit . 'd' : '—',
				'on_time'     => $on_time_pct . '%',
			);
		}

		return array(
			'title'   => __( 'Carrier Performance', 'mdr-ai-carrier-intelligence' ),
			'summary' => __( 'Carrier volume, spend concentration, and service reliability across your network.', 'mdr-ai-carrier-intelligence' ),
			'carriers' => $list,
			'insights' => array(
				__( 'Top carriers by volume drive the majority of spend leverage.', 'mdr-ai-carrier-intelligence' ),
				__( 'Compare on-time performance before assigning premium lanes.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Routing improvements section.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function routing_improvements( array $rows ) {
		$lane_costs = array();
		foreach ( $rows as $row ) {
			if ( empty( $row['lane'] ) || $row['cost'] <= 0 ) {
				continue;
			}
			if ( ! isset( $lane_costs[ $row['lane'] ] ) ) {
				$lane_costs[ $row['lane'] ] = array();
			}
			$lane_costs[ $row['lane'] ][] = $row['cost'];
		}

		$opportunities = array();
		foreach ( $lane_costs as $lane => $costs ) {
			if ( count( $costs ) < 2 ) {
				continue;
			}
			$spread = max( $costs ) - min( $costs );
			if ( $spread > 0 ) {
				$opportunities[] = array(
					'lane'    => $lane,
					'spread'  => '$' . number_format( $spread, 0 ),
					'min'     => '$' . number_format( min( $costs ), 0 ),
					'max'     => '$' . number_format( max( $costs ), 0 ),
					'loads'   => count( $costs ),
				);
			}
		}

		usort(
			$opportunities,
			function ( $a, $b ) {
				return (float) str_replace( array( '$', ',' ), '', $b['spread'] ) <=> (float) str_replace( array( '$', ',' ), '', $a['spread'] );
			}
		);

		return array(
			'title'          => __( 'Routing Improvements', 'mdr-ai-carrier-intelligence' ),
			'summary'        => __( 'Lanes with high cost variance indicate routing and carrier selection opportunities.', 'mdr-ai-carrier-intelligence' ),
			'opportunities'  => array_slice( $opportunities, 0, 5 ),
			'insights'       => array(
				__( 'Standardize routing on lowest-cost proven paths for repeat lanes.', 'mdr-ai-carrier-intelligence' ),
				__( 'Investigate lanes with wide cost spreads for accessorial or routing inefficiencies.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Lane analysis section.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function lane_analysis( array $rows ) {
		$lanes = array();
		foreach ( $rows as $row ) {
			if ( empty( $row['lane'] ) ) {
				continue;
			}
			if ( ! isset( $lanes[ $row['lane'] ] ) ) {
				$lanes[ $row['lane'] ] = array( 'loads' => 0, 'spend' => 0 );
			}
			$lanes[ $row['lane'] ]['loads']++;
			$lanes[ $row['lane'] ]['spend'] += $row['cost'];
		}

		uasort(
			$lanes,
			function ( $a, $b ) {
				return $b['loads'] <=> $a['loads'];
			}
		);

		$top_lanes = array();
		foreach ( array_slice( $lanes, 0, 6, true ) as $lane => $data ) {
			$top_lanes[] = array(
				'lane'        => $lane,
				'loads'       => $data['loads'],
				'total_spend' => '$' . number_format( $data['spend'], 0 ),
				'avg_cost'    => '$' . number_format( $data['loads'] ? $data['spend'] / $data['loads'] : 0, 0 ),
			);
		}

		return array(
			'title'   => __( 'Lane Analysis', 'mdr-ai-carrier-intelligence' ),
			'summary' => __( 'Top lanes by volume and spend concentration across your network.', 'mdr-ai-carrier-intelligence' ),
			'lanes'   => $top_lanes,
			'insights' => array(
				__( 'Focus negotiation efforts on highest-volume lanes first.', 'mdr-ai-carrier-intelligence' ),
				__( 'Use lane benchmarks to validate carrier bids in MDR.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Service level trends.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function service_level_trends( array $rows ) {
		$on_time = 0;
		$late    = 0;
		$unknown = 0;
		$transit = array();

		foreach ( $rows as $row ) {
			if ( $this->is_on_time( $row['status'] ) ) {
				$on_time++;
			} elseif ( $this->is_late( $row['status'] ) ) {
				$late++;
			} else {
				$unknown++;
			}
			if ( $row['transit'] > 0 ) {
				$transit[] = $row['transit'];
			}
		}

		$total   = count( $rows );
		$avg_tr  = ! empty( $transit ) ? round( array_sum( $transit ) / count( $transit ), 1 ) : 0;
		$on_pct  = $total ? round( ( $on_time / $total ) * 100 ) : 0;

		return array(
			'title'   => __( 'Service-Level Trends', 'mdr-ai-carrier-intelligence' ),
			'summary' => sprintf(
				/* translators: %s: on-time percentage */
				__( 'Estimated on-time performance at %s%% with an average transit of %s days.', 'mdr-ai-carrier-intelligence' ),
				$on_pct,
				$avg_tr
			),
			'metrics' => array(
				array( 'label' => __( 'On-Time', 'mdr-ai-carrier-intelligence' ), 'value' => (string) $on_time ),
				array( 'label' => __( 'Late', 'mdr-ai-carrier-intelligence' ), 'value' => (string) $late ),
				array( 'label' => __( 'Unclassified', 'mdr-ai-carrier-intelligence' ), 'value' => (string) $unknown ),
				array( 'label' => __( 'Avg Transit', 'mdr-ai-carrier-intelligence' ), 'value' => $avg_tr . 'd' ),
			),
			'insights' => array(
				__( 'Late shipments on repeat lanes may indicate carrier capacity issues.', 'mdr-ai-carrier-intelligence' ),
				__( 'Track service levels alongside rate to avoid false economy on cheap carriers.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Consolidation opportunities.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function consolidation_opportunities( array $rows ) {
		$by_week_lane = array();
		foreach ( $rows as $row ) {
			if ( empty( $row['lane'] ) ) {
				continue;
			}
			$week = $this->week_key( $row['date'] );
			$key  = $week . '|' . $row['lane'];
			if ( ! isset( $by_week_lane[ $key ] ) ) {
				$by_week_lane[ $key ] = array( 'lane' => $row['lane'], 'week' => $week, 'count' => 0, 'spend' => 0 );
			}
			$by_week_lane[ $key ]['count']++;
			$by_week_lane[ $key ]['spend'] += $row['cost'];
		}

		$candidates = array_values(
			array_filter(
				$by_week_lane,
				function ( $item ) {
					return $item['count'] >= 2;
				}
			)
		);

		usort(
			$candidates,
			function ( $a, $b ) {
				return $b['count'] <=> $a['count'];
			}
		);

		$formatted = array();
		foreach ( array_slice( $candidates, 0, 5 ) as $item ) {
			$formatted[] = array(
				'lane'             => $item['lane'],
				'period'           => $item['week'],
				'shipments'        => $item['count'],
				'combined_spend'   => '$' . number_format( $item['spend'], 0 ),
				'recommendation'   => __( 'Consolidate into fewer moves or negotiate volume rate.', 'mdr-ai-carrier-intelligence' ),
			);
		}

		return array(
			'title'       => __( 'Shipment Consolidation Opportunities', 'mdr-ai-carrier-intelligence' ),
			'summary'     => __( 'Repeated lane activity in the same period may be consolidated for better rates.', 'mdr-ai-carrier-intelligence' ),
			'candidates'  => $formatted,
			'insights'    => array(
				__( 'Multiple same-week shipments on one lane are prime consolidation targets.', 'mdr-ai-carrier-intelligence' ),
				__( 'MDR multilane tools can help model consolidated pricing scenarios.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Carrier scorecards.
	 *
	 * @param array<int, array<string, mixed>> $rows Mapped rows.
	 * @return array<string, mixed>
	 */
	private function carrier_scorecards( array $rows ) {
		$carriers = array();
		$costs    = array_filter( array_column( $rows, 'cost' ) );
		$avg_cost = ! empty( $costs ) ? array_sum( $costs ) / count( $costs ) : 0;

		foreach ( $rows as $row ) {
			$name = $row['carrier'] ?: __( 'Unknown Carrier', 'mdr-ai-carrier-intelligence' );
			if ( ! isset( $carriers[ $name ] ) ) {
				$carriers[ $name ] = array(
					'loads'   => 0,
					'spend'   => 0,
					'on_time' => 0,
					'transit' => array(),
				);
			}
			$carriers[ $name ]['loads']++;
			$carriers[ $name ]['spend'] += $row['cost'];
			if ( $this->is_on_time( $row['status'] ) ) {
				$carriers[ $name ]['on_time']++;
			}
			if ( $row['transit'] > 0 ) {
				$carriers[ $name ]['transit'][] = $row['transit'];
			}
		}

		$scorecards = array();
		foreach ( $carriers as $name => $data ) {
			$avg_lane_cost = $data['loads'] ? $data['spend'] / $data['loads'] : 0;
			$cost_score    = $avg_cost > 0 ? max( 0, min( 100, 100 - ( ( ( $avg_lane_cost - $avg_cost ) / $avg_cost ) * 50 ) ) ) : 70;
			$service_score = $data['loads'] ? ( $data['on_time'] / $data['loads'] ) * 100 : 60;
			$transit_avg   = ! empty( $data['transit'] ) ? array_sum( $data['transit'] ) / count( $data['transit'] ) : 0;
			$transit_score = $transit_avg > 0 ? max( 0, min( 100, 100 - ( $transit_avg * 5 ) ) ) : 65;
			$overall       = round( ( $cost_score * 0.4 ) + ( $service_score * 0.4 ) + ( $transit_score * 0.2 ) );

			$recommendation = __( 'Maintain', 'mdr-ai-carrier-intelligence' );
			if ( $overall >= 85 ) {
				$recommendation = __( 'Expand volume', 'mdr-ai-carrier-intelligence' );
			} elseif ( $overall < 65 ) {
				$recommendation = __( 'Review / replace on key lanes', 'mdr-ai-carrier-intelligence' );
			} elseif ( $cost_score < 60 ) {
				$recommendation = __( 'Renegotiate rates', 'mdr-ai-carrier-intelligence' );
			}

			$scorecards[] = array(
				'carrier'        => $name,
				'score'          => $overall,
				'cost_score'     => round( $cost_score ),
				'service_score'  => round( $service_score ),
				'recommendation' => $recommendation,
				'loads'          => $data['loads'],
			);
		}

		usort(
			$scorecards,
			function ( $a, $b ) {
				return $b['score'] <=> $a['score'];
			}
		);

		return array(
			'title'      => __( 'Carrier Scorecards & Recommendations', 'mdr-ai-carrier-intelligence' ),
			'summary'    => __( 'Composite scoring based on cost efficiency, service reliability, and transit performance.', 'mdr-ai-carrier-intelligence' ),
			'scorecards' => array_slice( $scorecards, 0, 6 ),
			'insights'   => array(
				__( 'Prioritize high-score carriers for critical lanes.', 'mdr-ai-carrier-intelligence' ),
				__( 'Use MDR live rates to validate scorecard recommendations in real time.', 'mdr-ai-carrier-intelligence' ),
			),
		);
	}

	/**
	 * Optional OpenAI narrative enrichment.
	 *
	 * @param array<string, mixed>              $report Report.
	 * @param array<int, array<string, mixed>>  $rows   Rows.
	 * @return array<string, mixed>
	 */
	private function maybe_enrich_with_ai( array $report, array $rows ) {
		$api_key = Settings::get_option( 'openai_api_key' );
		if ( empty( $api_key ) ) {
			return $report;
		}

		$payload = wp_json_encode(
			array(
				'shipments' => count( $rows ),
				'sections'  => array(
					'cost_savings'   => $report['cost_savings']['summary'],
					'carrier_performance' => $report['carrier_performance']['summary'],
				),
			)
		);

		$response = wp_remote_post(
			'https://api.openai.com/v1/chat/completions',
			array(
				'timeout' => 20,
				'headers' => array(
					'Authorization' => 'Bearer ' . $api_key,
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode(
					array(
						'model'    => Settings::get_option( 'openai_model', 'gpt-4o-mini' ),
						'messages' => array(
							array(
								'role'    => 'system',
								'content' => 'You are a logistics analyst. Write one concise executive summary sentence for a drayage carrier intelligence report.',
							),
							array(
								'role'    => 'user',
								'content' => $payload,
							),
						),
						'max_tokens' => 120,
					)
				),
			)
		);

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( ! empty( $body['choices'][0]['message']['content'] ) ) {
				$report['executive_summary'] = sanitize_text_field( $body['choices'][0]['message']['content'] );
			}
		}

		return $report;
	}

	/**
	 * Determine on-time from status text.
	 *
	 * @param string $status Status value.
	 * @return bool
	 */
	private function is_on_time( $status ) {
		$status = strtolower( (string) $status );
		return (bool) preg_match( '/on[\s-]?time|delivered|complete|success/', $status );
	}

	/**
	 * Determine late from status text.
	 *
	 * @param string $status Status value.
	 * @return bool
	 */
	private function is_late( $status ) {
		$status = strtolower( (string) $status );
		return (bool) preg_match( '/late|delay|missed|failed/', $status );
	}

	/**
	 * Median of numeric array.
	 *
	 * @param float[] $values Values.
	 * @return float
	 */
	private function median( array $values ) {
		if ( empty( $values ) ) {
			return 0;
		}
		sort( $values );
		$count = count( $values );
		$mid   = (int) floor( $count / 2 );
		return ( 0 === $count % 2 ) ? ( $values[ $mid - 1 ] + $values[ $mid ] ) / 2 : $values[ $mid ];
	}

	/**
	 * Week key from date string.
	 *
	 * @param string $date Date string.
	 * @return string
	 */
	private function week_key( $date ) {
		$timestamp = strtotime( (string) $date );
		if ( ! $timestamp ) {
			return __( 'Unknown period', 'mdr-ai-carrier-intelligence' );
		}
		return gmdate( 'Y-W', $timestamp );
	}

	/**
	 * Date range from rows.
	 *
	 * @param array<int, array<string, mixed>> $rows Rows.
	 * @return string
	 */
	private function date_range( array $rows ) {
		$dates = array();
		foreach ( $rows as $row ) {
			$ts = strtotime( (string) $row['date'] );
			if ( $ts ) {
				$dates[] = $ts;
			}
		}
		if ( empty( $dates ) ) {
			return __( 'Not available', 'mdr-ai-carrier-intelligence' );
		}
		sort( $dates );
		return gmdate( 'M j, Y', $dates[0] ) . ' – ' . gmdate( 'M j, Y', end( $dates ) );
	}
}
