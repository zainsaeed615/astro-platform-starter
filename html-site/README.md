# Eerie Ever After Events — Static HTML Site

Pure HTML/CSS/JS version of the website. No build step required.

## How to use

1. Open `index.html` in your browser, **or**
2. Upload the entire `html-site` folder to any web host (cPanel, Netlify, GitHub Pages, etc.)

For local preview with proper paths, use a simple server:

```bash
cd html-site
npx serve .
```

## Folder structure

```
html-site/
├── index.html              ← Landing page (images only here)
├── css/styles.css
├── js/main.js
├── images/                 ← Logo SVGs
├── sleepy-hollow/          ← 8 pages
└── paynes-labyrinth/       ← 10 pages
```

## Regenerate from source data

If you update content in `src/data/`, run:

```bash
node scripts/generate-html-site.mjs
```

## Update ticket link

Search for `href="#"` in all HTML files (Get Tickets links) and replace with your ticket purchase URL.
