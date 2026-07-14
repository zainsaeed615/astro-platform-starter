<?php
/**
 * Seed demo homes on first activation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Seed {

	public static function run() {
		$homes = self::data();
		foreach ( $homes as $home ) {
			// Skip if a plan with this title already exists.
			if ( self::title_exists( $home['title'] ) ) {
				continue;
			}

			$post_id = wp_insert_post( array(
				'post_type'    => 'home_plan',
				'post_status'  => 'publish',
				'post_title'   => $home['title'],
				'post_content' => $home['content'],
			) );

			if ( ! $post_id || is_wp_error( $post_id ) ) {
				continue;
			}

			foreach ( $home['meta'] as $k => $v ) {
				update_post_meta( $post_id, '_mwh_' . $k, $v );
			}
			foreach ( $home['specs'] as $tab => $text ) {
				update_post_meta( $post_id, '_mwh_spec_' . $tab, $text );
			}

			self::set_term( $post_id, 'mwh_manufacturer', $home['manufacturer'] );
			self::set_term( $post_id, 'mwh_series', $home['series'] );
			foreach ( (array) $home['types'] as $type ) {
				self::set_term( $post_id, 'mwh_type', $type, true );
			}
		}
	}

	private static function title_exists( $title ) {
		$q = new WP_Query( array(
			'post_type'      => 'home_plan',
			'post_status'    => 'any',
			'title'          => $title,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		) );
		return ! empty( $q->posts );
	}

	private static function set_term( $post_id, $tax, $name, $append = false ) {
		if ( ! $name ) {
			return;
		}
		$term = term_exists( $name, $tax );
		if ( ! $term ) {
			$term = wp_insert_term( $name, $tax );
		}
		if ( ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, (int) $term['term_id'], $tax, $append );
		}
	}

	private static function data() {
		return array(
			array(
				'title'        => 'Signature Series / The Klasse DVHBSS-8026',
				'manufacturer' => 'Deer Valley Homebuilders',
				'series'       => 'Signature Series',
				'types'        => array( 'Manufactured', 'Modular' ),
				'content'      => 'Innovative high quality three section family home boasts numerous well designed features and elegant amenities including two covered porches, spacious great room open to beautiful bright kitchen, formal dining room, king size bedrooms and luxurious master bedroom featuring luxury ensuite bath.',
				'meta'         => array(
					'model_number' => 'DVHBSS-8026',
					'built_by'     => 'Deer Valley Homebuilders',
					'beds'         => '4',
					'baths'        => '2.50',
					'sqft'         => '2520',
					'width'        => "47'0\"",
					'length'       => "80'0\"",
					'sections'     => '3',
					'short_desc'   => 'The Klasse DVHBSS-8026 / Innovative high quality three section family home boasts numerous well designed features and elegant amenities.',
					'featured'     => 'yes',
				),
				'specs'        => array(
					'construction' => "Exterior Wall On Center: 16\" OC\nExterior Wall Studs: 2x6\nFloor Decking: 23/32\" OSB Tongue and Groove\nFloor Joists: 2x8 (16\" OC HUD)\nInterior Wall Studs: 2x4 Marriage and Interior\nSide Wall Height: 8' Residential Smooth Painted Ceilings\nRoof Decking: Tech Shield\nInsulation: 22-19-40 Energy Star Ready (HUD)\n12\" I-Beams with 8' OC Outriggers\nContinuous Ridge Beam entire home length\nFiber Cement Fascia Plank",
					'exterior'     => "Front Door: (38x82) 3680 Steel with Deadbolt\nRear Door: (38x82) 3680 9 Light Steel with Deadbolt\nShingles: 30 Year Fiberglass Architectural\nSiding: Vinyl Lap with Whole House Wrap; 7/16\" TallWall OSB\nWindow Type: Heritage Windows DP-50 G-7 Enhanced Low E Argon Gas Filled\nWindow Trim: Decorative 4\" over FAUX Blinds\nExterior Lighting: Deluxe Coach Lamps\nExterior Frost Proof Faucet",
					'interior'     => "Baseboards: 4\" Painted throughout\nMolding: 4\" Painted Crown throughout\nWall Finish: 1/2\" Finished Sheetrock throughout\nInterior Doors: 5 Panel with 3 Black Mortis Hinges\nInterior Paint: Sherwin Williams\nCarpet: 25oz. Trackless with 8lb Re-bond Pad\nWindow Treatment: 2\" FAUX Wood Blinds",
					'utilities'    => "Electrical Service: 200 AMP Total; 40/40 Residential Breaker Box\nWater Heater: 50 Gallon Electric\nThermostat: Ecobee Smart\nHeat Duct Registers: Perimeter Floor\nWhole House Water Cut-Off Valve in Utility Room\nDoor Hardware: Black Interior Lever Handles",
					'baths'        => "Master Bath Shower: 48\" Walk-in Fiberglass with Black Door\nGuest Bath: 60\" Fiberglass Tub-Shower\nBathroom Countertops: Solido Edge High Definition\nBathroom Flooring: Hand Laid Tile\nToilet Type: Elongated Commodes\nBathroom Cabinets: KITH KCMA Certified Maple",
					'kitchen'      => "Kitchen Sink: 3322 Residential Stainless Steel Deep\nRefrigerator: 26' Side by Side with Ice & Water in Door\nRange: Designer 30\" Electric\nDishwasher: Deluxe Cycle with Delay Start\nCountertops: Solido Edge High Definition\nCabinetry: 36\"/30\" Staggered Overhead Stained Maple\nMicrowave: Over-the-Range Space Saver",
				),
			),
			array(
				'title'        => 'Disciple Series / The Bethel',
				'manufacturer' => 'BG Manufacturing',
				'series'       => 'Disciple Series',
				'types'        => array( 'Manufactured' ),
				'content'      => 'When your buyers are ready to move up, The Bethel by BG Manufacturing is ready to deliver. Part of the Disciple Series, this home blends comfortable everyday living with standout curb appeal and a smart, open layout.',
				'meta'         => array(
					'model_number' => 'THE BETHEL',
					'built_by'     => 'BG Manufacturing',
					'beds'         => '4',
					'baths'        => '2.00',
					'sqft'         => '2250',
					'width'        => "32'0\"",
					'length'       => "84'0\"",
					'sections'     => '2',
					'short_desc'   => 'When your buyers are ready to move up, The Bethel by BG Manufacturing is ready to deliver. Part of the Disciple Series.',
					'featured'     => 'yes',
				),
				'specs'        => array(
					'construction' => "Exterior Wall On Center: 16\" OC\nExterior Wall Studs: 2x6\nFloor Joists: 2x8 (16\" OC)\nSide Wall Height: 8' Ceilings\nInsulation: R-22 Floor / R-19 Wall / R-40 Roof",
					'exterior'     => "Shingles: 30 Year Architectural\nSiding: Vinyl Lap\nWindows: Low-E Argon Gas Filled\nFront & Rear Steel Doors with Deadbolt",
					'interior'     => "Wall Finish: Finished Sheetrock throughout\nBaseboards: Painted\nCarpet: Trackless with Re-bond Pad\n2\" Faux Wood Blinds",
					'utilities'    => "Electrical Service: 200 AMP\nWater Heater: 50 Gallon Electric\nThermostat: Programmable\nPerimeter Floor Heat Registers",
					'baths'        => "Master Bath: Walk-in Fiberglass Shower\nGuest Bath: Tub-Shower Combo\nHand Laid Tile Flooring\nElongated Commodes",
					'kitchen'      => "Stainless Steel Appliance Package\nStaggered Overhead Cabinets\nDeep Stainless Sink\nIsland with Extra Outlets",
				),
			),
			array(
				'title'        => 'Plantation Series / Biltmore P-7663A',
				'manufacturer' => 'Live Oak Homes',
				'series'       => 'Plantation Series',
				'types'        => array( 'Manufactured' ),
				'content'      => 'The Plantation Series / Biltmore P-7663A built by Live Oak Homes offers upscale design with practical features perfect for growing families, including a spacious kitchen, generous master suite, and welcoming front porch.',
				'meta'         => array(
					'model_number' => 'P-7663A',
					'built_by'     => 'Live Oak Homes',
					'beds'         => '4',
					'baths'        => '3.00',
					'sqft'         => '2346',
					'width'        => "32'0\"",
					'length'       => "70'0\"",
					'sections'     => '2',
					'short_desc'   => 'The Plantation Series / Biltmore P-7663A built by Live Oak Homes offers upscale design with practical features perfect for growing families.',
					'featured'     => 'yes',
				),
				'specs'        => array(
					'construction' => "Exterior Wall On Center: 16\" OC\nExterior Wall Studs: 2x6\nFloor Decking: OSB Tongue and Groove\nSide Wall Height: 8' Ceilings\nInsulation: Energy Star Ready",
					'exterior'     => "Shingles: 30 Year Architectural Fiberglass\nSiding: Vinyl Lap with House Wrap\nLow-E Windows\nDeluxe Coach Lamps",
					'interior'     => "Finished Sheetrock Walls\nPainted Crown Molding\n5-Panel Interior Doors\nName Brand Interior Paint",
					'utilities'    => "200 AMP Electrical Service\n50 Gallon Electric Water Heater\nSmart Thermostat\nUtility Room Cabinets",
					'baths'        => "Master Suite with Walk-in Shower & Soaking Tub\nDouble Vanity\nTile Flooring\nDecorative Beveled Mirrors",
					'kitchen'      => "Full Stainless Appliance Package\nStained Maple Cabinetry\nSolid Surface Countertops\nOver-the-Range Microwave",
				),
			),
		);
	}
}
