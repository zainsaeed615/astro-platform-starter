jQuery(function ($) {

	// Generic repeater add/remove
	$(document).on('click', '.vp-add-row', function () {
		var target = $('#' + $(this).data('target'));
		var type = $(this).data('type');
		var newRow;

		if (type === 'stat') {
			newRow = $('#vp_tmpl_stat').html();
		} else if (type === 'icontext') {
			var name = $(this).data('name');
			newRow = $('#vp_tmpl_icontext_' + name).html();
		}
		if (newRow) {
			target.append(newRow);
		}
	});

	$(document).on('click', '.vp-remove-row', function () {
		$(this).closest('.vp-repeater-row').remove();
	});

	// Gallery uploader
	var galleryFrame;
	$('#vp_add_gallery_images').on('click', function (e) {
		e.preventDefault();
		if (galleryFrame) { galleryFrame.open(); return; }

		galleryFrame = wp.media({
			title: 'Select Gallery Images',
			button: { text: 'Add to Gallery' },
			multiple: true
		});

		galleryFrame.on('select', function () {
			var selection = galleryFrame.state().get('selection');
			var idsField = $('#vp_gallery_ids');
			var existing = idsField.val() ? idsField.val().split(',').filter(Boolean) : [];

			selection.each(function (attachment) {
				attachment = attachment.toJSON();
				if (existing.indexOf(String(attachment.id)) === -1) {
					existing.push(attachment.id);
					var thumb = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
					$('#vp_gallery_preview').append(
						'<div class="vp-gallery-item" data-id="' + attachment.id + '" style="position:relative;">' +
						'<img src="' + thumb + '" style="width:90px;height:90px;object-fit:cover;border-radius:4px;border:1px solid #ddd;" />' +
						'<span class="vp-remove-gallery-item" style="position:absolute;top:-6px;right:-6px;background:#c00;color:#fff;border-radius:50%;width:20px;height:20px;line-height:20px;text-align:center;cursor:pointer;font-weight:bold;">×</span>' +
						'</div>'
					);
				}
			});
			idsField.val(existing.join(','));
		});

		galleryFrame.open();
	});

	$(document).on('click', '.vp-remove-gallery-item', function () {
		var item = $(this).closest('.vp-gallery-item');
		var id = String(item.data('id'));
		var idsField = $('#vp_gallery_ids');
		var existing = idsField.val() ? idsField.val().split(',').filter(Boolean) : [];
		existing = existing.filter(function (v) { return v !== id; });
		idsField.val(existing.join(','));
		item.remove();
	});

});
