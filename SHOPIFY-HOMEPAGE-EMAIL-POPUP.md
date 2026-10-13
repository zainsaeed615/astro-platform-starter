# Homepage-only email popup (replace POWR)

## Client feedback
- Popup should be on the **front page only** — not when opening products
- Must **not keep popping** after the customer enters email
- Must **not show** for people who already subscribed
- Prefer a **free** basic solution (POWR paid features not required)

## What is wrong now
The store uses **POWR Sales Popup / Email Popup**. Its Shopify **app embed** loads on **every page** (homepage + product pages). That is why it keeps interrupting shopping even when settings look “basic”.

Free POWR is also limited (e.g. ~25 submissions/month; some display controls are paid).

## Recommended free fix (do this)

### 1) Turn POWR off
1. Shopify Admin → **Online Store → Themes → Customize**
2. Left: **Theme settings** (gear) → **App embeds**
3. Turn **OFF** `POWR Popup` / `POWR Sales Popup` → **Save**
4. Optional: **Apps → POWR** → unpublish / pause the popup so it cannot come back

### 2) Add the free homepage popup
1. Open `shopify-homepage-email-popup.liquid` from this repo
2. Theme Customize → **Home page** template (not Header group)
3. **Add section → Custom liquid**
4. Paste the **entire** file → **Save**

### Behavior
| Rule | How it works |
|------|----------------|
| Front page only | Liquid `{% if template.name == 'index' %}` |
| Not on product pages | Section is only on Home page + Liquid guard |
| Not again after email | `localStorage` flag set on submit |
| Not again after close | Same flag on close (X / overlay) |
| Not for subscribed logged-in customers | Skips if `customer.accepts_marketing` |

Emails land in **Shopify Customers** with tags `newsletter, homepage-popup` (can sync to Klaviyo if you already connect Shopify → Klaviyo).

## If you insist on keeping POWR
In POWR editor publish screen: install on **homepage only** (not Everywhere), and set display frequency to **once per visitor** / do not show after submission.  
Still turn off “Everywhere” / app-embed-all-pages behavior — otherwise product pages will keep getting the script. Paid targeting is what POWR upsells; the free Custom Liquid above covers the basic need without paying.
