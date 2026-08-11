<?php
/**
 * Upload modal — opened by the single hero upload button.
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
<div class="mdr-aci__modal mdr-aci__modal--upload mdr-aci-hidden" data-mdr-aci-upload-modal hidden aria-hidden="true">
	<div class="mdr-aci__modal-overlay" data-mdr-aci-upload-modal-overlay></div>
	<div class="mdr-aci__modal-dialog mdr-aci__modal-dialog--upload" role="dialog" aria-modal="true" aria-labelledby="mdr-aci-upload-modal-title">
		<div class="mdr-aci__modal-header">
			<h3 id="mdr-aci-upload-modal-title"><?php esc_html_e( 'Upload Shipment History', 'mdr-ai-carrier-intelligence' ); ?></h3>
			<button type="button" class="mdr-aci__modal-close" data-mdr-aci-upload-modal-close aria-label="<?php esc_attr_e( 'Close', 'mdr-ai-carrier-intelligence' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</button>
		</div>
		<div class="mdr-aci__modal-body mdr-aci__modal-body--upload">
			<div class="mdr-aci__upload-modal-icon" aria-hidden="true">
				<svg width="40" height="40" viewBox="0 0 24 24" fill="none"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 20h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
						esc_html__( 'Supports CSV, XLSX, XLS up to %dMB', 'mdr-ai-carrier-intelligence' ),
						$max_mb
					);
					?>
				</p>
				<p class="mdr-aci__dropzone-file mdr-aci-hidden" data-mdr-aci-selected-file hidden></p>
			</div>

			<p class="mdr-aci__upload-security">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5"/></svg>
				<?php esc_html_e( 'Your data is encrypted and securely processed.', 'mdr-ai-carrier-intelligence' ); ?>
			</p>
		</div>
	</div>
</div>
