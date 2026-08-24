export function pathTo(href: string): string {
    if (href.startsWith('http') || href.startsWith('mailto:') || href.startsWith('#')) {
        return href;
    }

    const base = import.meta.env.BASE_URL;
    return `${base}${href.replace(/^\//, '')}`;
}

export function normalizePath(pathname: string): string {
    const base = import.meta.env.BASE_URL;

    if (base !== '/' && pathname.startsWith(base)) {
        const stripped = pathname.slice(base.length - 1);
        return stripped || '/';
    }

    return pathname;
}
