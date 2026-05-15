# RentEase — Furniture & Appliance Rental Platform

> Affordable monthly rental solutions for furniture and appliances, built for students and working professionals who relocate frequently.

[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Supabase](https://img.shields.io/badge/Supabase-PostgreSQL-3ECF8E?logo=supabase&logoColor=white)](https://supabase.com/)
[![Stripe](https://img.shields.io/badge/Stripe-Payments-635BFF?logo=stripe&logoColor=white)](https://stripe.com/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

---

## Features

- **Product Catalog** — Browse furniture & appliances by category with filtering and search
- **Flexible Rentals** — Monthly plans with customizable tenure (3/6/9/12 months)
- **Stripe Checkout** — Secure payment processing with webhook verification
- **User Dashboard** — Track active rentals, orders, and rental history
- **Admin Panel** — Inventory management, order tracking, analytics
- **Real-Time Tracking** — Live delivery tracking with Supabase Realtime
- **Push Notifications** — OneSignal web push for order updates
- **Maintenance System** — Request and track maintenance for rented items
- **Rewards & Referrals** — Loyalty points and referral program
- **Email Notifications** — Transactional emails via Resend + admin SMTP via PHPMailer

## Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.3+ (Strict Types, PSR-12) |
| **Database** | PostgreSQL via Supabase (Auth + RLS + Realtime) |
| **Frontend** | Vanilla JS, Tailwind CSS, GSAP 3 |
| **Payments** | Stripe (Checkout Sessions + Webhooks) |
| **Email** | Resend (transactional), PHPMailer (admin SMTP) |
| **Push** | OneSignal Web SDK v16 |
| **Shipping** | Shiprocket API integration |
| **Maps** | Google Maps Geocoding API |

## Prerequisites

- PHP 8.3+ with extensions: `pdo_pgsql`, `curl`, `openssl`, `mbstring`
- Composer 2.x
- Apache with `mod_rewrite` enabled (or equivalent)
- Supabase project (Auth + Database + Realtime)
- Stripe account (test or live mode)

## Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/Tausifonly001/RentEase.git
cd RentEase

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
# Edit .env with your credentials (Supabase, Stripe, SMTP, etc.)

# 4. Set up the database
php backend/scripts/migrate.php

# 5. Seed sample data (optional)
php backend/scripts/seed.php

# 6. Configure Apache
# Point your vhost or XAMPP to the project root
# Ensure mod_rewrite is enabled

# 7. Open in browser
# http://localhost/rentease/
```

## Project Structure

```
rentease/
├── index.php                   # Front controller (router)
├── .htaccess                   # Apache URL rewriting
├── composer.json               # PHP dependencies
├── .env.example                # Environment template
│
├── backend/
│   ├── bootstrap.php           # App initialization (env, autoload, config)
│   ├── config/
│   │   └── config.php          # Centralized configuration
│   ├── database/
│   │   ├── schema.sql          # Database schema
│   │   └── shiprocket_schema.sql
│   ├── public/
│   │   ├── api/                # REST API endpoints
│   │   │   ├── auth/           # OAuth, login, signup
│   │   │   ├── logistics/      # Delivery tracking
│   │   │   ├── support/        # Support tickets
│   │   │   └── webhook/        # Stripe webhooks
│   │   ├── partials/           # Shared UI (header, footer)
│   │   └── [pages].php         # Page controllers
│   ├── scripts/
│   │   ├── migrate.php         # Database migration runner
│   │   └── seed*.php           # Data seeders
│   ├── src/
│   │   ├── Middleware/          # Auth middleware
│   │   ├── Services/            # Business logic layer
│   │   │   ├── AuthService.php
│   │   │   ├── StripeService.php
│   │   │   ├── RentalService.php
│   │   │   ├── LogisticsService.php
│   │   │   └── ...
│   │   └── Support/             # Utilities (CSRF, etc.)
│   └── storage/
│       └── cache/
│
├── js/                          # Client-side JavaScript
│   ├── onesignal.js
│   └── tracking.js
│
└── OneSignalSDKWorker.js        # Service worker (must be at root)
```

## Environment Variables

All required configuration is documented in [`.env.example`](.env.example). Key sections:

| Variable Group | Description |
|---|---|
| `SUPABASE_*` | Database and auth connection |
| `STRIPE_*` | Payment processing keys |
| `SMTP_*` | Admin email (Gmail SMTP) |
| `RESEND_*` | Transactional email API |
| `ONESIGNAL_*` | Push notification service |
| `GOOGLE_MAPS_*` | Geocoding for delivery |
| `SHIPROCKET_*` | Shipping integration |

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/signup` | User registration |
| `POST` | `/api/login` | User authentication |
| `GET` | `/api/products` | Product catalog |
| `GET` | `/api/furniture` | Furniture listings |
| `POST` | `/api/checkout` | Create Stripe checkout session |
| `POST` | `/api/book-rental` | Book a rental |
| `GET` | `/api/orders` | User order history |
| `POST` | `/api/returns` | Initiate product return |
| `POST` | `/api/maintenance-request` | Submit maintenance ticket |
| `POST` | `/api/webhook/stripe` | Stripe webhook handler |

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feat/your-feature`
3. Commit with conventional commits: `git commit -m "feat: add new feature"`
4. Push to your branch: `git push origin feat/your-feature`
5. Open a Pull Request

### Commit Convention

| Prefix | Use Case |
|---|---|
| `feat:` | New feature |
| `fix:` | Bug fix |
| `refactor:` | Code restructure |
| `chore:` | Build, deps, config |
| `docs:` | Documentation |
| `security:` | Security patches |

## License

This project is licensed under the MIT License — see the [LICENSE](LICENSE) file for details.

---

**Built with ❤️ by [Tausif Ali](https://github.com/Tausifonly001)**
