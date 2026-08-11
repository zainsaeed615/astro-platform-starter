=== MDR AI Carrier Intelligence ===
Contributors: mydrayrate
Tags: drayage, logistics, ai, carrier intelligence, freight
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Above-the-fold AI Carrier Intelligence CTA with secure shipment upload and actionable carrier intelligence reports for MyDrayRate.

== Description ==

MDR AI Carrier Intelligence adds a premium, dark-themed lead generation section to your WordPress site. Visitors can upload historical shipment data (CSV, XLS, XLSX) and receive an AI-powered carrier intelligence report before signing up for MDR.

**Features:**

* Above-the-fold CTA section matching MDR branding
* Drag-and-drop secure file upload
* Seven-section intelligence report
* Signup and demo scheduling CTAs
* Responsive Google Calendar modal
* Admin settings for branding, uploads, and calendar embed
* Optional OpenAI narrative enrichment

== Installation ==

1. Upload the `mdr-ai-carrier-intelligence` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings → MDR AI Carrier Intelligence to configure options
4. Add `[mdr_ai_carrier_intelligence]` to your homepage (Elementor HTML widget or page content)

== Frequently Asked Questions ==

= What file formats are supported? =

CSV, XLS, and XLSX files up to the configured upload size limit.

= Does it require an OpenAI API key? =

No. Reports are generated using built-in analytics. OpenAI is optional for executive summary enrichment.

== Changelog ==

= 1.0.4 =
* Simplified section to upload button only — removed headline, eyebrow, description, and background graphics
* Full flow inside popup: upload → processing → AI report/results (no separate page sections)
* Modal expands for report view; responsive on desktop and mobile
* Process Colors admin settings apply across all popup steps

= 1.0.3 =
* Single crimson upload button with cloud icon (matches MDR design)
* Full process color customization in Settings → Process Colors
* CSS variables drive button, modal, loading, report cards, and CTAs
* Optional upload button subtitle (off by default for single-line button)

= 1.0.2 =
* Single hero button opens upload modal (matches Replit demo flow)
* Drag-and-drop moved inside modal — no visible upload zone on page load
* Upload CTA with title + optional subtitle styling

= 1.0.1 =
* Fix asset loading when shortcode renders after wp_enqueue_scripts
* Fix CSV/XLS/XLSX upload validation on WordPress hosts
* Fix AJAX nonce errors returning proper JSON messages
* Fix XLSX parser namespace handling
* Fix demo modal z-index and body scroll lock
* Improve report empty-state messaging
* Elementor editor/preview compatibility

= 1.0.0 =
* Initial release
