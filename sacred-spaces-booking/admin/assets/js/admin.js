/**
 * Sacred Spaces Booking — Admin JavaScript
 */
(function ($) {
	'use strict';

	const SSBAdmin = {
		init() {
			this.bindStatusChanges();
			this.bindForms();
		},

		toast(message, isError) {
			$('.ssb-toast').remove();
			const $t = $('<div class="ssb-toast"></div>').text(message);
			if (isError) $t.css('background', '#8B4545');
			$('body').append($t);
			setTimeout(() => $t.fadeOut(300, () => $t.remove()), 3000);
		},

		ajax(action, data) {
			return $.post(ssbAdmin.ajaxUrl, Object.assign({ action, nonce: ssbAdmin.nonce }, data));
		},

		bindStatusChanges() {
			$(document).on('change', '.ssb-status-select', function () {
				const $el = $(this);
				const id = $el.data('id');
				const status = $el.val();

				SSBAdmin.ajax('ssb_update_booking_status', { booking_id: id, status })
					.done((res) => {
						if (res.success) {
							SSBAdmin.toast(res.data.message);
							$el.closest('tr').find('.ssb-badge')
								.removeClass()
								.addClass('ssb-badge ssb-badge--' + status)
								.text(status.charAt(0).toUpperCase() + status.slice(1));
						} else {
							SSBAdmin.toast(res.data?.message || ssbAdmin.i18n.error, true);
						}
					})
					.fail(() => SSBAdmin.toast(ssbAdmin.i18n.error, true));
			});
		},

		bindForms() {
			$('#ssb-availability-days').on('submit', function (e) {
				e.preventDefault();
				const days = $(this).find('input[name="days[]"]:checked').map(function () {
					return $(this).val();
				}).get();

				SSBAdmin.ajax('ssb_save_availability', { days })
					.done((res) => SSBAdmin.toast(res.success ? res.data.message : ssbAdmin.i18n.error, !res.success));
			});

			$('#ssb-time-slots-form').on('submit', function (e) {
				e.preventDefault();
				const slots = [];
				$('#ssb-slots-table tbody tr').each(function (i) {
					const $row = $(this);
					slots.push({
						id: $row.data('slot-id') || 0,
						time: $row.find('.slot-time').val() + ':00',
						label: $row.find('.slot-label').val(),
						active: $row.find('.slot-active').is(':checked'),
						sort: $row.find('.slot-sort').val() || i + 1
					});
				});

				SSBAdmin.ajax('ssb_save_time_slots', { slots: JSON.stringify(slots) })
					.done((res) => SSBAdmin.toast(res.success ? res.data.message : ssbAdmin.i18n.error, !res.success));
			});

			$('#ssb-block-date-form').on('submit', function (e) {
				e.preventDefault();
				const $form = $(this);
				SSBAdmin.ajax('ssb_block_date', {
					date: $form.find('[name="date"]').val(),
					reason: $form.find('[name="reason"]').val()
				}).done((res) => {
					if (res.success) location.reload();
					else SSBAdmin.toast(ssbAdmin.i18n.error, true);
				});
			});

			$(document).on('click', '.ssb-unblock-date', function () {
				const date = $(this).data('date');
				SSBAdmin.ajax('ssb_unblock_date', { date })
					.done((res) => { if (res.success) location.reload(); });
			});

			$('.ssb-service-form').on('submit', function (e) {
				e.preventDefault();
				const $form = $(this);
				const data = {};
				$form.serializeArray().forEach((item) => { data[item.name] = item.value; });
				data.is_active = $form.find('[name="is_active"]').is(':checked') ? 1 : 0;

				SSBAdmin.ajax('ssb_save_service', data)
					.done((res) => SSBAdmin.toast(res.success ? res.data.message : ssbAdmin.i18n.error, !res.success));
			});

			$('#ssb-general-settings').on('submit', function (e) {
				e.preventDefault();
				const data = {};
				$(this).serializeArray().forEach((item) => { data[item.name] = item.value; });
				$(this).find('input[type="checkbox"]').each(function () {
					if (!this.checked) data[this.name] = 0;
					else data[this.name] = 1;
				});

				SSBAdmin.ajax('ssb_save_settings', data)
					.done((res) => SSBAdmin.toast(res.success ? res.data.message : ssbAdmin.i18n.error, !res.success));
			});

			$('#ssb-email-templates').on('submit', function (e) {
				e.preventDefault();
				const data = {};
				$(this).serializeArray().forEach((item) => { data[item.name] = item.value; });

				SSBAdmin.ajax('ssb_save_email_templates', data)
					.done((res) => SSBAdmin.toast(res.success ? res.data.message : ssbAdmin.i18n.error, !res.success));
			});
		}
	};

	$(document).ready(() => SSBAdmin.init());
})(jQuery);
