# PDQ Construction — Shah G Preview Folder

Yahan se aap site assets aur preview dekh sakte ho.

## Folder structure

| Path | Contents |
|------|----------|
| `shah g/drive-assets/` | Google Drive se download ki hui **original** photos/videos (local only, ~688MB) |
| `shah g/web-images/` | Web-optimized JPG/SVG/PNG jo site use karti hai |
| `shah g/preview/` | Latest `npm run build` output — HTML pages for quick look |
| `shah g/drive-assets-index.txt` | Original Drive files ki list |

## Website preview (recommended)

Workspace root se:

```bash
npm install
npm run dev
```

Browser: `http://localhost:4321`

Routes: `/` `/about` `/services` `/portfolio` `/process` `/faq` `/contact`

## Static preview files

Build ke baad HTML yahan milti hai:

- `shah g/preview/index.html`
- `shah g/preview/about/index.html`
- ... baaki pages

Ya:

```bash
npm run build && npm run preview
```

## Brand

- Colors: Navy `#1B3A6B` + Red `#C8102E`
- Phone: 916-871-4325
- License: #1013079
- Domain: pdqbuilt.com

## Downloadable HTML website

Offline HTML package (double-click `index.html` to open):

- Folder: `shah g/pdq-html-website/`
- ZIP: `shah g/PDQ-Construction-HTML-Website.zip`

Unzip karke `index.html` kholen — browser mein poori site chalegi (images/CSS included).
