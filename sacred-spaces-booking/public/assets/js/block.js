/**
 * Sacred Spaces Booking Gutenberg Block
 */
(function (wp) {
	const { registerBlockType } = wp.blocks;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { createElement: el, Fragment } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType('sacred-spaces/booking', {
		edit: function (props) {
			const { attributes, setAttributes } = props;
			const blockProps = useBlockProps({
				className: 'ssb-block-preview',
				style: {
					padding: '48px',
					background: '#F6F1E8',
					border: '1px solid #E6DAC5',
					borderRadius: '12px',
					textAlign: 'center',
					fontFamily: 'Georgia, serif'
				}
			});

			return el(Fragment, {},
				el(InspectorControls, {},
					el(PanelBody, { title: __('Booking Settings', 'sacred-spaces-booking') },
						el(ToggleControl, {
							label: __('Show Hero Section', 'sacred-spaces-booking'),
							checked: attributes.showHero !== false,
							onChange: function (val) { setAttributes({ showHero: val }); }
						})
					)
				),
				el('div', blockProps,
					el('h2', { style: { fontSize: '28px', margin: '0 0 12px', color: '#111' } },
						__('Sacred Spaces Booking', 'sacred-spaces-booking')
					),
					el('p', { style: { color: '#6A6A6A', margin: 0 } },
						__('8-step luxury booking wizard will appear here on the frontend.', 'sacred-spaces-booking')
					)
				)
			);
		}
	});
})(window.wp);
