<?php
/**
 * Widget: Single home – header (badges, title, built/offered by, action buttons).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Header extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_header';
	}

	public function get_title() {
		return __( 'Home: Header', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Header', 'mw-homes' ) ) );

		$this->add_control( 'show_badges', array( 'label' => __( 'Show badges', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'show_by', array( 'label' => __( 'Show built/offered by', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'show_buttons', array( 'label' => __( 'Show buttons (Quote/Brochure/Tour)', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );

		$this->add_control( 'align', array(
			'label'     => __( 'Alignment', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => array(
				'left'   => array( 'title' => __( 'Left', 'mw-homes' ), 'icon' => 'eicon-text-align-left' ),
				'center' => array( 'title' => __( 'Center', 'mw-homes' ), 'icon' => 'eicon-text-align-center' ),
			),
			'default'   => 'left',
			'selectors' => array( '{{WRAPPER}} .mwh-single-header' => 'text-align: {{VALUE}};' ),
		) );

		$this->add_control( 'title_color', array(
			'label'     => __( 'Title color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-single-title' => 'color: {{VALUE}};' ),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s  = $this->get_settings_for_display();
		$id = $this->preview_plan_id();
		if ( ! $id ) {
			$this->empty_notice( __( 'No home found to display.', 'mw-homes' ) );
			return;
		}
		$built   = mwh_get( 'built_by', $id );
		$offered = mwh_get( 'offered_by', $id );
		$tour    = mwh_get( 'tour_url', $id );
		$broch   = mwh_get( 'brochure_url', $id );
		?>
		<div class="mwh-single-header">
			<?php if ( 'yes' === $s['show_badges'] ) : $badges = mwh_badges( $id ); if ( $badges ) : ?>
				<div class="mwh-badges">
					<?php foreach ( $badges as $b ) : ?>
						<span class="mwh-badge mwh-badge--<?php echo esc_attr( $b['type'] ); ?>"><?php echo esc_html( $b['label'] ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; endif; ?>

			<h1 class="mwh-single-title"><?php echo esc_html( get_the_title( $id ) ); ?></h1>

			<?php if ( 'yes' === $s['show_by'] ) : ?>
				<?php if ( $built ) : ?><p class="mwh-single-by"><?php esc_html_e( 'Built by:', 'mw-homes' ); ?> <span><?php echo esc_html( $built ); ?></span></p><?php endif; ?>
				<?php if ( $offered ) : ?><p class="mwh-single-by"><?php esc_html_e( 'Offered by:', 'mw-homes' ); ?> <span><?php echo esc_html( $offered ); ?></span></p><?php endif; ?>
			<?php endif; ?>

			<?php if ( 'yes' === $s['show_buttons'] ) : ?>
				<div class="mwh-single-actions" style="display:flex;gap:10px;flex-wrap:wrap;margin-top:16px">
					<?php echo mwh_quote_button( $id, __( 'Request a Price Quote', 'mw-homes' ) ); // phpcs:ignore ?>
					<?php if ( $broch ) : ?><a class="mwh-btn mwh-btn--dark" href="<?php echo esc_url( $broch ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Brochure', 'mw-homes' ); ?></a><?php endif; ?>
					<?php if ( $tour ) : ?><a class="mwh-btn mwh-btn--dark" href="<?php echo esc_url( $tour ); ?>" target="_blank" rel="noopener"><?php esc_html_e( '3D Tour', 'mw-homes' ); ?></a><?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
