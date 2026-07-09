/* Outlandis Homes — Main JavaScript */

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initMobileNav();
  initScrollAnimations();
  initListingFilters();
  initListingsPage();
  initContactForm();
});

function initHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const onScroll = () => {
    header.classList.toggle('scrolled', window.scrollY > 60);
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
}

function initMobileNav() {
  const toggle = document.querySelector('.mobile-toggle');
  const nav = document.querySelector('.main-nav');
  if (!toggle || !nav) return;
  toggle.addEventListener('click', () => {
    nav.classList.toggle('open');
    toggle.classList.toggle('active');
  });
}

function initScrollAnimations() {
  const elements = document.querySelectorAll('.fade-up');
  if (!elements.length) return;
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    },
    { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
  );
  elements.forEach((el) => observer.observe(el));
}

function createListingCard(listing, showFeatured = true) {
  const badge = listing.featured && showFeatured
    ? '<span class="listing-badge featured">Featured</span>'
    : `<span class="listing-badge">${listing.brand}</span>`;

  const baths = listing.baths % 1 === 0 ? listing.baths : listing.baths.toFixed(1);

  return `
    <article class="listing-card fade-up visible" data-brand="${listing.brand}" data-width="${listing.width || ''}">
      <div class="listing-card-image">
        <img src="${listing.image}" alt="${listing.name}" loading="lazy" />
        ${badge}
      </div>
      <div class="listing-card-body">
        <span class="listing-series">${listing.series}</span>
        <h3>${listing.name}</h3>
        <p class="listing-brand">Built by ${listing.brand} · Offered by Outlandis Corp</p>
        <div class="listing-specs">
          <div class="spec-item"><strong>${listing.beds}</strong><span>Beds</span></div>
          <div class="spec-item"><strong>${baths}</strong><span>Baths</span></div>
          <div class="spec-item"><strong>${listing.sqft.toLocaleString()}</strong><span>Sq Ft</span></div>
          <div class="spec-item"><strong style="font-size:0.85rem">${(listing.dimensions || '—').split(' ')[0]}</strong><span>Size</span></div>
        </div>
        ${listing.description ? `<p class="listing-desc">${listing.description}</p>` : ''}
        <div class="listing-actions">
          <a href="${listing.url}" target="_blank" rel="noopener" class="btn btn-outline-dark btn-sm">More Info</a>
          <a href="contact.html?home=${encodeURIComponent(listing.name)}" class="btn btn-primary btn-sm">Price Quote</a>
        </div>
      </div>
    </article>
  `;
}

function initListingFilters() {
  if (document.getElementById('mw-featured-grid') || document.getElementById('mw-plans-grid')) return;
  const grid = document.getElementById('featured-listings');
  const filters = document.querySelectorAll('.listings-filters .filter-btn');
  if (!grid || typeof OUTLANDIS_LISTINGS === 'undefined') return;

  const listings = OUTLANDIS_LISTINGS.featured;
  renderListings(grid, listings);

  filters.forEach((btn) => {
    btn.addEventListener('click', () => {
      filters.forEach((f) => f.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      let filtered = listings;
      if (filter !== 'all') {
        filtered = listings.filter(
          (l) => l.brand.toLowerCase() === filter || l.width === filter
        );
      }
      renderListings(grid, filtered);
      initScrollAnimations();
    });
  });
}

function renderListings(container, listings) {
  container.innerHTML = listings.map((l) => createListingCard(l)).join('');
}

function initListingsPage() {
  if (document.getElementById('mw-plans-grid')) return;
  const grid = document.getElementById('all-listings');
  const searchInput = document.getElementById('listing-search');
  const brandSelect = document.getElementById('brand-filter');
  const widthSelect = document.getElementById('width-filter');
  const countEl = document.getElementById('listings-count');

  if (!grid || typeof OUTLANDIS_LISTINGS === 'undefined') return;

  let allListings = OUTLANDIS_LISTINGS.catalog.map((l) => ({
    ...l,
    type: 'manufactured',
    description: `${l.series} series by ${l.brand}. ${l.beds} bed, ${l.baths} bath, ${l.sqft.toLocaleString()} sq. ft.`
  }));

  function filterAndRender() {
    const query = (searchInput?.value || '').toLowerCase();
    const brand = brandSelect?.value || 'all';
    const width = widthSelect?.value || 'all';

    let filtered = allListings;

    if (query) {
      filtered = filtered.filter(
        (l) =>
          l.name.toLowerCase().includes(query) ||
          l.series.toLowerCase().includes(query) ||
          l.brand.toLowerCase().includes(query)
      );
    }
    if (brand !== 'all') filtered = filtered.filter((l) => l.brand === brand);
    if (width !== 'all') filtered = filtered.filter((l) => l.width === width);

    if (countEl) countEl.textContent = `Showing ${filtered.length} floor plans`;
    grid.innerHTML = filtered.map((l) => createListingCard(l, false)).join('');
    initScrollAnimations();
  }

  searchInput?.addEventListener('input', filterAndRender);
  brandSelect?.addEventListener('change', filterAndRender);
  widthSelect?.addEventListener('change', filterAndRender);
  filterAndRender();
}

function initContactForm() {
  const form = document.getElementById('contact-form');
  if (!form) return;

  const params = new URLSearchParams(window.location.search);
  const home = params.get('home');
  if (home) {
    const interest = form.querySelector('[name="interest"]');
    if (interest) interest.value = `Price quote for: ${home}`;
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const original = btn.textContent;
    btn.textContent = 'Message Sent!';
    btn.disabled = true;
    setTimeout(() => {
      btn.textContent = original;
      btn.disabled = false;
      form.reset();
    }, 3000);
  });
}
