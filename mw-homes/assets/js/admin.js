/* MW Homes – admin meta box interactions */
(function ($) {
	'use strict';

	$(function () {

		// Single image picker (floor plan).
		$('.mwh-media-single').each(function () {
			var $wrap = $(this),
				$input = $wrap.find('input[type=hidden]'),
				$preview = $wrap.find('.mwh-media-preview');

			$wrap.on('click', '.mwh-media-pick', function (e) {
				e.preventDefault();
				var frame = wp.media({ title: 'Select image', multiple: false, library: { type: 'image' } });
				frame.on('select', function () {
					var att = frame.state().get('selection').first().toJSON();
					$input.val(att.id);
					var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
					$preview.html('<img src="' + url + '" />');
				});
				frame.open();
			});

			$wrap.on('click', '.mwh-media-clear', function (e) {
				e.preventDefault();
				$input.val('');
				$preview.empty();
			});
		});

		// Multi-image gallery picker.
		$('.mwh-media-gallery').each(function () {
			var $wrap = $(this),
				$input = $wrap.find('input[type=hidden]'),
				$list = $wrap.find('.mwh-gallery-list');

			function sync() {
				var ids = [];
				$list.find('li').each(function () { ids.push($(this).data('id')); });
				$input.val(ids.join(','));
			}

			$wrap.on('click', '.mwh-gallery-add', function (e) {
				e.preventDefault();
				var frame = wp.media({ title: 'Add gallery images', multiple: true, library: { type: 'image' } });
				frame.on('select', function () {
					frame.state().get('selection').toJSON().forEach(function (att) {
						if ($list.find('li[data-id="' + att.id + '"]').length) { return; }
						var url = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
						$list.append('<li data-id="' + att.id + '"><img src="' + url + '" /><button type="button" class="mwh-gallery-remove">&times;</button></li>');
					});
					sync();
				});
				frame.open();
			});

			$wrap.on('click', '.mwh-gallery-remove', function (e) {
				e.preventDefault();
				$(this).closest('li').remove();
				sync();
			});

			if ($list.sortable) {
				$list.sortable({ update: sync });
			}
		});

		// Spec tabs.
		$('.mwh-spec-nav a').on('click', function (e) {
			e.preventDefault();
			var target = $(this).attr('href');
			$('.mwh-spec-nav a').removeClass('active');
			$(this).addClass('active');
			$('.mwh-spec-pane').removeClass('active');
			$(target).addClass('active');
		});
	});
})(jQuery);
