import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isStaticDeploy = process.env.STATIC_DEPLOY === 'true';
const isZipDeploy = process.env.ZIP_DEPLOY === 'true';
const deployBase = isZipDeploy ? '/' : (process.env.DEPLOY_BASE || '/astro-platform-starter/');

// https://astro.build/config
export default defineConfig({
    site: isStaticDeploy && !isZipDeploy ? (process.env.DEPLOY_SITE || 'https://zainsaeed615.github.io') : undefined,
    base: isStaticDeploy || isZipDeploy ? deployBase : undefined,
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isStaticDeploy || isZipDeploy ? 'static' : 'server',
    adapter: isStaticDeploy || isZipDeploy ? undefined : netlify()
});
