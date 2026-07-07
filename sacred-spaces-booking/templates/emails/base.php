<?php
/**
 * Base email template.
 *
 * @package SacredSpaces\Booking
 *
 * @var string $title   Email title.
 * @var string $body    Email body HTML.
 * @var object $booking Booking object.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo esc_html( $title ); ?></title>
</head>
<body style="margin:0;padding:0;background-color:#F6F1E8;font-family:'Lato',Arial,sans-serif;">
	<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#F6F1E8;padding:40px 20px;">
		<tr>
			<td align="center">
				<table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color:#FCFAF6;border:1px solid #E6DAC5;border-radius:12px;overflow:hidden;">
					<tr>
						<td style="padding:48px 40px 24px;text-align:center;">
							<h1 style="margin:0;font-family:'Cormorant Garamond',Georgia,serif;font-size:32px;font-weight:500;color:#111111;letter-spacing:0.02em;">
								Sacred Spaces
							</h1>
							<div style="width:60px;height:1px;background:linear-gradient(90deg,transparent,#C9A04F,transparent);margin:20px auto;"></div>
							<p style="margin:0;font-size:13px;text-transform:uppercase;letter-spacing:0.12em;color:#7E8163;">
								<?php echo esc_html( $title ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<td style="padding:0 40px 48px;font-size:16px;line-height:1.7;color:#111111;">
							<?php echo wp_kses_post( $body ); ?>
						</td>
					</tr>
					<tr>
						<td style="padding:24px 40px;background-color:#F6F1E8;text-align:center;border-top:1px solid #E6DAC5;">
							<p style="margin:0;font-size:13px;color:#6A6A6A;">
								&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Sacred Spaces by Sharon<br>
								<a href="https://sacredspacesbysharon.com" style="color:#C9A04F;text-decoration:none;">sacredspacesbysharon.com</a>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
