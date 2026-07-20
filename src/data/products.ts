export type Product = {
  slug: string;
  name: string;
  price: number;
  category: 'shirts' | 'hoodies' | 'hats' | 'accessories';
  description: string;
  image: string;
  sizes?: string[];
  colors?: string[];
  featured?: boolean;
};

export const categories = [
  { slug: 'all', label: 'All Products' },
  { slug: 'shirts', label: 'Shirts & Tees' },
  { slug: 'hoodies', label: 'Hoodies & Crewnecks' },
  { slug: 'hats', label: 'Hats & Headwear' },
] as const;

export const products: Product[] = [
  {
    slug: 'operation-17-2-t-shirt',
    name: 'Operation 17:2 T-Shirt',
    price: 20,
    category: 'shirts',
    description:
      'High-quality soft cotton t-shirt featuring a bold design that embodies the spirit of Operation 17:2. More than apparel — a symbol of your commitment to child safety.',
    image:
      'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/pic1-standard-standard-high.jpg',
    sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'],
    colors: ['Black'],
    featured: true,
  },
  {
    slug: 'luke-17-2-camo-t-shirt',
    name: 'Luke 17:2 Camo T-Shirt',
    price: 25,
    category: 'shirts',
    description:
      'Rugged camo tee carrying our guiding scripture. Designed for comfort, durability, and making a statement wherever you go.',
    image:
      'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/img_1509-high-fbbux5.jpg',
    sizes: ['S', 'M', 'L', 'XL', '2XL'],
    colors: ['Camo'],
    featured: true,
  },
  {
    slug: 'operation-17-2-hoodie',
    name: 'Operation 17:2 Hoodie',
    price: 35,
    category: 'hoodies',
    description:
      'Premium hoodie built for comfort and purpose. Every purchase directly funds decoy operations and child protection efforts.',
    image:
      'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/pic9-high-8qde6n.jpg',
    sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'],
    colors: ['Black'],
    featured: true,
  },
  {
    slug: 'operation-17-2-crewnecks',
    name: 'Operation 17:2 Crewneck',
    price: 28,
    category: 'hoodies',
    description:
      'Classic crewneck sweatshirt with the Operation 17:2 emblem. Wear your support and fund critical mission resources.',
    image: 'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/pic7-high.jpg',
    sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'],
    colors: ['Black'],
  },
  {
    slug: 'operation-17-2-embroidered-hat',
    name: 'Operation 17:2 Embroidered Hat',
    price: 38,
    category: 'hats',
    description:
      'Embroidered hat featuring the Operation 17:2 logo. A subtle yet powerful way to represent the mission daily.',
    image:
      'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/pics3-high-w010ny.jpg',
    colors: ['Black'],
  },
  {
    slug: 'b-w-operation-17-2-hat',
    name: 'B/W Operation 17:2 Hat',
    price: 38,
    category: 'hats',
    description:
      'Black and white Operation 17:2 hat. Clean, bold design that speaks to your commitment to protecting children.',
    image: 'https://primary.jwwb.nl/public/m/f/r/temp-ugvmozzpzknfbnquktyi/img_1659-high.jpg',
    colors: ['Black/White'],
  },
];

export function getProduct(slug: string): Product | undefined {
  return products.find((p) => p.slug === slug);
}

export function getProductsByCategory(category: string): Product[] {
  if (category === 'all') return products;
  return products.filter((p) => p.category === category);
}
