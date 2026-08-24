import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isStaticDeploy = process.env.STATIC_DEPLOY === 'true';

// https://astro.build/config
export default defineConfig({
    site: isStaticDeploy ? 'https://mindfulness-mockup.netlify.app' : undefined,
    base: isStaticDeploy ? '/' : undefined,
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isStaticDeploy ? 'static' : 'server',
    adapter: isStaticDeploy ? undefined : netlify()
});
