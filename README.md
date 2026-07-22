# Operation 17:2 — Website Redesign Draft

## Live Preview

**[Open Preview →](https://sparkling-tanuki-9ce643.netlify.app/)**

Password (if prompted): `My-Drop-Site`

Bold, masculine, rugged redesign for [op17two.com](https://www.op17two.com/) built with Astro + Tailwind CSS + React.

## Design

- **Colors:** Black background, white text, electric blue gradient accents (matching logo)
- **Typography:** Oswald (display) + DM Sans (body)
- **Style:** High-end, action-oriented, community-focused SaaS-quality layout

## Pages

| Page | Route |
|------|-------|
| Home | `/` |
| About Us | `/about` |
| Mission | `/about/mission` |
| How It Works | `/about/how-it-works` |
| Statement of Faith | `/about/values` |
| Leadership | `/about/leadership` |
| Get Involved | `/get-involved` |
| Apply | `/get-involved/apply` |
| Role Pages | `/get-involved/*-team` |
| Donate | `/donate` |
| Live Prayer | `/live-prayer` |
| Shop | `/shop` |
| Product Detail | `/shop/product/[slug]` |
| Resources | `/resources` |
| Contact | `/contact` |
| Legal | `/legal/*` |

## Features (Draft)

- E-commerce cart (localStorage) with product variants
- Live donation thermometer (Givebutter-ready)
- Volunteer application form (platform-ready)
- Newsletter signup, contact form
- Responsive mobile navigation

## Preview

```bash
npm install
npm run dev      # http://localhost:4321
npm run build    # static output in dist/
npm run preview  # preview production build
```

## Launch Integrations (Not Connected in Draft)

- **Shopify** — apparel store + checkout
- **Givebutter** — donations, live goals, peer-to-peer fundraisers
- **Volunteer Platform** — applications + background check gate
- **Zoom** — live prayer call registration

## Download

See `op17two-website-redesign-draft.zip` for a portable preview package.
