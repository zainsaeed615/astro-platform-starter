#!/usr/bin/env node
/**
 * Prepare static dist for offline zip viewing:
 * 1. Inline CSS into every HTML file (works with file:// and any server)
 * 2. Rewrite root-absolute links to relative index.html paths
 */
import { readdir, readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';

const distDir = process.argv[2] || 'dist';

async function walk(dir) {
    const entries = await readdir(dir, { withFileTypes: true });
    const files = [];

    for (const entry of entries) {
        const fullPath = path.join(dir, entry.name);
        if (entry.isDirectory()) {
            files.push(...(await walk(fullPath)));
        } else if (entry.name.endsWith('.html')) {
            files.push(fullPath);
        }
    }

    return files;
}

function routePrefixFor(filePath) {
    const relativeDir = path.relative(distDir, path.dirname(filePath));
    if (!relativeDir || relativeDir === '.') {
        return './';
    }

    const depth = relativeDir.split(path.sep).length;
    return '../'.repeat(depth);
}

function isRootPage(filePath) {
    return path.dirname(filePath) === distDir;
}

function routeToRelative(route, prefix, onRootPage) {
    if (!route || route === '/') {
        return onRootPage ? 'index.html' : `${prefix}index.html`;
    }

    const clean = route.replace(/^\//, '').replace(/\/$/, '');
    return `${prefix}${clean}/index.html`;
}

async function inlineStylesheets(html) {
    const linkPattern = /<link rel="stylesheet" href="\/_astro\/([^"]+\.css)">/g;
    let result = html;
    const matches = [...html.matchAll(linkPattern)];

    for (const match of matches) {
        const cssPath = path.join(distDir, '_astro', match[1]);
        const css = (await readFile(cssPath, 'utf8'))
            .replace(/url\(\.\/files\/[^)]+\)/g, 'none')
            .replace(/@font-face\s*\{[^}]*\}/g, '');

        result = result.replace(match[0], `<style data-inlined="${match[1]}">${css}</style>`);
    }

    return result;
}

function rewriteLinks(html, prefix, onRootPage) {
    return html
        .replace(/href="(\/[^"#?]*)(#[^"]*)?"/g, (full, route, hash = '') => {
            if (route.startsWith('/_astro/')) {
                return full;
            }

            if (route === '/' && hash) {
                return onRootPage ? `href="${hash.slice(1) ? hash : 'index.html'}"` : `href="${prefix}index.html${hash}"`;
            }

            return `href="${routeToRelative(route, prefix, onRootPage)}${hash}"`;
        })
        .replace(/href="\/favicon\.svg"/g, `href="${prefix}favicon.svg"`);
}

const htmlFiles = await walk(distDir);

for (const file of htmlFiles) {
    const prefix = routePrefixFor(file);
    const onRootPage = isRootPage(file);
    const original = await readFile(file, 'utf8');
    let updated = await inlineStylesheets(original);
    updated = rewriteLinks(updated, prefix, onRootPage);

    await writeFile(file, updated);
    console.log(`prepared ${path.relative(distDir, file)}`);
}

console.log(`Done. Prepared ${htmlFiles.length} HTML files for offline viewing.`);
