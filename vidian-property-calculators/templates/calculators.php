<?php
/**
 * Calculator template.
 *
 * @package VidianPropertyCalculators
 *
 * @var bool   $show_hero
 * @var bool   $show_cta
 * @var string $consultation_url
 * @var string $contact_url
 * @var string $default_tab
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="vcp-calculators" data-default-tab="<?php echo esc_attr( $default_tab ); ?>">
	<?php if ( $show_hero ) : ?>
		<div class="vcp-hero">
			<div class="vcp-container vcp-hero__inner">
				<h1 class="vcp-hero__title"><?php esc_html_e( 'Property Investment Calculators', 'vidian-property-calculators' ); ?></h1>
				<p class="vcp-hero__subtitle"><?php esc_html_e( 'Essential tools to help you plan your property investment journey.', 'vidian-property-calculators' ); ?></p>
			</div>
		</div>
	<?php endif; ?>

	<div class="vcp-main">
		<div class="vcp-container">
			<div class="vcp-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Property calculators', 'vidian-property-calculators' ); ?>">
				<button
					type="button"
					class="vcp-tab<?php echo 'stamp-duty' === $default_tab ? ' is-active' : ''; ?>"
					role="tab"
					id="vcp-tab-stamp-duty"
					aria-selected="<?php echo 'stamp-duty' === $default_tab ? 'true' : 'false'; ?>"
					aria-controls="vcp-panel-stamp-duty"
					data-tab="stamp-duty"
				>
					<svg class="vcp-tab__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<rect width="16" height="20" x="4" y="2" rx="2"/>
						<line x1="8" x2="16" y1="6" y2="6"/>
						<line x1="16" x2="16" y1="14" y2="18"/>
						<path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 10h.01"/>
						<path d="M12 14h.01"/><path d="M8 14h.01"/><path d="M12 18h.01"/><path d="M8 18h.01"/>
					</svg>
					<span class="vcp-tab__label"><?php esc_html_e( 'Stamp Duty', 'vidian-property-calculators' ); ?></span>
				</button>
				<button
					type="button"
					class="vcp-tab<?php echo 'yield' === $default_tab ? ' is-active' : ''; ?>"
					role="tab"
					id="vcp-tab-yield"
					aria-selected="<?php echo 'yield' === $default_tab ? 'true' : 'false'; ?>"
					aria-controls="vcp-panel-yield"
					data-tab="yield"
				>
					<svg class="vcp-tab__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<line x1="19" x2="5" y1="5" y2="19"/>
						<circle cx="6.5" cy="6.5" r="2.5"/>
						<circle cx="17.5" cy="17.5" r="2.5"/>
					</svg>
					<span class="vcp-tab__label"><?php esc_html_e( 'Rental Yield', 'vidian-property-calculators' ); ?></span>
				</button>
				<button
					type="button"
					class="vcp-tab<?php echo 'mortgage' === $default_tab ? ' is-active' : ''; ?>"
					role="tab"
					id="vcp-tab-mortgage"
					aria-selected="<?php echo 'mortgage' === $default_tab ? 'true' : 'false'; ?>"
					aria-controls="vcp-panel-mortgage"
					data-tab="mortgage"
				>
					<svg class="vcp-tab__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
						<path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
					</svg>
					<span class="vcp-tab__label"><?php esc_html_e( 'Mortgage', 'vidian-property-calculators' ); ?></span>
				</button>
			</div>

			<!-- Stamp Duty Calculator -->
			<div
				class="vcp-panel<?php echo 'stamp-duty' === $default_tab ? ' is-active' : ''; ?>"
				role="tabpanel"
				id="vcp-panel-stamp-duty"
				aria-labelledby="vcp-tab-stamp-duty"
				<?php echo 'stamp-duty' !== $default_tab ? 'hidden' : ''; ?>
			>
				<div class="vcp-card">
					<div class="vcp-card__header">
						<h2 class="vcp-card__title"><?php esc_html_e( 'Stamp Duty Land Tax (SDLT) Calculator', 'vidian-property-calculators' ); ?></h2>
					</div>
					<div class="vcp-card__body">
						<div class="vcp-form-grid vcp-form-grid--2">
							<div class="vcp-field">
								<label class="vcp-label" for="vcp-sdlt-price"><?php esc_html_e( 'Property Price (£)', 'vidian-property-calculators' ); ?></label>
								<input class="vcp-input vcp-input--lg" type="number" id="vcp-sdlt-price" value="300000" min="0" step="1000" />
							</div>
							<div class="vcp-field">
								<label class="vcp-label" for="vcp-sdlt-buyer"><?php esc_html_e( 'Buyer Type', 'vidian-property-calculators' ); ?></label>
								<div class="vcp-select-wrap">
									<select class="vcp-select vcp-input--lg" id="vcp-sdlt-buyer">
										<option value="first"><?php esc_html_e( 'First Time Buyer', 'vidian-property-calculators' ); ?></option>
										<option value="mover"><?php esc_html_e( 'Home Mover', 'vidian-property-calculators' ); ?></option>
										<option value="investor" selected><?php esc_html_e( 'Investor / Additional Property', 'vidian-property-calculators' ); ?></option>
									</select>
								</div>
							</div>
						</div>

						<div class="vcp-checkbox-row">
							<input class="vcp-checkbox" type="checkbox" id="vcp-sdlt-non-resident" checked />
							<label class="vcp-checkbox-label" for="vcp-sdlt-non-resident">
								<?php esc_html_e( 'Non-UK Resident', 'vidian-property-calculators' ); ?>
								<span class="vcp-checkbox-hint"><?php esc_html_e( '(+2% surcharge applies)', 'vidian-property-calculators' ); ?></span>
							</label>
						</div>

						<button type="button" class="vcp-btn vcp-btn--primary vcp-btn--full" id="vcp-sdlt-calculate">
							<?php esc_html_e( 'Calculate Stamp Duty', 'vidian-property-calculators' ); ?>
						</button>

						<div class="vcp-result vcp-result--hidden" id="vcp-sdlt-result" aria-live="polite">
							<p class="vcp-result__label"><?php esc_html_e( 'Estimated Stamp Duty Payable', 'vidian-property-calculators' ); ?></p>
							<p class="vcp-result__value" id="vcp-sdlt-amount">£0</p>
							<p class="vcp-result__note" id="vcp-sdlt-note"></p>
						</div>
					</div>
				</div>
			</div>

			<!-- Rental Yield Calculator -->
			<div
				class="vcp-panel<?php echo 'yield' === $default_tab ? ' is-active' : ''; ?>"
				role="tabpanel"
				id="vcp-panel-yield"
				aria-labelledby="vcp-tab-yield"
				<?php echo 'yield' !== $default_tab ? 'hidden' : ''; ?>
			>
				<div class="vcp-card">
					<div class="vcp-card__header">
						<h2 class="vcp-card__title"><?php esc_html_e( 'Rental Yield Calculator', 'vidian-property-calculators' ); ?></h2>
					</div>
					<div class="vcp-card__body">
						<div class="vcp-form-grid vcp-form-grid--2 vcp-form-grid--wide">
							<div class="vcp-field-group">
								<h3 class="vcp-field-group__title"><?php esc_html_e( 'Property Details', 'vidian-property-calculators' ); ?></h3>
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-yield-price"><?php esc_html_e( 'Purchase Price (£)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-yield-price" value="250000" min="0" step="1000" />
								</div>
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-yield-rent"><?php esc_html_e( 'Monthly Rent (£)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-yield-rent" value="1250" min="0" step="50" />
								</div>
							</div>
							<div class="vcp-field-group">
								<h3 class="vcp-field-group__title"><?php esc_html_e( 'Annual Costs', 'vidian-property-calculators' ); ?></h3>
								<div class="vcp-form-grid vcp-form-grid--2 vcp-form-grid--nested">
									<div class="vcp-field">
										<label class="vcp-label" for="vcp-yield-service"><?php esc_html_e( 'Service Charge (£)', 'vidian-property-calculators' ); ?></label>
										<input class="vcp-input" type="number" id="vcp-yield-service" value="1500" min="0" step="100" />
									</div>
									<div class="vcp-field">
										<label class="vcp-label" for="vcp-yield-ground"><?php esc_html_e( 'Ground Rent (£)', 'vidian-property-calculators' ); ?></label>
										<input class="vcp-input" type="number" id="vcp-yield-ground" value="250" min="0" step="50" />
									</div>
									<div class="vcp-field vcp-field--full">
										<label class="vcp-label" for="vcp-yield-mgmt"><?php esc_html_e( 'Management Fee (%)', 'vidian-property-calculators' ); ?></label>
										<input class="vcp-input" type="number" id="vcp-yield-mgmt" value="10" min="0" max="100" step="0.5" />
									</div>
								</div>
							</div>
						</div>

						<div class="vcp-yield-results">
							<div class="vcp-yield-box">
								<p class="vcp-yield-box__label"><?php esc_html_e( 'Gross Yield', 'vidian-property-calculators' ); ?></p>
								<p class="vcp-yield-box__value" id="vcp-yield-gross">6.00%</p>
							</div>
							<div class="vcp-yield-box vcp-yield-box--primary">
								<p class="vcp-yield-box__label"><?php esc_html_e( 'Net Yield', 'vidian-property-calculators' ); ?></p>
								<p class="vcp-yield-box__value" id="vcp-yield-net">4.70%</p>
							</div>
						</div>

						<div class="vcp-yield-summary">
							<span><?php esc_html_e( 'Annual Income:', 'vidian-property-calculators' ); ?> <span id="vcp-yield-income">£15,000</span></span>
							<span><?php esc_html_e( 'Net Annual Cash Flow:', 'vidian-property-calculators' ); ?> <strong id="vcp-yield-cashflow">£11,750</strong></span>
						</div>
					</div>
				</div>
			</div>

			<!-- Mortgage Calculator -->
			<div
				class="vcp-panel<?php echo 'mortgage' === $default_tab ? ' is-active' : ''; ?>"
				role="tabpanel"
				id="vcp-panel-mortgage"
				aria-labelledby="vcp-tab-mortgage"
				<?php echo 'mortgage' !== $default_tab ? 'hidden' : ''; ?>
			>
				<div class="vcp-card">
					<div class="vcp-card__header">
						<h2 class="vcp-card__title"><?php esc_html_e( 'Mortgage Repayment Calculator', 'vidian-property-calculators' ); ?></h2>
					</div>
					<div class="vcp-card__body">
						<div class="vcp-form-grid vcp-form-grid--2 vcp-form-grid--wide">
							<div class="vcp-field-group vcp-field-group--plain">
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-mortgage-value"><?php esc_html_e( 'Property Value (£)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-mortgage-value" value="300000" min="0" step="1000" />
								</div>
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-mortgage-deposit"><?php esc_html_e( 'Deposit Amount (£)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-mortgage-deposit" value="75000" min="0" step="1000" />
									<p class="vcp-field-hint" id="vcp-mortgage-ltv">25.0% LTV: 75.0%</p>
								</div>
							</div>
							<div class="vcp-field-group vcp-field-group--plain">
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-mortgage-rate"><?php esc_html_e( 'Interest Rate (%)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-mortgage-rate" value="4.5" min="0" max="30" step="0.1" />
								</div>
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-mortgage-term"><?php esc_html_e( 'Mortgage Term (Years)', 'vidian-property-calculators' ); ?></label>
									<input class="vcp-input" type="number" id="vcp-mortgage-term" value="25" min="1" max="40" step="1" />
								</div>
								<div class="vcp-field">
									<label class="vcp-label" for="vcp-mortgage-type"><?php esc_html_e( 'Mortgage Type', 'vidian-property-calculators' ); ?></label>
									<div class="vcp-select-wrap">
										<select class="vcp-select" id="vcp-mortgage-type">
											<option value="repayment"><?php esc_html_e( 'Capital Repayment', 'vidian-property-calculators' ); ?></option>
											<option value="interest"><?php esc_html_e( 'Interest Only', 'vidian-property-calculators' ); ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="vcp-result vcp-result--mortgage">
							<p class="vcp-result__label"><?php esc_html_e( 'Estimated Monthly Payment', 'vidian-property-calculators' ); ?></p>
							<p class="vcp-result__value" id="vcp-mortgage-payment">£1,250.62</p>
							<p class="vcp-result__subtext"><?php esc_html_e( 'Loan Amount:', 'vidian-property-calculators' ); ?> <span id="vcp-mortgage-loan">£225,000</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ( $show_cta ) : ?>
		<section class="vcp-cta">
			<div class="vcp-container vcp-cta__inner">
				<h2 class="vcp-cta__title"><?php esc_html_e( 'Start Your Investment Journey', 'vidian-property-calculators' ); ?></h2>
				<p class="vcp-cta__text"><?php esc_html_e( "Whether you're looking for your first buy-to-let or expanding a global portfolio, our team is here to help you make informed decisions.", 'vidian-property-calculators' ); ?></p>
				<div class="vcp-cta__actions">
					<a href="<?php echo esc_url( $consultation_url ); ?>" class="vcp-btn vcp-btn--primary vcp-btn--cta">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>
						</svg>
						<?php esc_html_e( 'Book Free Consultation', 'vidian-property-calculators' ); ?>
					</a>
					<a href="<?php echo esc_url( $contact_url ); ?>" class="vcp-btn vcp-btn--outline vcp-btn--cta">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
						</svg>
						<?php esc_html_e( 'Contact Us', 'vidian-property-calculators' ); ?>
					</a>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>
