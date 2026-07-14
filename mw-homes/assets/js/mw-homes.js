/* MW Homes – front-end */
(function ($) {
	'use strict';

	var $modal;

	/* ---------------- Quote modal ---------------- */
	function openModal(data) {
		if (!$modal.length) { return; }
		$modal.find('input[name=plan_id]').val(data.id || '');
		$modal.find('input[name=plan_title]').val(data.title || '');
		$modal.find('[data-mwh-plan-title]').text(data.title || '');
		var $thumb = $modal.find('[data-mwh-thumb]');
		if (data.thumb) {
			$thumb.html('<img src="' + data.thumb + '" alt="" />').show();
		} else {
			$thumb.empty().hide();
		}
		$modal.find('.mwh-form-msg').removeClass('is-error is-success').text('');
		$modal.attr('aria-hidden', 'false').addClass('is-open');
		$('body').addClass('mwh-modal-open');
	}

	function closeModal() {
		$modal.attr('aria-hidden', 'true').removeClass('is-open');
		$('body').removeClass('mwh-modal-open');
	}

	/* ---------------- Lightbox ---------------- */
	function lightbox(src) {
		var $lb = $('<div class="mwh-lightbox"><span class="mwh-lightbox__close">&times;</span><img src="' + src + '" /></div>');
		$lb.on('click', function () { $lb.remove(); });
		$('body').append($lb);
	}

	$(function () {
		$modal = $('#mwh-quote-modal');

		// Open triggers.
		$(document).on('click', '.mwh-quote-open', function (e) {
			e.preventDefault();
			var $b = $(this);
			openModal({ id: $b.data('plan-id'), title: $b.data('plan-title'), thumb: $b.data('plan-thumb') });
		});

		// Close triggers.
		$(document).on('click', '[data-mwh-close]', closeModal);
		$(document).on('keyup', function (e) { if (e.key === 'Escape') { closeModal(); } });

		// Lightbox for floor plans.
		$(document).on('click', '[data-mwh-lightbox]', function (e) {
			e.preventDefault();
			lightbox($(this).attr('href'));
		});

		/* ---------------- Quote submit ---------------- */
		$(document).on('submit', '.mwh-quote-form', function (e) {
			e.preventDefault();
			var $form = $(this),
				$btn = $form.find('.mwh-quote-submit'),
				$msg = $form.find('.mwh-form-msg');

			// Basic required check.
			var missing = false;
			$form.find('[required]').each(function () {
				if (!$.trim($(this).val())) { $(this).addClass('mwh-invalid'); missing = true; }
				else { $(this).removeClass('mwh-invalid'); }
			});
			if (missing) {
				$msg.addClass('is-error').text(MWH.i18n.error === '' ? '' : 'Please complete all required fields.');
				return;
			}

			var payload = $form.serializeArray();
			payload.push({ name: 'action', value: 'mwh_submit_quote' });
			payload.push({ name: 'nonce', value: MWH.quoteNonce });

			$btn.prop('disabled', true).text(MWH.i18n.sending);
			$msg.removeClass('is-error is-success').text('');

			$.post(MWH.ajax, $.param(payload))
				.done(function (res) {
					if (res && res.success) {
						$msg.addClass('is-success').text(res.data.message);
						$form.find('input[type=text],input[type=email],input[type=tel],textarea').val('');
						$form.find('select').prop('selectedIndex', 0);
						$form.find('input[type=radio]').prop('checked', false);
					} else {
						$msg.addClass('is-error').text((res && res.data && res.data.message) || MWH.i18n.error);
					}
				})
				.fail(function () { $msg.addClass('is-error').text(MWH.i18n.error); })
				.always(function () { $btn.prop('disabled', false).text(MWH.i18n.submit); });
		});

		/* ---------------- Archive filtering ---------------- */
		$('.mwh-archive').each(function () {
			var $wrap = $(this),
				$results = $wrap.find('.mwh-grid-results'),
				$count = $wrap.find('.mwh-result-count'),
				$pager = $wrap.find('.mwh-pagination'),
				perPage = $wrap.data('per-page') || 9,
				current = 1;

			function collect() {
				var d = {
					action: 'mwh_filter',
					nonce: MWH.filterNonce,
					per_page: perPage,
					paged: current,
					stats_mode: $wrap.data('stats-mode') || 'labels',
					show_excerpt: $wrap.data('show-excerpt') ? 1 : 0
				};
				$wrap.find('[data-filter]').each(function () {
					var $f = $(this), name = $f.data('filter');
					if ($f.attr('type') === 'checkbox') { d[name] = $f.is(':checked') ? 1 : ''; }
					else { d[name] = $f.val(); }
				});
				return d;
			}

			function run() {
				$results.addClass('is-loading');
				$.post(MWH.ajax, collect())
					.done(function (res) {
						if (res && res.success) {
							$results.html(res.data.html);
							if ($count.length) { $count.text(res.data.found); }
							buildPager(res.data.pages, res.data.paged);
						}
					})
					.always(function () { $results.removeClass('is-loading'); });
			}

			function buildPager(pages, paged) {
				if (!$pager.length || pages < 2) { $pager.empty(); return; }
				var html = '';
				html += '<button class="mwh-page-btn" data-page="' + (paged - 1) + '"' + (paged <= 1 ? ' disabled' : '') + '>&laquo;</button>';
				for (var i = 1; i <= pages; i++) {
					html += '<button class="mwh-page-btn' + (i === paged ? ' is-active' : '') + '" data-page="' + i + '">' + i + '</button>';
				}
				html += '<button class="mwh-page-btn" data-page="' + (paged + 1) + '"' + (paged >= pages ? ' disabled' : '') + '>&raquo;</button>';
				$pager.html(html);
			}

			$wrap.on('change keyup', '[data-filter]', function (e) {
				if (e.type === 'keyup' && $(this).data('filter') !== 's') { return; }
				current = 1;
				clearTimeout($wrap.data('t'));
				$wrap.data('t', setTimeout(run, e.type === 'keyup' ? 350 : 0));
			});

			$wrap.on('click', '.mwh-page-btn', function () {
				if ($(this).is('[disabled]')) { return; }
				current = $(this).data('page');
				run();
				$('html,body').animate({ scrollTop: $wrap.offset().top - 60 }, 300);
			});

			$wrap.on('click', '.mwh-reset', function (e) {
				e.preventDefault();
				$wrap.find('[data-filter]').each(function () {
					if ($(this).attr('type') === 'checkbox') { $(this).prop('checked', false); }
					else if (this.tagName === 'SELECT') { this.selectedIndex = 0; }
					else { $(this).val(''); }
				});
				current = 1; run();
			});

			run();
		});
	});
})(jQuery);
