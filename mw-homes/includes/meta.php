<?php
/**
 * Admin meta boxes for Floor Plans.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Meta {

	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_boxes' ) );
		add_action( 'save_post_home_plan', array( __CLASS__, 'save' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_assets' ) );
	}

	public static function add_boxes() {
		add_meta_box( 'mwh_details', __( 'Home Details', 'mw-homes' ), array( __CLASS__, 'box_details' ), 'home_plan', 'normal', 'high' );
		add_meta_box( 'mwh_media', __( 'Media – 3D Tour, Floor Plan, Gallery & Brochure', 'mw-homes' ), array( __CLASS__, 'box_media' ), 'home_plan', 'normal', 'default' );
		add_meta_box( 'mwh_specs', __( 'Specifications Sheet', 'mw-homes' ), array( __CLASS__, 'box_specs' ), 'home_plan', 'normal', 'default' );
		add_meta_box( 'mwh_flags', __( 'Options', 'mw-homes' ), array( __CLASS__, 'box_flags' ), 'home_plan', 'side', 'default' );
	}

	public static function admin_assets( $hook ) {
		global $post_type;
		if ( 'home_plan' !== $post_type ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_style( 'mwh-admin', MWH_URL . 'assets/css/admin.css', array(), MWH_VERSION );
		wp_enqueue_script( 'mwh-admin', MWH_URL . 'assets/js/admin.js', array( 'jquery' ), MWH_VERSION, true );
	}

	private static function field( $key, $post_id ) {
		return esc_attr( get_post_meta( $post_id, '_mwh_' . $key, true ) );
	}

	/* ---------- Details ---------- */
	public static function box_details( $post ) {
		wp_nonce_field( 'mwh_save', 'mwh_nonce' );
		$id = $post->ID;
		?>
		<div class="mwh-grid">
			<p class="mwh-f"><label><?php esc_html_e( 'Model Number', 'mw-homes' ); ?></label>
				<input type="text" name="mwh_model_number" value="<?php echo self::field( 'model_number', $id ); ?>" placeholder="DVHBSS-8026" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Built By (Manufacturer)', 'mw-homes' ); ?></label>
				<input type="text" name="mwh_built_by" value="<?php echo self::field( 'built_by', $id ); ?>" placeholder="Deer Valley Homebuilders" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Offered By', 'mw-homes' ); ?></label>
				<input type="text" name="mwh_offered_by" value="<?php echo self::field( 'offered_by', $id ); ?>" placeholder="<?php esc_attr_e( 'Leave blank to use site default', 'mw-homes' ); ?>" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Beds', 'mw-homes' ); ?></label>
				<input type="number" step="1" min="0" name="mwh_beds" value="<?php echo self::field( 'beds', $id ); ?>" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Baths', 'mw-homes' ); ?></label>
				<input type="number" step="0.5" min="0" name="mwh_baths" value="<?php echo self::field( 'baths', $id ); ?>" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Square Feet', 'mw-homes' ); ?></label>
				<input type="number" step="1" min="0" name="mwh_sqft" value="<?php echo self::field( 'sqft', $id ); ?>" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Sections', 'mw-homes' ); ?></label>
				<input type="number" step="1" min="1" max="6" name="mwh_sections" value="<?php echo self::field( 'sections', $id ); ?>" placeholder="3" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Width', 'mw-homes' ); ?></label>
				<input type="text" name="mwh_width" value="<?php echo self::field( 'width', $id ); ?>" placeholder="47'0&quot;" /></p>

			<p class="mwh-f"><label><?php esc_html_e( 'Length', 'mw-homes' ); ?></label>
				<input type="text" name="mwh_length" value="<?php echo self::field( 'length', $id ); ?>" placeholder="80'0&quot;" /></p>
		</div>

		<p class="mwh-f mwh-f--full"><label><?php esc_html_e( 'Short Description (card excerpt)', 'mw-homes' ); ?></label>
			<textarea name="mwh_short_desc" rows="3" placeholder="<?php esc_attr_e( 'Innovative high quality three section family home…', 'mw-homes' ); ?>"><?php echo esc_textarea( get_post_meta( $id, '_mwh_short_desc', true ) ); ?></textarea>
			<span class="description"><?php esc_html_e( 'Shown on cards. The main editor content shows on the single page. Leave blank to auto-generate from content.', 'mw-homes' ); ?></span></p>
		<?php
	}

	/* ---------- Media ---------- */
	public static function box_media( $post ) {
		$id     = $post->ID;
		$fp_id  = get_post_meta( $id, '_mwh_floorplan_id', true );
		$gallery = get_post_meta( $id, '_mwh_gallery', true );
		$gids   = $gallery ? array_filter( array_map( 'absint', explode( ',', $gallery ) ) ) : array();
		?>
		<p class="mwh-f mwh-f--full"><label><?php esc_html_e( '3D Tour URL (Matterport / iframe embed link)', 'mw-homes' ); ?></label>
			<input type="url" name="mwh_tour_url" value="<?php echo self::field( 'tour_url', $id ); ?>" placeholder="https://my.matterport.com/show/?m=..." /></p>

		<p class="mwh-f mwh-f--full"><label><?php esc_html_e( 'Brochure URL (PDF)', 'mw-homes' ); ?></label>
			<input type="url" name="mwh_brochure_url" value="<?php echo self::field( 'brochure_url', $id ); ?>" placeholder="https://…/brochure.pdf" /></p>

		<?php $tour_thumb = get_post_meta( $id, '_mwh_tour_thumb_id', true ); ?>
		<div class="mwh-f mwh-f--full">
			<label><?php esc_html_e( '3D Tour Thumbnail (optional)', 'mw-homes' ); ?></label>
			<div class="mwh-media-single" data-target="mwh_tour_thumb_id">
				<div class="mwh-media-preview">
					<?php if ( $tour_thumb ) : ?>
						<?php echo wp_get_attachment_image( $tour_thumb, 'medium' ); ?>
					<?php endif; ?>
				</div>
				<input type="hidden" name="mwh_tour_thumb_id" value="<?php echo esc_attr( $tour_thumb ); ?>" />
				<button type="button" class="button mwh-media-pick"><?php esc_html_e( 'Select image', 'mw-homes' ); ?></button>
				<button type="button" class="button mwh-media-clear"><?php esc_html_e( 'Remove', 'mw-homes' ); ?></button>
			</div>
			<p class="description"><?php esc_html_e( 'Shown on the listing card overlay (right side) and Tours section. Leave empty to use the default 3D Tour graphic.', 'mw-homes' ); ?></p>
		</div>

		<div class="mwh-f mwh-f--full">
			<label><?php esc_html_e( 'Floor Plan Image', 'mw-homes' ); ?></label>
			<div class="mwh-media-single" data-target="mwh_floorplan_id">
				<div class="mwh-media-preview">
					<?php if ( $fp_id ) : ?>
						<?php echo wp_get_attachment_image( $fp_id, 'medium' ); ?>
					<?php endif; ?>
				</div>
				<input type="hidden" name="mwh_floorplan_id" value="<?php echo esc_attr( $fp_id ); ?>" />
				<button type="button" class="button mwh-media-pick"><?php esc_html_e( 'Select image', 'mw-homes' ); ?></button>
				<button type="button" class="button mwh-media-clear"><?php esc_html_e( 'Remove', 'mw-homes' ); ?></button>
			</div>
			<p class="description"><?php esc_html_e( 'Shown as the left overlay on listing cards and the Floor Plan section on the single page. Use the client floor-plan artwork (logo/text in the image is fine).', 'mw-homes' ); ?></p>
		</div>

		<div class="mwh-f mwh-f--full">
			<label><?php esc_html_e( 'Photo Gallery', 'mw-homes' ); ?></label>
			<div class="mwh-media-gallery" data-target="mwh_gallery">
				<ul class="mwh-gallery-list">
					<?php foreach ( $gids as $gid ) : ?>
						<li data-id="<?php echo esc_attr( $gid ); ?>"><?php echo wp_get_attachment_image( $gid, 'thumbnail' ); ?><button type="button" class="mwh-gallery-remove">&times;</button></li>
					<?php endforeach; ?>
				</ul>
				<input type="hidden" name="mwh_gallery" value="<?php echo esc_attr( $gallery ); ?>" />
				<button type="button" class="button mwh-gallery-add"><?php esc_html_e( 'Add images', 'mw-homes' ); ?></button>
			</div>
			<p class="description"><?php esc_html_e( 'The Featured Image (top-right) is the main card photo. These extra images build the single-page gallery.', 'mw-homes' ); ?></p>
		</div>
		<?php
	}

	/* ---------- Specs ---------- */
	public static function box_specs( $post ) {
		$id = $post->ID;
		echo '<p class="description">' . esc_html__( 'Enter one spec per line as "Label: Value" (or "Label | Value"). Each tab becomes a section on the single page spec sheet.', 'mw-homes' ) . '</p>';
		echo '<div class="mwh-spec-tabs">';
		echo '<ul class="mwh-spec-nav">';
		$first = true;
		foreach ( mwh_spec_tabs() as $key => $label ) {
			printf( '<li><a href="#mwh-spec-%1$s" class="%2$s">%3$s</a></li>', esc_attr( $key ), $first ? 'active' : '', esc_html( $label ) );
			$first = false;
		}
		echo '</ul>';
		$first = true;
		foreach ( mwh_spec_tabs() as $key => $label ) {
			$val = get_post_meta( $id, '_mwh_spec_' . $key, true );
			printf(
				'<div id="mwh-spec-%1$s" class="mwh-spec-pane%2$s"><textarea name="mwh_spec_%1$s" rows="10" placeholder="%4$s">%3$s</textarea></div>',
				esc_attr( $key ),
				$first ? ' active' : '',
				esc_textarea( $val ),
				esc_attr__( "Exterior Wall On Center: 16\" OC\nExterior Wall Studs: 2x6", 'mw-homes' )
			);
			$first = false;
		}
		echo '</div>';
	}

	/* ---------- Flags ---------- */
	public static function box_flags( $post ) {
		$id       = $post->ID;
		$featured = get_post_meta( $id, '_mwh_featured', true );
		?>
		<p><label><input type="checkbox" name="mwh_featured" value="yes" <?php checked( $featured, 'yes' ); ?> /> <?php esc_html_e( 'Featured home', 'mw-homes' ); ?></label></p>
		<p class="description"><?php esc_html_e( 'Featured homes get a badge and can be pulled into the Featured Homes grid.', 'mw-homes' ); ?></p>
		<p class="description"><?php esc_html_e( 'Set Manufacturer, Series and Home Type using the boxes in the right column.', 'mw-homes' ); ?></p>
		<?php
	}

	/* ---------- Save ---------- */
	public static function save( $post_id, $post ) {
		if ( ! isset( $_POST['mwh_nonce'] ) || ! wp_verify_nonce( $_POST['mwh_nonce'], 'mwh_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$text_keys = array( 'model_number', 'built_by', 'offered_by', 'beds', 'baths', 'sqft', 'sections', 'width', 'length' );
		foreach ( $text_keys as $k ) {
			if ( isset( $_POST[ 'mwh_' . $k ] ) ) {
				update_post_meta( $post_id, '_mwh_' . $k, sanitize_text_field( wp_unslash( $_POST[ 'mwh_' . $k ] ) ) );
			}
		}

		if ( isset( $_POST['mwh_short_desc'] ) ) {
			update_post_meta( $post_id, '_mwh_short_desc', sanitize_textarea_field( wp_unslash( $_POST['mwh_short_desc'] ) ) );
		}

		foreach ( array( 'tour_url', 'brochure_url' ) as $k ) {
			if ( isset( $_POST[ 'mwh_' . $k ] ) ) {
				update_post_meta( $post_id, '_mwh_' . $k, esc_url_raw( wp_unslash( $_POST[ 'mwh_' . $k ] ) ) );
			}
		}

		update_post_meta( $post_id, '_mwh_floorplan_id', isset( $_POST['mwh_floorplan_id'] ) ? absint( $_POST['mwh_floorplan_id'] ) : 0 );
		update_post_meta( $post_id, '_mwh_tour_thumb_id', isset( $_POST['mwh_tour_thumb_id'] ) ? absint( $_POST['mwh_tour_thumb_id'] ) : 0 );

		if ( isset( $_POST['mwh_gallery'] ) ) {
			$ids = array_filter( array_map( 'absint', explode( ',', wp_unslash( $_POST['mwh_gallery'] ) ) ) );
			update_post_meta( $post_id, '_mwh_gallery', implode( ',', $ids ) );
		}

		foreach ( array_keys( mwh_spec_tabs() ) as $key ) {
			if ( isset( $_POST[ 'mwh_spec_' . $key ] ) ) {
				update_post_meta( $post_id, '_mwh_spec_' . $key, sanitize_textarea_field( wp_unslash( $_POST[ 'mwh_spec_' . $key ] ) ) );
			}
		}

		update_post_meta( $post_id, '_mwh_featured', ( isset( $_POST['mwh_featured'] ) && 'yes' === $_POST['mwh_featured'] ) ? 'yes' : '' );
	}
}

MWH_Meta::init();
