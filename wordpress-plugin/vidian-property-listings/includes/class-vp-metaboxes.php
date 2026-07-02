<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Metaboxes {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'save_post_vp_property', array( $this, 'save' ), 10, 2 );
	}

	public function register() {
		add_meta_box( 'vp_hero', 'Card / Hero Info (Location, Title area, Price, Buttons)', array( $this, 'render_hero' ), 'vp_property', 'normal', 'high' );
		add_meta_box( 'vp_gallery', 'Feature Image (use featured image box) + Gallery Images', array( $this, 'render_gallery' ), 'vp_property', 'normal', 'high' );
		add_meta_box( 'vp_stats', 'Icon Stat Boxes (Expected Yields, Completion, Bedrooms, Deposit, Tenure...)', array( $this, 'render_stats' ), 'vp_property', 'normal', 'default' );
		add_meta_box( 'vp_content', 'Summary & Overview', array( $this, 'render_content' ), 'vp_property', 'normal', 'default' );
		add_meta_box( 'vp_dev_highlights', 'Development Highlights (icon list)', array( $this, 'render_dev_highlights' ), 'vp_property', 'normal', 'default' );
		add_meta_box( 'vp_amenities', 'Amenities (icon list)', array( $this, 'render_amenities' ), 'vp_property', 'normal', 'default' );
		add_meta_box( 'vp_location_highlights', 'Location Highlights (icon list)', array( $this, 'render_location_highlights' ), 'vp_property', 'normal', 'default' );
		add_meta_box( 'vp_why_invest', 'Why Invest In... (sidebar box)', array( $this, 'render_why_invest' ), 'vp_property', 'side', 'default' );
		add_meta_box( 'vp_map', 'Map', array( $this, 'render_map' ), 'vp_property', 'side', 'default' );
		add_meta_box( 'vp_notify', 'Inquiry Notification Email (optional override)', array( $this, 'render_notify' ), 'vp_property', 'side', 'default' );
	}

	private static function nonce_field() {
		wp_nonce_field( 'vp_save_meta', 'vp_meta_nonce' );
	}

	private static function text_row( $label, $name, $value, $placeholder = '' ) {
		echo '<p><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
		echo '<input type="text" style="width:100%;" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '" /></p>';
	}

	private static function textarea_row( $label, $name, $value, $rows = 4 ) {
		echo '<p><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
		echo '<textarea style="width:100%;" rows="' . intval( $rows ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea></p>';
	}

	/* ---------------- HERO / CARD ---------------- */
	public function render_hero( $post ) {
		self::nonce_field();
		$location   = get_post_meta( $post->ID, '_vp_location', true );
		$price      = get_post_meta( $post->ID, '_vp_price', true );
		$price_lbl  = get_post_meta( $post->ID, '_vp_price_label', true ) ?: 'Prices From';
		$card_txt   = get_post_meta( $post->ID, '_vp_card_button_text', true ) ?: 'View Developments';
		$card_link  = get_post_meta( $post->ID, '_vp_card_button_link', true );
		$cta_txt    = get_post_meta( $post->ID, '_vp_cta_button_text', true ) ?: 'Book Your Strategy Call';
		$cta_link   = get_post_meta( $post->ID, '_vp_cta_button_link', true );

		echo '<div style="display:flex;gap:20px;flex-wrap:wrap;">';
		echo '<div style="flex:1;min-width:260px;">';
		self::text_row( 'Location (e.g. UK - Manchester)', '_vp_location', $location, 'UK - Manchester' );
		self::text_row( 'Price', '_vp_price', $price, '£300,000' );
		self::text_row( 'Price Label', '_vp_price_label', $price_lbl, 'Prices From' );
		echo '</div><div style="flex:1;min-width:260px;">';
		self::text_row( 'Card Button Text (shown on listing card)', '_vp_card_button_text', $card_txt );
		self::text_row( 'Card Button Link', '_vp_card_button_link', $card_link, 'https://... (leave blank to use property page link)' );
		self::text_row( 'Detail Page CTA Button Text', '_vp_cta_button_text', $cta_txt );
		self::text_row( 'Detail Page CTA Button Link', '_vp_cta_button_link', $cta_link, 'https://calendly.com/...' );
		echo '</div></div>';
		echo '<p style="color:#666;">Title = post title upar. Feature image niche wale box "Feature Image + Gallery" me set karein (ya standard Featured Image box use karein).</p>';
	}

	/* ---------------- GALLERY ---------------- */
	public function render_gallery( $post ) {
		$gallery = get_post_meta( $post->ID, '_vp_gallery', true );
		$ids     = $gallery ? explode( ',', $gallery ) : array();
		$remote_photos = get_post_meta( $post->ID, '_vp_remote_photos', true );
		$remote_photos = is_array( $remote_photos ) ? implode( "\n", $remote_photos ) : '';
		$feature_url = get_post_meta( $post->ID, '_vp_feature_image_url', true );
		echo '<p>Feature image ke liye upar/side "Featured Image" box use karein. Neeche gallery images add karein (jo detail page pr thumbnails/carousel ki tarah scroll hongi).</p>';
		echo '<input type="hidden" id="vp_gallery_ids" name="_vp_gallery" value="' . esc_attr( $gallery ) . '" />';
		echo '<div id="vp_gallery_preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">';
		foreach ( $ids as $id ) {
			if ( ! $id ) continue;
			$src = wp_get_attachment_image_url( $id, 'thumbnail' );
			if ( ! $src ) continue;
			echo '<div class="vp-gallery-item" data-id="' . esc_attr( $id ) . '" style="position:relative;">';
			echo '<img src="' . esc_url( $src ) . '" style="width:90px;height:90px;object-fit:cover;border-radius:4px;border:1px solid #ddd;" />';
			echo '<span class="vp-remove-gallery-item" style="position:absolute;top:-6px;right:-6px;background:#c00;color:#fff;border-radius:50%;width:20px;height:20px;line-height:20px;text-align:center;cursor:pointer;font-weight:bold;">×</span>';
			echo '</div>';
		}
		echo '</div>';
		echo '<button type="button" class="button button-primary" id="vp_add_gallery_images">Add Gallery Images</button>';
		self::text_row( 'Fallback Feature Image URL (optional)', '_vp_feature_image_url', $feature_url, 'https://...' );
		self::textarea_row( 'Remote Gallery Image URLs (one per line)', '_vp_remote_photos', $remote_photos, 6 );
	}

	/* ---------------- STATS ---------------- */
	public function render_stats( $post ) {
		$stats = get_post_meta( $post->ID, '_vp_stats', true );
		if ( ! is_array( $stats ) || empty( $stats ) ) {
			$stats = array(
				array( 'icon' => 'dashicons-chart-bar', 'label' => 'Expected Yields', 'value' => '6%' ),
				array( 'icon' => 'dashicons-calendar-alt', 'label' => 'Completion', 'value' => 'Completed' ),
				array( 'icon' => 'dashicons-admin-multisite', 'label' => 'Bedrooms', 'value' => '1 - 3' ),
				array( 'icon' => 'dashicons-money-alt', 'label' => 'Deposit', 'value' => '25%' ),
				array( 'icon' => 'dashicons-media-document', 'label' => 'Tenure', 'value' => 'Leasehold 999 years' ),
			);
		}
		echo '<p style="color:#666;">Icon field me koi bhi <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">Dashicon</a> class daalein, e.g. <code>dashicons-chart-bar</code></p>';
		echo '<div id="vp_repeater_stats" class="vp-repeater">';
		foreach ( $stats as $i => $row ) {
			self::stat_row( $row );
		}
		echo '</div>';
		echo '<button type="button" class="button vp-add-row" data-target="vp_repeater_stats" data-type="stat">+ Add Stat Box</button>';
		echo '<script type="text/template" id="vp_tmpl_stat">'; self::stat_row( array( 'icon' => '', 'label' => '', 'value' => '' ) ); echo '</script>';
	}
	private static function stat_row( $row ) {
		echo '<div class="vp-repeater-row" style="display:flex;gap:8px;align-items:center;margin-bottom:8px;">';
		echo '<input type="text" name="_vp_stats_icon[]" value="' . esc_attr( $row['icon'] ) . '" placeholder="dashicons-chart-bar" style="width:180px;" />';
		echo '<input type="text" name="_vp_stats_label[]" value="' . esc_attr( $row['label'] ) . '" placeholder="Label e.g. Expected Yields" style="flex:1;" />';
		echo '<input type="text" name="_vp_stats_value[]" value="' . esc_attr( $row['value'] ) . '" placeholder="Value e.g. 6%" style="flex:1;" />';
		echo '<button type="button" class="button vp-remove-row">Remove</button>';
		echo '</div>';
	}

	/* ---------------- SUMMARY / OVERVIEW ---------------- */
	public function render_content( $post ) {
		$summary  = get_post_meta( $post->ID, '_vp_summary', true );
		$overview = get_post_meta( $post->ID, '_vp_overview', true );
		$summary_label = get_post_meta( $post->ID, '_vp_summary_label', true ) ?: 'Summary';
		$overview_label = get_post_meta( $post->ID, '_vp_overview_label', true ) ?: 'Overview';
		$dev_label = get_post_meta( $post->ID, '_vp_dev_highlights_label', true ) ?: 'Development Highlights';
		$amenities_label = get_post_meta( $post->ID, '_vp_amenities_label', true ) ?: 'Amenities';
		$location_label = get_post_meta( $post->ID, '_vp_location_highlights_label', true ) ?: 'Location Highlights';
		echo '<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;">';
		self::text_row( 'Summary Label', '_vp_summary_label', $summary_label, 'Summary' );
		self::text_row( 'Overview Label', '_vp_overview_label', $overview_label, 'Overview' );
		self::text_row( 'Development Highlights Label', '_vp_dev_highlights_label', $dev_label, 'Development Highlights' );
		self::text_row( 'Amenities Label', '_vp_amenities_label', $amenities_label, 'Amenities' );
		self::text_row( 'Location Highlights Label', '_vp_location_highlights_label', $location_label, 'Location Highlights' );
		echo '</div>';
		self::textarea_row( 'Summary Text', '_vp_summary', $summary, 4 );
		echo '<label style="display:block;font-weight:600;margin:10px 0 4px;">Overview Text</label>';
		wp_editor( $overview, 'vp_overview', array( 'textarea_name' => '_vp_overview', 'textarea_rows' => 8, 'media_buttons' => false ) );
	}

	/* ---------------- REPEATER: icon + text lists (shared renderer) ---------------- */
	private function render_icon_text_list( $post, $meta_key, $default_icon, $box_id, $default_rows = array() ) {
		$items = get_post_meta( $post->ID, $meta_key, true );
		if ( ! is_array( $items ) || empty( $items ) ) $items = $default_rows;
		echo '<p style="color:#666;">Icon field optional hai, khali chor sakte hain (default icon use hoga). Dashicon class daal sakte hain.</p>';
		echo '<div id="' . esc_attr( $box_id ) . '" class="vp-repeater" data-name="' . esc_attr( $meta_key ) . '" data-defaulticon="' . esc_attr( $default_icon ) . '">';
		foreach ( $items as $row ) {
			self::icon_text_row( $meta_key, $row );
		}
		echo '</div>';
		echo '<button type="button" class="button vp-add-row" data-target="' . esc_attr( $box_id ) . '" data-type="icontext" data-name="' . esc_attr( $meta_key ) . '">+ Add Item</button>';
	}
	private static function icon_text_row( $meta_key, $row ) {
		$icon = isset( $row['icon'] ) ? $row['icon'] : '';
		$text = isset( $row['text'] ) ? $row['text'] : '';
		echo '<div class="vp-repeater-row" style="display:flex;gap:8px;align-items:center;margin-bottom:8px;">';
		echo '<input type="text" name="' . esc_attr( $meta_key ) . '_icon[]" value="' . esc_attr( $icon ) . '" placeholder="dashicons-yes" style="width:160px;" />';
		echo '<input type="text" name="' . esc_attr( $meta_key ) . '_text[]" value="' . esc_attr( $text ) . '" placeholder="Item text" style="flex:1;" />';
		echo '<button type="button" class="button vp-remove-row">Remove</button>';
		echo '</div>';
	}

	public function render_dev_highlights( $post ) {
		self::render_icon_text_list( $post, '_vp_dev_highlights', 'dashicons-marker', 'vp_repeater_dev', array(
			array( 'icon' => 'dashicons-marker', 'text' => '556 high-spec apartments, duplexes, and penthouses' ),
			array( 'icon' => 'dashicons-marker', 'text' => 'Five architecturally striking residential towers' ),
		) );
		echo '<script type="text/template" id="vp_tmpl_icontext__vp_dev_highlights">'; self::icon_text_row( '_vp_dev_highlights', array( 'icon' => '', 'text' => '' ) ); echo '</script>';
	}
	public function render_amenities( $post ) {
		self::render_icon_text_list( $post, '_vp_amenities', 'dashicons-yes', 'vp_repeater_amenities', array(
			array( 'icon' => 'dashicons-yes', 'text' => 'Swimming pool, spa, sauna, and steam room' ),
			array( 'icon' => 'dashicons-yes', 'text' => 'Fully equipped gym and fitness studio' ),
		) );
		echo '<script type="text/template" id="vp_tmpl_icontext__vp_amenities">'; self::icon_text_row( '_vp_amenities', array( 'icon' => '', 'text' => '' ) ); echo '</script>';
	}
	public function render_location_highlights( $post ) {
		self::render_icon_text_list( $post, '_vp_location_highlights', 'dashicons-location', 'vp_repeater_loc', array(
			array( 'icon' => 'dashicons-location', 'text' => 'Prime central location near key districts' ),
		) );
		echo '<script type="text/template" id="vp_tmpl_icontext__vp_location_highlights">'; self::icon_text_row( '_vp_location_highlights', array( 'icon' => '', 'text' => '' ) ); echo '</script>';
	}

	/* ---------------- WHY INVEST (sidebar) ---------------- */
	public function render_why_invest( $post ) {
		$title = get_post_meta( $post->ID, '_vp_why_invest_title', true );
		self::text_row( 'Box Title', '_vp_why_invest_title', $title, 'Why Invest In [Property Name]?' );
		self::render_icon_text_list( $post, '_vp_why_invest_items', 'dashicons-star-filled', 'vp_repeater_why', array(
			array( 'icon' => 'dashicons-star-filled', 'text' => 'Prime City Centre Location' ),
		) );
		echo '<script type="text/template" id="vp_tmpl_icontext__vp_why_invest_items">'; self::icon_text_row( '_vp_why_invest_items', array( 'icon' => '', 'text' => '' ) ); echo '</script>';
	}

	/* ---------------- MAP ---------------- */
	public function render_map( $post ) {
		$address  = get_post_meta( $post->ID, '_vp_map_address', true );
		$maplink  = get_post_meta( $post->ID, '_vp_map_link', true );
		self::text_row( 'Address / Location for Map', '_vp_map_address', $address, 'e.g. Manchester, UK or full address' );
		self::text_row( '"Open in Maps" Link (optional)', '_vp_map_link', $maplink, 'https://maps.google.com/?q=...' );
	}

	/* ---------------- NOTIFY EMAIL ---------------- */
	public function render_notify( $post ) {
		$email = get_post_meta( $post->ID, '_vp_notify_email', true );
		self::text_row( 'Send Inquiries To (override)', '_vp_notify_email', $email, 'blank = use global default (Properties > Settings)' );
	}

	/* ---------------- SAVE ---------------- */
	public function save( $post_id, $post ) {
		if ( ! isset( $_POST['vp_meta_nonce'] ) || ! wp_verify_nonce( $_POST['vp_meta_nonce'], 'vp_save_meta' ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		$text_fields = array(
			'_vp_location', '_vp_price', '_vp_price_label',
			'_vp_card_button_text', '_vp_card_button_link',
			'_vp_cta_button_text', '_vp_cta_button_link',
			'_vp_gallery', '_vp_why_invest_title',
			'_vp_map_address', '_vp_map_link', '_vp_notify_email',
			'_vp_feature_image_url',
			'_vp_summary_label', '_vp_overview_label',
			'_vp_dev_highlights_label', '_vp_amenities_label',
			'_vp_location_highlights_label',
		);
		foreach ( $text_fields as $f ) {
			if ( isset( $_POST[ $f ] ) ) {
				update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
			}
		}

		if ( isset( $_POST['_vp_summary'] ) ) {
			update_post_meta( $post_id, '_vp_summary', sanitize_textarea_field( wp_unslash( $_POST['_vp_summary'] ) ) );
		}
		if ( isset( $_POST['_vp_overview'] ) ) {
			update_post_meta( $post_id, '_vp_overview', wp_kses_post( wp_unslash( $_POST['_vp_overview'] ) ) );
		}
		if ( isset( $_POST['_vp_remote_photos'] ) ) {
			$raw_urls = preg_split( '/\r\n|\r|\n/', sanitize_textarea_field( wp_unslash( $_POST['_vp_remote_photos'] ) ) );
			$urls = array();
			foreach ( $raw_urls as $url ) {
				$url = trim( $url );
				if ( $url !== '' ) {
					$urls[] = esc_url_raw( $url );
				}
			}
			update_post_meta( $post_id, '_vp_remote_photos', $urls );
		}

		// Stats repeater
		if ( isset( $_POST['_vp_stats_label'] ) ) {
			$icons  = wp_unslash( $_POST['_vp_stats_icon'] );
			$labels = wp_unslash( $_POST['_vp_stats_label'] );
			$values = wp_unslash( $_POST['_vp_stats_value'] );
			$stats  = array();
			foreach ( $labels as $i => $label ) {
				if ( trim( $label ) === '' && trim( $values[ $i ] ) === '' ) continue;
				$stats[] = array(
					'icon'  => sanitize_text_field( $icons[ $i ] ),
					'label' => sanitize_text_field( $label ),
					'value' => sanitize_text_field( $values[ $i ] ),
				);
			}
			update_post_meta( $post_id, '_vp_stats', $stats );
		}

		// Icon-text repeaters
		$icontext_keys = array( '_vp_dev_highlights', '_vp_amenities', '_vp_location_highlights', '_vp_why_invest_items' );
		foreach ( $icontext_keys as $key ) {
			$icon_field = $key . '_icon';
			$text_field = $key . '_text';
			if ( isset( $_POST[ $text_field ] ) ) {
				$icons = wp_unslash( $_POST[ $icon_field ] );
				$texts = wp_unslash( $_POST[ $text_field ] );
				$rows  = array();
				foreach ( $texts as $i => $t ) {
					if ( trim( $t ) === '' ) continue;
					$rows[] = array(
						'icon' => sanitize_text_field( $icons[ $i ] ),
						'text' => sanitize_text_field( $t ),
					);
				}
				update_post_meta( $post_id, $key, $rows );
			}
		}
	}
}
