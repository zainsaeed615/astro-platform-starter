=== Vidian Property Calculators ===
Contributors: vidiancapital
Tags: calculator, property, stamp duty, rental yield, mortgage, shortcode
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Property investment calculators matching the Vidian Capital design — Stamp Duty, Rental Yield, and Mortgage.

== Description ==

Embed the Vidian Capital property investment calculators on any WordPress page using a simple shortcode. Perfect for Elementor Shortcode widgets.

**Calculators included:**

* Stamp Duty Land Tax (SDLT) Calculator
* Rental Yield Calculator
* Mortgage Repayment Calculator

**Shortcode:**

`[vidian_calculators]`

Also supported: `[calculator_plugin]` and `[vidian_calculator]`

**Optional attributes:**

* `show_hero="true"` — Show or hide the hero section (default: true)
* `show_cta="true"` — Show or hide the CTA section (default: true)
* `consultation_url="/consultation"` — CTA consultation link
* `contact_url="/contact"` — CTA contact link
* `default_tab="stamp-duty"` — Default active tab (stamp-duty, yield, mortgage)

== Installation ==

1. Upload the plugin ZIP via **Plugins → Add New → Upload Plugin**
2. Activate the plugin
3. Add `[calculator_plugin]` to any page or Elementor Shortcode widget

== Changelog ==

= 1.0.3 =
* Added [vidian_calculators] shortcode alias (plural)

= 1.0.2 =
* Fix shortcode not rendering (earlier registration + Elementor compatibility)
* Process shortcode inside Elementor Text/Heading widgets automatically
* Ensure CSS/JS load when shortcode renders late on page
* Added alternate shortcode: [vidian_calculator]

= 1.0.1 =
* Improved mobile responsiveness for tabs, cards, inputs, and Elementor embeds
* Fixed horizontal overflow on small screens
* Reduced padding and font sizes on mobile devices

= 1.0.0 =
* Initial release
