import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isGitHubPages = process.env.GITHUB_PAGES === 'true';

// https://astro.build/config
export default defineConfig({
    site: isGitHubPages ? 'https://zainsaeed615.github.io' : undefined,
    base: isGitHubPages ? '/astro-platform-starter' : undefined,
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isGitHubPages ? 'static' : 'server',
    adapter: isGitHubPages ? undefined : netlify()
});
