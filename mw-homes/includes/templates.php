<?php
/**
 * Reusable front-end render helpers (card, stats, quote button).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default 3D tour overlay thumbnail URL.
 */
function mwh_default_tour_thumb() {
	return MWH_URL . 'assets/images/3d-tour-thumb.png';
}

/**
 * Resolve tour overlay image URL for a plan.
 *
 * @param int $post_id Plan ID.
 * @return string
 */
function mwh_tour_thumb_url( $post_id ) {
	$custom = mwh_get( 'tour_thumb_id', $post_id );
	if ( $custom ) {
		$url = wp_get_attachment_image_url( (int) $custom, 'medium' );
		if ( $url ) {
			return $url;
		}
	}
	return mwh_default_tour_thumb();
}

/**
 * Render the 4 stat blocks (beds / baths / sqft / dimensions).
 *
 * @param int    $post_id Plan ID.
 * @param string $mode    'labels' (reference text) or 'icons'.
 */
function mwh_render_stats( $post_id, $mode = 'labels' ) {
	if ( is_bool( $mode ) ) {
		// Back-compat: old $compact bool.
		$mode = $mode ? 'icons' : 'labels';
	}
	$beds  = mwh_get( 'beds', $post_id );
	$baths = mwh_get( 'baths', $post_id );
	$sqft  = mwh_get( 'sqft', $post_id );
	$dim   = mwh_dimensions( $post_id );
	$cls   = 'icons' === $mode ? ' mwh-stats--icons' : '';
	ob_start();
	?>
	<ul class="mwh-stats<?php echo esc_attr( $cls ); ?>">
		<?php if ( '' !== $beds ) : ?>
			<li class="mwh-stat mwh-stat--beds">
				<span class="mwh-stat__ico" aria-hidden="true"></span>
				<span class="mwh-stat__label"><?php esc_html_e( 'Beds:', 'mw-homes' ); ?></span>
				<span class="mwh-stat__val"><?php echo esc_html( $beds ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( '' !== $baths ) : ?>
			<li class="mwh-stat mwh-stat--baths">
				<span class="mwh-stat__ico" aria-hidden="true"></span>
				<span class="mwh-stat__label"><?php esc_html_e( 'Baths:', 'mw-homes' ); ?></span>
				<span class="mwh-stat__val"><?php echo esc_html( $baths ); ?></span>
			</li>
		<?php endif; ?>
		<?php if ( '' !== $sqft ) : ?>
			<li class="mwh-stat mwh-stat--area">
				<span class="mwh-stat__ico" aria-hidden="true"></span>
				<span class="mwh-stat__label"><?php esc_html_e( 'Sq Ft:', 'mw-homes' ); ?></span>
				<span class="mwh-stat__val"><?php echo esc_html( number_format_i18n( (float) $sqft ) ); ?><?php echo 'icons' === $mode ? ' ft²' : ''; ?></span>
			</li>
		<?php endif; ?>
		<?php if ( $dim ) : ?>
			<li class="mwh-stat mwh-stat--dim">
				<span class="mwh-stat__ico" aria-hidden="true"></span>
				<span class="mwh-stat__label"><?php esc_html_e( 'W x L:', 'mw-homes' ); ?></span>
				<span class="mwh-stat__val"><?php echo esc_html( $dim ); ?></span>
			</li>
		<?php endif; ?>
	</ul>
	<?php
	return ob_get_clean();
}

/**
 * Inline meta row for single details panel: BEDS: 3   BATHS: 2.00 …
 */
function mwh_render_details_meta( $post_id ) {
	$beds  = mwh_get( 'beds', $post_id );
	$baths = mwh_get( 'baths', $post_id );
	$sqft  = mwh_get( 'sqft', $post_id );
	$dim   = mwh_dimensions( $post_id );
	$parts = array();
	if ( '' !== $beds ) {
		$parts[] = '<strong>' . esc_html__( 'Beds:', 'mw-homes' ) . '</strong> ' . esc_html( $beds );
	}
	if ( '' !== $baths ) {
		$parts[] = '<strong>' . esc_html__( 'Baths:', 'mw-homes' ) . '</strong> ' . esc_html( $baths );
	}
	if ( '' !== $sqft ) {
		$parts[] = '<strong>' . esc_html__( 'Sq Ft:', 'mw-homes' ) . '</strong> ' . esc_html( number_format_i18n( (float) $sqft ) );
	}
	if ( $dim ) {
		$parts[] = '<strong>' . esc_html__( 'WxL:', 'mw-homes' ) . '</strong> ' . esc_html( $dim );
	}
	if ( ! $parts ) {
		return '';
	}
	return '<div class="mwh-details-meta"><span>' . implode( '</span><span>', $parts ) . '</span></div>';
}

/**
 * A price-quote trigger button. Opens the popup with this plan pre-filled.
 */
function mwh_quote_button( $post_id, $label = '', $class = 'mwh-btn mwh-btn--quote' ) {
	$label = $label ? $label : __( 'Price Quote', 'mw-homes' );
	$title = get_the_title( $post_id );
	$fp_id = mwh_get( 'floorplan_id', $post_id );
	$thumb = $fp_id ? wp_get_attachment_image_url( $fp_id, 'medium' ) : '';
	if ( ! $thumb && has_post_thumbnail( $post_id ) ) {
		$thumb = get_the_post_thumbnail_url( $post_id, 'medium' );
	}
	return sprintf(
		'<button type="button" class="mwh-quote-open %s" data-plan-id="%d" data-plan-title="%s" data-plan-thumb="%s">%s</button>',
		esc_attr( $class ),
		absint( $post_id ),
		esc_attr( $title ),
		esc_url( $thumb ),
		esc_html( $label )
	);
}

/**
 * Specs HTML (tabs).
 *
 * @param int  $id     Plan ID.
 * @param bool $echo   Unused; always returns string.
 * @return string
 */
function mwh_render_specs( $id ) {
	if ( ! mwh_has_specs( $id ) ) {
		return '<div class="mwh-no-specs">' . esc_html__( 'No specification data available', 'mw-homes' ) . '</div>';
	}
	$tabs = mwh_spec_tabs();
	$uid  = 'mwh-specs-' . $id . '-' . wp_unique_id();
	ob_start();
	echo '<div class="mwh-specs" id="' . esc_attr( $uid ) . '">';
	echo '<div class="mwh-specs__nav">';
	$first = true;
	foreach ( $tabs as $key => $label ) {
		if ( ! mwh_get_specs( $key, $id ) ) {
			continue;
		}
		echo '<button type="button" class="mwh-specs__tab' . ( $first ? ' is-active' : '' ) . '" data-tab="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</button>';
		$first = false;
	}
	echo '</div>';
	$first = true;
	foreach ( $tabs as $key => $label ) {
		$rows = mwh_get_specs( $key, $id );
		if ( ! $rows ) {
			continue;
		}
		echo '<div class="mwh-specs__pane' . ( $first ? ' is-active' : '' ) . '" data-pane="' . esc_attr( $key ) . '"><ul class="mwh-specs__list">';
		foreach ( $rows as $r ) {
			echo '<li>';
			if ( $r['label'] ) {
				echo '<span class="mwh-spec-row-label">' . esc_html( $r['label'] ) . ':</span> ';
			}
			echo '<span class="mwh-spec-row-val">' . esc_html( $r['value'] ) . '</span></li>';
		}
		echo '</ul></div>';
		$first = false;
	}
	echo '</div>';
	echo '<script>(function(){var r=document.getElementById("' . esc_js( $uid ) . '");if(!r)return;r.querySelectorAll(".mwh-specs__tab").forEach(function(t){t.addEventListener("click",function(){var k=t.getAttribute("data-tab");r.querySelectorAll(".mwh-specs__tab").forEach(function(x){x.classList.remove("is-active")});t.classList.add("is-active");r.querySelectorAll(".mwh-specs__pane").forEach(function(p){p.classList.toggle("is-active",p.getAttribute("data-pane")===k)})})})})();</script>';
	return ob_get_clean();
}

/**
 * Render a single home card (used by grid + archive).
 *
 * @param int   $post_id Plan ID.
 * @param array $args    Optional: stats_mode => labels|icons, show_excerpt => bool.
 */
function mwh_render_card( $post_id, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'stats_mode'   => 'labels',
			'show_excerpt' => true,
		)
	);

	$title    = get_the_title( $post_id );
	$link     = get_permalink( $post_id );
	$built_by = mwh_get( 'built_by', $post_id );
	$offered  = mwh_get( 'offered_by', $post_id );
	$badges   = mwh_badges( $post_id );
	$tour     = mwh_get( 'tour_url', $post_id );
	$fp_id    = mwh_get( 'floorplan_id', $post_id );
	$excerpt  = mwh_excerpt( $post_id );

	ob_start();
	?>
	<article class="mwh-card" data-id="<?php echo absint( $post_id ); ?>">
		<div class="mwh-card__media">
			<?php if ( $badges ) : ?>
				<div class="mwh-badges">
					<?php foreach ( $badges as $b ) : ?>
						<span class="mwh-badge mwh-badge--<?php echo esc_attr( $b['type'] ); ?>"><?php echo esc_html( $b['label'] ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<a href="<?php echo esc_url( $link ); ?>" class="mwh-card__photo" title="<?php echo esc_attr( $title ); ?>">
				<?php if ( has_post_thumbnail( $post_id ) ) : ?>
					<?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
				<?php else : ?>
					<span class="mwh-card__noimg"></span>
				<?php endif; ?>
			</a>

			<div class="mwh-card__overlays">
				<?php if ( $fp_id ) : ?>
					<?php
					$fp_thumb = wp_get_attachment_image_url( $fp_id, 'medium' );
					$fp_full  = wp_get_attachment_image_url( $fp_id, 'large' );
					?>
					<?php if ( $fp_thumb ) : ?>
						<a href="<?php echo esc_url( $fp_full ? $fp_full : $fp_thumb ); ?>" class="mwh-ov mwh-ov--fp" data-mwh-lightbox title="<?php esc_attr_e( 'Floor Plan', 'mw-homes' ); ?>">
							<img src="<?php echo esc_url( $fp_thumb ); ?>" alt="<?php esc_attr_e( 'Floor plan', 'mw-homes' ); ?>" loading="lazy" />
						</a>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ( $tour ) : ?>
					<a href="<?php echo esc_url( $tour ); ?>" class="mwh-ov mwh-ov--tour" target="_blank" rel="noopener" title="<?php esc_attr_e( '3D Tour', 'mw-homes' ); ?>">
						<img class="mwh-ov__bg" src="<?php echo esc_url( mwh_tour_thumb_url( $post_id ) ); ?>" alt="<?php esc_attr_e( '3D Tour', 'mw-homes' ); ?>" loading="lazy" />
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="mwh-card__body">
			<h3 class="mwh-card__title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h3>
			<?php if ( $built_by ) : ?>
				<p class="mwh-card__by"><?php esc_html_e( 'Built by:', 'mw-homes' ); ?> <span><?php echo esc_html( $built_by ); ?></span></p>
			<?php endif; ?>
			<?php if ( $offered ) : ?>
				<p class="mwh-card__by"><?php esc_html_e( 'Offered by:', 'mw-homes' ); ?> <span><?php echo esc_html( $offered ); ?></span></p>
			<?php endif; ?>

			<?php echo mwh_render_stats( $post_id, $args['stats_mode'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

			<?php if ( $args['show_excerpt'] && $excerpt ) : ?>
				<p class="mwh-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
		</div>

		<div class="mwh-card__actions">
			<a href="<?php echo esc_url( $link ); ?>" class="mwh-btn mwh-btn--info"><?php esc_html_e( 'More Info', 'mw-homes' ); ?></a>
			<?php echo mwh_quote_button( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</article>
	<?php
	return ob_get_clean();
}

/**
 * Render the full single-plan layout (reference order).
 *
 * @param int   $id   Plan ID.
 * @param array $args Options.
 * @return string
 */
function mwh_render_single_layout( $id, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'show_topbar'     => true,
			'show_tour'       => true,
			'embed_tour'      => false,
			'show_floorplan'  => true,
			'show_specs'      => true,
			'show_tours'      => true,
			'show_gallery'    => true,
			'show_disclaimer' => true,
			'archive_url'     => get_post_type_archive_link( 'home_plan' ),
			'disclaimer'      => '',
		)
	);

	$built   = mwh_get( 'built_by', $id );
	$tour    = mwh_get( 'tour_url', $id );
	$broch   = mwh_get( 'brochure_url', $id );
	$fp_id   = mwh_get( 'floorplan_id', $id );
	$badges  = mwh_badges( $id );
	$raw     = get_post_field( 'post_content', $id );
	$content = $raw ? wpautop( do_shortcode( $raw ) ) : '';
	if ( ! trim( wp_strip_all_tags( $content ) ) ) {
		$content = '<p>' . esc_html( mwh_excerpt( $id, 80 ) ) . '</p>';
	}

	$settings   = get_option( 'mwh_settings', array() );
	$disclaimer = $args['disclaimer'];
	if ( ! $disclaimer ) {
		$disclaimer = ! empty( $settings['disclaimer'] )
			? $settings['disclaimer']
			: __( 'All sizes and dimensions are nominal or based on approximate builder measurements. We reserve the right to make changes due to any changes in material, color, specifications and features anytime without notice or obligation.', 'mw-homes' );
	}

	$tour_cover = '';
	if ( has_post_thumbnail( $id ) ) {
		$tour_cover = get_the_post_thumbnail_url( $id, 'large' );
	}
	$custom_cover = mwh_get( 'tour_thumb_id', $id );
	if ( $custom_cover ) {
		$cu = wp_get_attachment_image_url( (int) $custom_cover, 'large' );
		if ( $cu ) {
			$tour_cover = $cu;
		}
	}
	if ( ! $tour_cover ) {
		$tour_cover = mwh_default_tour_thumb();
	}

	ob_start();
	echo '<div class="mwh-single">';

	if ( $args['show_topbar'] ) {
		echo '<div class="mwh-single-topbar">';
		echo '<h1 class="mwh-single-topbar__title">' . esc_html( get_the_title( $id ) ) . '</h1>';
		if ( $args['archive_url'] ) {
			echo '<a class="mwh-single-topbar__back" href="' . esc_url( $args['archive_url'] ) . '">' . esc_html__( 'Back to all floor plans', 'mw-homes' ) . '</a>';
		}
		echo '</div>';
	}

	/* ---- Hero: 3D Tour | Details ---- */
	echo '<div class="mwh-single-hero">';
	echo '<div class="mwh-tour-panel">';
	echo '<h2 class="mwh-h2">' . esc_html__( '3D Tour', 'mw-homes' ) . '</h2>';
	if ( $args['show_tour'] && $tour ) {
		if ( $args['embed_tour'] ) {
			echo '<div class="mwh-tour-panel__embed"><iframe src="' . esc_url( $tour ) . '" allowfullscreen allow="xr-spatial-tracking; fullscreen" loading="lazy" title="' . esc_attr__( '3D Tour', 'mw-homes' ) . '"></iframe></div>';
		} else {
			echo '<div class="mwh-tour-panel__frame">';
			echo '<img class="mwh-tour-cover" src="' . esc_url( $tour_cover ) . '" alt="' . esc_attr__( '3D Tour', 'mw-homes' ) . '" loading="lazy" />';
			echo '<a class="mwh-tour-panel__play" href="' . esc_url( $tour ) . '" target="_blank" rel="noopener" title="' . esc_attr__( 'Launch 3D Tour', 'mw-homes' ) . '"><span class="mwh-tour-panel__play-ico" aria-hidden="true"></span></a>';
			echo '</div>';
		}
	} elseif ( has_post_thumbnail( $id ) ) {
		echo '<div class="mwh-tour-panel__frame">';
		echo get_the_post_thumbnail( $id, 'large' );
		echo '</div>';
	} else {
		echo '<div class="mwh-no-specs">' . esc_html__( 'No 3D tour available.', 'mw-homes' ) . '</div>';
	}
	echo '</div>';

	echo '<div class="mwh-details-panel">';
	echo '<h2 class="mwh-h2">' . esc_html__( 'Floor Plan Details', 'mw-homes' ) . '</h2>';
	if ( $badges ) {
		echo '<div class="mwh-badges">';
		foreach ( $badges as $b ) {
			echo '<span class="mwh-badge mwh-badge--' . esc_attr( $b['type'] ) . '">' . esc_html( $b['label'] ) . '</span>';
		}
		echo '</div>';
	}
	echo mwh_render_details_meta( $id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	if ( $built ) {
		echo '<p class="mwh-details-built"><strong>' . esc_html__( 'Built by:', 'mw-homes' ) . '</strong> ' . esc_html( $built ) . '</p>';
	}
	echo '<div class="mwh-details-desc">' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<div class="mwh-details-actions">';
	if ( $broch ) {
		echo '<a class="mwh-btn mwh-btn--info" href="' . esc_url( $broch ) . '" target="_blank" rel="noopener">' . esc_html__( 'Brochure', 'mw-homes' ) . '</a>';
	}
	echo mwh_quote_button( $id, __( 'Price Quote', 'mw-homes' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</div>';
	echo '</div>';
	echo '</div>';

	/* ---- Floor Plan | Specs ---- */
	echo '<div class="mwh-single-planrow">';
	echo '<div class="mwh-floorplan-panel">';
	echo '<h2 class="mwh-h2">' . esc_html__( 'Floor Plan', 'mw-homes' ) . '</h2>';
	if ( $args['show_floorplan'] && $fp_id ) {
		$full = wp_get_attachment_image_url( $fp_id, 'full' );
		echo '<a class="mwh-floorplan-panel__img" href="' . esc_url( $full ) . '" data-mwh-lightbox>';
		echo wp_get_attachment_image( $fp_id, 'large' );
		echo '</a>';
	} else {
		echo '<div class="mwh-no-specs">' . esc_html__( 'No floor plan image uploaded.', 'mw-homes' ) . '</div>';
	}
	echo '</div>';

	echo '<div class="mwh-specs-panel">';
	echo '<h2 class="mwh-h2">' . esc_html__( 'Floor Plan Specifications', 'mw-homes' ) . '</h2>';
	if ( $args['show_specs'] ) {
		echo mwh_render_specs( $id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div>';
	echo '</div>';

	/* ---- Tours & Videos ---- */
	if ( $args['show_tours'] && $tour ) {
		echo '<div class="mwh-tours">';
		echo '<h2 class="mwh-h2">' . esc_html__( 'Tours & Videos', 'mw-homes' ) . '</h2>';
		echo '<div class="mwh-tours__grid">';
		echo '<a class="mwh-tours__item" href="' . esc_url( $tour ) . '" target="_blank" rel="noopener">';
		echo '<div class="mwh-tours__thumb"><img src="' . esc_url( mwh_tour_thumb_url( $id ) ) . '" alt="' . esc_attr__( '3D Tour', 'mw-homes' ) . '" loading="lazy" /></div>';
		echo '<p class="mwh-tours__cap">' . esc_html__( 'Matterport Tour', 'mw-homes' ) . '</p>';
		echo '</a>';
		echo '</div></div>';
	}

	/* ---- Photo Gallery ---- */
	if ( $args['show_gallery'] ) {
		$gids = mwh_gallery_ids( $id );
		if ( $fp_id ) {
			array_unshift( $gids, (int) $fp_id );
		}
		if ( has_post_thumbnail( $id ) ) {
			$gids[] = get_post_thumbnail_id( $id );
		}
		$gids = array_values( array_unique( array_filter( $gids ) ) );
		if ( $gids ) {
			echo '<div class="mwh-gallery-section" id="mwh-gallery">';
			echo '<h2 class="mwh-h2">' . esc_html__( 'Photo Gallery', 'mw-homes' ) . '</h2>';
			echo '<div class="mwh-gallery">';
			foreach ( $gids as $img ) {
				$full = wp_get_attachment_image_url( $img, 'full' );
				echo '<a href="' . esc_url( $full ) . '" data-mwh-lightbox>' . wp_get_attachment_image( $img, 'medium_large' ) . '</a>';
			}
			echo '</div></div>';
		}
	}

	if ( $args['show_disclaimer'] && $disclaimer ) {
		echo '<div class="mwh-disclaimer"><span class="mwh-disclaimer__ico" aria-hidden="true">!</span><div><strong>' . esc_html__( 'Please Note:', 'mw-homes' ) . '</strong>' . esc_html( $disclaimer ) . '</div></div>';
	}

	echo '</div>';
	return ob_get_clean();
}
