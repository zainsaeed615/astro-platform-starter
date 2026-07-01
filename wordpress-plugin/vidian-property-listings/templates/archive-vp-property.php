<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
?>
<main class="vp-archive-page">
	<section class="vp-archive-hero">
		<div class="vp-archive-wrap">
			<p>Investment Opportunities</p>
			<h1>Property Investment Developments</h1>
			<span>Explore strategy-led UK and Dubai property investment opportunities.</span>
		</div>
	</section>
	<section class="vp-archive-wrap vp-archive-grid-wrap">
		<?php echo VP_Render::grid( array( 'posts_per_page' => -1, 'columns' => 3 ) ); ?>
	</section>
</main>
<?php
get_footer();
