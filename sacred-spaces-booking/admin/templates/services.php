<?php
/**
 * Admin services template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\ServiceRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = ( new ServiceRepository() )->get_all();
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Services', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Manage sanctuary experiences', 'sacred-spaces-booking' ); ?></p>
	</header>

	<?php foreach ( $services as $service ) : ?>
		<section class="ssb-card ssb-service-editor" data-service-id="<?php echo esc_attr( (string) $service->id ); ?>">
			<form class="ssb-service-form">
				<input type="hidden" name="id" value="<?php echo esc_attr( (string) $service->id ); ?>">
				<div class="ssb-form-grid">
					<div class="ssb-field">
						<label><?php esc_html_e( 'Name', 'sacred-spaces-booking' ); ?></label>
						<input type="text" name="name" value="<?php echo esc_attr( $service->name ); ?>" class="ssb-input" required>
					</div>
					<div class="ssb-field">
						<label><?php esc_html_e( 'Investment Display', 'sacred-spaces-booking' ); ?></label>
						<input type="text" name="investment_display" value="<?php echo esc_attr( $service->investment_display ); ?>" class="ssb-input">
					</div>
					<div class="ssb-field">
						<label><?php esc_html_e( 'Duration (minutes)', 'sacred-spaces-booking' ); ?></label>
						<input type="number" name="duration_minutes" value="<?php echo esc_attr( (string) $service->duration_minutes ); ?>" class="ssb-input">
					</div>
					<div class="ssb-field">
						<label><?php esc_html_e( 'Locations', 'sacred-spaces-booking' ); ?></label>
						<input type="text" name="locations" value="<?php echo esc_attr( $service->locations ); ?>" class="ssb-input" placeholder="virtual,in_home">
					</div>
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Description', 'sacred-spaces-booking' ); ?></label>
					<textarea name="description" class="ssb-textarea" rows="3"><?php echo esc_textarea( $service->description ); ?></textarea>
				</div>
				<div class="ssb-field ssb-field--checkbox">
					<label>
						<input type="checkbox" name="is_active" value="1" <?php checked( (int) $service->is_active, 1 ); ?>>
						<?php esc_html_e( 'Active', 'sacred-spaces-booking' ); ?>
					</label>
				</div>
				<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Service', 'sacred-spaces-booking' ); ?></button>
			</form>
		</section>
	<?php endforeach; ?>
</div>
