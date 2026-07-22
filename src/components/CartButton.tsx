import { useEffect, useState } from 'react';
import { getCart, getCartCount, type CartItem } from '../lib/cart';
import CartDrawer from './CartDrawer';

export default function CartButton() {
    const [count, setCount] = useState(0);
    const [open, setOpen] = useState(false);
    const [items, setItems] = useState<CartItem[]>([]);

    useEffect(() => {
        const sync = () => {
            const cart = getCart();
            setItems(cart);
            setCount(getCartCount(cart));
        };
        sync();
        window.addEventListener('cart-updated', sync);
        window.addEventListener('storage', sync);
        return () => {
            window.removeEventListener('cart-updated', sync);
            window.removeEventListener('storage', sync);
        };
    }, []);

    return (
        <>
            <button
                onClick={() => setOpen(true)}
                className="relative inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-white transition-all hover:border-brand-blue/50 hover:text-brand-blue"
                aria-label="Open cart"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
                {count > 0 && (
                    <span className="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-brand-blue text-[10px] font-bold text-white">
                        {count}
                    </span>
                )}
            </button>
            <CartDrawer open={open} onClose={() => setOpen(false)} items={items} onUpdate={setItems} />
        </>
    );
}
