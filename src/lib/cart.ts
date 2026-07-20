export interface CartItem {
    id: string;
    slug: string;
    name: string;
    price: number;
    image: string;
    size?: string;
    color?: string;
    quantity: number;
}

const CART_KEY = 'op172-cart';

export function getCart(): CartItem[] {
    if (typeof window === 'undefined') return [];
    try {
        return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    } catch {
        return [];
    }
}

export function saveCart(items: CartItem[]) {
    localStorage.setItem(CART_KEY, JSON.stringify(items));
    window.dispatchEvent(new CustomEvent('cart-updated', { detail: items }));
}

export function addToCart(item: Omit<CartItem, 'quantity'> & { quantity?: number }) {
    const cart = getCart();
    const existing = cart.find((i) => i.id === item.id && i.size === item.size && i.color === item.color);
    if (existing) {
        existing.quantity += item.quantity || 1;
    } else {
        cart.push({ ...item, quantity: item.quantity || 1 });
    }
    saveCart(cart);
    return cart;
}

export function removeFromCart(id: string, size?: string, color?: string) {
    const cart = getCart().filter((i) => !(i.id === id && i.size === size && i.color === color));
    saveCart(cart);
    return cart;
}

export function updateQuantity(id: string, quantity: number, size?: string, color?: string) {
    const cart = getCart().map((i) =>
        i.id === id && i.size === size && i.color === color ? { ...i, quantity: Math.max(1, quantity) } : i
    );
    saveCart(cart);
    return cart;
}

export function getCartTotal(items: CartItem[]): number {
    return items.reduce((sum, i) => sum + i.price * i.quantity, 0);
}

export function getCartCount(items: CartItem[]): number {
    return items.reduce((sum, i) => sum + i.quantity, 0);
}
