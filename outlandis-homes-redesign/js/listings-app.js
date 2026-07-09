/* Outlandis Homes — MW-Style Listings Engine */

(function () {
  const BASE = document.querySelector('meta[name="base-path"]')?.content || '';

  function planUrl(id) {
    return `${BASE}plan.html?id=${encodeURIComponent(id)}`;
  }

  function bathsDisplay(b) {
    return b % 1 === 0 ? b : b.toFixed(2);
  }

  function createMWPlanCard(listing, options = {}) {
    const badges = [
      `<span class="mw-badge mw-badge-manufactured">Manufactured</span>`,
      listing.featured ? `<span class="mw-badge mw-badge-featured">Featured</span>` : '',
      listing.has3dTour ? `<span class="mw-badge mw-badge-tour">3D Tour</span>` : '',
    ].filter(Boolean).join('');

    const desc = listing.description || '';
    const shortDesc = desc.length > 140 ? desc.slice(0, 140) + '...' : desc;

    return `
      <article class="mw-plan-card fade-up visible" data-id="${listing.id}">
        <div class="mw-plan-image">
          <img src="${BASE}${listing.image}" alt="${listing.name}" loading="lazy" />
          <div class="mw-plan-badges">${badges}</div>
        </div>
        <div class="mw-plan-body">
          <h3 class="mw-plan-title">${listing.series} / <span>${listing.name}</span></h3>
          <p class="mw-plan-meta">Built by: <strong>${listing.manufacturer}</strong></p>
          <p class="mw-plan-meta">Offered by: <strong>Outlandis Corp</strong></p>
          <div class="mw-plan-specs">
            <div class="mw-spec">
              <div class="mw-spec-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
              </div>
              <strong>${listing.beds}</strong>
              <span>Beds</span>
            </div>
            <div class="mw-spec">
              <div class="mw-spec-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 12h16M6 8h12M8 4h8"/></svg>
              </div>
              <strong>${bathsDisplay(listing.baths)}</strong>
              <span>Baths</span>
            </div>
            <div class="mw-spec">
              <div class="mw-spec-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
              </div>
              <strong>${listing.sqft.toLocaleString()}</strong>
              <span>Sq Ft</span>
            </div>
            <div class="mw-spec">
              <div class="mw-spec-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 3H3v18h18V3z"/></svg>
              </div>
              <strong style="font-size:0.75rem">${listing.dimensions}</strong>
              <span>W × L</span>
            </div>
          </div>
          <p class="mw-plan-desc">${shortDesc}</p>
          <div class="mw-plan-actions">
            <a href="${planUrl(listing.id)}" class="mw-btn mw-btn-info">More Info</a>
            <button type="button" class="mw-btn mw-btn-quote" data-quote="${listing.id}">Price Quote</button>
          </div>
        </div>
      </article>
    `;
  }

  function getFilteredListings(filters = {}) {
    if (typeof OUTLANDIS_LISTINGS === 'undefined') return [];
    let list = [...OUTLANDIS_LISTINGS.catalog];

    if (filters.search) {
      const q = filters.search.toLowerCase();
      list = list.filter(
        (l) =>
          l.name.toLowerCase().includes(q) ||
          l.series.toLowerCase().includes(q) ||
          l.brand.toLowerCase().includes(q)
      );
    }
    if (filters.brand && filters.brand !== 'all') list = list.filter((l) => l.brand === filters.brand);
    if (filters.series && filters.series !== 'all') list = list.filter((l) => l.series === filters.series);
    if (filters.section && filters.section !== 'all') list = list.filter((l) => l.section === filters.section);
    if (filters.beds && filters.beds !== 'all') {
      const b = parseInt(filters.beds, 10);
      list = list.filter((l) => l.beds >= b);
    }
    if (filters.baths && filters.baths !== 'all') {
      const b = parseFloat(filters.baths);
      list = list.filter((l) => l.baths >= b);
    }
    if (filters.sqft && filters.sqft !== 'all') {
      const parts = filters.sqft.split('-').map(Number);
      const min = parts[0];
      const max = parts[1];
      list = list.filter((l) => {
        if (max >= 99999) return l.sqft >= min;
        return l.sqft >= min && l.sqft < max;
      });
    }
    if (filters.tour) list = list.filter((l) => l.has3dTour);

    if (filters.sort === 'sqft-desc') list.sort((a, b) => b.sqft - a.sqft);
    else if (filters.sort === 'sqft-asc') list.sort((a, b) => a.sqft - b.sqft);
    else if (filters.sort === 'beds-desc') list.sort((a, b) => b.beds - a.beds);
    else if (filters.sort === 'name') list.sort((a, b) => a.name.localeCompare(b.name));

    return list;
  }

  function getUniqueValues(key) {
    if (typeof OUTLANDIS_LISTINGS === 'undefined') return [];
    return [...new Set(OUTLANDIS_LISTINGS.catalog.map((l) => l[key]))].sort();
  }

  function renderPlansGrid(container, listings) {
    if (!container) return;
    if (!listings.length) {
      container.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:60px;color:var(--text-muted)">No floor plans match your search. Try adjusting filters.</p>';
      return;
    }
    container.innerHTML = listings.map((l) => createMWPlanCard(l)).join('');
    bindQuoteButtons(container);
  }

  function bindQuoteButtons(root = document) {
    root.querySelectorAll('[data-quote]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.quote;
        const listing = getListingById(id);
        if (listing) openQuoteModal(listing);
      });
    });
  }

  /* ─── Quote Modal ─── */
  function ensureModal() {
    if (document.getElementById('quote-modal-overlay')) return;

    const html = `
      <div class="quote-modal-overlay" id="quote-modal-overlay" aria-hidden="true">
        <div class="quote-modal" role="dialog" aria-labelledby="quote-modal-title">
          <div class="quote-modal-header">
            <button class="quote-modal-close" id="quote-modal-close" aria-label="Close">&times;</button>
            <h2 id="quote-modal-title">Request a Price Quote</h2>
            <p>Complete the form below and our team will reach out with pricing and availability.</p>
            <div class="quote-modal-home" id="quote-modal-home"></div>
          </div>
          <div class="quote-modal-body">
            <form id="quote-modal-form">
              <input type="hidden" name="home_id" id="quote-home-id" />
              <input type="hidden" name="home_name" id="quote-home-name" />
              <div class="quote-form-row">
                <div class="quote-form-group">
                  <label for="quote-first">First Name *</label>
                  <input type="text" id="quote-first" name="first_name" required />
                </div>
                <div class="quote-form-group">
                  <label for="quote-last">Last Name *</label>
                  <input type="text" id="quote-last" name="last_name" required />
                </div>
              </div>
              <div class="quote-form-row">
                <div class="quote-form-group">
                  <label for="quote-email">Email *</label>
                  <input type="email" id="quote-email" name="email" required />
                </div>
                <div class="quote-form-group">
                  <label for="quote-phone">Phone *</label>
                  <input type="tel" id="quote-phone" name="phone" required />
                </div>
              </div>
              <div class="quote-form-group">
                <label for="quote-address">Property / Delivery Address</label>
                <input type="text" id="quote-address" name="address" placeholder="City, County, SC" />
              </div>
              <div class="quote-form-row">
                <div class="quote-form-group">
                  <label for="quote-contact">Preferred Contact</label>
                  <select id="quote-contact" name="contact_method">
                    <option value="phone">Phone Call</option>
                    <option value="email">Email</option>
                    <option value="text">Text Message</option>
                  </select>
                </div>
                <div class="quote-form-group">
                  <label for="quote-financing">Interested In Financing?</label>
                  <select id="quote-financing" name="financing">
                    <option value="yes">Yes — I need financing</option>
                    <option value="maybe">Maybe — tell me more</option>
                    <option value="no">No — cash buyer</option>
                  </select>
                </div>
              </div>
              <div class="quote-form-group">
                <label for="quote-timeline">When are you looking to purchase?</label>
                <select id="quote-timeline" name="timeline">
                  <option value="asap">As soon as possible</option>
                  <option value="1-3">1–3 months</option>
                  <option value="3-6">3–6 months</option>
                  <option value="exploring">Just exploring options</option>
                </select>
              </div>
              <div class="quote-form-group">
                <label for="quote-message">Additional Questions or Notes</label>
                <textarea id="quote-message" name="message" placeholder="Land owned? Site prep needed? Specific customizations?"></textarea>
              </div>
              <button type="submit" class="quote-form-submit">Submit Price Quote Request</button>
              <p class="quote-form-note">By submitting, you agree to be contacted by Outlandis Corp. Dealer License: 35784 · Sales License: 37098 · South Carolina, USA</p>
            </form>
          </div>
        </div>
      </div>
    `;
    document.body.insertAdjacentHTML('beforeend', html);

    document.getElementById('quote-modal-close').addEventListener('click', closeQuoteModal);
    document.getElementById('quote-modal-overlay').addEventListener('click', (e) => {
      if (e.target.id === 'quote-modal-overlay') closeQuoteModal();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeQuoteModal();
    });
    document.getElementById('quote-modal-form').addEventListener('submit', (e) => {
      e.preventDefault();
      const btn = e.target.querySelector('.quote-form-submit');
      btn.textContent = '✓ Request Sent Successfully!';
      btn.style.background = 'linear-gradient(135deg, #22c55e, #16a34a)';
      setTimeout(() => {
        closeQuoteModal();
        btn.textContent = 'Submit Price Quote Request';
        btn.style.background = '';
        e.target.reset();
      }, 2500);
    });
  }

  function openQuoteModal(listing) {
    ensureModal();
    const overlay = document.getElementById('quote-modal-overlay');
    document.getElementById('quote-home-id').value = listing.id;
    document.getElementById('quote-home-name').value = `${listing.series} / ${listing.name}`;
    document.getElementById('quote-modal-home').innerHTML = `
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
      ${listing.series} / ${listing.name} — ${listing.sqft.toLocaleString()} sq. ft.
    `;
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeQuoteModal() {
    const overlay = document.getElementById('quote-modal-overlay');
    if (!overlay) return;
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  /* ─── Floor Plans Page ─── */
  function initFloorPlansPage() {
    const grid = document.getElementById('mw-plans-grid');
    if (!grid) return;

    const brands = getUniqueValues('brand');
    const series = getUniqueValues('series');
    const brandSelect = document.getElementById('filter-brand');
    const seriesSelect = document.getElementById('filter-series');

    if (brandSelect) {
      brands.forEach((b) => {
        brandSelect.innerHTML += `<option value="${b}">${b}</option>`;
      });
    }
    if (seriesSelect) {
      series.forEach((s) => {
        seriesSelect.innerHTML += `<option value="${s}">${s}</option>`;
      });
    }

    function applyFilters() {
      const filters = {
        search: document.getElementById('filter-search')?.value || '',
        brand: document.getElementById('filter-brand')?.value || 'all',
        series: document.getElementById('filter-series')?.value || 'all',
        section: document.getElementById('filter-section')?.value || 'all',
        beds: document.getElementById('filter-beds')?.value || 'all',
        baths: document.getElementById('filter-baths')?.value || 'all',
        sqft: document.getElementById('filter-sqft')?.value || 'all',
        tour: document.getElementById('filter-tour')?.checked || false,
        sort: document.getElementById('filter-sort')?.value || '',
      };
      const results = getFilteredListings(filters);
      const countEl = document.getElementById('mw-results-count');
      if (countEl) countEl.textContent = `${results.length} Floor Plans Found`;
      renderPlansGrid(grid, results);
    }

    document.getElementById('mw-filter-form')?.addEventListener('submit', (e) => {
      e.preventDefault();
      applyFilters();
    });

    ['filter-brand', 'filter-series', 'filter-section', 'filter-beds', 'filter-baths', 'filter-sqft', 'filter-sort'].forEach((id) => {
      document.getElementById(id)?.addEventListener('change', applyFilters);
    });
    document.getElementById('filter-search')?.addEventListener('input', applyFilters);
    document.getElementById('filter-tour')?.addEventListener('change', applyFilters);

    applyFilters();
  }

  /* ─── Homepage Featured ─── */
  function initFeaturedSection() {
    const grid = document.getElementById('mw-featured-grid');
    if (!grid || typeof OUTLANDIS_LISTINGS === 'undefined') return;

    let listings = OUTLANDIS_LISTINGS.featured;

    function render(filter) {
      let filtered = listings;
      if (filter && filter !== 'all') {
        filtered = OUTLANDIS_LISTINGS.catalog.filter(
          (l) => l.brand.toLowerCase() === filter || l.section === filter
        ).slice(0, 6);
        if (!filtered.length) filtered = listings;
      }
      renderPlansGrid(grid, filtered.slice(0, 6));
    }

    document.querySelectorAll('.mw-tab').forEach((tab) => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.mw-tab').forEach((t) => t.classList.remove('active'));
        tab.classList.add('active');
        render(tab.dataset.filter);
      });
    });

    render('all');
  }

  /* ─── Plan Detail Page ─── */
  function initPlanDetailPage() {
    const container = document.getElementById('plan-detail-root');
    if (!container) return;

    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const listing = id ? getListingById(id) : null;

    if (!listing) {
      container.innerHTML = '<div class="container" style="padding:120px 0;text-align:center"><h2>Floor plan not found</h2><a href="listings.html" class="btn btn-primary" style="margin-top:24px">Browse All Plans</a></div>';
      return;
    }

    document.title = `${listing.series} / ${listing.name} | Outlandis Corp`;

    const tourSection = listing.tourUrl
      ? `<div class="plan-section-title">3D Virtual Tour</div>
         <div class="plan-tour-embed"><iframe src="${listing.tourUrl}" allowfullscreen loading="lazy"></iframe></div>`
      : '';

    const externalLink = listing.externalUrl
      ? `<a href="${listing.externalUrl}" target="_blank" rel="noopener" class="btn btn-outline-dark btn-sm" style="margin-top:12px">View Manufacturer Details →</a>`
      : '';

    const notesBlock = listing.notes
      ? `<p class="plan-description" style="background:var(--primary-light);padding:16px;border-radius:12px;border-left:3px solid var(--primary)"><strong>Note:</strong> ${listing.notes}</p>`
      : '';

    container.innerHTML = `
      <div class="plan-detail-hero">
        <div class="container">
          <a href="listings.html" class="plan-back">← Back to all floor plans</a>
          <h1>${listing.series} / ${listing.name}</h1>
          <div class="plan-detail-tags">
            <span class="mw-badge mw-badge-manufactured">Manufactured</span>
            ${listing.featured ? '<span class="mw-badge mw-badge-featured">Featured</span>' : ''}
            ${listing.has3dTour ? '<span class="mw-badge mw-badge-tour">3D Tour Available</span>' : ''}
            <span class="mw-badge" style="background:var(--bg-warm);color:var(--text)">${listing.section} section</span>
          </div>
          <div class="plan-spec-bar">
            <div><strong>${listing.beds}</strong> Beds</div>
            <div><strong>${bathsDisplay(listing.baths)}</strong> Baths</div>
            <div><strong>${listing.sqft.toLocaleString()}</strong> Sq Ft</div>
            <div><strong>${listing.dimensions}</strong> W × L</div>
          </div>
          <p class="plan-built-by">BUILT BY: <strong>${listing.manufacturer}</strong> · OFFERED BY: <strong>Outlandis Corp</strong></p>
          <div class="plan-detail-actions">
            <button type="button" class="btn btn-gold" data-quote="${listing.id}">Price Quote</button>
            ${listing.externalUrl ? `<a href="${listing.externalUrl}" target="_blank" rel="noopener" class="btn btn-primary">Manufacturer Brochure</a>` : ''}
            <a href="contact.html" class="btn btn-outline-dark">Contact Us</a>
          </div>
        </div>
      </div>
      <div class="plan-detail-content">
        <div class="container plan-detail-grid">
          <div>
            <div class="plan-main-image">
              <img src="${listing.image}" alt="${listing.name}" />
            </div>
            <p class="plan-description">${listing.description}</p>
            ${notesBlock}
            ${tourSection}
            <div class="plan-section-title">Floor Plan Specifications</div>
            <table class="plan-specs-table">
              <tr><th>Series</th><td>${listing.series}</td></tr>
              <tr><th>Model Name</th><td>${listing.name}</td></tr>
              <tr><th>Manufacturer</th><td>${listing.manufacturer}</td></tr>
              <tr><th>Dealer</th><td>Outlandis Corp — South Carolina</td></tr>
              <tr><th>Bedrooms</th><td>${listing.beds}</td></tr>
              <tr><th>Bathrooms</th><td>${bathsDisplay(listing.baths)}</td></tr>
              <tr><th>Square Footage</th><td>${listing.sqft.toLocaleString()} sq. ft.</td></tr>
              <tr><th>Dimensions (W × L)</th><td>${listing.dimensions}</td></tr>
              <tr><th>Section Type</th><td>${listing.section.charAt(0).toUpperCase() + listing.section.slice(1)} Wide</td></tr>
              <tr><th>Home Type</th><td>Manufactured Home</td></tr>
              <tr><th>3D Tour</th><td>${listing.has3dTour ? 'Available' : 'Contact us for availability'}</td></tr>
            </table>
            ${externalLink}
            <div class="plan-disclaimer">
              <strong>PLEASE NOTE:</strong> All sizes and dimensions are nominal or based on approximate manufacturer measurements. Outlandis Corp reserves the right to make changes due to material, color, specifications and features at any time without notice or obligation. Contact our team for the most current pricing and availability.
            </div>
          </div>
          <div>
            <div class="plan-sidebar-card">
              <h3>Quick Summary</h3>
              <div class="plan-sidebar-spec"><span>Series</span><strong>${listing.series}</strong></div>
              <div class="plan-sidebar-spec"><span>Brand</span><strong>${listing.brand}</strong></div>
              <div class="plan-sidebar-spec"><span>Beds / Baths</span><strong>${listing.beds} / ${bathsDisplay(listing.baths)}</strong></div>
              <div class="plan-sidebar-spec"><span>Square Feet</span><strong>${listing.sqft.toLocaleString()}</strong></div>
              <div class="plan-sidebar-spec"><span>Size</span><strong>${listing.dimensions}</strong></div>
              <button type="button" class="btn btn-gold" style="width:100%;margin-top:24px" data-quote="${listing.id}">Get Price Quote</button>
              <a href="tel:18033613668" class="btn btn-outline-dark btn-sm" style="width:100%;margin-top:12px;text-align:center">Call Olivia: (803) 361-3668</a>
              <a href="tel:18643139933" class="btn btn-outline-dark btn-sm" style="width:100%;margin-top:8px;text-align:center">Call Griffin: (864) 313-9933</a>
            </div>
          </div>
        </div>
      </div>
    `;

    bindQuoteButtons(container);
  }

  document.addEventListener('DOMContentLoaded', () => {
    ensureModal();
    initFloorPlansPage();
    initFeaturedSection();
    initPlanDetailPage();
  });

  window.OutlandisListings = {
    createMWPlanCard,
    openQuoteModal,
    getFilteredListings,
    renderPlansGrid,
  };
})();
