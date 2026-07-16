# PDQ Construction — Preview Guide

How to preview the Astro site locally from the workspace root.

## Asset locations

| Folder | Purpose |
|--------|---------|
| `shah g/drive-assets/` | Original Drive downloads / source assets |
| `shah g/web-images/` | Optimized web-ready images (about, hero, logo, projects) |
| `public/images/` | Images served by the site at `/images/...` |

Copy or sync web images into `public/images/` when updating photography so the site can serve them.

## Develop

From the workspace root (`/workspace`):

```bash
npm install
npm run dev
```

Open the local URL Astro prints (usually `http://localhost:4321`).

## Build & static preview

```bash
npm run build
npm run preview
```

Production output lands in `dist/`. After build you can also open files under `dist/` or serve that folder with any static server.

## Main routes

- `/` — Homepage
- `/about` — About
- `/services` — Services
- `/portfolio` — Portfolio
- `/process` — Process
- `/faq` — FAQ
- `/contact` — Contact
