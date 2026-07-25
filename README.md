# ClickNet — Performance Affiliate Network Platform

A production-grade affiliate marketing network website with a custom-built
CMS. Built on Core PHP 8.3+, PDO and a hand-rolled MVC framework (no
WordPress, Laravel, or third-party framework), with a Tailwind CSS +
Alpine.js frontend.

Development happens on feature branches merged via pull request. See the
open PR(s) for the current build phase and status.

## Stack
- **Backend:** Core PHP 8.3+, PDO, custom MVC (Router / Controller / Model / View)
- **Frontend:** HTML5, Tailwind CSS, Alpine.js, vanilla JS
- **Database:** MySQL 8+ (see `database/schema.sql`)

## Local setup
1. `cp .env.example .env` and fill in your database credentials.
2. Import the schema: `mysql -u root your_db < database/schema.sql`
3. Seed initial data (default admin, settings, homepage content):
   `mysql -u root your_db < database/seeders/seed.sql`
   `mysql -u root your_db < database/seeders/seed_pages.sql`
4. Point your web server's document root at `public/`, or for local dev:
   `php -S localhost:8000 -t public`
5. Default admin login: `admin@clicknet.test` / `ChangeMe!123` — change this
   immediately after first login.
