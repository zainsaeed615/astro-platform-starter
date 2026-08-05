<?php
/**
 * Upload zone partial.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$allowed = MDR_ACI\Settings::allowed_extensions();
$accept  = implode( ',', array_map( function ( $ext ) {
	return '.' . $ext;
}, $allowed ) );
?>
<div class="mdr-aci__upload-wrap" data-mdr-aci-upload-wrap>
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
			<svg width="48" height="48" viewBox="0 0 24 24" fill="none"><path d="M7 10l5-5 5 5M12 5v12M5 19h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
		</div>
		<p class="mdr-aci__dropzone-title"><?php esc_html_e( 'Drag & drop your shipment file here', 'mdr-ai-carrier-intelligence' ); ?></p>
		<p class="mdr-aci__dropzone-sub"><?php esc_html_e( 'or click to browse — CSV, XLS, XLSX', 'mdr-ai-carrier-intelligence' ); ?></p>
		<p class="mdr-aci__dropzone-file mdr-aci-hidden" data-mdr-aci-selected-file hidden></p>
	</div>
	<p class="mdr-aci__error mdr-aci-hidden" data-mdr-aci-error hidden role="alert"></p>
</div>
