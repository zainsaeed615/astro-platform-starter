<?php
/**
 * Widget: Floor Plans archive with filters + AJAX pagination.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Archive extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_archive';
	}

	public function get_title() {
		return __( 'Floor Plans Archive (Filters)', 'mw-homes' );
	}

	public function get_keywords() {
		return array( 'homes', 'archive', 'filter', 'search', 'floor plans', 'mw' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Archive', 'mw-homes' ) ) );

		$this->add_control( 'per_page', array(
			'label'   => __( 'Homes per page', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 9,
			'min'     => 1,
			'max'     => 48,
		) );

		$this->add_responsive_control( 'columns', array(
			'label'          => __( 'Columns', 'mw-homes' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '3',
			'tablet_default' => '2',
			'mobile_default' => '1',
			'options'        => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
			'selectors'      => array( '{{WRAPPER}} .mwh-grid-results' => '--mwh-cols: {{VALUE}};' ),
		) );

		$this->add_control( 'filters_heading', array( 'label' => __( 'Filters to show', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ) );
		foreach ( array(
			'f_search'       => __( 'Search box', 'mw-homes' ),
			'f_manufacturer' => __( 'Manufacturer', 'mw-homes' ),
			'f_series'       => __( 'Series', 'mw-homes' ),
			'f_type'         => __( 'Home Type', 'mw-homes' ),
			'f_beds'         => __( 'Beds', 'mw-homes' ),
			'f_baths'        => __( 'Baths', 'mw-homes' ),
			'f_sections'     => __( 'Sections', 'mw-homes' ),
			'f_sqft'         => __( 'Square footage', 'mw-homes' ),
			'f_tour'         => __( 'Has 3D tour', 'mw-homes' ),
		) as $key => $label ) {
			$this->add_control( $key, array(
				'label'        => $label,
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',
			) );
		}

		$this->add_control( 'stats_mode', array(
			'label'     => __( 'Specs display', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'labels',
			'options'   => array(
				'labels' => __( 'Text labels (Beds: 3)', 'mw-homes' ),
				'icons'  => __( 'Icons', 'mw-homes' ),
			),
			'separator' => 'before',
		) );

		$this->add_control( 'show_excerpt', array(
			'label'   => __( 'Show short description on cards', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => '',
		) );

		$this->end_controls_section();

		$this->register_card_style_controls( '{{WRAPPER}} .mwh-grid-results' );
	}

	private function term_select( $tax, $name, $label ) {
		$terms = get_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return;
		}
		echo '<div class="mwh-filter"><label>' . esc_html( $label ) . '</label><select data-filter="' . esc_attr( $name ) . '"><option value="">' . esc_html__( 'All', 'mw-homes' ) . '</option>';
		foreach ( $terms as $t ) {
			printf( '<option value="%s">%s</option>', esc_attr( $t->slug ), esc_html( $t->name ) );
		}
		echo '</select></div>';
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$per_page = (int) ( $s['per_page'] ? $s['per_page'] : 9 );
		$stats    = ! empty( $s['stats_mode'] ) ? $s['stats_mode'] : 'labels';
		$excerpt  = ( 'yes' === $s['show_excerpt'] ) ? '1' : '0';
		?>
		<div class="mwh-archive" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-stats-mode="<?php echo esc_attr( $stats ); ?>" data-show-excerpt="<?php echo esc_attr( $excerpt ); ?>">
			<aside class="mwh-filters">
				<h4><?php esc_html_e( 'Filter Homes', 'mw-homes' ); ?></h4>

				<?php if ( 'yes' === $s['f_search'] ) : ?>
					<div class="mwh-filter"><label><?php esc_html_e( 'Search', 'mw-homes' ); ?></label>
						<input type="text" data-filter="s" placeholder="<?php esc_attr_e( 'Keyword…', 'mw-homes' ); ?>" /></div>
				<?php endif; ?>

				<?php if ( 'yes' === $s['f_manufacturer'] ) { $this->term_select( 'mwh_manufacturer', 'mwh_manufacturer', __( 'Manufacturer', 'mw-homes' ) ); } ?>
				<?php if ( 'yes' === $s['f_series'] ) { $this->term_select( 'mwh_series', 'mwh_series', __( 'Series', 'mw-homes' ) ); } ?>
				<?php if ( 'yes' === $s['f_type'] ) { $this->term_select( 'mwh_type', 'mwh_type', __( 'Home Type', 'mw-homes' ) ); } ?>

				<?php if ( 'yes' === $s['f_beds'] ) : ?>
					<div class="mwh-filter"><label><?php esc_html_e( 'Beds', 'mw-homes' ); ?></label>
						<select data-filter="beds"><option value=""><?php esc_html_e( 'Any', 'mw-homes' ); ?></option>
							<?php foreach ( array( 1, 2, 3, 4, 5 ) as $n ) { printf( '<option value="%1$d">%1$d+</option>', $n ); } ?>
						</select></div>
				<?php endif; ?>

				<?php if ( 'yes' === $s['f_baths'] ) : ?>
					<div class="mwh-filter"><label><?php esc_html_e( 'Baths', 'mw-homes' ); ?></label>
						<select data-filter="baths"><option value=""><?php esc_html_e( 'Any', 'mw-homes' ); ?></option>
							<?php foreach ( array( 2, 3, 4 ) as $n ) { printf( '<option value="%1$d">%1$d+</option>', $n ); } ?>
						</select></div>
				<?php endif; ?>

				<?php if ( 'yes' === $s['f_sections'] ) : ?>
					<div class="mwh-filter"><label><?php esc_html_e( 'Sections', 'mw-homes' ); ?></label>
						<select data-filter="sections"><option value=""><?php esc_html_e( 'Any', 'mw-homes' ); ?></option>
							<?php foreach ( array( 1, 2, 3, 4 ) as $n ) { printf( '<option value="%1$d">%1$d</option>', $n ); } ?>
						</select></div>
				<?php endif; ?>

				<?php if ( 'yes' === $s['f_sqft'] ) : ?>
					<div class="mwh-filter"><label><?php esc_html_e( 'Square Feet', 'mw-homes' ); ?></label>
						<div class="mwh-filter--row">
							<input type="number" data-filter="sqft_min" placeholder="<?php esc_attr_e( 'Min', 'mw-homes' ); ?>" min="0" />
							<input type="number" data-filter="sqft_max" placeholder="<?php esc_attr_e( 'Max', 'mw-homes' ); ?>" min="0" />
						</div></div>
				<?php endif; ?>

				<?php if ( 'yes' === $s['f_tour'] ) : ?>
					<div class="mwh-filter mwh-filter--check">
						<input type="checkbox" id="mwh-hastour-<?php echo esc_attr( $this->get_id() ); ?>" data-filter="has_tour" />
						<label for="mwh-hastour-<?php echo esc_attr( $this->get_id() ); ?>"><?php esc_html_e( 'Has 3D Tour', 'mw-homes' ); ?></label>
					</div>
				<?php endif; ?>

				<button type="button" class="mwh-reset"><?php esc_html_e( 'Reset filters', 'mw-homes' ); ?></button>
			</aside>

			<div class="mwh-archive-main">
				<div class="mwh-result-bar">
					<span><strong class="mwh-result-count">0</strong> <?php esc_html_e( 'homes', 'mw-homes' ); ?></span>
				</div>
				<div class="mwh-grid-results"></div>
				<div class="mwh-pagination"></div>
			</div>
		</div>
		<?php
	}
}
