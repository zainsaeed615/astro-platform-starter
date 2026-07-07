<?php
/**
 * Services listing template.
 *
 * @package SacredSpaces\Booking
 *
 * @var array<int, object> $services Services list.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ssb-services-list">
	<?php foreach ( $services as $service ) : ?>
		<article class="ssb-service-card">
			<h3 class="ssb-service-card__title"><?php echo esc_html( $service->name ); ?></h3>
			<p class="ssb-service-card__investment"><?php echo esc_html( $service->investment_display ); ?></p>
			<?php if ( (int) $service->duration_minutes > 0 ) : ?>
				<p class="ssb-service-card__duration"><?php echo esc_html( (string) $service->duration_minutes ); ?> <?php esc_html_e( 'Minutes', 'sacred-spaces-booking' ); ?></p>
			<?php endif; ?>
			<p class="ssb-service-card__desc"><?php echo esc_html( $service->description ); ?></p>
			<?php
			$locations = explode( ',', $service->locations );
			if ( ! empty( $locations ) ) :
				?>
				<div class="ssb-service-card__locations">
					<?php foreach ( $locations as $loc ) : ?>
						<span class="ssb-location-tag"><?php echo esc_html( 'in_home' === trim( $loc ) ? __( 'In Home', 'sacred-spaces-booking' ) : __( 'Virtual', 'sacred-spaces-booking' ) ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</article>
	<?php endforeach; ?>
</div>
