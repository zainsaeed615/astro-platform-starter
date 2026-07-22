import { getCartTotal, removeFromCart, updateQuantity, type CartItem } from '../lib/cart';

interface Props {
    open: boolean;
    onClose: () => void;
    items: CartItem[];
    onUpdate: (items: CartItem[]) => void;
}

export default function CartDrawer({ open, onClose, items, onUpdate }: Props) {
    const total = getCartTotal(items);

    if (!open) return null;

    return (
        <div className="fixed inset-0 z-[100]">
            <div className="absolute inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose} />
            <div className="absolute right-0 top-0 flex h-full w-full max-w-md flex-col border-l border-white/10 bg-brand-dark shadow-2xl">
                <div className="flex items-center justify-between border-b border-white/10 p-6">
                    <h2 className="font-display text-lg font-bold uppercase tracking-wider">Your Cart</h2>
                    <button onClick={onClose} className="text-white/60 hover:text-white" aria-label="Close cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>

                <div className="flex-1 overflow-y-auto p-6">
                    {items.length === 0 ? (
                        <div className="flex h-full flex-col items-center justify-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" className="text-white/20">
                                <circle cx="8" cy="21" r="1" />
                                <circle cx="19" cy="21" r="1" />
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                            </svg>
                            <p className="mt-4 text-white/50">Your cart is empty</p>
                            <a href="/shop" className="btn-primary mt-6 no-underline" onClick={onClose}>
                                Browse Shop
                            </a>
                        </div>
                    ) : (
                        <div className="space-y-4">
                            {items.map((item) => (
                                <div key={`${item.id}-${item.size}-${item.color}`} className="flex gap-4 rounded-xl border border-white/10 bg-brand-gray/50 p-4">
                                    <div className="h-16 w-16 shrink-0 overflow-hidden rounded-lg bg-brand-black">
                                        <img src={item.image} alt={item.name} className="h-full w-full object-cover" />
                                    </div>
                                    <div className="flex-1">
                                        <h3 className="font-display text-xs font-semibold uppercase tracking-wide">{item.name}</h3>
                                        {(item.size || item.color) && (
                                            <p className="mt-1 text-xs text-white/40">
                                                {[item.size, item.color].filter(Boolean).join(' · ')}
                                            </p>
                                        )}
                                        <div className="mt-2 flex items-center justify-between">
                                            <div className="flex items-center gap-2">
                                                <button
                                                    onClick={() => onUpdate(updateQuantity(item.id, item.quantity - 1, item.size, item.color))}
                                                    className="flex h-6 w-6 items-center justify-center rounded border border-white/10 text-xs hover:border-brand-blue"
                                                >
                                                    −
                                                </button>
                                                <span className="text-sm">{item.quantity}</span>
                                                <button
                                                    onClick={() => onUpdate(updateQuantity(item.id, item.quantity + 1, item.size, item.color))}
                                                    className="flex h-6 w-6 items-center justify-center rounded border border-white/10 text-xs hover:border-brand-blue"
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <span className="font-display text-sm font-bold text-brand-blue">${(item.price * item.quantity).toFixed(2)}</span>
                                        </div>
                                    </div>
                                    <button
                                        onClick={() => onUpdate(removeFromCart(item.id, item.size, item.color))}
                                        className="text-white/30 hover:text-red-400"
                                        aria-label="Remove item"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                            <path d="M3 6h18" />
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        </svg>
                                    </button>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

                {items.length > 0 && (
                    <div className="border-t border-white/10 p-6">
                        <div className="mb-4 flex items-center justify-between">
                            <span className="text-sm text-white/60">Subtotal</span>
                            <span className="font-display text-xl font-bold text-brand-blue">${total.toFixed(2)}</span>
                        </div>
                        <p className="mb-4 text-xs text-white/40">Proceeds support child protection operations. Shopify checkout at launch.</p>
                        <a href="/shop/checkout" className="btn-primary block w-full text-center no-underline" onClick={onClose}>
                            Checkout
                        </a>
                    </div>
                )}
            </div>
        </div>
    );
}
