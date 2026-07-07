<?php
/**
 * Admin questionnaires template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bookings = ( new BookingRepository() )->list( array( 'limit' => 50 ) );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Questionnaires', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Client intake responses', 'sacred-spaces-booking' ); ?></p>
	</header>

	<?php foreach ( $bookings as $b ) : ?>
		<?php if ( empty( $b->transformation_goals ) && empty( $b->project_type ) ) { continue; } ?>
		<section class="ssb-card ssb-questionnaire-card">
			<div class="ssb-questionnaire-header">
				<h3><?php echo esc_html( $b->first_name . ' ' . $b->last_name ); ?></h3>
				<span><?php echo esc_html( $b->service_name . ' · ' . gmdate( 'M j, Y', strtotime( $b->booking_date ) ) ); ?></span>
			</div>
			<div class="ssb-questionnaire-body">
				<?php if ( $b->project_type ) : ?>
					<p><strong><?php esc_html_e( 'Project Type:', 'sacred-spaces-booking' ); ?></strong> <?php echo esc_html( $b->project_type ); ?></p>
				<?php endif; ?>
				<?php if ( $b->referral_source ) : ?>
					<p><strong><?php esc_html_e( 'Referral:', 'sacred-spaces-booking' ); ?></strong> <?php echo esc_html( $b->referral_source ); ?></p>
				<?php endif; ?>
				<?php if ( $b->transformation_goals ) : ?>
					<p><strong><?php esc_html_e( 'Transformation Goals:', 'sacred-spaces-booking' ); ?></strong></p>
					<blockquote><?php echo esc_html( $b->transformation_goals ); ?></blockquote>
				<?php endif; ?>
			</div>
		</section>
	<?php endforeach; ?>
</div>
