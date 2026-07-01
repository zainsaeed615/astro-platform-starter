jQuery(function ($) {

	// Gallery thumb click -> swap main feature image
	$(document).on('click', '.vp-gallery-thumb', function () {
		var bg = $(this).css('background-image');
		$(this).closest('.vp-details-hero-right').find('.vp-feat-img').css('background-image', bg);
	});

	// Inquiry form submit
	$(document).on('submit', '.vp-inquiry-form', function (e) {
		e.preventDefault();
		var form = $(this);
		var responseBox = form.find('.vp-form-response');
		var btn = form.find('.vp-form-submit');

		var data = {
			action: 'vp_submit_inquiry',
			nonce: VP_Ajax.nonce,
			property_id: form.data('property-id'),
			name: form.find('[name="name"]').val(),
			email: form.find('[name="email"]').val(),
			phone: form.find('[name="phone"]').val(),
			message: form.find('[name="message"]').val()
		};

		btn.prop('disabled', true).text('Sending...');
		responseBox.removeClass('vp-success vp-error').text('');

		$.post(VP_Ajax.ajax_url, data, function (res) {
			if (res.success) {
				responseBox.addClass('vp-success').text(res.data.message);
				form[0].reset();
			} else {
				responseBox.addClass('vp-error').text(res.data.message);
			}
		}).fail(function () {
			responseBox.addClass('vp-error').text('Kuch masla hua, dobara koshish karein.');
		}).always(function () {
			btn.prop('disabled', false).text('Send Message');
		});
	});

});
