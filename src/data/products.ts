export interface Product {
    id: string;
    slug: string;
    name: string;
    price: number;
    category: string;
    description: string;
    image: string;
    badge?: string;
    sizes?: string[];
    colors?: string[];
    featured?: boolean;
}

export const categories = [
    { slug: 'all', name: 'All Products', description: 'Browse our full mission-driven collection' },
    { slug: 'shirts', name: 'Shirts & Tees', description: 'Wear your support with purpose' },
    { slug: 'hats', name: 'Hats & Headwear', description: 'Bold headwear for the mission' },
    { slug: 'accessories', name: 'Accessories', description: 'Everyday items that carry the message' }
];

export const products: Product[] = [
    {
        id: '1',
        slug: 'protector-tee',
        name: 'The Protector Tee',
        price: 29.99,
        category: 'shirts',
        description:
            'Make a statement with our signature design. This high-quality, soft cotton t-shirt features a bold design that embodies the spirit of Operation 17:2. More than apparel — a visible declaration against child predators.',
        image: '/products/protector-tee.svg',
        badge: 'Best Seller',
        sizes: ['S', 'M', 'L', 'XL', '2XL'],
        colors: ['Black', 'Navy'],
        featured: true
    },
    {
        id: '2',
        slug: 'detect-protect-defend-hoodie',
        name: 'Detect • Protect • Defend Hoodie',
        price: 54.99,
        category: 'shirts',
        description:
            'Premium heavyweight hoodie with the Operation 17:2 tagline across the chest. Built for comfort and durability — perfect for prayer calls, events, and everyday wear.',
        image: '/products/hoodie.svg',
        badge: 'New',
        sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'],
        colors: ['Black'],
        featured: true
    },
    {
        id: '3',
        slug: 'operation-logo-tee',
        name: 'Operation 17:2 Logo Tee',
        price: 27.99,
        category: 'shirts',
        description:
            'Classic fit tee featuring the full Operation 17:2 logo. Every purchase directly supports our mission to protect children and hunt predators.',
        image: '/products/logo-tee.svg',
        sizes: ['S', 'M', 'L', 'XL', '2XL'],
        colors: ['Black', 'Charcoal']
    },
    {
        id: '4',
        slug: 'mission-patch-hat',
        name: 'Mission Patch Snapback',
        price: 32.99,
        category: 'hats',
        description:
            'Structured snapback with embroidered Operation 17:2 mission patch. Adjustable fit with premium stitching.',
        image: '/products/snapback.svg',
        badge: 'Popular',
        colors: ['Black/Blue']
    },
    {
        id: '5',
        slug: 'defender-beanie',
        name: 'Defender Beanie',
        price: 24.99,
        category: 'hats',
        description: 'Warm knit beanie with subtle embroidered logo. Stay covered in the field and in prayer.',
        image: '/products/beanie.svg',
        sizes: ['One Size'],
        colors: ['Black']
    },
    {
        id: '6',
        slug: 'mission-sticker-pack',
        name: 'Mission Sticker Pack',
        price: 9.99,
        category: 'accessories',
        description: 'Set of 5 weatherproof vinyl stickers featuring Operation 17:2 branding. Spread the mission everywhere you go.',
        image: '/products/stickers.svg'
    },
    {
        id: '7',
        slug: 'faith-over-fear-wristband',
        name: 'Faith Over Fear Wristband',
        price: 7.99,
        category: 'accessories',
        description: 'Silicone wristband with embossed Luke 17:2 reference. A daily reminder of why we fight.',
        image: '/products/wristband.svg',
        sizes: ['One Size']
    },
    {
        id: '8',
        slug: 'operation-tactical-cap',
        name: 'Operation Tactical Cap',
        price: 28.99,
        category: 'hats',
        description: 'Low-profile tactical cap with laser-cut ventilation and embroidered logo. Built for the mission.',
        image: '/products/tactical-cap.svg',
        colors: ['Black', 'OD Green']
    }
];

export function getProductBySlug(slug: string): Product | undefined {
    return products.find((p) => p.slug === slug);
}

export function getProductsByCategory(category: string): Product[] {
    if (category === 'all') return products;
    return products.filter((p) => p.category === category);
}
