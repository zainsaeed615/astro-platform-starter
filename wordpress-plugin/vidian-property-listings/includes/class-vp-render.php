<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Render {

	/* -------- CARD (Image 1 style) -------- */
	public static function card( $post_id ) {
		$title    = get_the_title( $post_id );
		$location = get_post_meta( $post_id, '_vp_location', true );
		$price    = get_post_meta( $post_id, '_vp_price', true );
		$price_lbl= get_post_meta( $post_id, '_vp_price_label', true ) ?: 'Prices From';
		$btn_txt  = get_post_meta( $post_id, '_vp_card_button_text', true ) ?: 'View Developments';
		$btn_link = get_post_meta( $post_id, '_vp_card_button_link', true ) ?: get_permalink( $post_id );
		if ( empty( $btn_link ) || $btn_link === '#' ) {
			$btn_link = get_permalink( $post_id );
		}
		$img      = get_the_post_thumbnail_url( $post_id, 'large' );
		$image_style = $img ? "background-image:url('" . esc_url( $img ) . "');" : '';

		ob_start();
		?>
		<a href="<?php echo esc_url( $btn_link ); ?>" class="vp-card">
			<div class="vp-card-img<?php echo $img ? '' : ' vp-card-img--placeholder'; ?>" style="<?php echo esc_attr( $image_style ); ?>">
				<div class="vp-card-overlay"></div>
				<?php if ( $location ) : ?>
					<div class="vp-card-location"><span class="dashicons dashicons-location"></span><?php echo esc_html( $location ); ?></div>
				<?php endif; ?>
				<div class="vp-card-arrow"><span class="dashicons dashicons-arrow-up-alt"></span></div>
				<div class="vp-card-bottom">
					<h3 class="vp-card-title"><?php echo esc_html( $title ); ?></h3>
					<div class="vp-card-row">
						<?php if ( $price ) : ?>
							<div class="vp-card-price"><span class="dashicons dashicons-money-alt"></span><?php echo esc_html( $price_lbl . ' ' . $price ); ?></div>
						<?php endif; ?>
						<span class="vp-card-btn"><?php echo esc_html( $btn_txt ); ?></span>
					</div>
				</div>
			</div>
		</a>
		<?php
		return ob_get_clean();
	}

	/* -------- GRID of cards -------- */
	public static function grid( $args = array() ) {
		$defaults = array( 'posts_per_page' => 6, 'columns' => 3, 'category' => '', 'orderby' => 'date', 'order' => 'DESC' );
		$args = wp_parse_args( $args, $defaults );

		$query_args = array(
			'post_type'      => 'vp_property',
			'posts_per_page' => intval( $args['posts_per_page'] ),
			'post_status'    => 'publish',
			'orderby'        => $args['orderby'],
			'order'          => $args['order'],
		);
		if ( ! empty( $args['category'] ) ) {
			$query_args['tax_query'] = array( array(
				'taxonomy' => 'vp_property_category',
				'field'    => 'slug',
				'terms'    => explode( ',', $args['category'] ),
			) );
		}

		$q = new WP_Query( $query_args );
		if ( ! $q->have_posts() ) return '<p>Koi property nahi mili.</p>';

		ob_start();
		echo '<div class="vp-grid vp-grid-cols-' . intval( $args['columns'] ) . '">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo self::card( get_the_ID() );
		}
		echo '</div>';
		wp_reset_postdata();
		return ob_get_clean();
	}

	/* -------- helper: icon list -------- */
	private static function icon_list( $items, $default_icon, $columns = 2 ) {
		if ( empty( $items ) || ! is_array( $items ) ) return '';
		$out = '<ul class="vp-icon-list vp-icon-list-cols-' . intval( $columns ) . '">';
		foreach ( $items as $item ) {
			$icon = ! empty( $item['icon'] ) ? $item['icon'] : $default_icon;
			$out .= '<li><span class="dashicons ' . esc_attr( $icon ) . '"></span><span>' . esc_html( $item['text'] ) . '</span></li>';
		}
		$out .= '</ul>';
		return $out;
	}

	/* -------- FULL DETAILS (Image 2 style) -------- */
	public static function details( $post_id ) {
		$title      = get_the_title( $post_id );
		$location   = get_post_meta( $post_id, '_vp_location', true );
		$price      = get_post_meta( $post_id, '_vp_price', true );
		$price_lbl  = get_post_meta( $post_id, '_vp_price_label', true ) ?: 'Prices From';
		$cta_txt    = get_post_meta( $post_id, '_vp_cta_button_text', true ) ?: 'Book Your Strategy Call';
		$cta_link   = get_post_meta( $post_id, '_vp_cta_button_link', true ) ?: '#vp-inquiry-form';
		$summary    = get_post_meta( $post_id, '_vp_summary', true );
		$overview   = get_post_meta( $post_id, '_vp_overview', true );
		$stats      = get_post_meta( $post_id, '_vp_stats', true );
		$dev        = get_post_meta( $post_id, '_vp_dev_highlights', true );
		$amenities  = get_post_meta( $post_id, '_vp_amenities', true );
		$loc_high   = get_post_meta( $post_id, '_vp_location_highlights', true );
		$why_title  = get_post_meta( $post_id, '_vp_why_invest_title', true ) ?: ( 'Why Invest In ' . $title . '?' );
		$why_items  = get_post_meta( $post_id, '_vp_why_invest_items', true );
		$map_addr   = get_post_meta( $post_id, '_vp_map_address', true );
		$map_link   = get_post_meta( $post_id, '_vp_map_link', true ) ?: ( $map_addr ? 'https://www.google.com/maps?q=' . urlencode( $map_addr ) : '' );
		$notify     = get_post_meta( $post_id, '_vp_notify_email', true );

		$feat_img   = get_the_post_thumbnail_url( $post_id, 'large' );
		$gallery_m  = get_post_meta( $post_id, '_vp_gallery', true );
		$gallery_ids= $gallery_m ? explode( ',', $gallery_m ) : array();

		ob_start();
		?>
		<div class="vp-details">
			<div class="vp-details-hero">
				<div class="vp-details-hero-left">
					<?php if ( $location ) : ?><div class="vp-loc"><span class="dashicons dashicons-location"></span><?php echo esc_html( $location ); ?></div><?php endif; ?>
					<h1 class="vp-title"><?php echo esc_html( $title ); ?></h1>
					<?php if ( $summary ) : ?><h2 class="vp-subhead">Summary</h2><p class="vp-lead"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					<div class="vp-hero-actions">
						<a class="vp-btn-primary" href="<?php echo esc_url( $cta_link ); ?>"><?php echo esc_html( $cta_txt ); ?></a>
						<?php if ( $price ) : ?>
						<div class="vp-price-badge"><span class="dashicons dashicons-money-alt"></span><div><strong><?php echo esc_html( $price_lbl ); ?></strong><br><?php echo esc_html( $price ); ?></div></div>
						<?php endif; ?>
					</div>
				</div>
				<div class="vp-details-hero-right">
					<?php if ( $feat_img ) : ?><div class="vp-feat-img" style="background-image:url('<?php echo esc_url( $feat_img ); ?>');"></div><?php endif; ?>
					<?php if ( ! empty( $gallery_ids ) ) : ?>
					<div class="vp-gallery-scroll">
						<?php foreach ( $gallery_ids as $gid ) :
							$src = wp_get_attachment_image_url( $gid, 'medium' );
							if ( ! $src ) continue; ?>
							<div class="vp-gallery-thumb" style="background-image:url('<?php echo esc_url( $src ); ?>');"></div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( ! empty( $stats ) ) : ?>
			<div class="vp-stats-row">
				<?php foreach ( $stats as $s ) : ?>
					<div class="vp-stat-box">
						<div class="vp-stat-icon"><span class="dashicons <?php echo esc_attr( $s['icon'] ?: 'dashicons-yes' ); ?>"></span></div>
						<div class="vp-stat-label"><?php echo esc_html( $s['label'] ); ?></div>
						<div class="vp-stat-value"><?php echo esc_html( $s['value'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<div class="vp-details-body">
				<div class="vp-details-main">
					<?php if ( $summary ) : ?>
						<h2>Summary</h2><p><?php echo esc_html( $summary ); ?></p>
					<?php endif; ?>
					<?php if ( $overview ) : ?>
						<h2>Overview</h2><div class="vp-overview"><?php echo wp_kses_post( wpautop( $overview ) ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $dev ) ) : ?>
						<h2>Development Highlights</h2><?php echo self::icon_list( $dev, 'dashicons-marker' ); ?>
					<?php endif; ?>
					<?php if ( ! empty( $amenities ) ) : ?>
						<h2>Amenities</h2><?php echo self::icon_list( $amenities, 'dashicons-yes' ); ?>
					<?php endif; ?>
					<?php if ( ! empty( $loc_high ) ) : ?>
						<h2>Location Highlights</h2><?php echo self::icon_list( $loc_high, 'dashicons-location' ); ?>
					<?php endif; ?>
				</div>

				<div class="vp-details-sidebar">
					<?php if ( ! empty( $why_items ) ) : ?>
					<div class="vp-sidebar-box">
						<h3><?php echo esc_html( $why_title ); ?></h3>
						<?php echo self::icon_list( $why_items, 'dashicons-star-filled', 1 ); ?>
					</div>
					<?php endif; ?>

					<?php if ( $map_addr ) : ?>
					<div class="vp-sidebar-box vp-map-box">
						<?php if ( $map_link ) : ?><a href="<?php echo esc_url( $map_link ); ?>" target="_blank" class="vp-open-maps">Open in Maps ↗</a><?php endif; ?>
						<iframe class="vp-map-iframe" src="https://www.google.com/maps?q=<?php echo rawurlencode( $map_addr ); ?>&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
					<?php endif; ?>

					<div class="vp-sidebar-box vp-form-box" id="vp-inquiry-form">
						<h3>Request Information</h3>
						<form class="vp-inquiry-form" data-property-id="<?php echo esc_attr( $post_id ); ?>">
							<label>Full Name</label>
							<input type="text" name="name" required placeholder="Enter your full name" />
							<label>Email Address</label>
							<input type="email" name="email" required placeholder="email@example.com" />
							<label>Phone Number</label>
							<input type="text" name="phone" placeholder="+44 7700 900000" />
							<label>Message</label>
							<textarea name="message" rows="4" placeholder="Type about your inquiry..."></textarea>
							<button type="submit" class="vp-btn-primary vp-form-submit">Send Message</button>
							<div class="vp-form-response"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
