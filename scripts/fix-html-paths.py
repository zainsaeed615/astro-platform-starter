#!/usr/bin/env python3
from pathlib import Path
import re

DIST = Path('/workspace/dist')

ROUTE_SUFFIX = {
    '/': 'index.html',
    '/about': 'about.html',
    '/about/mission': 'about/mission.html',
    '/about/how-it-works': 'about/how-it-works.html',
    '/about/values': 'about/values.html',
    '/about/leadership': 'about/leadership.html',
    '/get-involved': 'get-involved.html',
    '/get-involved/apply': 'get-involved/apply.html',
    '/get-involved/prayer-team': 'get-involved/prayer-team.html',
    '/get-involved/media-team': 'get-involved/media-team.html',
    '/get-involved/decoy-team': 'get-involved/decoy-team.html',
    '/get-involved/operations-team': 'get-involved/operations-team.html',
    '/donate': 'donate.html',
    '/live-prayer': 'live-prayer.html',
    '/shop': 'shop.html',
    '/shop/checkout': 'shop/checkout.html',
    '/resources': 'resources.html',
    '/contact': 'contact.html',
    '/legal/privacy': 'legal/privacy.html',
    '/legal/terms': 'legal/terms.html',
}

for slug in [
    'protector-tee', 'detect-protect-defend-hoodie', 'operation-logo-tee',
    'mission-patch-hat', 'defender-beanie', 'mission-sticker-pack',
    'faith-over-fear-wristband', 'operation-tactical-cap'
]:
    ROUTE_SUFFIX[f'/shop/product/{slug}'] = f'shop/product/{slug}.html'


def to_relative(from_file: Path, target: str) -> str:
    rel = Path('../' * len(from_file.parent.relative_to(DIST).parts)) / target
    s = rel.as_posix()
    if not s.startswith('.'):
        s = './' + s
    return s


def resolve_url(from_file: Path, url: str) -> str:
    anchor = ''
    if '#' in url:
        url, anchor = url.split('#', 1)
        anchor = '#' + anchor

    if not url or url == '/':
        return to_relative(from_file, 'index.html') + anchor

    if url.startswith('/'):
        clean = url.rstrip('/')
        if clean in ROUTE_SUFFIX:
            return to_relative(from_file, ROUTE_SUFFIX[clean]) + anchor
        if clean.endswith('.html') and clean.lstrip('/') in [v for v in ROUTE_SUFFIX.values()]:
            return to_relative(from_file, clean.lstrip('/')) + anchor
        asset = url.lstrip('/').replace('./', '')
        return to_relative(from_file, asset) + anchor

    return url + anchor


def fix_file(path: Path):
    text = path.read_text(encoding='utf-8')

    def sub_attr(attr, match):
        val = match.group(1)
        if val.startswith(('http', 'mailto', 'javascript', 'data:')):
            return match.group(0)
        return f'{attr}="{resolve_url(path, val)}"'

    text = re.sub(r'href="([^"]*)"', lambda m: sub_attr('href', m), text)
    text = re.sub(r'src="([^"]*)"', lambda m: sub_attr('src', m), text)
    text = re.sub(r'component-url="([^"]*)"', lambda m: sub_attr('component-url', m), text)
    text = re.sub(r'renderer-url="([^"]*)"', lambda m: sub_attr('renderer-url', m), text)
    path.write_text(text, encoding='utf-8')


html_files = list(DIST.rglob('*.html'))
for f in html_files:
    fix_file(f)

print(f'Processed {len(html_files)} HTML files')
