# VUZE Horizon header — mobile fix

Copy `sections/header.liquid` into your Shopify theme at:

`Online Store → Themes → Edit code → sections/header.liquid`

## What changed (mobile only, ≤749px)

1. **Logo left** — VUZE logo is pinned to the left (`grid-area: logo`, `justify-content: flex-start`).
2. **Even cart + profile icons** — account and cart share equal 44×44px touch targets with matching icon size.
3. **Drawer override** — also applied under `#header-component[data-menu-style='drawer']` so Horizon’s mobile drawer mode does not re-center the logo.

Desktop layout is unchanged.
