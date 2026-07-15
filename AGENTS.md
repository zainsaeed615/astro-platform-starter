# AGENTS.md

## Cursor Cloud specific instructions

This repo is a single product: the **Astro on Netlify Platform Starter** (Astro 5 + React islands + Tailwind 4, deployed via the Netlify adapter). It is an npm project (`package-lock.json`); use `npm`. There is no database or docker-compose — persistence for the demo is Netlify Blob Store, emulated locally by the Netlify CLI.

### Running (non-obvious)
- Preferred: `netlify dev` — serves the full app on `http://localhost:8888` and emulates the Netlify primitives (Blob Store `/blobs`, Edge Functions `/edge`, Image CDN, cache purge). It internally starts `astro dev` on port 4321 and proxies through 8888; **use 8888** for full functionality.
- `npm run dev` (plain `astro dev`, port 4321) works for general pages but the Blob Store and Edge Function features will not function without `netlify dev`.
- `netlify dev` runs unlinked — no `netlify login`/`netlify link` is required for local emulation, and no `.env`/secrets are needed for local dev.
- `netlify-cli` is installed globally under `~/.npm-global` (prefix set in `~/.npmrc`, PATH added in `~/.bashrc`). An `nvm` prefix-incompatibility warning may print when running npm/netlify; it is harmless.

### Lint / test / build
- No test suite and no lint script exist in this repo. Closest type check: `npm run astro -- check`.
- Build: `npm run build` (outputs `./dist/`); preview a build with `npm run preview`.
- Standard commands are documented in `README.md` and `package.json` scripts.
