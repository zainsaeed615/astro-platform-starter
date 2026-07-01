# Vidian Investment Developments WordPress Plugin

A full property-investment development manager for WordPress/Elementor websites.

This is not a rental booking plugin. It is built for Vidian Capital style pages:

- Build Your Wealth Through Strategic Property Investment
- UK/Dubai investment developments
- Gallery-driven development pages
- Investment metrics
- Summary and overview content
- Why-invest/keypoint cards
- Flexible custom sections
- Enquiry forms tagged to the selected development
- Optional Elementor widgets

## Installation

1. Zip the folder:
   `vidian-investment-developments`
2. In WordPress admin, go to **Plugins > Add New > Upload Plugin**.
3. Upload the zip file.
4. Activate **Vidian Investment Developments**.
5. Go to **Settings > Permalinks** and click **Save Changes** once.

## Admin Usage

After activation, a new admin menu appears:

**Investment Developments**

Each development supports:

- Main title
- Subtitle
- Status
- Location
- Market/country
- Prices from
- Expected yields
- Completion
- Bedrooms
- Deposit
- Tenure
- Short summary
- Full overview
- Clickable image gallery
- Keypoints / why-invest cards
- Unlimited flexible sections
- CTA heading and CTA text

The plugin seeds a sample **Waterhouse Gardens** page using data from the old Vidian Capital page.

## Shortcodes

Show one development by slug:

```text
[vidian_development slug="waterhouse-gardens"]
```

Show one development by ID:

```text
[vidian_development id="123"]
```

Show a grid:

```text
[vidian_developments limit="6"]
```

Filter by market taxonomy slug:

```text
[vidian_developments limit="6" market="uk"]
```

## Elementor Widgets

If Elementor is installed, two widgets are available:

1. **Vidian Developments Grid**
2. **Vidian Development Detail**

Use the detail widget with a development slug such as:

```text
waterhouse-gardens
```

## Frontend Routes

Single development pages use:

```text
/developments/development-slug/
```

Example:

```text
/developments/waterhouse-gardens/
```

## Design System

The frontend uses the Vidian/Waterhouse design style:

- Deep blue: `#001F78`
- Bright blue accent: `#052C8F`
- White and soft grey sections
- Roboto Condensed headings
- Inter Tight body font
- Premium investment-page layout

## Enquiry Forms

Each detail page includes a built-in enquiry form. Submissions are emailed to the WordPress admin email and tagged with the development title.
