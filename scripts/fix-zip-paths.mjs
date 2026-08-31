#!/usr/bin/env node
/**
 * Rewrites absolute /./ paths in static HTML to depth-correct relative paths
 * so the mockup works when opened from the filesystem or a local server.
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

function prefixFor(filePath) {
    const relative = path.relative(distDir, path.dirname(filePath));
    if (!relative || relative === '.') {
        return './';
    }

    const depth = relative.split(path.sep).length;
    return `${'../'.repeat(depth)}`;
}

function fixHtml(content, prefix) {
    return content
        .replaceAll('href="/./', `href="${prefix}`)
        .replaceAll("href='/./", `href='${prefix}`)
        .replaceAll('src="/./', `src="${prefix}`)
        .replaceAll("src='/./", `src='${prefix}`);
}

const htmlFiles = await walk(distDir);

for (const file of htmlFiles) {
    const prefix = prefixFor(file);
    const original = await readFile(file, 'utf8');
    const updated = fixHtml(original, prefix);

    if (updated !== original) {
        await writeFile(file, updated);
        console.log(`fixed paths in ${path.relative(distDir, file)} → prefix "${prefix}"`);
    }
}

console.log(`Done. Processed ${htmlFiles.length} HTML files.`);
