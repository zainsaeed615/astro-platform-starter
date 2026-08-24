import { defineConfig } from 'astro/config';
import netlify from '@astrojs/netlify';
import react from '@astrojs/react';
import tailwindcss from '@tailwindcss/vite';

const isStaticDeploy = process.env.STATIC_DEPLOY === 'true';

// https://astro.build/config
export default defineConfig({
    vite: {
        plugins: [tailwindcss()]
    },
    integrations: [react()],
    output: isStaticDeploy ? 'static' : 'server',
    adapter: isStaticDeploy ? undefined : netlify()
});
