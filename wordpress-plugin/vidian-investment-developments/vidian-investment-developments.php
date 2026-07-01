<?php
/**
 * Plugin Name: Vidian Investment Developments
 * Description: Manage and display premium property investment development pages with galleries, metrics, repeatable sections, enquiry forms, shortcodes, and Elementor widgets.
 * Version: 1.0.0
 * Author: Vidian Capital
 * Text Domain: vidian-investments
 */

if (!defined('ABSPATH')) {
    exit;
}

define('VIDIAN_INVESTMENTS_VERSION', '1.0.0');
define('VIDIAN_INVESTMENTS_FILE', __FILE__);
define('VIDIAN_INVESTMENTS_DIR', plugin_dir_path(__FILE__));
define('VIDIAN_INVESTMENTS_URL', plugin_dir_url(__FILE__));

final class Vidian_Investment_Developments {
    const POST_TYPE = 'vidian_development';
    const TAXONOMY = 'vidian_market';
    const NONCE = 'vidian_development_nonce';

    private static $instance = null;

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomy']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post_' . self::POST_TYPE, [$this, 'save_meta']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_shortcode('vidian_development', [$this, 'development_shortcode']);
        add_shortcode('vidian_developments', [$this, 'developments_shortcode']);
        add_filter('template_include', [$this, 'single_template']);
        add_action('admin_post_vidian_development_enquiry', [$this, 'handle_enquiry']);
        add_action('admin_post_nopriv_vidian_development_enquiry', [$this, 'handle_enquiry']);
        add_action('elementor/widgets/register', [$this, 'register_elementor_widgets']);
    }

    public function register_post_type() {
        register_post_type(self::POST_TYPE, [
            'labels' => [
                'name' => __('Investment Developments', 'vidian-investments'),
                'singular_name' => __('Investment Development', 'vidian-investments'),
                'add_new_item' => __('Add New Development', 'vidian-investments'),
                'edit_item' => __('Edit Development', 'vidian-investments'),
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-building',
            'supports' => ['title', 'thumbnail', 'excerpt'],
            'rewrite' => ['slug' => 'developments'],
            'show_in_rest' => true,
        ]);
    }

    public function register_taxonomy() {
        register_taxonomy(self::TAXONOMY, self::POST_TYPE, [
            'labels' => [
                'name' => __('Markets', 'vidian-investments'),
                'singular_name' => __('Market', 'vidian-investments'),
            ],
            'public' => true,
            'hierarchical' => true,
            'rewrite' => ['slug' => 'investment-market'],
            'show_in_rest' => true,
        ]);
    }

    public function add_meta_boxes() {
        add_meta_box('vidian_development_details', __('Investment Page Builder', 'vidian-investments'), [$this, 'render_meta_box'], self::POST_TYPE, 'normal', 'high');
    }

    public function admin_assets($hook) {
        global $post;

        if (($hook !== 'post.php' && $hook !== 'post-new.php') || !$post || $post->post_type !== self::POST_TYPE) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style('vidian-admin', VIDIAN_INVESTMENTS_URL . 'assets/css/admin.css', [], VIDIAN_INVESTMENTS_VERSION);
        wp_enqueue_script('vidian-admin', VIDIAN_INVESTMENTS_URL . 'assets/js/admin.js', ['jquery'], VIDIAN_INVESTMENTS_VERSION, true);
    }

    public function frontend_assets() {
        wp_enqueue_style('vidian-investments', VIDIAN_INVESTMENTS_URL . 'assets/css/frontend.css', [], VIDIAN_INVESTMENTS_VERSION);
        wp_enqueue_script('vidian-investments', VIDIAN_INVESTMENTS_URL . 'assets/js/frontend.js', [], VIDIAN_INVESTMENTS_VERSION, true);
    }

    private function meta($post_id, $key, $default = '') {
        $value = get_post_meta($post_id, '_vidian_' . $key, true);
        return $value !== '' ? $value : $default;
    }

    private function decode_rows($value) {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode((string) $value, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function render_meta_box($post) {
        wp_nonce_field(self::NONCE, self::NONCE);

        $fields = [
            'subtitle' => __('Subtitle', 'vidian-investments'),
            'status' => __('Status', 'vidian-investments'),
            'location' => __('Location', 'vidian-investments'),
            'market' => __('Market/Country', 'vidian-investments'),
            'price_from' => __('Prices From', 'vidian-investments'),
            'expected_yield' => __('Expected Yields', 'vidian-investments'),
            'completion' => __('Completion', 'vidian-investments'),
            'bedrooms' => __('Bedrooms', 'vidian-investments'),
            'deposit' => __('Deposit', 'vidian-investments'),
            'tenure' => __('Tenure', 'vidian-investments'),
            'cta_heading' => __('CTA Heading', 'vidian-investments'),
            'cta_text' => __('CTA Text', 'vidian-investments'),
        ];

        $gallery_ids = $this->meta($post->ID, 'gallery_ids');
        $keypoints = $this->decode_rows($this->meta($post->ID, 'keypoints'));
        $sections = $this->decode_rows($this->meta($post->ID, 'sections'));
        ?>
        <div class="vidian-admin">
            <p class="vidian-admin__hint">
                Build investment development pages like Waterhouse Gardens: hero metrics, modern clickable gallery, overview, key investment points, flexible sections, and enquiry form.
            </p>

            <div class="vidian-admin__grid">
                <?php foreach ($fields as $key => $label) : ?>
                    <label>
                        <span><?php echo esc_html($label); ?></span>
                        <input type="text" name="vidian_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($this->meta($post->ID, $key)); ?>" />
                    </label>
                <?php endforeach; ?>
            </div>

            <label class="vidian-admin__wide">
                <span><?php esc_html_e('Short Summary', 'vidian-investments'); ?></span>
                <textarea name="vidian_summary" rows="4"><?php echo esc_textarea($this->meta($post->ID, 'summary')); ?></textarea>
            </label>

            <label class="vidian-admin__wide">
                <span><?php esc_html_e('Full Overview', 'vidian-investments'); ?></span>
                <textarea name="vidian_overview" rows="8"><?php echo esc_textarea($this->meta($post->ID, 'overview')); ?></textarea>
            </label>

            <div class="vidian-admin__panel">
                <div class="vidian-admin__panel-head">
                    <h3><?php esc_html_e('Clickable Gallery', 'vidian-investments'); ?></h3>
                    <button type="button" class="button vidian-gallery-select"><?php esc_html_e('Select Gallery Images', 'vidian-investments'); ?></button>
                </div>
                <input type="hidden" name="vidian_gallery_ids" class="vidian-gallery-ids" value="<?php echo esc_attr($gallery_ids); ?>" />
                <div class="vidian-gallery-preview">
                    <?php foreach (array_filter(array_map('absint', explode(',', $gallery_ids))) as $image_id) : ?>
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="vidian-admin__panel">
                <div class="vidian-admin__panel-head">
                    <h3><?php esc_html_e('Key Points / Why Invest', 'vidian-investments'); ?></h3>
                    <button type="button" class="button vidian-add-row" data-target="keypoints"><?php esc_html_e('Add Point', 'vidian-investments'); ?></button>
                </div>
                <div class="vidian-repeater" data-repeater="keypoints">
                    <?php $this->render_keypoint_rows($keypoints); ?>
                </div>
                <textarea class="vidian-json" name="vidian_keypoints"><?php echo esc_textarea(wp_json_encode($keypoints)); ?></textarea>
            </div>

            <div class="vidian-admin__panel">
                <div class="vidian-admin__panel-head">
                    <h3><?php esc_html_e('Flexible Page Sections', 'vidian-investments'); ?></h3>
                    <button type="button" class="button vidian-add-row" data-target="sections"><?php esc_html_e('Add Section', 'vidian-investments'); ?></button>
                </div>
                <div class="vidian-repeater" data-repeater="sections">
                    <?php $this->render_section_rows($sections); ?>
                </div>
                <textarea class="vidian-json" name="vidian_sections"><?php echo esc_textarea(wp_json_encode($sections)); ?></textarea>
            </div>
        </div>
        <?php
    }

    private function render_keypoint_rows($rows) {
        if (empty($rows)) {
            $rows = [['title' => '', 'text' => '']];
        }

        foreach ($rows as $row) {
            ?>
            <div class="vidian-row" data-row="keypoints">
                <input type="text" data-field="title" placeholder="Point title" value="<?php echo esc_attr($row['title'] ?? ''); ?>" />
                <textarea data-field="text" placeholder="Point description"><?php echo esc_textarea($row['text'] ?? ''); ?></textarea>
                <button type="button" class="button-link-delete vidian-remove-row">Remove</button>
            </div>
            <?php
        }
    }

    private function render_section_rows($rows) {
        if (empty($rows)) {
            $rows = [['eyebrow' => '', 'title' => '', 'body' => '', 'bullets' => '']];
        }

        foreach ($rows as $row) {
            ?>
            <div class="vidian-row vidian-row--section" data-row="sections">
                <input type="text" data-field="eyebrow" placeholder="Small label e.g. Amenities" value="<?php echo esc_attr($row['eyebrow'] ?? ''); ?>" />
                <input type="text" data-field="title" placeholder="Section title" value="<?php echo esc_attr($row['title'] ?? ''); ?>" />
                <textarea data-field="body" placeholder="Section description"><?php echo esc_textarea($row['body'] ?? ''); ?></textarea>
                <textarea data-field="bullets" placeholder="Bullets, one per line"><?php echo esc_textarea($row['bullets'] ?? ''); ?></textarea>
                <button type="button" class="button-link-delete vidian-remove-row">Remove</button>
            </div>
            <?php
        }
    }

    public function save_meta($post_id) {
        if (!isset($_POST[self::NONCE]) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[self::NONCE])), self::NONCE)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $text_fields = ['subtitle', 'status', 'location', 'market', 'price_from', 'expected_yield', 'completion', 'bedrooms', 'deposit', 'tenure', 'cta_heading', 'cta_text', 'gallery_ids'];

        foreach ($text_fields as $field) {
            $value = isset($_POST['vidian_' . $field]) ? sanitize_text_field(wp_unslash($_POST['vidian_' . $field])) : '';
            update_post_meta($post_id, '_vidian_' . $field, $value);
        }

        foreach (['summary', 'overview'] as $field) {
            $value = isset($_POST['vidian_' . $field]) ? wp_kses_post(wp_unslash($_POST['vidian_' . $field])) : '';
            update_post_meta($post_id, '_vidian_' . $field, $value);
        }

        foreach (['keypoints', 'sections'] as $field) {
            $raw = isset($_POST['vidian_' . $field]) ? wp_unslash($_POST['vidian_' . $field]) : '[]';
            $decoded = json_decode($raw, true);
            update_post_meta($post_id, '_vidian_' . $field, wp_json_encode(is_array($decoded) ? $decoded : []));
        }
    }

    public function development_shortcode($atts) {
        $atts = shortcode_atts(['id' => 0, 'slug' => ''], $atts, 'vidian_development');
        $post = null;

        if (!empty($atts['id'])) {
            $post = get_post(absint($atts['id']));
        } elseif (!empty($atts['slug'])) {
            $post = get_page_by_path(sanitize_title($atts['slug']), OBJECT, self::POST_TYPE);
        } elseif (is_singular(self::POST_TYPE)) {
            $post = get_post();
        }

        if (!$post || $post->post_type !== self::POST_TYPE) {
            return '<p class="vidian-empty">Development not found.</p>';
        }

        return $this->render_development($post);
    }

    public function developments_shortcode($atts) {
        $atts = shortcode_atts(['limit' => 6, 'market' => ''], $atts, 'vidian_developments');
        $args = [
            'post_type' => self::POST_TYPE,
            'posts_per_page' => absint($atts['limit']),
            'post_status' => 'publish',
        ];

        if (!empty($atts['market'])) {
            $args['tax_query'] = [[
                'taxonomy' => self::TAXONOMY,
                'field' => 'slug',
                'terms' => sanitize_title($atts['market']),
            ]];
        }

        $query = new WP_Query($args);
        ob_start();
        ?>
        <div class="vidian-dev-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php $post_id = get_the_ID(); ?>
                <article class="vidian-dev-card">
                    <a href="<?php the_permalink(); ?>" class="vidian-dev-card__image">
                        <?php if (has_post_thumbnail()) : the_post_thumbnail('large'); else : ?><span></span><?php endif; ?>
                    </a>
                    <div class="vidian-dev-card__body">
                        <p><?php echo esc_html($this->meta($post_id, 'location')); ?></p>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="vidian-dev-card__meta">
                            <span><?php echo esc_html($this->meta($post_id, 'price_from')); ?></span>
                            <span><?php echo esc_html($this->meta($post_id, 'expected_yield')); ?></span>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php
        return ob_get_clean();
    }

    public function single_template($template) {
        if (is_singular(self::POST_TYPE)) {
            return VIDIAN_INVESTMENTS_DIR . 'templates/single-development.php';
        }

        return $template;
    }

    public function render_development($post) {
        $post_id = $post->ID;
        $gallery_ids = array_filter(array_map('absint', explode(',', $this->meta($post_id, 'gallery_ids'))));
        $hero_id = $gallery_ids[0] ?? get_post_thumbnail_id($post_id);
        $metrics = [
            'Prices From' => $this->meta($post_id, 'price_from'),
            'Expected Yields' => $this->meta($post_id, 'expected_yield'),
            'Completion' => $this->meta($post_id, 'completion'),
            'Bedrooms' => $this->meta($post_id, 'bedrooms'),
            'Deposit' => $this->meta($post_id, 'deposit'),
            'Tenure' => $this->meta($post_id, 'tenure'),
        ];
        $keypoints = $this->decode_rows($this->meta($post_id, 'keypoints'));
        $sections = $this->decode_rows($this->meta($post_id, 'sections'));

        ob_start();
        ?>
        <div class="vidian-development">
            <section class="vidian-hero">
                <div class="vidian-hero__media">
                    <?php if ($hero_id) : ?>
                        <?php echo wp_get_attachment_image($hero_id, 'full'); ?>
                    <?php else : ?>
                        <div class="vidian-hero__placeholder"></div>
                    <?php endif; ?>
                </div>
                <div class="vidian-hero__overlay"></div>
                <div class="vidian-wrap vidian-hero__content">
                    <a class="vidian-back" href="<?php echo esc_url(get_post_type_archive_link(self::POST_TYPE)); ?>">All Developments</a>
                    <div class="vidian-status-row">
                        <span><?php echo esc_html($this->meta($post_id, 'status', 'Available')); ?></span>
                        <span><?php echo esc_html($this->meta($post_id, 'location')); ?></span>
                    </div>
                    <h1><?php echo esc_html(get_the_title($post)); ?></h1>
                    <?php if ($this->meta($post_id, 'subtitle')) : ?>
                        <p class="vidian-subtitle"><?php echo esc_html($this->meta($post_id, 'subtitle')); ?></p>
                    <?php endif; ?>
                    <div class="vidian-metrics">
                        <?php foreach ($metrics as $label => $value) : ?>
                            <?php if ($value) : ?>
                                <div>
                                    <span><?php echo esc_html($label); ?></span>
                                    <strong><?php echo esc_html($value); ?></strong>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <?php if (!empty($gallery_ids)) : ?>
                <section class="vidian-gallery vidian-wrap">
                    <div class="vidian-gallery__main">
                        <?php foreach ($gallery_ids as $index => $image_id) : ?>
                            <button class="vidian-gallery__item <?php echo $index === 0 ? 'is-active' : ''; ?>" data-vidian-gallery-item="<?php echo esc_attr($index); ?>" type="button">
                                <?php echo wp_get_attachment_image($image_id, $index === 0 ? 'full' : 'large'); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <div class="vidian-gallery__thumbs">
                        <?php foreach ($gallery_ids as $index => $image_id) : ?>
                            <button data-vidian-gallery-thumb="<?php echo esc_attr($index); ?>" class="<?php echo $index === 0 ? 'is-active' : ''; ?>" type="button">
                                <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="vidian-overview vidian-wrap">
                <div>
                    <p class="vidian-kicker">Summary</p>
                    <p class="vidian-summary"><?php echo wp_kses_post($this->meta($post_id, 'summary')); ?></p>
                    <p class="vidian-kicker">Overview</p>
                    <div class="vidian-richtext"><?php echo wpautop(wp_kses_post($this->meta($post_id, 'overview'))); ?></div>
                </div>
                <?php echo $this->render_enquiry_form($post); ?>
            </section>

            <?php if (!empty($keypoints)) : ?>
                <section class="vidian-section vidian-section--blue">
                    <div class="vidian-wrap">
                        <p class="vidian-kicker">Why Invest</p>
                        <h2>Why Invest in <?php echo esc_html(get_the_title($post)); ?>?</h2>
                        <div class="vidian-point-grid">
                            <?php foreach ($keypoints as $point) : ?>
                                <article>
                                    <h3><?php echo esc_html($point['title'] ?? ''); ?></h3>
                                    <p><?php echo esc_html($point['text'] ?? ''); ?></p>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php foreach ($sections as $index => $section) : ?>
                <section class="vidian-section <?php echo $index % 2 === 0 ? 'vidian-section--light' : 'vidian-section--white'; ?>">
                    <div class="vidian-wrap vidian-section__grid">
                        <div>
                            <p class="vidian-kicker"><?php echo esc_html($section['eyebrow'] ?? ''); ?></p>
                            <h2><?php echo esc_html($section['title'] ?? ''); ?></h2>
                            <?php if (!empty($section['body'])) : ?>
                                <p><?php echo esc_html($section['body']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="vidian-bullets">
                            <?php foreach (array_filter(array_map('trim', explode("\n", $section['bullets'] ?? ''))) as $bullet) : ?>
                                <div><?php echo esc_html($bullet); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>

            <section class="vidian-cta">
                <div class="vidian-wrap">
                    <p class="vidian-kicker">Get In Touch</p>
                    <h2><?php echo esc_html($this->meta($post_id, 'cta_heading', 'Looking to invest in property?')); ?></h2>
                    <p><?php echo esc_html($this->meta($post_id, 'cta_text', 'Request the full investment pack and speak with a strategy-led advisor.')); ?></p>
                    <a href="#vidian-enquiry-<?php echo esc_attr($post_id); ?>">Request Full Investment Details</a>
                </div>
            </section>
        </div>
        <?php
        return ob_get_clean();
    }

    private function render_enquiry_form($post) {
        ob_start();
        ?>
        <form id="vidian-enquiry-<?php echo esc_attr($post->ID); ?>" class="vidian-enquiry" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="vidian_development_enquiry" />
            <input type="hidden" name="development_id" value="<?php echo esc_attr($post->ID); ?>" />
            <?php wp_nonce_field('vidian_development_enquiry_' . $post->ID, 'vidian_enquiry_nonce'); ?>
            <h3>Request information about <?php echo esc_html(get_the_title($post)); ?></h3>
            <?php if (isset($_GET['vidian_enquiry']) && $_GET['vidian_enquiry'] === 'sent') : ?>
                <p class="vidian-enquiry__success">Thank you. Your enquiry has been sent.</p>
            <?php endif; ?>
            <label>Full Name<input type="text" name="full_name" required /></label>
            <label>Email Address<input type="email" name="email" required /></label>
            <label>Phone Number<input type="tel" name="phone" required /></label>
            <p>Your enquiry will be tagged to <?php echo esc_html(get_the_title($post)); ?> so our team can respond with the right information.</p>
            <button type="submit">Request info about <?php echo esc_html(get_the_title($post)); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_enquiry() {
        $development_id = isset($_POST['development_id']) ? absint($_POST['development_id']) : 0;

        if (!$development_id || !isset($_POST['vidian_enquiry_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vidian_enquiry_nonce'])), 'vidian_development_enquiry_' . $development_id)) {
            wp_die(esc_html__('Invalid enquiry request.', 'vidian-investments'));
        }

        $name = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $development = get_the_title($development_id);

        $message = "Development: {$development}\nName: {$name}\nEmail: {$email}\nPhone: {$phone}";
        wp_mail(get_option('admin_email'), 'New investment development enquiry', $message, ['Reply-To: ' . $email]);

        wp_safe_redirect(add_query_arg('vidian_enquiry', 'sent', get_permalink($development_id)) . '#vidian-enquiry-' . $development_id);
        exit;
    }

    public function register_elementor_widgets($widgets_manager) {
        if (!class_exists('\Elementor\Widget_Base')) {
            return;
        }

        require_once VIDIAN_INVESTMENTS_DIR . 'includes/class-vidian-elementor-widgets.php';
        $widgets_manager->register(new Vidian_Elementor_Developments_Grid_Widget());
        $widgets_manager->register(new Vidian_Elementor_Development_Detail_Widget());
    }

    public static function activate() {
        self::instance()->register_post_type();
        self::instance()->register_taxonomy();
        flush_rewrite_rules();
        self::seed_sample();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    private static function seed_sample() {
        $existing = get_page_by_path('waterhouse-gardens', OBJECT, self::POST_TYPE);
        if ($existing) {
            return;
        }

        $post_id = wp_insert_post([
            'post_type' => self::POST_TYPE,
            'post_status' => 'publish',
            'post_title' => 'Waterhouse Gardens',
            'post_name' => 'waterhouse-gardens',
            'post_excerpt' => 'A premium Manchester city centre development designed for strategic property investment.',
        ]);

        if (is_wp_error($post_id) || !$post_id) {
            return;
        }

        wp_set_object_terms($post_id, ['UK', 'Manchester'], self::TAXONOMY);

        $meta = [
            'subtitle' => 'Premium Manchester Property Investment',
            'status' => 'Available',
            'location' => 'Manchester, UK',
            'market' => 'UK',
            'price_from' => '£300,000',
            'expected_yield' => '6%',
            'completion' => 'Completed',
            'bedrooms' => '1 - 3',
            'deposit' => '25%',
            'tenure' => 'Leasehold 999 years',
            'summary' => 'Waterhouse Gardens is a premium residential development in Manchester city centre, offering high-spec 1, 2, and 3-bedroom apartments within a vibrant mixed-use neighbourhood. Positioned in a major regeneration zone, it delivers strong rental demand and long-term capital growth potential.',
            'overview' => 'Waterhouse Gardens is a landmark Manchester property investment opportunity, delivering 556 high-spec apartments across five architecturally striking towers. Designed as a vibrant mixed-use neighbourhood, the development also includes over 30,000 sq. ft of commercial, retail, and leisure space, creating a dynamic destination for modern city living. Located in the heart of Manchester city centre, between key districts such as Greengate, NOMA, and the historic core, the development benefits from excellent connectivity to major employment hubs, universities, and transport links. As part of the wider Great Ducie Street regeneration masterplan, Waterhouse Gardens sits within one of Manchester’s most exciting growth areas.',
            'cta_heading' => 'Looking to invest in Manchester property?',
            'cta_text' => 'Waterhouse Gardens offers a rare opportunity to secure a completed, income-generating asset in a prime Manchester location.',
        ];

        foreach ($meta as $key => $value) {
            update_post_meta($post_id, '_vidian_' . $key, $value);
        }

        update_post_meta($post_id, '_vidian_keypoints', wp_json_encode([
            ['title' => 'Prime City Centre Location', 'text' => 'Situated within walking distance of Manchester’s key business districts, supporting strong tenant demand.'],
            ['title' => 'Strong Capital Growth Potential', 'text' => 'Located in a major regeneration zone driving long-term value appreciation.'],
            ['title' => 'Reliable Rental Income', 'text' => 'Expected yields of 6-6.5%, supported by one of the UK’s strongest rental markets.'],
            ['title' => 'Lifestyle-Led Development', 'text' => 'Premium amenities and high-quality design maximise tenant appeal and retention.'],
        ]));

        update_post_meta($post_id, '_vidian_sections', wp_json_encode([
            ['eyebrow' => 'Development Highlights', 'title' => 'At a Glance', 'body' => '', 'bullets' => "556 high-spec apartments, duplexes, and penthouses\nFive architecturally striking residential towers\n30,000 sq. ft of commercial, retail, and leisure space\nCompleted development ready for occupancy\nLocated within the Great Ducie Street regeneration zone\nDeveloped by leading UK developer Salboy"],
            ['eyebrow' => 'Amenities', 'title' => 'Lifestyle & Facilities', 'body' => 'A premium amenities package designed to improve tenant appeal and retention.', 'bullets' => "Swimming pool, spa, sauna, and steam room\nFully equipped gym and fitness studio\nResidents’ lounge and entertainment spaces\nPrivate dining areas and cinema room\nCo-working spaces and meeting rooms\n24/7 concierge service\nLandscaped podium gardens"],
            ['eyebrow' => 'Location Highlights', 'title' => 'Why the Location Matters', 'body' => '', 'bullets' => "Prime central Manchester location near Greengate, NOMA, and Spinningfields\nWalking distance to major business districts and employment hubs\nClose to Victoria Station and key transport links\nSurrounded by restaurants, retail, and cultural attractions\nNear leading universities, driving strong rental demand\nLocated within a major regeneration area supporting long-term growth"],
        ]));
    }
}

register_activation_hook(__FILE__, ['Vidian_Investment_Developments', 'activate']);
register_deactivation_hook(__FILE__, ['Vidian_Investment_Developments', 'deactivate']);
Vidian_Investment_Developments::instance();
