/**
 * MDR AI Carrier Intelligence — public scripts
 *
 * @package MDR_ACI
 */
(function () {
	'use strict';

	if (typeof mdrAci === 'undefined') {
		return;
	}

	document.querySelectorAll('[data-mdr-aci-root]').forEach(function (root) {
		initInstance(root);
	});

	function initInstance(root) {
		let modal = root.querySelector('[data-mdr-aci-modal]');
		let uploadModal = root.querySelector('[data-mdr-aci-upload-modal]');

		if (uploadModal && uploadModal.parentElement !== document.body) {
			document.body.appendChild(uploadModal);
		}
		if (modal && modal.parentElement !== document.body) {
			document.body.appendChild(modal);
		}

		const modalDialog = uploadModal
			? uploadModal.querySelector('.mdr-aci__modal-dialog--upload')
			: null;
		const modalTitle = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-modal-title]')
			: null;
		const steps = {
			upload: uploadModal
				? uploadModal.querySelector('[data-mdr-aci-step="upload"]')
				: null,
			processing: uploadModal
				? uploadModal.querySelector('[data-mdr-aci-step="processing"]')
				: null,
			report: uploadModal
				? uploadModal.querySelector('[data-mdr-aci-step="report"]')
				: null,
		};
		const loadingText = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-loading-text]')
			: null;
		const progressBar = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-progress-bar]')
			: null;
		const progressPercent = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-progress-percent]')
			: null;
		const processingFileEl = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-processing-file]')
			: null;
		const dropzone = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-dropzone]')
			: null;
		const fileInput = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-file-input]')
			: null;
		const selectedFileEl = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-selected-file]')
			: null;
		const errorEl = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-error]')
			: null;
		const reportSections = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-report-sections]')
			: null;
		const reportMeta = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-report-meta]')
			: null;
		const executiveSummary = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-executive-summary]')
			: null;
		const disclaimerEl = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-disclaimer]')
			: null;
		const signupLink = uploadModal
			? uploadModal.querySelector('[data-mdr-aci-signup]')
			: null;

		let progressTimer = null;
		let currentStep = 'upload';

		const stepTitles = {
			upload: mdrAci.i18n.modalTitleUpload || 'Upload Shipment History',
			processing: mdrAci.i18n.modalTitleProcessing || 'Analyzing Your Data',
			report: mdrAci.i18n.modalTitleReport || 'Your Intelligence Report',
		};

		function show(el) {
			if (!el) return;
			el.classList.remove('mdr-aci-hidden');
			el.hidden = false;
		}

		function hide(el) {
			if (!el) return;
			el.classList.add('mdr-aci-hidden');
			el.hidden = true;
		}

		function showError(message) {
			if (!errorEl) return;
			errorEl.textContent = message;
			show(errorEl);
		}

		function clearError() {
			if (!errorEl) return;
			errorEl.textContent = '';
			hide(errorEl);
		}

		function setModalStep(step) {
			currentStep = step;
			Object.keys(steps).forEach(function (key) {
				if (key === step) {
					show(steps[key]);
				} else {
					hide(steps[key]);
				}
			});

			if (modalTitle && stepTitles[step]) {
				modalTitle.textContent = stepTitles[step];
			}

			if (modalDialog) {
				modalDialog.classList.toggle('mdr-aci__modal-dialog--report', step === 'report');
				modalDialog.classList.toggle('mdr-aci__modal-dialog--processing', step === 'processing');
			}
		}

		function resetFlow() {
			if (progressTimer) {
				window.clearInterval(progressTimer);
				progressTimer = null;
			}
			if (fileInput) fileInput.value = '';
			if (selectedFileEl) hide(selectedFileEl);
			if (processingFileEl) hide(processingFileEl);
			if (progressBar) progressBar.style.width = '0%';
			if (progressPercent) progressPercent.textContent = '0%';
			if (reportSections) reportSections.innerHTML = '';
			clearError();
			setModalStep('upload');
		}

		function startProgress(fileName) {
			setModalStep('processing');
			clearError();

			if (processingFileEl && fileName) {
				processingFileEl.textContent = fileName;
				show(processingFileEl);
			}

			let value = 0;
			const messages = [
				mdrAci.i18n.uploading,
				mdrAci.i18n.analyzing,
				mdrAci.i18n.generating,
			];
			let msgIndex = 0;

			if (loadingText) loadingText.textContent = messages[0];

			progressTimer = window.setInterval(function () {
				value = Math.min(value + Math.random() * 12, 92);
				if (progressBar) progressBar.style.width = value + '%';
				if (progressPercent) progressPercent.textContent = Math.round(value) + '%';

				if (value > 30 && msgIndex === 0) {
					msgIndex = 1;
					if (loadingText) loadingText.textContent = messages[1];
				}
				if (value > 65 && msgIndex === 1) {
					msgIndex = 2;
					if (loadingText) loadingText.textContent = messages[2];
				}
			}, 350);
		}

		function finishProgress() {
			if (progressTimer) {
				window.clearInterval(progressTimer);
				progressTimer = null;
			}
			if (progressBar) progressBar.style.width = '100%';
			if (progressPercent) progressPercent.textContent = '100%';
		}

		function isAllowedFile(file) {
			const parts = file.name.split('.');
			if (parts.length < 2) return false;
			const ext = parts.pop().toLowerCase();
			return mdrAci.allowed.indexOf(ext) !== -1;
		}

		function parseResponse(response) {
			return response.text().then(function (text) {
				try {
					return JSON.parse(text);
				} catch (e) {
					if (response.status === 403 || text === '-1' || text === '0') {
						return { success: false, data: { message: mdrAci.i18n.sessionError } };
					}
					return { success: false, data: { message: mdrAci.i18n.genericError } };
				}
			});
		}

		function handleFile(file) {
			clearError();

			if (!isAllowedFile(file)) {
				showError(mdrAci.i18n.invalidType);
				return;
			}

			if (file.size > mdrAci.maxBytes) {
				showError(mdrAci.i18n.invalidSize);
				return;
			}

			if (selectedFileEl) {
				selectedFileEl.textContent = file.name;
				show(selectedFileEl);
			}

			uploadFile(file);
		}

		function uploadFile(file) {
			startProgress(file.name);

			const formData = new FormData();
			formData.append('action', 'mdr_aci_upload');
			formData.append('nonce', mdrAci.nonce);
			formData.append('shipment_file', file);

			fetch(mdrAci.ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin',
			})
				.then(parseResponse)
				.then(function (data) {
					finishProgress();

					if (!data.success) {
						const message =
							(data.data && data.data.message) || mdrAci.i18n.genericError;
						setModalStep('upload');
						showError(message);
						return;
					}

					renderReport(data.data.report);
					setModalStep('report');

					const reportBody = steps.report;
					if (reportBody) {
						reportBody.scrollTop = 0;
					}
				})
				.catch(function () {
					finishProgress();
					setModalStep('upload');
					showError(mdrAci.i18n.genericError);
				});
		}

		function renderReport(report) {
			if (!reportSections || !report) return;

			if (reportMeta && report.meta) {
				reportMeta.textContent =
					report.meta.total_shipments +
					' shipments · ' +
					(report.meta.date_range || '');
			}

			if (executiveSummary && report.executive_summary) {
				executiveSummary.textContent = report.executive_summary;
				show(executiveSummary);
			} else if (executiveSummary) {
				hide(executiveSummary);
			}

			if (disclaimerEl && report.disclaimer) {
				disclaimerEl.textContent = report.disclaimer;
			}

			if (signupLink) {
				if (report.signup_url) signupLink.href = report.signup_url;
				if (report.signup_text) signupLink.textContent = report.signup_text;
			}

			const sections = [
				buildSectionCard(report.cost_savings, 'savings', 0),
				buildCarrierCard(report.carrier_performance, 1),
				buildRoutingCard(report.routing, 2),
				buildLaneCard(report.lane_analysis, 3),
				buildSectionCard(report.service_levels, 'service', 4),
				buildConsolidationCard(report.consolidation, 5),
				buildScorecardCard(report.scorecards, 6),
			];

			reportSections.innerHTML = sections.filter(Boolean).join('');
		}

		function buildSectionCard(section, type, delayIndex) {
			if (!section) return '';

			let metricsHtml = '';
			if (section.metrics && section.metrics.length) {
				metricsHtml =
					'<div class="mdr-aci__metrics">' +
					section.metrics
						.map(function (m) {
							return (
								'<div class="mdr-aci__metric"><span class="mdr-aci__metric-label">' +
								escapeHtml(m.label) +
								'</span><span class="mdr-aci__metric-value">' +
								escapeHtml(m.value) +
								'</span></div>'
							);
						})
						.join('') +
					'</div>';
			}

			return cardWrapper(
				section.title,
				section.summary,
				metricsHtml + insightsHtml(section.insights),
				iconFor(type),
				delayIndex
			);
		}

		function buildCarrierCard(section, delayIndex) {
			if (!section || !section.carriers || !section.carriers.length) {
				return cardWrapper(
					section ? section.title : '',
					section ? section.summary : '',
					'<p class="mdr-aci__card-summary">' + escapeHtml('No carrier data detected in upload.') + '</p>',
					iconFor('carrier'),
					delayIndex
				);
			}

			const rows = section.carriers
				.map(function (c) {
					return (
						'<tr><td>' +
						escapeHtml(c.name) +
						'</td><td>' +
						escapeHtml(String(c.loads)) +
						'</td><td>' +
						escapeHtml(c.spend) +
						'</td><td>' +
						escapeHtml(c.on_time) +
						'</td></tr>'
					);
				})
				.join('');

			const table =
				'<div class="mdr-aci__table-wrap"><table class="mdr-aci__table"><thead><tr><th>Carrier</th><th>Loads</th><th>Spend</th><th>On-Time</th></tr></thead><tbody>' +
				rows +
				'</tbody></table></div>';

			return cardWrapper(
				section.title,
				section.summary,
				table + insightsHtml(section.insights),
				iconFor('carrier'),
				delayIndex
			);
		}

		function buildRoutingCard(section, delayIndex) {
			if (!section) return '';
			const opportunities = section.opportunities || [];
			const body =
				opportunities.length > 0
					? buildOpportunityTable(opportunities)
					: '<p class="mdr-aci__card-summary">No routing variance detected yet — upload more lane history for deeper insights.</p>';

			return cardWrapper(
				section.title,
				section.summary,
				body + insightsHtml(section.insights),
				iconFor('routing'),
				delayIndex
			);
		}

		function buildOpportunityTable(opportunities) {
			const rows = opportunities
				.map(function (o) {
					return (
						'<tr><td>' +
						escapeHtml(o.lane) +
						'</td><td>' +
						escapeHtml(o.spread) +
						'</td><td>' +
						escapeHtml(String(o.loads)) +
						'</td></tr>'
					);
				})
				.join('');

			return (
				'<div class="mdr-aci__table-wrap"><table class="mdr-aci__table"><thead><tr><th>Lane</th><th>Cost Spread</th><th>Loads</th></tr></thead><tbody>' +
				rows +
				'</tbody></table></div>'
			);
		}

		function buildLaneCard(section, delayIndex) {
			if (!section || !section.lanes || !section.lanes.length) {
				return cardWrapper(
					section ? section.title : '',
					section ? section.summary : '',
					'<p class="mdr-aci__card-summary">Include origin and destination columns for lane analysis.</p>',
					iconFor('lane'),
					delayIndex
				);
			}

			const rows = section.lanes
				.map(function (l) {
					return (
						'<tr><td>' +
						escapeHtml(l.lane) +
						'</td><td>' +
						escapeHtml(String(l.loads)) +
						'</td><td>' +
						escapeHtml(l.avg_cost) +
						'</td></tr>'
					);
				})
				.join('');

			const table =
				'<div class="mdr-aci__table-wrap"><table class="mdr-aci__table"><thead><tr><th>Lane</th><th>Loads</th><th>Avg Cost</th></tr></thead><tbody>' +
				rows +
				'</tbody></table></div>';

			return cardWrapper(
				section.title,
				section.summary,
				table + insightsHtml(section.insights),
				iconFor('lane'),
				delayIndex
			);
		}

		function buildConsolidationCard(section, delayIndex) {
			if (!section) return '';
			const candidates = section.candidates || [];
			const body =
				candidates.length > 0
					? buildConsolidationTable(candidates)
					: '<p class="mdr-aci__card-summary">No consolidation patterns found in the current dataset.</p>';

			return cardWrapper(
				section.title,
				section.summary,
				body + insightsHtml(section.insights),
				iconFor('consolidation'),
				delayIndex
			);
		}

		function buildConsolidationTable(candidates) {
			const rows = candidates
				.map(function (c) {
					return (
						'<tr><td>' +
						escapeHtml(c.lane) +
						'</td><td>' +
						escapeHtml(String(c.shipments)) +
						'</td><td>' +
						escapeHtml(c.combined_spend) +
						'</td></tr>'
					);
				})
				.join('');

			return (
				'<div class="mdr-aci__table-wrap"><table class="mdr-aci__table"><thead><tr><th>Lane</th><th>Shipments</th><th>Spend</th></tr></thead><tbody>' +
				rows +
				'</tbody></table></div>'
			);
		}

		function buildScorecardCard(section, delayIndex) {
			if (!section || !section.scorecards || !section.scorecards.length) {
				return cardWrapper(
					section ? section.title : '',
					section ? section.summary : '',
					'<p class="mdr-aci__card-summary">Add carrier names to generate scorecards.</p>',
					iconFor('scorecard'),
					delayIndex
				);
			}

			const rows = section.scorecards
				.map(function (s) {
					const scoreClass =
						s.score >= 80
							? 'mdr-aci__score--high'
							: s.score >= 65
								? 'mdr-aci__score--mid'
								: 'mdr-aci__score--low';
					return (
						'<tr><td>' +
						escapeHtml(s.carrier) +
						'</td><td><span class="mdr-aci__score ' +
						scoreClass +
						'">' +
						escapeHtml(String(s.score)) +
						'</span></td><td>' +
						escapeHtml(s.recommendation) +
						'</td></tr>'
					);
				})
				.join('');

			const table =
				'<div class="mdr-aci__table-wrap"><table class="mdr-aci__table"><thead><tr><th>Carrier</th><th>Score</th><th>Recommendation</th></tr></thead><tbody>' +
				rows +
				'</tbody></table></div>';

			return cardWrapper(
				section.title,
				section.summary,
				table + insightsHtml(section.insights),
				iconFor('scorecard'),
				delayIndex
			);
		}

		function cardWrapper(title, summary, body, icon, delayIndex) {
			return (
				'<article class="mdr-aci__card" style="animation-delay:' +
				delayIndex * 0.08 +
				's"><div class="mdr-aci__card-icon">' +
				icon +
				'</div><h3 class="mdr-aci__card-title">' +
				escapeHtml(title) +
				'</h3><p class="mdr-aci__card-summary">' +
				escapeHtml(summary) +
				'</p>' +
				body +
				'</article>'
			);
		}

		function insightsHtml(insights) {
			if (!insights || !insights.length) return '';
			return (
				'<ul class="mdr-aci__insights">' +
				insights
					.map(function (i) {
						return '<li>' + escapeHtml(i) + '</li>';
					})
					.join('') +
				'</ul>'
			);
		}

		function iconFor(type) {
			const icons = {
				savings:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
				carrier:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7V8zM5.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM18.5 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" stroke="currentColor" stroke-width="1.5"/></svg>',
				routing:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 12h7l3-8 4 16 3-8h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
				lane:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
				service:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
				consolidation:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
				scorecard:
					'<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
			};
			return icons[type] || icons.savings;
		}

		function escapeHtml(str) {
			const div = document.createElement('div');
			div.textContent = str == null ? '' : String(str);
			return div.innerHTML;
		}

		function openDemoModal() {
			if (!modal) return;
			show(modal);
			modal.setAttribute('aria-hidden', 'false');
			lockBodyScroll();
			const closeBtn = modal.querySelector('[data-mdr-aci-modal-close]');
			if (closeBtn) closeBtn.focus();
		}

		function closeDemoModal() {
			if (!modal) return;
			hide(modal);
			modal.setAttribute('aria-hidden', 'true');
			if (!uploadModal || uploadModal.hidden) {
				unlockBodyScroll();
			}
		}

		function ensureUploadCloseButtonStyles() {
			if (!uploadModal) return;
			const closeBtn = uploadModal.querySelector('.mdr-aci__modal-close--upload');
			if (!closeBtn) return;

			const styles = window.getComputedStyle(uploadModal);
			const red =
				styles.getPropertyValue('--mdr-aci-button-bg').trim() || '#da1121';
			const redHover =
				styles.getPropertyValue('--mdr-aci-button-hover').trim() || '#911a1e';

			closeBtn.style.setProperty('background-color', red, 'important');
			closeBtn.style.setProperty('border', '0', 'important');
			closeBtn.style.setProperty('color', '#ffffff', 'important');
			closeBtn.dataset.mdrAciCloseHover = redHover;

			closeBtn.querySelectorAll('.mdr-aci__modal-close-bar').forEach(function (bar) {
				bar.style.setProperty('display', 'block', 'important');
				bar.style.setProperty('background-color', '#ffffff', 'important');
				bar.style.setProperty('opacity', '1', 'important');
				bar.style.setProperty('visibility', 'visible', 'important');
			});
		}

		function openUploadModal() {
			if (!uploadModal) return;
			resetFlow();
			ensureUploadCloseButtonStyles();
			show(uploadModal);
			uploadModal.setAttribute('aria-hidden', 'false');
			lockBodyScroll();
			const closeBtn = uploadModal.querySelector('[data-mdr-aci-upload-modal-close]');
			if (closeBtn) closeBtn.focus();
		}

		function closeUploadModal() {
			if (!uploadModal) return;
			hide(uploadModal);
			uploadModal.setAttribute('aria-hidden', 'true');
			resetFlow();
			if (!modal || modal.hidden) {
				unlockBodyScroll();
			}
		}

		function lockBodyScroll() {
			document.documentElement.classList.add('mdr-aci-modal-open');
			document.body.classList.add('mdr-aci-modal-open');
		}

		function unlockBodyScroll() {
			document.documentElement.classList.remove('mdr-aci-modal-open');
			document.body.classList.remove('mdr-aci-modal-open');
		}

		root.addEventListener('click', function (e) {
			const uploadTrigger = e.target.closest('[data-mdr-aci-upload-trigger]');
			if (uploadTrigger) {
				e.preventDefault();
				openUploadModal();
				return;
			}

			const demoBtn = e.target.closest('[data-mdr-aci-demo-open]');
			if (demoBtn) {
				e.preventDefault();
				openDemoModal();
				return;
			}

			const resetBtn = e.target.closest('[data-mdr-aci-reset]');
			if (resetBtn) {
				e.preventDefault();
				resetFlow();
			}
		});

		if (uploadModal) {
			uploadModal.addEventListener('click', function (e) {
				const demoBtn = e.target.closest('[data-mdr-aci-demo-open]');
				if (demoBtn) {
					e.preventDefault();
					openDemoModal();
					return;
				}

				const resetBtn = e.target.closest('[data-mdr-aci-reset]');
				if (resetBtn) {
					e.preventDefault();
					resetFlow();
					return;
				}

				if (
					e.target.matches('[data-mdr-aci-upload-modal-overlay]') ||
					e.target.closest('[data-mdr-aci-upload-modal-close]')
				) {
					if (currentStep !== 'processing') {
						closeUploadModal();
					}
				}
			});
		}

		if (dropzone && fileInput) {
			dropzone.addEventListener('click', function (e) {
				if (e.target === fileInput) return;
				e.preventDefault();
				fileInput.click();
			});

			dropzone.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					fileInput.click();
				}
			});

			fileInput.addEventListener('change', function () {
				if (fileInput.files && fileInput.files[0]) {
					handleFile(fileInput.files[0]);
				}
			});

			['dragenter', 'dragover'].forEach(function (eventName) {
				dropzone.addEventListener(eventName, function (e) {
					e.preventDefault();
					e.stopPropagation();
					dropzone.classList.add('is-dragover');
				});
			});

			['dragleave', 'drop'].forEach(function (eventName) {
				dropzone.addEventListener(eventName, function (e) {
					e.preventDefault();
					e.stopPropagation();
					dropzone.classList.remove('is-dragover');
				});
			});

			dropzone.addEventListener('drop', function (e) {
				const files = e.dataTransfer && e.dataTransfer.files;
				if (files && files[0]) {
					handleFile(files[0]);
				}
			});
		}

		if (modal) {
			modal.addEventListener('click', function (e) {
				if (
					e.target.matches('[data-mdr-aci-modal-overlay]') ||
					e.target.closest('[data-mdr-aci-modal-close]')
				) {
					closeDemoModal();
				}
			});
		}

		document.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape') return;
			if (uploadModal && !uploadModal.hidden) {
				if (currentStep !== 'processing') {
					closeUploadModal();
				}
			} else if (modal && !modal.hidden) {
				closeDemoModal();
			}
		});

		ensureUploadCloseButtonStyles();
	}
})();
