import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isStaticDeploy = process.env.STATIC_DEPLOY === 'true';
const deployBase = process.env.DEPLOY_BASE || '/astro-platform-starter/';

// https://astro.build/config
export default defineConfig({
    site: isStaticDeploy ? (process.env.DEPLOY_SITE || 'https://zainsaeed615.github.io') : undefined,
    base: isStaticDeploy ? deployBase : undefined,
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isStaticDeploy ? 'static' : 'server',
    adapter: isStaticDeploy ? undefined : netlify()
});
