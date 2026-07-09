/**
 * Sacred Spaces Booking — 8-Step Wizard
 */
(function () {
	'use strict';

	const config = window.ssbBooking || {};
	const STEPS = 8;
	const i18n = config.i18n || {};

	const state = {
		step: 0,
		services: [],
		availableDates: [],
		availableSlots: [],
		calYear: new Date().getFullYear(),
		calMonth: new Date().getMonth() + 1,
		submitting: false,
		bookingResult: null,
		data: {
			service_id: null,
			service: null,
			location: '',
			booking_date: '',
			booking_time: '',
			first_name: '',
			last_name: '',
			email: '',
			phone: '',
			address: '',
			city: '',
			state: '',
			zip: '',
			country: 'United States',
			preferred_contact: 'email',
			project_type: '',
			referral_source: '',
			transformation_goals: '',
			intentional_ack: false
		}
	};

	const $ = (sel, ctx = document) => ctx.querySelector(sel);
	const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

	const app = $('#ssb-booking-app');
	if (!app) return;

	const panelsEl = $('#ssb-wizard-panels');
	const progressFill = $('#ssb-progress-fill');
	const progressSteps = $('#ssb-progress-steps');
	const btnBack = $('#ssb-btn-back');
	const btnNext = $('#ssb-btn-next');
	const loading = $('#ssb-loading');

	/* ── API ── */
	async function api(path, options = {}, timeoutMs = 12000) {
		const url = `${config.restUrl}${path}`;
		const headers = { 'Content-Type': 'application/json' };
		if (config.nonce) headers['X-WP-Nonce'] = config.nonce;

		const controller = new AbortController();
		const timer = setTimeout(() => controller.abort(), timeoutMs);

		try {
			const res = await fetch(url, { ...options, headers, signal: controller.signal });
			const data = await res.json().catch(() => ({}));
			if (!res.ok) throw new Error(data.message || i18n.error);
			return data;
		} catch (err) {
			if (err.name === 'AbortError') {
				throw new Error(i18n.error || 'Request timed out. Please try again.');
			}
			throw err;
		} finally {
			clearTimeout(timer);
		}
	}

	function showLoading(show) {
		if (loading) loading.hidden = !show;
	}

	/* ── Progress ── */
	function renderProgress() {
		if (!progressSteps) return;
		const labels = config.steps || [];
		progressSteps.innerHTML = labels.map((label, i) => {
			const cls = i < state.step ? 'is-complete' : i === state.step ? 'is-active' : '';
			return `<li class="${cls}"><span>${label}</span></li>`;
		}).join('');
		if (progressFill) {
			progressFill.style.width = `${((state.step + 1) / STEPS) * 100}%`;
		}
	}

	/* ── Navigation ── */
	function goToStep(n) {
		const current = $('.ssb-panel.is-active', panelsEl);
		if (current) {
			current.classList.remove('is-active');
			current.classList.add('is-exiting');
			setTimeout(() => current.classList.remove('is-exiting'), 300);
		}

		state.step = n;
		renderProgress();
		renderPanel();

		const next = $(`.ssb-panel[data-step="${n}"]`, panelsEl);
		if (next) {
			requestAnimationFrame(() => next.classList.add('is-active'));
		}

		btnBack.hidden = n === 0 || n === STEPS - 1;
		updateNextButton();

		const title = $('.ssb-panel__title', next);
		if (title) title.focus();
	}

	function updateNextButton() {
		if (state.step === STEPS - 1) {
			btnNext.hidden = true;
		} else if (state.step === 6) {
			btnNext.textContent = i18n.submit || 'Submit Request';
		} else {
			btnNext.textContent = i18n.next || 'Continue';
			btnNext.hidden = false;
		}
	}

	function needsScheduling() {
		return !!state.data.service;
	}

	/* ── Validation ── */
	function validateStep() {
		clearErrors();
		const d = state.data;

		switch (state.step) {
			case 0:
				if (!d.service_id) return showFieldError('service', i18n.required);
				break;
			case 1:
				if (!d.location) return showFieldError('location', i18n.required);
				break;
			case 2:
				if (needsScheduling() && !d.booking_date) return showFieldError('date', i18n.selectDate);
				break;
			case 3:
				if (needsScheduling() && !d.booking_time) return showFieldError('time', i18n.selectTime);
				break;
			case 4:
				if (!d.first_name || !d.last_name || !d.email) return showFieldError('client', i18n.required);
				if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(d.email)) return showFieldError('client', 'Invalid email');
				break;
			case 5:
				if (!d.intentional_ack) return showFieldError('ack', i18n.ackRequired);
				break;
		}
		return true;
	}

	function showFieldError(key, msg) {
		const panel = $(`.ssb-panel[data-step="${state.step}"]`, panelsEl);
		let err = $('.ssb-panel-error', panel);
		if (!err) {
			err = document.createElement('p');
			err.className = 'ssb-panel-error ssb-field-error';
			err.style.textAlign = 'center';
			err.style.marginBottom = '20px';
			panel.prepend(err);
		}
		err.textContent = msg;
		return false;
	}

	function clearErrors() {
		$$('.ssb-panel-error', panelsEl).forEach(el => el.remove());
		$$('.has-error', panelsEl).forEach(el => el.classList.remove('has-error'));
	}

	/* ── Panel Renderers ── */
	function renderPanel() {
		const existing = $(`.ssb-panel[data-step="${state.step}"]`, panelsEl);
		if (existing) return;

		const panel = document.createElement('div');
		panel.className = 'ssb-panel';
		panel.dataset.step = state.step;
		panel.setAttribute('role', 'tabpanel');

		const renderers = [
			renderServiceStep,
			renderLocationStep,
			renderCalendarStep,
			renderTimeStep,
			renderClientStep,
			renderQuestionnaireStep,
			renderReviewStep,
			renderConfirmationStep
		];

		panel.innerHTML = renderers[state.step]();
		panelsEl.appendChild(panel);
		bindPanelEvents(panel);
	}

	function renderServiceStep() {
		const cards = state.services.map(s => `
			<button type="button" class="ssb-service-option ${state.data.service_id === s.id ? 'is-selected' : ''}"
				data-service-id="${s.id}" aria-pressed="${state.data.service_id === s.id}">
				<span class="ssb-service-option__name">${esc(s.name)}</span>
				<span class="ssb-service-option__investment">${esc(s.investment_display)}</span>
				<span class="ssb-service-option__meta">${s.duration_minutes} ${i18n.minutes || 'Minutes'}</span>
				<p class="ssb-service-option__desc">${esc(s.description)}</p>
			</button>
		`).join('');

		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.chooseService}</h2>
			<p class="ssb-panel__subtitle">${i18n.investment}</p>
			<div class="ssb-service-grid" role="listbox">${cards}</div>
		`;
	}

	function renderLocationStep() {
		const s = state.data.service;
		const locs = s?.locations || ['virtual', 'in_home'];
		const options = locs.map(loc => {
			const label = loc === 'in_home' ? (i18n.inHome || 'In Home') : (i18n.virtual || 'Virtual');
			const icon = loc === 'in_home' ? '⌂' : '◉';
			const selected = state.data.location === loc ? 'is-selected' : '';
			return `
				<button type="button" class="ssb-location-option ${selected}" data-location="${loc}" aria-pressed="${state.data.location === loc}">
					<span class="ssb-location-option__icon">${icon}</span>
					<span class="ssb-location-option__label">${label}</span>
				</button>
			`;
		}).join('');

		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.location}</h2>
			<p class="ssb-panel__subtitle">${esc(s?.name || '')}</p>
			<div class="ssb-location-grid">${options}</div>
		`;
	}

	function renderCalendarStep() {
		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.calendar}</h2>
			<p class="ssb-panel__subtitle">${i18n.selectDate}</p>
			<div class="ssb-cal-header">
				<button type="button" class="ssb-cal-nav" id="ssb-wiz-cal-prev" aria-label="Previous month">&larr;</button>
				<h3 class="ssb-cal-title" id="ssb-wiz-cal-title"></h3>
				<button type="button" class="ssb-cal-nav" id="ssb-wiz-cal-next" aria-label="Next month">&rarr;</button>
			</div>
			<div class="ssb-cal-weekdays">
				<span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
			</div>
			<div class="ssb-cal-days" id="ssb-wiz-cal-days" role="grid"></div>
		`;
	}

	function renderTimeStep() {
		const slots = state.availableSlots.map(slot => `
			<button type="button" class="ssb-time-slot ${state.data.booking_time === slot.time ? 'is-selected' : ''}"
				data-time="${slot.time}" aria-pressed="${state.data.booking_time === slot.time}">
				${esc(slot.label)}
			</button>
		`).join('');

		const empty = state.availableSlots.length === 0
			? `<p class="ssb-panel__subtitle">${i18n.noSlots}</p>` : '';

		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.time}</h2>
			<p class="ssb-panel__subtitle">${formatDisplayDate(state.data.booking_date)}</p>
			<div class="ssb-time-grid">${slots}</div>
			${empty}
		`;
	}

	function renderClientStep() {
		const d = state.data;
		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.clientDetails}</h2>
			<p class="ssb-panel__subtitle"></p>
			<div class="ssb-form-grid">
				<div class="ssb-field"><label for="ssb-first">${esc('First Name')} *</label><input id="ssb-first" name="first_name" value="${esc(d.first_name)}" required></div>
				<div class="ssb-field"><label for="ssb-last">${esc('Last Name')} *</label><input id="ssb-last" name="last_name" value="${esc(d.last_name)}" required></div>
				<div class="ssb-field"><label for="ssb-email">${esc('Email')} *</label><input id="ssb-email" name="email" type="email" value="${esc(d.email)}" required></div>
				<div class="ssb-field"><label for="ssb-phone">${esc('Phone')}</label><input id="ssb-phone" name="phone" type="tel" value="${esc(d.phone)}"></div>
				<div class="ssb-field ssb-field--full"><label for="ssb-address">${esc('Address')}</label><input id="ssb-address" name="address" value="${esc(d.address)}"></div>
				<div class="ssb-field"><label for="ssb-city">${esc('City')}</label><input id="ssb-city" name="city" value="${esc(d.city)}"></div>
				<div class="ssb-field"><label for="ssb-state">${esc('State')}</label><input id="ssb-state" name="state" value="${esc(d.state)}"></div>
				<div class="ssb-field"><label for="ssb-zip">${esc('Zip')}</label><input id="ssb-zip" name="zip" value="${esc(d.zip)}"></div>
				<div class="ssb-field"><label for="ssb-country">${esc('Country')}</label><input id="ssb-country" name="country" value="${esc(d.country)}"></div>
				<div class="ssb-field">
					<label for="ssb-contact">${esc('Preferred Contact')}</label>
					<select id="ssb-contact" name="preferred_contact">
						<option value="email" ${d.preferred_contact === 'email' ? 'selected' : ''}>Email</option>
						<option value="phone" ${d.preferred_contact === 'phone' ? 'selected' : ''}>Phone</option>
					</select>
				</div>
			</div>
		`;
	}

	function renderQuestionnaireStep() {
		const d = state.data;
		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.questionnaire}</h2>
			<p class="ssb-panel__subtitle"></p>
			<div class="ssb-form-grid">
				<div class="ssb-field"><label for="ssb-project">${esc('Project Type')}</label><input id="ssb-project" name="project_type" value="${esc(d.project_type)}"></div>
				<div class="ssb-field"><label for="ssb-referral">${esc('How did you hear about us?')}</label><input id="ssb-referral" name="referral_source" value="${esc(d.referral_source)}"></div>
				<div class="ssb-field ssb-field--full">
					<label for="ssb-goals">${esc('What are you hoping to transform in your home?')}</label>
					<textarea id="ssb-goals" name="transformation_goals">${esc(d.transformation_goals)}</textarea>
				</div>
				<div class="ssb-field ssb-field--full ssb-field--checkbox">
					<input type="checkbox" id="ssb-ack" name="intentional_ack" ${d.intentional_ack ? 'checked' : ''}>
					<label for="ssb-ack">${esc('I understand this is an intentional design experience.')} *</label>
				</div>
			</div>
		`;
	}

	function renderReviewStep() {
		const d = state.data;
		const s = d.service;
		const locLabel = d.location === 'in_home' ? (i18n.inHome || 'In Home') : (i18n.virtual || 'Virtual');

		return `
			<h2 class="ssb-panel__title" tabindex="-1">${i18n.review}</h2>
			<p class="ssb-panel__subtitle"></p>
			<div class="ssb-review">
				<div class="ssb-review__row"><strong>${esc('Service')}</strong><span>${esc(s?.name || '')}</span></div>
				<div class="ssb-review__row"><strong>${esc('Investment')}</strong><span>${esc(s?.investment_display || '')}</span></div>
				${d.booking_date ? `<div class="ssb-review__row"><strong>${esc('Date')}</strong><span>${formatDisplayDate(d.booking_date)}</span></div>` : ''}
				${d.booking_time ? `<div class="ssb-review__row"><strong>${esc('Time')}</strong><span>${formatDisplayTime(d.booking_time)}</span></div>` : ''}
				<div class="ssb-review__row"><strong>${esc('Location')}</strong><span>${locLabel}</span></div>
				<div class="ssb-review__divider"></div>
				<div class="ssb-review__row"><strong>${esc('Name')}</strong><span>${esc(d.first_name)} ${esc(d.last_name)}</span></div>
				<div class="ssb-review__row"><strong>${esc('Email')}</strong><span>${esc(d.email)}</span></div>
				<div class="ssb-review__row"><strong>${esc('Phone')}</strong><span>${esc(d.phone)}</span></div>
			</div>
		`;
	}

	function renderConfirmationStep() {
		const r = state.bookingResult;
		const d = state.data;
		const locLabel = d.location === 'in_home' ? (i18n.inHome || 'In Home') : (i18n.virtual || 'Virtual');

		return `
			<div class="ssb-confirmation">
				<div class="ssb-confirmation__check" aria-hidden="true">✔</div>
				<h2 class="ssb-confirmation__title">${i18n.thankYou}</h2>
				<p class="ssb-confirmation__message">${i18n.received}<br>${i18n.contactShortly}</p>
				<div class="ssb-review__divider"></div>
				<div class="ssb-summary-card">
					<h3>${i18n.bookingSummary}</h3>
					<div class="ssb-review">
						<div class="ssb-review__row"><strong>${esc('Service')}</strong><span>${esc(d.service?.name || r?.service_name || '')}</span></div>
						${d.booking_date ? `<div class="ssb-review__row"><strong>${esc('Date')}</strong><span>${formatDisplayDate(d.booking_date)}</span></div>` : ''}
						${d.booking_time ? `<div class="ssb-review__row"><strong>${esc('Time')}</strong><span>${formatDisplayTime(d.booking_time)}</span></div>` : ''}
						<div class="ssb-review__row"><strong>${esc('Location')}</strong><span>${locLabel}</span></div>
						<div class="ssb-review__row"><strong>${esc('Investment')}</strong><span>${esc(d.service?.investment_display || '')}</span></div>
					</div>
				</div>
			</div>
		`;
	}

	/* ── Panel Events ── */
	function bindPanelEvents(panel) {
		const step = parseInt(panel.dataset.step, 10);

		if (step === 0) {
			$$('.ssb-service-option', panel).forEach(btn => {
				btn.addEventListener('click', () => {
					const id = parseInt(btn.dataset.serviceId, 10);
					state.data.service_id = id;
					state.data.service = state.services.find(s => s.id === id);
					$$('.ssb-service-option', panel).forEach(b => {
						b.classList.toggle('is-selected', b === btn);
						b.setAttribute('aria-pressed', b === btn);
					});
				});
			});
		}

		if (step === 1) {
			$$('.ssb-location-option', panel).forEach(btn => {
				btn.addEventListener('click', () => {
					state.data.location = btn.dataset.location;
					$$('.ssb-location-option', panel).forEach(b => {
						b.classList.toggle('is-selected', b === btn);
						b.setAttribute('aria-pressed', b === btn);
					});
				});
			});
		}

		if (step === 2) {
			renderWizardCalendar(panel);
			$('#ssb-wiz-cal-prev', panel)?.addEventListener('click', () => changeCalMonth(-1, panel));
			$('#ssb-wiz-cal-next', panel)?.addEventListener('click', () => changeCalMonth(1, panel));
		}

		if (step === 3) {
			$$('.ssb-time-slot', panel).forEach(btn => {
				btn.addEventListener('click', () => {
					state.data.booking_time = btn.dataset.time;
					$$('.ssb-time-slot', panel).forEach(b => {
						b.classList.toggle('is-selected', b === btn);
						b.setAttribute('aria-pressed', b === btn);
					});
				});
			});
		}

		if (step === 4 || step === 5) {
			$$('input, select, textarea', panel).forEach(el => {
				el.addEventListener('change', () => syncFormFields(panel));
				el.addEventListener('input', () => syncFormFields(panel));
			});
		}
	}

	function syncFormFields(panel) {
		$$('input, select, textarea', panel).forEach(el => {
			const name = el.name;
			if (!name) return;
			if (el.type === 'checkbox') {
				state.data[name] = el.checked;
			} else {
				state.data[name] = el.value;
			}
		});
	}

	/* ── Calendar ── */
	async function loadAvailableDates() {
		const data = await api(`/availability/dates?year=${state.calYear}&month=${state.calMonth}`);
		state.availableDates = data.dates || [];
	}

	async function loadAvailableSlots() {
		if (!state.data.booking_date) return;
		const data = await api(`/availability/slots?date=${state.data.booking_date}`);
		state.availableSlots = data.slots || [];
	}

	function changeCalMonth(delta, panel) {
		state.calMonth += delta;
		if (state.calMonth > 12) { state.calMonth = 1; state.calYear++; }
		if (state.calMonth < 1) { state.calMonth = 12; state.calYear--; }
		renderWizardCalendar(panel);
	}

	async function renderWizardCalendar(panel) {
		const titleEl = $('#ssb-wiz-cal-title', panel);
		const daysEl = $('#ssb-wiz-cal-days', panel);
		if (!daysEl) return;

		showLoading(true);
		try {
			await loadAvailableDates();
		} catch (e) {
			console.error(e);
		}
		showLoading(false);

		const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		if (titleEl) titleEl.textContent = `${months[state.calMonth - 1]} ${state.calYear}`;

		const firstDay = new Date(state.calYear, state.calMonth - 1, 1).getDay();
		const daysInMonth = new Date(state.calYear, state.calMonth, 0).getDate();

		let html = '';
		for (let i = 0; i < firstDay; i++) {
			html += '<span class="ssb-cal-day ssb-cal-day--empty"></span>';
		}

		for (let d = 1; d <= daysInMonth; d++) {
			const dateStr = `${state.calYear}-${String(state.calMonth).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
			const available = state.availableDates.includes(dateStr);
			const selected = state.data.booking_date === dateStr;
			let cls = 'ssb-cal-day';
			if (available) cls += ' ssb-cal-day--available';
			else cls += ' ssb-cal-day--disabled';
			if (selected) cls += ' ssb-cal-day--selected';

			if (available) {
				html += `<button type="button" class="${cls}" data-date="${dateStr}" role="gridcell">${d}</button>`;
			} else {
				html += `<span class="${cls}" role="gridcell">${d}</span>`;
			}
		}

		daysEl.innerHTML = html;

		$$('.ssb-cal-day--available', daysEl).forEach(btn => {
			btn.addEventListener('click', () => {
				state.data.booking_date = btn.dataset.date;
				state.data.booking_time = '';
				$$('.ssb-cal-day', daysEl).forEach(b => b.classList.remove('ssb-cal-day--selected'));
				btn.classList.add('ssb-cal-day--selected');
			});
		});
	}

	/* ── Submit ── */
	async function submitBooking() {
		if (state.submitting) return;
		state.submitting = true;
		showLoading(true);

		try {
			const payload = { ...state.data, intentional_ack: state.data.intentional_ack ? 1 : 0 };
			const result = await api('/bookings', { method: 'POST', body: JSON.stringify(payload) });
			state.bookingResult = result;
			goToStep(7);
		} catch (e) {
			showFieldError('submit', e.message);
		} finally {
			state.submitting = false;
			showLoading(false);
		}
	}

	async function handleNext() {
		syncCurrentPanelFields();
		if (!validateStep()) return;

		if (state.step === 2 && needsScheduling()) {
			await loadAvailableSlots();
			const panel = $(`.ssb-panel[data-step="3"]`, panelsEl);
			if (panel) panel.remove();
		}

		if (state.step === 6) {
			await submitBooking();
			return;
		}

		const next = state.step + 1;

		if (next === 3) {
			await loadAvailableSlots();
		}

		goToStep(next);
	}

	function syncCurrentPanelFields() {
		const panel = $(`.ssb-panel[data-step="${state.step}"]`, panelsEl);
		if (panel) syncFormFields(panel);
	}

	function handleBack() {
		goToStep(state.step - 1);
	}

	/* ── Utilities ── */
	function esc(str) {
		const div = document.createElement('div');
		div.textContent = str || '';
		return div.innerHTML;
	}

	function formatDisplayDate(dateStr) {
		if (!dateStr) return '';
		const d = new Date(dateStr + 'T12:00:00');
		return d.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
	}

	function formatDisplayTime(timeStr) {
		if (!timeStr) return '';
		const [h, m] = timeStr.split(':');
		const d = new Date();
		d.setHours(parseInt(h, 10), parseInt(m, 10));
		return d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
	}

	/* ── Init ── */
	function parseServicesFromDom() {
		return $$('.ssb-service-option[data-service-id]', panelsEl).map((btn) => ({
			id: parseInt(btn.dataset.serviceId, 10),
			name: $('.ssb-service-option__name', btn)?.textContent?.trim() || '',
			slug: btn.dataset.slug || '',
			investment_display: $('.ssb-service-option__investment', btn)?.textContent?.trim() || '',
			description: $('.ssb-service-option__desc', btn)?.textContent?.trim() || '',
			duration_minutes: parseInt($('.ssb-service-option__meta', btn)?.textContent, 10) || 90,
			locations: (btn.dataset.locations || 'virtual,in_home').split(',').map((l) => l.trim()).filter(Boolean)
		}));
	}

	function loadServices() {
		if (Array.isArray(config.services) && config.services.length) {
			state.services = config.services;
			return;
		}
		state.services = parseServicesFromDom();
	}

	async function init() {
		if (!btnBack || !btnNext || !panelsEl) {
			return;
		}

		btnBack.addEventListener('click', handleBack);
		btnNext.addEventListener('click', handleNext);

		document.addEventListener('keydown', (e) => {
			if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
				e.preventDefault();
				handleNext();
			}
		});

		loadServices();

		const initialPanel = $('.ssb-panel[data-step="0"]', panelsEl);
		if (initialPanel) {
			bindPanelEvents(initialPanel);
			state.step = 0;
			renderProgress();
			updateNextButton();
		} else if (state.services.length) {
			renderProgress();
			goToStep(0);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
