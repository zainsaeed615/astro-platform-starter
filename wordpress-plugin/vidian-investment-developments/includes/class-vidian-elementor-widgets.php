<?php
/**
 * Optional Elementor widgets for Vidian Investment Developments.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Vidian_Elementor_Developments_Grid_Widget') && class_exists('\Elementor\Widget_Base')) {
    class Vidian_Elementor_Developments_Grid_Widget extends \Elementor\Widget_Base {
        public function get_name() {
            return 'vidian_developments_grid';
        }

        public function get_title() {
            return __('Vidian Developments Grid', 'vidian-investments');
        }

        public function get_icon() {
            return 'eicon-gallery-grid';
        }

        public function get_categories() {
            return ['general'];
        }

        protected function register_controls() {
            $this->start_controls_section('content', [
                'label' => __('Content', 'vidian-investments'),
            ]);

            $this->add_control('limit', [
                'label' => __('Number of Developments', 'vidian-investments'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 24,
            ]);

            $this->add_control('market', [
                'label' => __('Market Slug', 'vidian-investments'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'uk',
            ]);

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();
            echo do_shortcode('[vidian_developments limit="' . absint($settings['limit']) . '" market="' . esc_attr($settings['market']) . '"]');
        }
    }
}

if (!class_exists('Vidian_Elementor_Development_Detail_Widget') && class_exists('\Elementor\Widget_Base')) {
    class Vidian_Elementor_Development_Detail_Widget extends \Elementor\Widget_Base {
        public function get_name() {
            return 'vidian_development_detail';
        }

        public function get_title() {
            return __('Vidian Development Detail', 'vidian-investments');
        }

        public function get_icon() {
            return 'eicon-single-page';
        }

        public function get_categories() {
            return ['general'];
        }

        protected function register_controls() {
            $this->start_controls_section('content', [
                'label' => __('Content', 'vidian-investments'),
            ]);

            $this->add_control('slug', [
                'label' => __('Development Slug', 'vidian-investments'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'waterhouse-gardens',
            ]);

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();
            echo do_shortcode('[vidian_development slug="' . sanitize_title($settings['slug']) . '"]');
        }
    }
}
