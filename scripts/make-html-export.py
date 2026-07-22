#!/usr/bin/env python3
"""Convert absolute asset paths to relative paths for offline HTML preview."""

from pathlib import Path
import re

DIST = Path('/workspace/dist')

ROUTE_MAP = {
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

for product in [
    'protector-tee', 'detect-protect-defend-hoodie', 'operation-logo-tee',
    'mission-patch-hat', 'defender-beanie', 'mission-sticker-pack',
    'faith-over-fear-wristband', 'operation-tactical-cap'
]:
    ROUTE_MAP[f'/shop/product/{product}'] = f'shop/product/{product}.html'


def rel_path(from_file: Path, target: str) -> str:
    from_dir = from_file.parent
    target_path = Path(target)
    try:
        rel = Path('../' * len(from_dir.relative_to(DIST).parts)) / target_path
        rel = rel.as_posix()
        if not rel.startswith('.'):
            rel = './' + rel
        return rel.replace('/./', '/')
    except ValueError:
        return target


def fix_html_file(path: Path):
    content = path.read_text(encoding='utf-8')
    current = path.relative_to(DIST).as_posix()

    def replace_href(match):
        url = match.group(1)
        if url.startswith(('http', 'mailto', '#', 'javascript')):
            return match.group(0)
        if url.startswith('/'):
            clean = url.split('#')[0].rstrip('/')
            anchor = '#' + url.split('#')[1] if '#' in url else ''
            target = ROUTE_MAP.get(clean or '/', ROUTE_MAP.get(clean, url.lstrip('/')))
            if clean in ROUTE_MAP:
                return f'href="{rel_path(path, ROUTE_MAP[clean])}{anchor}"'
            asset = url.lstrip('/')
            return f'href="{rel_path(path, asset)}{anchor}"'
        return match.group(0)

    def replace_src(match):
        url = match.group(1)
        if url.startswith(('http', 'data:')):
            return match.group(0)
        if url.startswith('/'):
            asset = url.lstrip('/').replace('./', '')
            return f'src="{rel_path(path, asset)}"'
        if url.startswith('./'):
            return f'src="{rel_path(path, url[2:])}"'
        return match.group(0)

    content = re.sub(r'href="([^"]+)"', replace_href, content)
    content = re.sub(r'src="([^"]+)"', replace_src, content)
    content = re.sub(r'component-url="([^"]+)"', lambda m: f'component-url="{rel_path(path, m.group(1).lstrip("/"))}"', content)
    content = re.sub(r'renderer-url="([^"]+)"', lambda m: f'renderer-url="{rel_path(path, m.group(1).lstrip("/"))}"', content)
    path.write_text(content, encoding='utf-8')


# Flatten index.html structure: about/index.html -> about.html
def flatten():
    for html in sorted(DIST.rglob('index.html')):
        if html == DIST / 'index.html':
            continue
        rel = html.parent.relative_to(DIST)
        if len(rel.parts) == 1:
            new_name = DIST / f'{rel.parts[0]}.html'
        else:
            new_dir = DIST / rel.parent
            new_dir.mkdir(parents=True, exist_ok=True)
            new_name = DIST / f'{"/".join(rel.parts)}.html'
        new_name.write_text(html.read_text(encoding='utf-8'))
        # remove index.html and empty dirs later

flatten()

# Also handle nested product pages: shop/product/x/index.html -> shop/product/x.html
for html in list(DIST.rglob('index.html')):
    if html == DIST / 'index.html':
        continue
    rel_parts = html.parent.relative_to(DIST).parts
    if len(rel_parts) >= 2:
        target = DIST / '/'.join(rel_parts[:-1]) / f'{rel_parts[-1]}.html'
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_text(html.read_text(encoding='utf-8'))

# Rebuild route map for flat files
ROUTE_MAP = {
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
for product in [
    'protector-tee', 'detect-protect-defend-hoodie', 'operation-logo-tee',
    'mission-patch-hat', 'defender-beanie', 'mission-sticker-pack',
    'faith-over-fear-wristband', 'operation-tactical-cap'
]:
    ROUTE_MAP[f'/shop/product/{product}'] = f'shop/product/{product}.html'

html_files = [DIST / 'index.html']
html_files += list(DIST.glob('*.html'))
html_files += list(DIST.glob('*/*.html'))
html_files += list(DIST.glob('*/*/*.html'))

for f in html_files:
    if f.exists():
        fix_html_file(f)

print(f'Fixed {len(html_files)} HTML files')
