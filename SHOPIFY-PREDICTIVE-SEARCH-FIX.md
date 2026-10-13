# Predictive search popup — fix (2Posh Beauty)

## Problem

Theme settings are already ON:

- Enable predictive search / Enable product suggestions
- Show product price
- Show products
- Show collections/categories (optional)

Shopify API also works (`/search/suggest.json` returns products).

**Still no popup**, because the live header is a **custom AI header** (`ai-beauty-header-...`) with a normal search form that only goes to `/search` on submit. It is **not wired** to Minimog’s `<predictive-search>` popup. Settings only control Minimog’s native search UI — which is not in the header anymore.

## Fix (5 minutes)

1. Open file in this repo: `shopify-header-predictive-search.liquid`
2. Shopify Admin → **Online Store → Themes → Customize**
3. Open the **Header** group (top of the page)
4. **Add section → Custom liquid**
5. Paste the **entire** contents of `shopify-header-predictive-search.liquid`
6. **Save**
7. Hard refresh the storefront and type `lip` in the header search

You should see a dropdown with product image, title, and price (and collections if returned).

### If dropdown still does not show
The AI header search form uses `overflow: hidden` + fixed height, which clips absolute menus. The latest snippet forces `overflow: visible` on that form. **Re-paste the full updated file** into the existing Custom liquid section (replace old code) → Save → hard refresh.

## Roman Urdu

Settings ON hone se popup nahi aata — kyunki header AI custom hai, Minimog search se connect nahi.

Custom Liquid section header mein paste karo (`shopify-header-predictive-search.liquid`). Uske baad search box ke neeche products + price ka dropdown aa jayega.

Agar pehle wala paste kiya tha aur phir bhi nahi aaya: search bar `overflow:hidden` se dropdown cut ho raha tha. **Updated file dubara poora paste** karo → Save → hard refresh → `lip` type karo.

## Do not do

- Theme settings dubara ON/OFF karna — already correct
- Sirf “Show products” toggle change karna — isse yeh header fix nahi hoga
