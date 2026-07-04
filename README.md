# Eerie Ever After Events

Modern website for **Ichabod Payne's Sleepy Hollow** and **Payne's Labyrinth** — two seasonal Halloween attractions in Wills Point, TX.

Built with [Astro](https://astro.build), [Tailwind CSS v4](https://tailwindcss.com), and [React](https://react.dev) islands for interactive components.

## Development

```bash
npm install
npm run dev
```

## Build

```bash
npm run build
npm run preview
```

## Site Structure

- `/` — Landing page with Eerie Ever After logo and portal cards to each attraction
- `/sleepy-hollow/*` — Family-friendly Ichabod Payne's Sleepy Hollow section
- `/paynes-labyrinth/*` — Intense horror Payne's Labyrinth section

Images are used only on the home page. Inner pages rely on typography, icons, and layout.

## Deployment

Configured for [Netlify](https://www.netlify.com) via `@astrojs/netlify`.
