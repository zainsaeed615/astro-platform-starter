# MDR AI Carrier Intelligence

Premium WordPress plugin for [MyDrayRate](https://mydrayrate.com/) — above-the-fold AI Carrier Intelligence lead generation with secure shipment upload and actionable reports.

## Installation

1. Copy or zip the `mdr-ai-carrier-intelligence` folder into `wp-content/plugins/`
2. Activate **MDR AI Carrier Intelligence** in WordPress Admin → Plugins
3. Configure at **Settings → MDR AI Carrier Intelligence**
4. Add the shortcode to your homepage (above the fold):

```
[mdr_ai_carrier_intelligence]
```

For Elementor: use an **HTML** or **Shortcode** widget.

## Features

- Dark modern MDR-branded CTA section
- Drag-and-drop upload (CSV, XLS, XLSX)
- Seven-section AI carrier intelligence report
- Signup + Google Calendar demo modal CTAs
- Admin settings for branding, uploads, calendar embed, optional OpenAI
- Nonce validation, rate limiting, secure file handling

## Sample Data

Use `sample-data/sample-shipments.csv` to test the upload flow locally.

## Requirements

- WordPress 6.0+
- PHP 7.4+ with Zip extension (for XLSX)
