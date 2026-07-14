<?php
/**
 * Widget: Single home – tabbed specifications sheet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Specs extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_specs';
	}

	public function get_title() {
		return __( 'Home: Specifications Sheet', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-table-of-contents';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Specifications', 'mw-homes' ) ) );
		$this->add_control( 'style', array(
			'label'   => __( 'Display', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'tabs',
			'options' => array( 'tabs' => __( 'Tabs', 'mw-homes' ), 'stacked' => __( 'Stacked sections', 'mw-homes' ) ),
		) );
		$this->add_control( 'active_color', array(
			'label'     => __( 'Active tab color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array(
				'{{WRAPPER}} .mwh-specs__tab.is-active' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				'{{WRAPPER}} .mwh-specs__nav'           => 'border-bottom-color: {{VALUE}};',
			),
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
		if ( ! mwh_has_specs( $id ) ) {
			$this->empty_notice( __( 'Add specifications to this home (Specifications Sheet box).', 'mw-homes' ) );
			return;
		}

		$tabs   = mwh_spec_tabs();
		$stacked = 'stacked' === $s['style'];
		$uid    = 'mwh-specs-' . $this->get_id();

		echo '<div class="mwh-specs" id="' . esc_attr( $uid ) . '">';

		if ( ! $stacked ) {
			echo '<div class="mwh-specs__nav">';
			$first = true;
			foreach ( $tabs as $key => $label ) {
				if ( ! mwh_get_specs( $key, $id ) ) {
					continue;
				}
				printf( '<button type="button" class="mwh-specs__tab%s" data-tab="%s">%s</button>', $first ? ' is-active' : '', esc_attr( $key ), esc_html( $label ) );
				$first = false;
			}
			echo '</div>';
		}

		$first = true;
		foreach ( $tabs as $key => $label ) {
			$rows = mwh_get_specs( $key, $id );
			if ( ! $rows ) {
				continue;
			}
			$pane_cls = $stacked ? 'mwh-specs__pane is-active' : 'mwh-specs__pane' . ( $first ? ' is-active' : '' );
			echo '<div class="' . esc_attr( $pane_cls ) . '" data-pane="' . esc_attr( $key ) . '">';
			if ( $stacked ) {
				echo '<h4 style="color:var(--mwh-navy);text-transform:uppercase;margin:0 0 6px">' . esc_html( $label ) . '</h4>';
			}
			echo '<ul class="mwh-specs__list">';
			foreach ( $rows as $r ) {
				echo '<li>';
				if ( $r['label'] ) {
					echo '<span class="mwh-spec-row-label">' . esc_html( $r['label'] ) . ':</span> ';
				}
				echo '<span class="mwh-spec-row-val">' . esc_html( $r['value'] ) . '</span>';
				echo '</li>';
			}
			echo '</ul></div>';
			$first = false;
		}

		echo '</div>';

		if ( ! $stacked ) {
			// Inline tab switcher (self-contained so it works everywhere).
			echo '<script>(function(){var r=document.getElementById("' . esc_js( $uid ) . '");if(!r)return;r.querySelectorAll(".mwh-specs__tab").forEach(function(t){t.addEventListener("click",function(){var k=t.getAttribute("data-tab");r.querySelectorAll(".mwh-specs__tab").forEach(function(x){x.classList.remove("is-active")});t.classList.add("is-active");r.querySelectorAll(".mwh-specs__pane").forEach(function(p){p.classList.toggle("is-active",p.getAttribute("data-pane")===k)})})})})();</script>';
		}
	}
}
