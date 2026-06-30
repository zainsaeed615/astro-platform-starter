/**
 * Vidian Property Calculators — interactions and calculations.
 */
(function () {
	'use strict';

	/**
	 * Format number as GBP currency (no decimals).
	 *
	 * @param {number} value Amount.
	 * @return {string}
	 */
	function formatCurrency(value) {
		return '£' + Math.round(value).toLocaleString('en-GB');
	}

	/**
	 * Format number as GBP with decimals.
	 *
	 * @param {number} value Amount.
	 * @return {string}
	 */
	function formatCurrencyDecimal(value) {
		return '£' + value.toLocaleString('en-GB', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
	}

	/**
	 * Parse input value as non-negative number.
	 *
	 * @param {HTMLInputElement} input Input element.
	 * @return {number}
	 */
	function getNumber(input) {
		var value = parseFloat(input.value, 10);
		return isNaN(value) || value < 0 ? 0 : value;
	}

	/**
	 * Calculate Stamp Duty Land Tax.
	 *
	 * @param {number}  price       Property price.
	 * @param {string}  buyerType   Buyer type key.
	 * @param {boolean} nonResident Non-UK resident surcharge.
	 * @return {number}
	 */
	function calculateStampDuty(price, buyerType, nonResident) {
		var remaining = price;
		var total = 0;
		var surcharge = nonResident ? 0.02 : 0;
		var isInvestor = buyerType === 'investor' || buyerType === 'investor-nonres';

		if (isInvestor) {
			var band1 = Math.min(remaining, 125000);
			total += band1 * (0.05 + surcharge);
			remaining -= band1;

			if (remaining > 0) {
				var band2 = Math.min(remaining, 125000);
				total += band2 * (0.07 + surcharge);
				remaining -= band2;
			}

			if (remaining > 0) {
				var band3 = Math.min(remaining, 675000);
				total += band3 * (0.1 + surcharge);
				remaining -= band3;
			}

			if (remaining > 0) {
				var band4 = Math.min(remaining, 575000);
				total += band4 * (0.15 + surcharge);
				remaining -= band4;
			}

			if (remaining > 0) {
				total += remaining * (0.17 + surcharge);
			}
		} else {
			var moverBand1 = Math.min(remaining, 250000);
			total += moverBand1 * (0 + surcharge);
			remaining -= moverBand1;

			if (remaining > 0) {
				var moverBand2 = Math.min(remaining, 675000);
				total += moverBand2 * (0.05 + surcharge);
				remaining -= moverBand2;
			}

			if (remaining > 0) {
				var moverBand3 = Math.min(remaining, 575000);
				total += moverBand3 * (0.1 + surcharge);
				remaining -= moverBand3;
			}

			if (remaining > 0) {
				total += remaining * (0.12 + surcharge);
			}
		}

		return total;
	}

	/**
	 * Initialize tab switching.
	 *
	 * @param {HTMLElement} root Calculator root element.
	 */
	function initTabs(root) {
		var tabs = root.querySelectorAll('.vcp-tab');
		var panels = root.querySelectorAll('.vcp-panel');

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				var target = tab.getAttribute('data-tab');

				tabs.forEach(function (t) {
					var isActive = t.getAttribute('data-tab') === target;
					t.classList.toggle('is-active', isActive);
					t.setAttribute('aria-selected', isActive ? 'true' : 'false');
				});

				panels.forEach(function (panel) {
					var isActive = panel.id === 'vcp-panel-' + target;
					panel.classList.toggle('is-active', isActive);

					if (isActive) {
						panel.removeAttribute('hidden');
					} else {
						panel.setAttribute('hidden', '');
					}
				});
			});
		});
	}

	/**
	 * Initialize Stamp Duty calculator.
	 *
	 * @param {HTMLElement} root Calculator root element.
	 */
	function initStampDuty(root) {
		var priceInput = root.querySelector('#vcp-sdlt-price');
		var buyerSelect = root.querySelector('#vcp-sdlt-buyer');
		var nonResidentInput = root.querySelector('#vcp-sdlt-non-resident');
		var calculateBtn = root.querySelector('#vcp-sdlt-calculate');
		var resultBox = root.querySelector('#vcp-sdlt-result');
		var amountEl = root.querySelector('#vcp-sdlt-amount');
		var noteEl = root.querySelector('#vcp-sdlt-note');

		if (!calculateBtn) {
			return;
		}

		calculateBtn.addEventListener('click', function () {
			var price = getNumber(priceInput);
			var buyerType = buyerSelect.value;
			var nonResident = nonResidentInput.checked;
			var duty = calculateStampDuty(price, buyerType, nonResident);

			amountEl.textContent = formatCurrency(duty);

			var note = '*Rates effective from 1st April 2025. ';
			if (nonResident) {
				note += 'Includes 2% non-UK resident surcharge.';
			}
			noteEl.textContent = note;

			resultBox.classList.remove('vcp-result--hidden');
		});
	}

	/**
	 * Initialize Rental Yield calculator.
	 *
	 * @param {HTMLElement} root Calculator root element.
	 */
	function initRentalYield(root) {
		var priceInput = root.querySelector('#vcp-yield-price');
		var rentInput = root.querySelector('#vcp-yield-rent');
		var serviceInput = root.querySelector('#vcp-yield-service');
		var groundInput = root.querySelector('#vcp-yield-ground');
		var mgmtInput = root.querySelector('#vcp-yield-mgmt');
		var grossEl = root.querySelector('#vcp-yield-gross');
		var netEl = root.querySelector('#vcp-yield-net');
		var incomeEl = root.querySelector('#vcp-yield-income');
		var cashflowEl = root.querySelector('#vcp-yield-cashflow');

		var inputs = [priceInput, rentInput, serviceInput, groundInput, mgmtInput];

		function update() {
			var price = getNumber(priceInput);
			var monthlyRent = getNumber(rentInput);
			var serviceCharge = getNumber(serviceInput);
			var groundRent = getNumber(groundInput);
			var mgmtFee = getNumber(mgmtInput);

			var annualIncome = monthlyRent * 12;
			var mgmtCost = annualIncome * mgmtFee / 100;
			var totalCosts = serviceCharge + groundRent + mgmtCost;
			var netCashFlow = annualIncome - totalCosts;

			var grossYield = price > 0 ? (annualIncome / price) * 100 : 0;
			var netYield = price > 0 ? (netCashFlow / price) * 100 : 0;

			grossEl.textContent = grossYield.toFixed(2) + '%';
			netEl.textContent = netYield.toFixed(2) + '%';
			incomeEl.textContent = formatCurrency(annualIncome);
			cashflowEl.textContent = formatCurrency(netCashFlow);
		}

		inputs.forEach(function (input) {
			input.addEventListener('input', update);
		});

		update();
	}

	/**
	 * Initialize Mortgage calculator.
	 *
	 * @param {HTMLElement} root Calculator root element.
	 */
	function initMortgage(root) {
		var valueInput = root.querySelector('#vcp-mortgage-value');
		var depositInput = root.querySelector('#vcp-mortgage-deposit');
		var rateInput = root.querySelector('#vcp-mortgage-rate');
		var termInput = root.querySelector('#vcp-mortgage-term');
		var typeSelect = root.querySelector('#vcp-mortgage-type');
		var paymentEl = root.querySelector('#vcp-mortgage-payment');
		var loanEl = root.querySelector('#vcp-mortgage-loan');
		var ltvEl = root.querySelector('#vcp-mortgage-ltv');

		var inputs = [valueInput, depositInput, rateInput, termInput, typeSelect];

		function update() {
			var propertyValue = getNumber(valueInput);
			var deposit = Math.min(getNumber(depositInput), propertyValue);
			var interestRate = getNumber(rateInput);
			var termYears = Math.max(getNumber(termInput), 1);
			var mortgageType = typeSelect.value;

			var loanAmount = propertyValue - deposit;
			var monthlyRate = interestRate / 100 / 12;
			var totalPayments = termYears * 12;
			var monthlyPayment = 0;

			if (mortgageType === 'repayment') {
				if (monthlyRate > 0) {
					monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, totalPayments)) /
						(Math.pow(1 + monthlyRate, totalPayments) - 1);
				} else {
					monthlyPayment = loanAmount / totalPayments;
				}
			} else {
				monthlyPayment = loanAmount * (interestRate / 100) / 12;
			}

			var depositPercent = propertyValue > 0 ? (deposit / propertyValue) * 100 : 0;
			var ltvPercent = propertyValue > 0 ? ((propertyValue - deposit) / propertyValue) * 100 : 0;

			paymentEl.textContent = formatCurrencyDecimal(monthlyPayment);
			loanEl.textContent = formatCurrency(loanAmount);
			ltvEl.textContent = depositPercent.toFixed(1) + '% LTV: ' + ltvPercent.toFixed(1) + '%';
		}

		inputs.forEach(function (input) {
			input.addEventListener('input', update);
			input.addEventListener('change', update);
		});

		update();
	}

	/**
	 * Initialize a single calculator instance.
	 *
	 * @param {HTMLElement} root Calculator root element.
	 */
	function initCalculator(root) {
		initTabs(root);
		initStampDuty(root);
		initRentalYield(root);
		initMortgage(root);
	}

	/**
	 * Boot all calculator instances on the page.
	 */
	function boot() {
		document.querySelectorAll('.vcp-calculators').forEach(initCalculator);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
