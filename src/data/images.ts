const base = import.meta.env.BASE_URL;

function img(name: string) {
    return `${base}images/mindfulness/${name}`;
}

export const images = {
    home: {
        hero: img('hero-home.jpg'),
        brand: img('brand-sanctuary.jpg'),
    },
    collections: {
        signature: img('collection-signature.jpg'),
        wellness: img('collection-wellness.jpg'),
        seasonal: img('collection-seasonal.jpg'),
    },
    bundles: {
        refocus: img('bundle-refocus.jpg'),
        renew: img('brand-sanctuary.jpg'),
        caregiver: img('collection-wellness.jpg'),
    },
    membership: {
        hero: img('membership-hero.jpg'),
        mindful: img('membership-hero.jpg'),
        restore: img('brand-sanctuary.jpg'),
        sanctuary: img('brand-sanctuary.jpg'),
    },
    healthcare: {
        hero: img('healthcare-hero.jpg'),
        caregiver: img('healthcare-hero.jpg'),
        flameFree: img('bundle-refocus.jpg'),
        b2b: img('healthcare-hero.jpg'),
    },
    corporate: {
        hero: img('corporate-hero.jpg'),
        experience: img('corporate-hero.jpg'),
        conference: img('collection-seasonal.jpg'),
    },
    fundraising: {
        hero: img('fundraising-hero.jpg'),
    },
    wholesale: {
        hero: img('collection-signature.jpg'),
    },
};
