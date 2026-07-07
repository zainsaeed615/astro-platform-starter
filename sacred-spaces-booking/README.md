# Sacred Spaces Booking

A premium luxury WordPress booking plugin designed exclusively for [Sacred Spaces by Sharon](https://sacredspacesbysharon.com).

![Version](https://img.shields.io/badge/version-1.0.0-C9A04F)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4)
![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-21759B)

## Overview

Sacred Spaces Booking delivers an intentional, eight-step booking experience with a refined aesthetic inspired by luxury hospitality and interior design studios. The plugin is built from the ground up for Sacred Spaces by Sharon — not a generic booking clone.

### Design Language

- **Colors:** Gold (#C9A04F), Cream (#F6F1E8), Soft White (#FCFAF6)
- **Typography:** Cormorant Garamond (headings), Lato (body)
- **Feel:** Calm, spacious, elegant, feminine, refined

## Features

### Frontend Booking Wizard (8 Steps)

1. Choose Service
2. Location (Virtual / In Home)
3. Calendar
4. Time
5. Client Details
6. Questionnaire
7. Review
8. Confirmation

- Animated progress bar
- Smooth fade/slide transitions (200–350ms)
- Fully responsive (desktop, tablet, mobile)
- WCAG-compliant with keyboard navigation

### Services (Pre-configured)

| Service | Investment | Payment |
|---------|-----------|---------|
| Private Consultation | $900 · 90 min | Full payment via Stripe |
| Spatial Reset – Private Client Experience | $4,000–$6,500 | Inquiry only |
| Private Retainer | $3,500–$5,000/mo | Inquiry only |

### Calendar & Availability

- Default available days: Tuesday & Wednesday (admin configurable)
- Weekends disabled by default
- Default time slots: 10:00 AM, 11:30 AM, 1:30 PM, 3:00 PM, 4:30 PM
- Double-booking prevention
- Vacation/date blocking

### Payments (Stripe)

- Full payment, deposit, or no payment per service
- Stripe Checkout Sessions
- Webhook support for payment confirmation
- Test and live mode

### Email Notifications

- Luxury HTML emails matching brand colors
- Client confirmation with booking summary
- Admin notification with questionnaire responses
- Customizable templates in admin

### WordPress Admin

- **Dashboard** — Today's appointments, upcoming bookings, revenue, recent clients
- **Bookings** — Approve, decline, cancel, reschedule, export CSV
- **Calendar** — Monthly overview
- **Services** — Edit services, pricing, payment modes
- **Availability** — Days, time slots, blocked dates
- **Payments** — Stripe configuration
- **Questionnaires** — Client intake responses
- **Reports** — Analytics overview
- **Settings** — General configuration, premium feature toggles
- **Email Templates** — Customize notification content

### Integrations

- **Shortcodes:** `[sacred_booking]`, `[sacred_calendar]`, `[sacred_services]`
- **Gutenberg Block:** Sacred Spaces Booking
- **Elementor Widget:** Full wizard, calendar, or services list

### Premium Features (Toggle in Settings)

- Google Calendar Sync
- Outlook Sync
- Zoom Integration
- SMS Reminders
- Client Portal

## Installation

### Requirements

- WordPress 6.0+
- PHP 8.2+
- MySQL 5.7+ or MariaDB 10.3+
- SSL certificate (required for Stripe)

### Quick Install

1. Download or clone the `sacred-spaces-booking` folder
2. ZIP the folder (the ZIP root must contain `sacred-spaces-booking.php`)
3. In WordPress Admin → **Plugins → Add New → Upload Plugin**
4. Upload the ZIP and click **Install Now**, then **Activate**

### Manual Install

```bash
# Copy plugin to WordPress plugins directory
cp -r sacred-spaces-booking /path/to/wordpress/wp-content/plugins/

# Activate via WP-CLI
wp plugin activate sacred-spaces-booking
```

### Post-Installation Setup

1. **Create a booking page**
   - Add a new page (e.g., "Book a Session")
   - Insert shortcode: `[sacred_booking]`
   - Publish the page

2. **Configure settings**
   - Go to **Sacred Spaces → Settings**
   - Set the **Booking Page URL** to your booking page
   - Set admin notification email

3. **Configure Stripe** (for Private Consultation payments)
   - Go to **Sacred Spaces → Payments**
   - Enter Stripe API keys (test mode first)
   - Create a webhook in Stripe Dashboard:
     - URL: `https://yoursite.com/wp-json/sacred-spaces-booking/v1/stripe-webhook`
     - Events: `checkout.session.completed`
   - Copy webhook signing secret into plugin settings

4. **Review availability**
   - Go to **Sacred Spaces → Availability**
   - Confirm days and time slots match your schedule

## Usage

### Shortcodes

```
[sacred_booking]
```
Full 8-step booking wizard with hero section.

```
[sacred_calendar]
```
Standalone availability calendar.

```
[sacred_services]
```
Elegant services listing cards.

### Gutenberg

Search for **"Sacred Spaces Booking"** in the block inserter under Widgets.

### Elementor

Find **Sacred Spaces Booking** under the Sacred Spaces category in the Elementor widget panel.

## Plugin Structure

```
sacred-spaces-booking/
├── sacred-spaces-booking.php    # Main plugin file
├── uninstall.php
├── composer.json
├── README.md
├── admin/
│   ├── assets/css/admin.css
│   ├── assets/js/admin.js
│   └── templates/               # Admin page templates
├── includes/
│   ├── class-activator.php
│   ├── class-deactivator.php
│   ├── class-plugin.php
│   ├── class-autoloader.php
│   └── classes/
│       ├── Admin/
│       ├── Api/
│       ├── Database/
│       ├── Frontend/
│       ├── Helpers/
│       ├── Integrations/
│       ├── Repositories/
│       └── Services/
├── public/
│   ├── assets/css/public.css
│   ├── assets/js/booking.js
│   ├── assets/js/block.js
│   ├── block.json
│   └── templates/
├── templates/emails/
└── languages/
```

## Database Tables

| Table | Purpose |
|-------|---------|
| `wp_ssb_services` | Service definitions |
| `wp_ssb_bookings` | Booking records |
| `wp_ssb_clients` | Client information |
| `wp_ssb_time_slots` | Available time slots |
| `wp_ssb_availability_days` | Day-of-week availability |
| `wp_ssb_blocked_dates` | Blocked/vacation dates |
| `wp_ssb_booking_notes` | Admin notes on bookings |

## REST API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp-json/sacred-spaces-booking/v1/services` | List active services |
| GET | `/wp-json/sacred-spaces-booking/v1/availability/dates` | Available dates for month |
| GET | `/wp-json/sacred-spaces-booking/v1/availability/slots` | Available slots for date |
| POST | `/wp-json/sacred-spaces-booking/v1/bookings` | Create booking |
| GET | `/wp-json/sacred-spaces-booking/v1/bookings/{ref}` | Get booking by reference |
| POST | `/wp-json/sacred-spaces-booking/v1/payments/checkout` | Create Stripe session |
| POST | `/wp-json/sacred-spaces-booking/v1/stripe-webhook` | Stripe webhook handler |

## Development

### Architecture

- PHP 8.2+ with strict types
- OOP with PSR-4 autoloading (`SacredSpaces\Booking` namespace)
- Repository pattern for data access
- Service layer for business logic
- Prepared SQL statements throughout
- Nonce verification on all mutations
- Input sanitization and output escaping

### Composer Autoload

```bash
cd sacred-spaces-booking
composer dump-autoload -o
```

## Uninstall

By default, uninstalling the plugin preserves data. To delete all tables and settings on uninstall, add this before uninstalling:

```php
update_option( 'ssb_delete_data_on_uninstall', true );
```

## Support

For Sacred Spaces by Sharon: [sacredspacesbysharon.com](https://sacredspacesbysharon.com)

## License

GPL-2.0-or-later
