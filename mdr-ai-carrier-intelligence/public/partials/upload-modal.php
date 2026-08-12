<?php
/**
 * Upload modal — full flow: upload → processing → report.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
$allowed  = MDR_ACI\Settings::allowed_extensions();
$accept   = implode( ',', array_map(
	function ( $ext ) {
		return '.' . $ext;
	},
	$allowed
) );
$max_mb   = (int) $settings['max_upload_mb'];
?>
<div class="mdr-aci mdr-aci__modal mdr-aci__modal--upload mdr-aci-hidden" data-mdr-aci-upload-modal hidden aria-hidden="true" style="<?php echo esc_attr( MDR_ACI\Settings::css_vars_style() ); ?>">
	<div class="mdr-aci__modal-overlay" data-mdr-aci-upload-modal-overlay></div>
	<div class="mdr-aci__modal-dialog mdr-aci__modal-dialog--upload" role="dialog" aria-modal="true" aria-labelledby="mdr-aci-upload-modal-title">
		<div class="mdr-aci__modal-header">
			<h3 id="mdr-aci-upload-modal-title" data-mdr-aci-modal-title><?php esc_html_e( 'Upload Shipment History', 'mdr-ai-carrier-intelligence' ); ?></h3>
			<button type="button" class="mdr-aci__modal-close mdr-aci__modal-close--upload" data-mdr-aci-upload-modal-close aria-label="<?php esc_attr_e( 'Close', 'mdr-ai-carrier-intelligence' ); ?>">
				<span class="mdr-aci__modal-close-x" aria-hidden="true"></span>
			</button>
		</div>

		<div class="mdr-aci__modal-body mdr-aci__modal-body--flow">
			<!-- Step 1: Upload -->
			<div class="mdr-aci__step mdr-aci__step--upload" data-mdr-aci-step="upload">
				<div class="mdr-aci__upload-modal-icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M7 18a4 4 0 010-8 5.5 5.5 0 0111 0 4 4 0 010 8H7z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 12V4m0 0l-3 3m3-3l3 3" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</div>
				<h4 class="mdr-aci__upload-modal-heading"><?php esc_html_e( 'Drop your data here', 'mdr-ai-carrier-intelligence' ); ?></h4>
				<p class="mdr-aci__upload-modal-desc">
					<?php esc_html_e( 'Upload your historical shipment data to receive a custom AI report identifying savings, carrier insights, and routing recommendations.', 'mdr-ai-carrier-intelligence' ); ?>
				</p>

				<div
					class="mdr-aci__dropzone"
					data-mdr-aci-dropzone
					role="button"
					tabindex="0"
					aria-label="<?php esc_attr_e( 'Upload shipment data file', 'mdr-ai-carrier-intelligence' ); ?>"
				>
					<input
						type="file"
						class="mdr-aci__file-input"
						data-mdr-aci-file-input
						accept="<?php echo esc_attr( $accept ); ?>"
						hidden
					/>
					<div class="mdr-aci__dropzone-icon" aria-hidden="true">
						<svg width="36" height="36" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" stroke="currentColor" stroke-width="1.5"/><path d="M14 2v6h6M12 18v-6M9 15l3-3 3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</div>
					<p class="mdr-aci__dropzone-title"><?php esc_html_e( 'Click to browse or drag and drop', 'mdr-ai-carrier-intelligence' ); ?></p>
					<p class="mdr-aci__dropzone-sub">
						<?php
						printf(
							/* translators: %d: max upload size in megabytes */
							esc_html__( 'Supports .CSV, .XLSX, .XLS up to %dMB', 'mdr-ai-carrier-intelligence' ),
							$max_mb
						);
						?>
					</p>
					<p class="mdr-aci__dropzone-file mdr-aci-hidden" data-mdr-aci-selected-file hidden></p>
				</div>

				<p class="mdr-aci__error mdr-aci-hidden" data-mdr-aci-error hidden role="alert"></p>

				<p class="mdr-aci__upload-security">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5"/></svg>
					<?php esc_html_e( 'Your data is encrypted and securely processed.', 'mdr-ai-carrier-intelligence' ); ?>
				</p>
			</div>

			<!-- Step 2: Processing -->
			<div class="mdr-aci__step mdr-aci__step--processing mdr-aci-hidden" data-mdr-aci-step="processing" hidden>
				<div class="mdr-aci__processing-card">
					<div class="mdr-aci__spinner" aria-hidden="true"></div>
					<p class="mdr-aci__loading-text" data-mdr-aci-loading-text><?php esc_html_e( 'Uploading your shipment data…', 'mdr-ai-carrier-intelligence' ); ?></p>
					<div class="mdr-aci__progress">
						<div class="mdr-aci__progress-bar" data-mdr-aci-progress-bar></div>
					</div>
					<span class="mdr-aci__progress-percent" data-mdr-aci-progress-percent>0%</span>
					<p class="mdr-aci__processing-file mdr-aci-hidden" data-mdr-aci-processing-file hidden></p>
				</div>
			</div>

			<!-- Step 3: Report -->
			<div class="mdr-aci__step mdr-aci__step--report mdr-aci-hidden" data-mdr-aci-step="report" hidden>
				<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/report.php'; ?>
			</div>
		</div>
	</div>
</div>
