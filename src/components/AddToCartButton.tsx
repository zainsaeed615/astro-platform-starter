import { useState } from 'react';
import { addToCart } from '../lib/cart';
import type { Product } from '../data/products';

interface Props {
    product: Product;
}

export default function AddToCartButton({ product }: Props) {
    const [size, setSize] = useState(product.sizes?.[0] || '');
    const [color, setColor] = useState(product.colors?.[0] || '');
    const [added, setAdded] = useState(false);

    const handleAdd = () => {
        addToCart({
            id: product.id,
            slug: product.slug,
            name: product.name,
            price: product.price,
            image: product.image,
            size: size || undefined,
            color: color || undefined
        });
        setAdded(true);
        setTimeout(() => setAdded(false), 2000);
    };

    return (
        <div className="space-y-6">
            {product.sizes && product.sizes.length > 0 && (
                <div>
                    <label className="mb-2 block font-display text-xs uppercase tracking-widest text-white/60">Size</label>
                    <div className="flex flex-wrap gap-2">
                        {product.sizes.map((s) => (
                            <button
                                key={s}
                                onClick={() => setSize(s)}
                                className={`rounded-lg border px-4 py-2 font-display text-xs uppercase tracking-wider transition-all ${
                                    size === s ? 'border-brand-blue bg-brand-blue/20 text-brand-blue' : 'border-white/10 text-white/70 hover:border-white/30'
                                }`}
                            >
                                {s}
                            </button>
                        ))}
                    </div>
                </div>
            )}

            {product.colors && product.colors.length > 0 && (
                <div>
                    <label className="mb-2 block font-display text-xs uppercase tracking-widest text-white/60">Color</label>
                    <div className="flex flex-wrap gap-2">
                        {product.colors.map((c) => (
                            <button
                                key={c}
                                onClick={() => setColor(c)}
                                className={`rounded-lg border px-4 py-2 font-display text-xs uppercase tracking-wider transition-all ${
                                    color === c ? 'border-brand-blue bg-brand-blue/20 text-brand-blue' : 'border-white/10 text-white/70 hover:border-white/30'
                                }`}
                            >
                                {c}
                            </button>
                        ))}
                    </div>
                </div>
            )}

            <button onClick={handleAdd} className="btn-primary w-full">
                {added ? '✓ Added to Cart' : `Add to Cart — $${product.price.toFixed(2)}`}
            </button>
        </div>
    );
}
