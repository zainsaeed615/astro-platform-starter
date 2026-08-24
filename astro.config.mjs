import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isStaticDeploy = process.env.STATIC_DEPLOY === 'true';

// https://astro.build/config
export default defineConfig({
    site: isStaticDeploy ? 'https://zainsaeed615.github.io' : undefined,
    base: isStaticDeploy ? '/astro-platform-starter/' : undefined,
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isStaticDeploy ? 'static' : 'server',
    adapter: isStaticDeploy ? undefined : netlify()
});
