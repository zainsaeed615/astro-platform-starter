#!/usr/bin/env node
/**
 * Generates static HTML site in /workspace/html-site/ from TypeScript data in /workspace/src/data/
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..');
const OUT = path.join(ROOT, 'html-site');
const DATA_DIR = path.join(ROOT, 'src', 'data');

// ─── Load TypeScript data (plain object literals, no type annotations) ───────

function loadTsExports(filePath) {
  let src = fs.readFileSync(filePath, 'utf8');
  src = src.replace(/^export const /gm, 'const ');
  const names = [...src.matchAll(/^const (\w+) =/gm)].map((m) => m[1]);
  // eslint-disable-next-line no-new-func
  const fn = new Function(`${src}\nreturn { ${names.join(', ')} };`);
  return fn();
}

const shared = loadTsExports(path.join(DATA_DIR, 'shared.ts'));
const sleepy = loadTsExports(path.join(DATA_DIR, 'sleepy-hollow.ts'));
const labyrinth = loadTsExports(path.join(DATA_DIR, 'labyrinth.ts'));

const { siteInfo, weatherContent, employmentFormFields, employmentFaq } = shared;
const {
  sleepyHollowHours,
  sleepyHollowTickets,
  sleepyHollowAttractions,
  sleepyHollowFaq,
} = sleepy;
const {
  labyrinthHours,
  labyrinthTickets,
  labyrinthAttractions,
  labyrinthWarnings,
  labyrinthWarningPoster,
  labyrinthFaq,
  specialEvents,
} = labyrinth;

// ─── Helpers ─────────────────────────────────────────────────────────────────

function escapeHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function writeFile(relPath, content) {
  const full = path.join(OUT, relPath);
  fs.mkdirSync(path.dirname(full), { recursive: true });
  fs.writeFileSync(full, content, 'utf8');
  return relPath;
}

const FONTS =
  '<link rel="preconnect" href="https://fonts.googleapis.com">' +
  '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' +
  '<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cinzel:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">';

const ICON_EMOJI = {
  compass: '🧭',
  utensils: '🍿',
  sparkles: '✨',
  tractor: '🚜',
  'gamepad-2': '🎮',
  eye: '👁️',
  gem: '💎',
  palette: '🎨',
  route: '🌀',
  warehouse: '🏚️',
  'wand-2': '🪄',
};

const EVENT_IDS = ['friday-13th', 'black-friday', 'new-years-eve', 'bloody-valentine'];

function faqAccordion(items) {
  return items
    .map(
      (item) => `<details class="faq-item">
  <summary>${escapeHtml(item.question)}</summary>
  <div class="faq-answer">${escapeHtml(item.answer)}</div>
</details>`
    )
    .join('\n');
}

function footerHtml() {
  const { address, ticketsUrl, social, phone, email } = siteInfo;
  const year = new Date().getFullYear();
  return `<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div>
        <h3 class="footer-heading">📍 Location</h3>
        <address class="footer-links" style="font-style:normal">
          <a href="${escapeHtml(address.mapsUrl)}" target="_blank" rel="noopener noreferrer">
            ${escapeHtml(address.street)}<br>
            ${escapeHtml(address.city)}, ${escapeHtml(address.state)} ${escapeHtml(address.zip)}
          </a>
        </address>
      </div>
      <div>
        <h3 class="footer-heading">🎟 Get Tickets</h3>
        <div class="footer-links">
          <a href="${escapeHtml(ticketsUrl)}" class="footer-tickets">Purchase Tickets Online →</a>
        </div>
      </div>
      <div>
        <h3 class="footer-heading">Follow Us</h3>
        <div class="footer-links">
          <a href="${escapeHtml(social.facebook)}" target="_blank" rel="noopener noreferrer">Facebook</a>
          <a href="${escapeHtml(social.instagram)}" target="_blank" rel="noopener noreferrer">Instagram</a>
          <a href="${escapeHtml(social.tiktok)}" target="_blank" rel="noopener noreferrer">TikTok @eerieeverafter</a>
        </div>
      </div>
      <div>
        <h3 class="footer-heading">Contact Us</h3>
        <div class="footer-links">
          <a href="tel:${escapeHtml(phone)}">📞 ${escapeHtml(phone)}</a>
          <a href="mailto:${escapeHtml(email)}">✉ ${escapeHtml(email)}</a>
        </div>
      </div>
    </div>
    <div class="footer-copy">
      <p>© ${year} Eerie Ever After Events. All Rights Reserved.</p>
    </div>
  </div>
</footer>`;
}

function navHtml(theme, linkPrefix, homeHref) {
  const isIpsh = theme === 'ipsh';
  const brand = isIpsh ? "Ichabod Payne's Sleepy Hollow" : "Payne's Labyrinth";
  const brandClass = isIpsh ? 'font-cinzel' : 'font-bebas';
  const p = linkPrefix;

  const links = isIpsh
    ? [
        { label: 'About Us', href: `${p}about.html` },
        { label: 'Attractions', href: `${p}attractions.html` },
        {
          label: 'Tickets & Pricing',
          items: [
            { label: 'Tickets & Pricing', href: `${p}tickets.html` },
            { label: 'Hours of Operations', href: `${p}hours.html` },
          ],
        },
        {
          label: 'FAQ',
          items: [
            { label: 'FAQ', href: `${p}faq.html` },
            { label: 'Weather Policy', href: `${p}weather.html` },
          ],
        },
        {
          label: 'Employment',
          items: [
            { label: 'FAQs', href: `${p}employment-faq.html` },
            { label: 'Apply Now', href: `${p}employment.html` },
          ],
        },
      ]
    : [
        { label: 'About Us', href: `${p}about.html` },
        { label: 'Attractions', href: `${p}attractions.html` },
        {
          label: 'Tickets & Pricing',
          items: [
            { label: 'Tickets & Pricing', href: `${p}tickets.html` },
            { label: 'Hours of Operations', href: `${p}hours.html` },
          ],
        },
        {
          label: 'FAQ',
          items: [
            { label: 'FAQ', href: `${p}faq.html` },
            { label: 'Warnings', href: `${p}warnings.html` },
            { label: 'Weather Policy', href: `${p}weather.html` },
          ],
        },
        {
          label: 'Employment',
          items: [
            { label: 'FAQs', href: `${p}employment-faq.html` },
            { label: 'Apply Now', href: `${p}employment.html` },
          ],
        },
        {
          label: 'Special Events',
          items: [
            { label: 'Friday the 13th', href: `${p}special-events.html#friday-13th` },
            { label: 'Black Friday', href: `${p}special-events.html#black-friday` },
            { label: "New Year's Eve", href: `${p}special-events.html#new-years-eve` },
            { label: 'Bloody Valentine', href: `${p}special-events.html#bloody-valentine` },
          ],
        },
      ];

  const desktopLinks = links
    .map((link) => {
      if (link.items) {
        const items = link.items
          .map(
            (item) =>
              `<a href="${escapeHtml(item.href)}">${escapeHtml(item.label)}</a>`
          )
          .join('');
        return `<li>
            <button type="button">${escapeHtml(link.label)} <span class="chevron">▾</span></button>
            <div class="dropdown-menu"><div class="dropdown-inner">${items}</div></div>
          </li>`;
      }
      return `<li><a href="${escapeHtml(link.href)}">${escapeHtml(link.label)}</a></li>`;
    })
    .join('\n          ');

  const mobileLinks = links
    .map((link, i) => {
      if (link.items) {
        const id = `submenu-${i}`;
        const items = link.items
          .map(
            (item) =>
              `<a href="${escapeHtml(item.href)}">${escapeHtml(item.label)}</a>`
          )
          .join('');
        return `<button type="button" data-submenu-toggle="${id}">${escapeHtml(link.label)} ▾</button>
          <div class="mobile-submenu" id="${id}">${items}</div>`;
      }
      return `<a href="${escapeHtml(link.href)}">${escapeHtml(link.label)}</a>`;
    })
    .join('\n        ');

  return `<nav class="site-nav">
    <div class="nav-inner">
      <a href="${p}about.html" class="nav-brand ${brandClass}">${escapeHtml(brand)}</a>
      <ul class="nav-links">
          ${desktopLinks}
          <li><a href="${homeHref}" class="nav-home-link">← Main Site</a></li>
      </ul>
      <button class="mobile-toggle" type="button" aria-label="Toggle menu" aria-expanded="false">☰</button>
    </div>
    <div class="mobile-menu">
        ${mobileLinks}
        <a href="${homeHref}">← Main Site</a>
    </div>
  </nav>`;
}

function pageShell({ title, theme, assetPrefix, body }) {
  const themeClass =
    theme === 'ipsh' ? 'theme-ipsh' : theme === 'labyrinth' ? 'theme-labyrinth' : 'theme-home';
  const css = `${assetPrefix}css/styles.css`;
  const js = `${assetPrefix}js/main.js`;
  const nav =
    theme === 'home'
      ? ''
      : navHtml(theme, '', assetPrefix === '../' ? '../index.html' : 'index.html');

  return `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>${escapeHtml(title)}</title>
  ${FONTS}
  <link rel="stylesheet" href="${css}">
</head>
<body class="${themeClass}">
${nav}
<main>
${body}
</main>
${footerHtml()}
<script src="${js}"></script>
</body>
</html>`;
}

function heroBlock({ label, title, subtitle, titleClass = 'page-title font-cinzel' }) {
  return `<section class="page-hero">
  <p class="section-label">${escapeHtml(label)}</p>
  <h1 class="${titleClass}">${escapeHtml(title)}</h1>
  ${subtitle ? `<p class="page-subtitle">${escapeHtml(subtitle)}</p>` : ''}
</section>`;
}

function employmentFormHtml(theme) {
  const btnClass = theme === 'ipsh' ? 'btn btn-ipsh' : 'btn btn-lab';
  const conceptOptions = employmentFormFields.concepts
    .map((c) => `<option value="${escapeHtml(c)}">${escapeHtml(c)}</option>`)
    .join('');
  const positionOptions = employmentFormFields.positions
    .map((p) => `<option value="${escapeHtml(p)}">${escapeHtml(p)}</option>`)
    .join('');

  return `<form id="employment-form" class="space-y">
  <div class="form-grid form-grid-2">
    <div class="form-group">
      <label class="form-label" for="firstName">First Name</label>
      <input class="form-input" type="text" id="firstName" name="firstName" required>
    </div>
    <div class="form-group">
      <label class="form-label" for="lastName">Last Name</label>
      <input class="form-input" type="text" id="lastName" name="lastName" required>
    </div>
    <div class="form-group">
      <label class="form-label" for="phone">Phone Number</label>
      <input class="form-input" type="tel" id="phone" name="phone" required>
    </div>
    <div class="form-group">
      <label class="form-label" for="email">Email</label>
      <input class="form-input" type="email" id="email" name="email" required>
    </div>
  </div>
  <div class="form-grid form-grid-2">
    <div class="form-group">
      <label class="form-label" for="concept">Which concept are you applying for?</label>
      <select class="form-select" id="concept" name="concept" required>
        <option value="">Select...</option>
        ${conceptOptions}
      </select>
    </div>
    <div class="form-group">
      <label class="form-label" for="position">What position are you interested in?</label>
      <select class="form-select" id="position" name="position" required>
        <option value="">Select...</option>
        ${positionOptions}
      </select>
    </div>
  </div>
  <fieldset class="form-group">
    <legend class="form-label">Have you ever worked at a haunted house or theme park?</legend>
    <div class="form-radio-group">
      <label><input type="radio" name="hauntExperience" value="yes"> Yes</label>
      <label><input type="radio" name="hauntExperience" value="no" checked> No</label>
    </div>
  </fieldset>
  <div class="form-group">
    <label class="form-label" for="hauntDetails">If yes, where &amp; how many seasons?</label>
    <input class="form-input" type="text" id="hauntDetails" name="hauntDetails">
  </div>
  <fieldset class="form-group">
    <legend class="form-label">Are you available all weekends in October?</legend>
    <div class="form-radio-group">
      <label><input type="radio" name="octoberWeekends" value="yes" required> Yes</label>
      <label><input type="radio" name="octoberWeekends" value="no"> No</label>
    </div>
  </fieldset>
  <fieldset class="form-group">
    <legend class="form-label">Are you available to work other special events throughout the year?</legend>
    <div class="form-radio-group">
      <label><input type="radio" name="specialEvents" value="yes" required> Yes</label>
      <label><input type="radio" name="specialEvents" value="no"> No</label>
    </div>
  </fieldset>
  <fieldset class="form-group">
    <legend class="form-label">Are you over the age of 15?</legend>
    <div class="form-radio-group">
      <label><input type="radio" name="over15" value="yes" required> Yes</label>
      <label><input type="radio" name="over15" value="no"> No</label>
    </div>
  </fieldset>
  <div class="form-group">
    <label class="form-label" for="about">Share a bit about yourself and let us know why you'd shine on our team. Let us know your special skills.</label>
    <textarea class="form-textarea" id="about" name="about" rows="5" required></textarea>
  </div>
  <button type="submit" class="${btnClass}">✉ Apply Now</button>
</form>
<div id="form-success" class="card text-center" style="display:none;padding:3rem">
  <p style="font-size:2rem;margin-bottom:1rem">✉</p>
  <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:0.5rem">Application Received!</h3>
  <p class="text-muted">Thank you for your interest. We will send a follow-up application shortly.</p>
</div>`;
}

function ticketCard(ticket, theme, featured = false) {
  const badge = ticket.badge
    ? `<span class="price-badge">${escapeHtml(ticket.badge)}</span>`
    : '';
  const per = ticket.per
    ? `<span class="text-muted" style="font-size:1rem;font-weight:400"> ${escapeHtml(ticket.per)}</span>`
    : '';
  const age = ticket.age
    ? `<p class="text-muted" style="font-size:0.875rem;margin-bottom:0.75rem">${escapeHtml(ticket.age)}</p>`
    : '';
  const warning = ticket.warning
    ? `<div class="alert-box mb-6">⚠ ${escapeHtml(ticket.warning)}</div>`
    : '';
  const featuredClass = featured && theme === 'ipsh' ? ' ipsh-ticket-featured' : featured && theme === 'labyrinth' ? ' lab-ticket-featured' : '';
  return `<div class="card${featuredClass}">
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;flex-wrap:wrap;gap:0.5rem">
    <h3 class="card-title">${escapeHtml(ticket.name)}</h3>
    ${badge}
  </div>
  ${warning}
  <p class="ticket-price">${escapeHtml(ticket.price)}${per}</p>
  ${age}
  <p class="text-muted" style="font-size:0.875rem">${escapeHtml(ticket.description)}</p>
</div>`;
}

function attractionsHtml(attractions, theme) {
  return attractions
    .map((a, index) => {
      const emoji = ICON_EMOJI[a.icon] || '✦';
      const price = a.price
        ? `<span class="price-badge">${escapeHtml(a.price)}</span>`
        : '';
      const taglineClass =
        theme === 'ipsh' ? 'card-tagline font-cormorant' : 'card-tagline';
      const ipshExtra =
        theme === 'ipsh'
          ? `<span class="ipsh-attraction-num">${String(index + 1).padStart(2, '0')}</span>`
          : '';
      const labExtra =
        theme === 'labyrinth'
          ? `<span class="lab-attraction-num">${String(index + 1).padStart(2, '0')}</span>`
          : '';
      const ipshClass = theme === 'ipsh' ? ' ipsh-attraction-card' : '';
      const labClass = theme === 'labyrinth' ? ' lab-attraction-card' : '';
      const titleClass = theme === 'ipsh' ? 'card-title font-cinzel' : 'card-title font-bebas';
      return `<article class="card${ipshClass}${labClass}">
  ${ipshExtra}${labExtra}
  <div class="card-row">
    <div class="card-icon">${emoji}</div>
    <div>
      <div style="display:flex;flex-wrap:wrap;justify-content:space-between;gap:0.5rem;margin-bottom:0.5rem">
        <h2 class="${titleClass}">${escapeHtml(a.name)}</h2>
        ${price}
      </div>
      <p class="${taglineClass}">${escapeHtml(a.tagline)}</p>
      <p class="text-muted">${escapeHtml(a.description)}</p>
    </div>
  </div>
</article>`;
    })
    .join('\n');
}

function hoursHtml(hours, theme) {
  const rows = hours
    .map((row, i) => {
      const highlight =
        row.date.includes('October 31') || row.date === 'HALLOWEEN'
          ? ' highlight'
          : '';
      return `<div class="hours-row${highlight}">
  <span>${escapeHtml(row.date)}</span>
  <span>${escapeHtml(row.hours)}</span>
</div>`;
    })
    .join('\n');
  return `<div class="card hours-table">
  <div class="hours-header"><span>Date</span><span>Hours</span></div>
  ${rows}
</div>`;
}

function weatherPageHtml(theme, assetPrefix) {
  const titleFont = theme === 'labyrinth' ? 'font-bebas' : 'font-cinzel';
  const policyCards = weatherContent.policy
    .map((p) => `<div class="card"><p class="text-muted">${escapeHtml(p)}</p></div>`)
    .join('\n');
  return pageShell({
    title: `Weather Policy | ${theme === 'ipsh' ? "Ichabod Payne's Sleepy Hollow" : "Payne's Labyrinth"}`,
    theme,
    assetPrefix,
    body: `${heroBlock({ label: 'Stay Informed', title: 'Weather Info', titleClass: `page-title ${titleFont}` })}
<section class="container-narrow space-y">
  <div class="card text-center" style="padding:2.5rem">
    <p style="font-size:2rem;margin-bottom:1rem">☁️</p>
    <p class="font-cormorant" style="font-size:1.25rem;font-style:italic">${escapeHtml(weatherContent.defaultMessage)}</p>
  </div>
  <div>
    <h2 class="card-title font-cinzel mb-6">Bad Weather Policy</h2>
    <div class="space-y">${policyCards}</div>
  </div>
</section>`,
  });
}

function employmentPageHtml(theme, assetPrefix, faqLink) {
  const titleFont = theme === 'labyrinth' ? 'font-bebas' : 'font-cinzel';
  return pageShell({
    title: `Employment | ${theme === 'ipsh' ? "Ichabod Payne's Sleepy Hollow" : "Payne's Labyrinth"}`,
    theme,
    assetPrefix,
    body: `${heroBlock({
      label: 'Join Our Team',
      title: 'Employment',
      subtitle: 'Love Halloween and all its magic? Looking for a fun seasonal job? Apply below.',
      titleClass: `page-title ${titleFont}`,
    })}
<section class="container-narrow">
  ${employmentFormHtml(theme)}
  <p class="text-center text-muted mt-8" style="font-size:0.875rem;margin-top:2rem">
    Have questions? Visit our <a href="${faqLink}">Employment FAQs</a>.
  </p>
</section>`,
  });
}

function employmentFaqPageHtml(theme, assetPrefix, applyLink) {
  const titleFont = theme === 'labyrinth' ? 'font-bebas' : 'font-cinzel';
  const btnClass = theme === 'ipsh' ? 'btn btn-ipsh' : 'btn btn-lab';
  return pageShell({
    title: `Employment FAQ | ${theme === 'ipsh' ? "Ichabod Payne's Sleepy Hollow" : "Payne's Labyrinth"}`,
    theme,
    assetPrefix,
    body: `${heroBlock({
      label: 'Working With Us',
      title: 'Employment FAQ',
      titleClass: `page-title ${titleFont}`,
    })}
<section class="container-narrow">
  <div class="faq-list">${faqAccordion(employmentFaq)}</div>
  <div class="btn-group"><a href="${applyLink}" class="${btnClass}">Apply Now</a></div>
</section>`,
  });
}

// ─── Page generators ─────────────────────────────────────────────────────────

function generateIndex() {
  const { address, ticketsUrl, phone } = siteInfo;
  const mapsUrl =
    'https://www.google.com/maps/search/?api=1&query=3701+VZ+County+Road+3504+Wills+Point+TX+75169';
  return pageShell({
    title: 'Eerie Ever After Events | Home',
    theme: 'home',
    assetPrefix: '',
    body: `<header class="home-header">
  <div class="home-header-inner">
    <a href="index.html" class="home-header-brand font-cinzel">Eerie Ever After</a>
    <div class="home-header-actions">
      <a href="tel:${escapeHtml(phone)}" class="home-header-phone">${escapeHtml(phone)}</a>
      <a href="${escapeHtml(ticketsUrl)}" class="btn btn-ipsh home-header-cta">Get Tickets</a>
    </div>
  </div>
</header>

<section class="home-hero-premium">
  <div class="home-hero-grid" aria-hidden="true"></div>
  <div class="home-hero-inner">
    <p class="home-eyebrow">Wills Point, Texas · Seasonal Destination</p>
    <div class="home-hero-divider"></div>
    <img src="images/eerie-ever-after-logo.svg" alt="Eerie Ever After Events" class="home-logo-premium">
    <h1 class="home-headline font-cinzel">Two Worlds.<br>One Destination.</h1>
    <p class="home-tagline">Choose your path into the supernatural — family legends or living nightmare.</p>
    <a href="#choose-path" class="home-scroll-cue">
      <span>Select Your Experience</span>
      <span class="home-scroll-arrow" aria-hidden="true">↓</span>
    </a>
  </div>
</section>

<section id="choose-path" class="home-portals-section">
  <div class="home-portals-intro">
    <p class="section-label">The Experience</p>
    <h2 class="home-portals-title font-cinzel">Choose Your Path</h2>
    <p class="home-portals-sub">Two distinct attractions. One unforgettable Halloween season.</p>
  </div>

  <div class="home-portals-split">
    <a href="sleepy-hollow/about.html" class="home-portal home-portal-ipsh">
      <div class="home-portal-top">
        <span class="home-portal-num">01</span>
        <span class="home-portal-badge">Family Adventure</span>
      </div>
      <div class="home-portal-body">
        <img src="images/sleepy-hollow-logo.svg" alt="Ichabod Payne's Sleepy Hollow" class="home-portal-logo">
        <h3 class="home-portal-title font-cinzel">Ichabod Payne's Sleepy Hollow</h3>
        <p class="home-portal-desc">Explore the legends. Family-friendly Halloween adventures, carnival games, and immersive themed attractions for all ages.</p>
        <ul class="home-portal-features">
          <li>Themed Walkthroughs</li>
          <li>Carnival Games</li>
          <li>All Ages Welcome</li>
        </ul>
      </div>
      <div class="home-portal-footer">
        <span>Enter Sleepy Hollow</span>
        <span class="home-portal-arrow" aria-hidden="true">→</span>
      </div>
    </a>

    <div class="home-portals-divider" aria-hidden="true"></div>

    <a href="paynes-labyrinth/about.html" class="home-portal home-portal-lab">
      <div class="home-portal-top">
        <span class="home-portal-num">02</span>
        <span class="home-portal-badge">Intense Horror</span>
      </div>
      <div class="home-portal-body">
        <img src="images/paynes-labyrinth-logo.svg" alt="Payne's Labyrinth" class="home-portal-logo">
        <h3 class="home-portal-title font-bebas">Payne's Labyrinth</h3>
        <p class="home-portal-desc">Step past the curtain into chaos. A living nightmare of haunted attractions designed for the brave.</p>
        <ul class="home-portal-features">
          <li>Haunted Attractions</li>
          <li>Live Actors</li>
          <li>18+ Recommended</li>
        </ul>
      </div>
      <div class="home-portal-footer">
        <span>Enter the Labyrinth</span>
        <span class="home-portal-arrow" aria-hidden="true">→</span>
      </div>
    </a>
  </div>
</section>

<section class="home-stats">
  <div class="home-stats-grid">
    <div class="home-stat reveal">
      <span class="home-stat-icon" aria-hidden="true">◆</span>
      <h3 class="home-stat-title">Two Experiences</h3>
      <p class="home-stat-text">Family-friendly legends and intense horror — side by side at one destination.</p>
    </div>
    <div class="home-stat reveal">
      <span class="home-stat-icon" aria-hidden="true">◆</span>
      <h3 class="home-stat-title">East Texas</h3>
      <p class="home-stat-text">${escapeHtml(address.city)}, ${escapeHtml(address.state)} — a seasonal Halloween destination for the entire community.</p>
    </div>
    <div class="home-stat reveal">
      <span class="home-stat-icon" aria-hidden="true">◆</span>
      <h3 class="home-stat-title">Plan Ahead</h3>
      <p class="home-stat-text">Review hours, weather policies, and tickets before you arrive for the best experience.</p>
    </div>
  </div>
</section>

<section class="home-visit">
  <div class="home-visit-card reveal">
    <div class="home-visit-content">
      <p class="section-label">Visit Us</p>
      <h2 class="home-visit-title font-cinzel">Plan Your Visit</h2>
      <p class="home-visit-address">${escapeHtml(address.full)}</p>
      <div class="home-visit-actions">
        <a href="${escapeHtml(ticketsUrl)}" class="btn btn-ipsh">Get Tickets</a>
        <a href="tel:${escapeHtml(phone)}" class="btn btn-outline-ipsh">${escapeHtml(phone)}</a>
        <a href="${mapsUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-ipsh">Open in Maps</a>
      </div>
    </div>
    <div class="home-visit-aside">
      <div class="home-visit-block">
        <h4>Quick Links</h4>
        <a href="sleepy-hollow/hours.html">Sleepy Hollow Hours</a>
        <a href="paynes-labyrinth/hours.html">Labyrinth Hours</a>
        <a href="sleepy-hollow/tickets.html">Ticket Pricing</a>
        <a href="paynes-labyrinth/warnings.html">Warnings &amp; Advisories</a>
      </div>
      <div class="home-visit-block">
        <h4>Connect</h4>
        <a href="https://www.facebook.com/eerieeverafter" target="_blank" rel="noopener noreferrer">Facebook</a>
        <a href="https://www.instagram.com/eerie.ever.after.events/" target="_blank" rel="noopener noreferrer">Instagram</a>
        <a href="https://www.tiktok.com/@eerieeverafter" target="_blank" rel="noopener noreferrer">TikTok</a>
      </div>
    </div>
  </div>
</section>`,
  });
}

function generateSleepyHollowAbout() {
  return pageShell({
    title: "About Us | Ichabod Payne's Sleepy Hollow",
    theme: 'ipsh',
    assetPrefix: '../',
    body: `${heroBlock({ label: 'Our Story', title: 'About Us' })}
<div class="ipsh-ornament">✦ ✦ ✦</div>
<section class="container-narrow">
  <div class="card">
    <div class="ipsh-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8">Owner and creator <strong>Amanda Limoges</strong> has always had a deep love for Halloween—so much so that she married on Friday the 13th to a man born on Halloween. For her, the thrill of transforming yourself and the world around you, even for one night, has always been irresistible.</p>
    </div>
    <div class="ipsh-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8">When their son Hank arrived, that love grew into a shared family tradition. Together they built a free home haunt for neighborhood kids to trick‑or‑treat and explore. Each year the haunt expanded, with new themes designed and created by Amanda and Hank:</p>
      <div class="ipsh-themes">
        <span class="ipsh-theme-tag">Area 51</span>
        <span class="ipsh-theme-tag">Mad Scientist Lab</span>
        <span class="ipsh-theme-tag">Haunted Swamp</span>
        <span class="ipsh-theme-tag">Wild West Ghost Town</span>
        <span class="ipsh-theme-tag">And more</span>
      </div>
    </div>
    <div class="ipsh-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8">By 2026, an incredible opportunity appeared—the chance to bring that joy, creativity, and Halloween magic to the public. What began as a family tradition is now a growing seasonal experience for the entire community.</p>
    </div>
    <blockquote class="ipsh-pull-quote">We hope you'll spend many Halloween seasons with us as we continue to grow, imagine, and share our ideas with you.</blockquote>
  </div>
  <div class="ipsh-quick-links">
    <a href="attractions.html" class="ipsh-quick-link"><span>🎃</span>Attractions</a>
    <a href="tickets.html" class="ipsh-quick-link"><span>🎟</span>Tickets</a>
    <a href="hours.html" class="ipsh-quick-link"><span>🕐</span>Hours</a>
    <a href="faq.html" class="ipsh-quick-link"><span>❓</span>FAQ</a>
  </div>
  <div class="btn-group">
    <a href="attractions.html" class="btn btn-ipsh">Explore Attractions</a>
    <a href="tickets.html" class="btn btn-outline-ipsh">View Tickets</a>
  </div>
</section>`,
  });
}

function generateSleepyHollowAttractions() {
  return pageShell({
    title: "Attractions | Ichabod Payne's Sleepy Hollow",
    theme: 'ipsh',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Adventures Await',
      title: 'Attractions',
      subtitle: 'Family-friendly Halloween adventures designed for explorers of all ages.',
    })}
<section class="container space-y">${attractionsHtml(sleepyHollowAttractions, 'ipsh')}</section>`,
  });
}

function generateSleepyHollowTickets() {
  const notes = sleepyHollowTickets.notes
    .map((n) => `<li>${escapeHtml(n)}</li>`)
    .join('');
  const tickets = sleepyHollowTickets.tickets
    .map((t, i) => ticketCard(t, 'ipsh', i === 0))
    .join('\n');
  const combo = sleepyHollowTickets.comboTickets
    .filter((t) => t.id !== 'fast-pass')
    .map((t) => ticketCard(t, 'ipsh'))
    .join('\n');
  const fastPass = sleepyHollowTickets.comboTickets
    .filter((t) => t.id === 'fast-pass')
    .map((t) => ticketCard(t, 'ipsh'))
    .join('\n');

  return pageShell({
    title: "Tickets & Pricing | Ichabod Payne's Sleepy Hollow",
    theme: 'ipsh',
    assetPrefix: '../',
    body: `${heroBlock({ label: 'Plan Your Visit', title: 'Tickets & Pricing' })}
<section class="container">
  <div class="ipsh-notes-banner">
    <h3>Important Information</h3>
    <ul>${notes}</ul>
  </div>
  <h2 class="ipsh-section-head">Sleepy Hollow Tickets</h2>
  <div class="card-grid card-grid-2 mb-6">${tickets}</div>
  <div class="divider text-center"><span>✦</span></div>
  <h2 class="ipsh-section-head">Combo &amp; Season Passes</h2>
  <div class="card-grid card-grid-2 mb-6">${combo}</div>
  <h2 class="ipsh-section-head">Fast Pass</h2>
  ${fastPass}
  <div class="btn-group"><a href="${escapeHtml(siteInfo.ticketsUrl)}" class="btn btn-ipsh">Purchase Tickets</a></div>
</section>`,
  });
}

function generateSleepyHollowHours() {
  return pageShell({
    title: "Hours of Operation | Ichabod Payne's Sleepy Hollow",
    theme: 'ipsh',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'When We Open',
      title: 'Hours of Operation',
      subtitle: 'September 19 – October 31, 2026',
    })}
<section class="container-narrow">
  <div class="ipsh-hours-banner">
    <p>Open every Saturday &amp; Sunday · 11am – 5pm · Halloween opens at 10am</p>
  </div>
  ${hoursHtml(sleepyHollowHours, 'ipsh')}
  <div class="btn-group"><a href="tickets.html" class="btn btn-ipsh">Get Tickets</a></div>
</section>`,
  });
}

function generateSleepyHollowFaq() {
  return pageShell({
    title: "FAQ | Ichabod Payne's Sleepy Hollow",
    theme: 'ipsh',
    assetPrefix: '../',
    body: `${heroBlock({ label: 'Got Questions?', title: 'Frequently Asked Questions' })}
<section class="container-narrow">
  <p class="ipsh-faq-intro">Everything you need to know before visiting Ichabod Payne's Sleepy Hollow. Click any question below to expand the answer.</p>
  <div class="faq-list">${faqAccordion(sleepyHollowFaq)}</div>
  <div class="btn-group">
    <a href="tickets.html" class="btn btn-ipsh">View Tickets</a>
    <a href="weather.html" class="btn btn-outline-ipsh">Weather Policy</a>
  </div>
</section>`,
  });
}

function generateLabyrinthAbout() {
  return pageShell({
    title: "About Us | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({ label: 'The Director', title: 'About Us', titleClass: 'page-title font-bebas' })}
<div class="lab-ornament">☠ ☠ ☠</div>
<section class="container-narrow">
  <div class="card">
    <div class="lab-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8"><strong>Darian Butler's</strong> household runs on adrenaline and a healthy appreciation for a good scare. Drawn to the paranormal from a young age, her obsession with the macabre only deepened over time. Today, one of her and her husband's favorite pastimes is cueing up a retro B-movie for a night of campy creeps and laughs.</p>
    </div>
    <div class="lab-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8">With a background in theater—both commanding the stage and pulling strings behind the scenes—Darian treats the world of haunts as the ultimate stage production. Having spent her adult life in the hospitality industry, she views immersive customer service as just another form of performance art.</p>
    </div>
    <div class="lab-story-card">
      <p class="text-muted" style="font-size:1.0625rem;line-height:1.8">Enter her role as the Director of Design for Payne's Labyrinth: the perfect culmination of her theatrical flair, hospitality roots, and lifelong love of things that go bump in the night.</p>
    </div>
    <blockquote class="lab-pull-quote">She cordially invites you to step past the curtain and into the chaos—just don't expect her to hold your hand when the lights go out.</blockquote>
  </div>
  <div class="lab-quick-links">
    <a href="attractions.html" class="lab-quick-link"><span>🌀</span>Attractions</a>
    <a href="tickets.html" class="lab-quick-link"><span>🎟</span>Tickets</a>
    <a href="warnings.html" class="lab-quick-link"><span>⚠</span>Warnings</a>
    <a href="hours.html" class="lab-quick-link"><span>🕐</span>Hours</a>
  </div>
  <div class="btn-group">
    <a href="attractions.html" class="btn btn-lab">Enter the Attractions</a>
    <a href="warnings.html" class="btn btn-outline-lab">Read Warnings</a>
  </div>
</section>`,
  });
}

function generateLabyrinthAttractions() {
  return pageShell({
    title: "Attractions | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Enter If You Dare',
      title: 'Attractions',
      subtitle: 'A living nightmare of haunted attractions for the brave.',
      titleClass: 'page-title font-bebas',
    })}
<section class="container space-y">${attractionsHtml(labyrinthAttractions, 'labyrinth')}</section>`,
  });
}

function generateLabyrinthTickets() {
  const notes = labyrinthTickets.notes.map((n) => `<li>${escapeHtml(n)}</li>`).join('');
  const regular = labyrinthTickets.tickets.filter((t) => t.id === 'regular');
  const other = labyrinthTickets.tickets.filter((t) => t.id !== 'regular');
  const tickets = [
    ...regular.map((t) => ticketCard(t, 'labyrinth', true)),
    ...other.map((t) => ticketCard(t, 'labyrinth')),
  ].join('\n');
  const combo = labyrinthTickets.comboTickets.map((t) => ticketCard(t, 'labyrinth')).join('\n');

  return pageShell({
    title: "Tickets & Pricing | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Face Your Fears',
      title: 'Tickets & Pricing',
      titleClass: 'page-title font-bebas',
    })}
<section class="container">
  <div class="lab-notes-banner">
    <h3>Important Information</h3>
    <ul>${notes}</ul>
  </div>
  <h2 class="lab-section-head">Labyrinth Tickets</h2>
  <div class="card-grid card-grid-2 mb-6">${tickets}</div>
  <div class="divider text-center"><span>☠</span></div>
  <h2 class="lab-section-head">Combo &amp; Season Passes</h2>
  <div class="card-grid card-grid-2 mb-6">${combo}</div>
  <div class="btn-group"><a href="${escapeHtml(siteInfo.ticketsUrl)}" class="btn btn-lab">Purchase Tickets</a></div>
</section>`,
  });
}

function generateLabyrinthHours() {
  return pageShell({
    title: "Hours of Operation | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'When We Open',
      title: 'Hours of Operation',
      subtitle: 'September 18 – November 1, 2026',
      titleClass: 'page-title font-bebas',
    })}
<section class="container-narrow">
  <div class="lab-hours-banner">
    <p>Fridays – Sundays · Evenings · Extended hours on Halloween</p>
  </div>
  ${hoursHtml(labyrinthHours, 'labyrinth')}
  <div class="btn-group"><a href="tickets.html" class="btn btn-lab">Get Tickets</a></div>
</section>`,
  });
}

function generateLabyrinthFaq() {
  return pageShell({
    title: "FAQ | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Before You Enter',
      title: 'Frequently Asked Questions',
      titleClass: 'page-title font-bebas',
    })}
<section class="container-narrow">
  <p class="lab-faq-intro">Everything you need to know before entering Payne's Labyrinth. Click any question below to expand the answer.</p>
  <div class="faq-list">${faqAccordion(labyrinthFaq)}</div>
  <div class="btn-group">
    <a href="tickets.html" class="btn btn-lab">View Tickets</a>
    <a href="warnings.html" class="btn btn-outline-lab">Read Warnings</a>
  </div>
</section>`,
  });
}

function generateLabyrinthWarnings() {
  const posterBody = labyrinthWarningPoster.paragraphs
    .map((p) => `<p>${escapeHtml(p)}</p>`)
    .join('\n      ');

  const extraCards = labyrinthWarnings
    .map((w) => {
      const cls = w.severity === 'high' ? 'warning-high' : 'warning-medium';
      return `<div class="card ${cls}">
  <h3 class="card-title font-bebas" style="font-size:1rem;letter-spacing:0.05em;margin-bottom:0.5rem">${escapeHtml(w.title)}</h3>
  <p class="text-muted" style="font-size:0.875rem">${escapeHtml(w.content)}</p>
</div>`;
    })
    .join('\n');

  return pageShell({
    title: "Warnings | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Read Before Entering',
      title: 'Warnings',
      titleClass: 'page-title font-bebas',
    })}
<section class="container-narrow">
  <div class="warning-poster">
    <h2 class="warning-poster-title">${escapeHtml(labyrinthWarningPoster.headline)}</h2>
    <p class="warning-poster-subhead">${escapeHtml(labyrinthWarningPoster.subhead)}</p>
    <div class="warning-poster-body">
      ${posterBody}
    </div>
    <p class="warning-poster-footer">${escapeHtml(labyrinthWarningPoster.footer)}</p>
  </div>
  <h2 class="lab-section-head" style="margin-top:2.5rem">Additional Advisories</h2>
  <div class="space-y">${extraCards}</div>
</section>`,
  });
}

function generateLabyrinthSpecialEvents() {
  const events = specialEvents
    .map(
      (event, i) => `<article id="${EVENT_IDS[i]}" class="card lab-event-card" style="scroll-margin-top:6rem">
  <p class="section-label">${escapeHtml(event.date)}</p>
  <h2 class="font-bebas" style="font-size:2rem;margin-bottom:1rem">${escapeHtml(event.name)}</h2>
  <span class="price-badge">🕐 ${escapeHtml(event.status)}</span>
</article>`
    )
    .join('\n');

  return pageShell({
    title: "Special Events | Payne's Labyrinth",
    theme: 'labyrinth',
    assetPrefix: '../',
    body: `${heroBlock({
      label: 'Beyond the Season',
      title: 'Special Events',
      subtitle: "The terror doesn't end when October does.",
      titleClass: 'page-title font-bebas',
    })}
<section class="container-narrow">
  <div class="space-y">${events}</div>
  <div class="btn-group"><a href="tickets.html" class="btn btn-lab">Get Tickets</a></div>
</section>`,
  });
}

// ─── Generate all files ──────────────────────────────────────────────────────

const pages = [
  ['index.html', generateIndex()],
  ['sleepy-hollow/about.html', generateSleepyHollowAbout()],
  ['sleepy-hollow/attractions.html', generateSleepyHollowAttractions()],
  ['sleepy-hollow/tickets.html', generateSleepyHollowTickets()],
  ['sleepy-hollow/hours.html', generateSleepyHollowHours()],
  ['sleepy-hollow/faq.html', generateSleepyHollowFaq()],
  ['sleepy-hollow/weather.html', weatherPageHtml('ipsh', '../')],
  ['sleepy-hollow/employment.html', employmentPageHtml('ipsh', '../', 'employment-faq.html')],
  ['sleepy-hollow/employment-faq.html', employmentFaqPageHtml('ipsh', '../', 'employment.html')],
  ['paynes-labyrinth/about.html', generateLabyrinthAbout()],
  ['paynes-labyrinth/attractions.html', generateLabyrinthAttractions()],
  ['paynes-labyrinth/tickets.html', generateLabyrinthTickets()],
  ['paynes-labyrinth/hours.html', generateLabyrinthHours()],
  ['paynes-labyrinth/faq.html', generateLabyrinthFaq()],
  ['paynes-labyrinth/warnings.html', generateLabyrinthWarnings()],
  ['paynes-labyrinth/weather.html', weatherPageHtml('labyrinth', '../')],
  ['paynes-labyrinth/employment.html', employmentPageHtml('labyrinth', '../', 'employment-faq.html')],
  ['paynes-labyrinth/employment-faq.html', employmentFaqPageHtml('labyrinth', '../', 'employment.html')],
  ['paynes-labyrinth/special-events.html', generateLabyrinthSpecialEvents()],
];

console.log('Generating static HTML site...\n');

const created = [];
for (const [relPath, html] of pages) {
  writeFile(relPath, html);
  created.push(relPath);
  console.log(`  ✓ ${relPath}`);
}

// Verify shared assets exist
const sharedAssets = ['css/styles.css', 'js/main.js'];
const missing = sharedAssets.filter((a) => !fs.existsSync(path.join(OUT, a)));

console.log(`\nDone! Created ${created.length} HTML files in ${OUT}`);

if (missing.length) {
  console.warn('\nWarning: missing shared assets:', missing.join(', '));
} else {
  console.log('Shared assets present: css/styles.css, js/main.js');
}

const imageAssets = [
  'images/eerie-ever-after-logo.svg',
  'images/sleepy-hollow-logo.svg',
  'images/paynes-labyrinth-logo.svg',
];
const missingImages = imageAssets.filter((a) => !fs.existsSync(path.join(OUT, a)));
if (missingImages.length) {
  console.warn('Warning: missing images (used on index.html only):', missingImages.join(', '));
} else {
  console.log('Image assets present for home page.');
}
