# Techslay — Performance Affiliate Network Platform

**Techslay Media Pvt Ltd** — a production-grade affiliate marketing network
website with a custom-built CMS. Built on Core PHP 8.3+, PDO and a
hand-rolled MVC framework (no WordPress, Laravel, or third-party framework),
with a Tailwind CSS + Alpine.js frontend.

Development happens on feature branches merged via pull request. See the
open PR(s) for the current build phase and status.

## Stack
- **Backend:** Core PHP 8.3+, PDO, custom MVC (Router / Controller / Model / View)
- **Frontend:** HTML5, Tailwind CSS (compiled, not the CDN build), Alpine.js, vanilla JS
- **Database:** MySQL 8+ (see `database/schema.sql`)

## Local setup
1. `cp .env.example .env` and fill in your database credentials.
2. Import the schema: `mysql -u root your_db < database/schema.sql`
3. Seed initial data (default admin, settings, homepage + page content):
   ```
   mysql -u root your_db < database/seeders/seed.sql
   mysql -u root your_db < database/seeders/seed_pages.sql
   ```
4. `npm install && npm run build:css` — compiles Tailwind into
   `public/assets/css/app.css`. Re-run this (or `npm run watch:css` while
   developing) any time you add/change Tailwind classes in `app/Views`,
   otherwise the new classes won't exist in the compiled stylesheet.
5. Point your web server's document root at `public/`, or for local dev:
   `php -S localhost:8000 -t public`
6. Default admin login: `admin@techslay.com` / `ChangeMe!123` — change this
   immediately after first login.

## What's built

**Frontend (public):** Home, About, Publishers, Advertisers, Technology,
Career, Contact (working lead-capture form), Privacy Policy, Terms, Cookie
Policy, Disclaimer — all rendered from admin-editable `page_sections`, plus
dedicated dynamic Services / Case Studies / Blog (listing + detail, with
categories, tags, related posts, reading time, view counts) and site-wide
search. XML sitemap, robots.txt, and full SEO meta / JSON-LD schema
(Organization, WebSite, Breadcrumb, FAQPage, Article) on every page. An
admin-manageable cookie consent banner (Settings → Cookie Banner).

**Branding:** original SVG mark (primary color lockup, white/dark/mono
variants, favicon, and a raster PNG for email use) under
`public/assets/images/techslay-*`, rendered through one shared
`partials/logo` component so every layout (front header/footer, admin
sidebar, admin login, maintenance page) stays in sync — and every one of
them falls back to an admin-uploaded logo from Settings → Branding the
moment one is set.

**Icons:** `App\Core\Icon` — ~25 original hand-drawn inline SVG icons
(shield-check, chart-bar, rocket, globe, etc.). Services, Industries and
Statistics store an icon *key* in the database and expose an icon picker in
their admin forms; homepage/section partials (services grid, why-choose-us,
technology, industries, benefits) render real icons instead of empty
placeholder boxes.

**Admin CMS:** login/logout/forgot-password with rate limiting and activity
logs, role-based permissions, Pages + section builder (this is what makes
the homepage/every page's content fully admin-editable), Media Manager
(upload, folders, WebP + AVIF conversion, SVG sanitization, trash/restore),
Menu builder with drag-and-drop reorder, Users & Roles, Settings (branding,
theme, business info, social, analytics, SMTP, reCAPTCHA, SEO, cookie
banner, general incl. maintenance/coming-soon mode and custom CSS/JS), Blog
CMS (categories, tags, authors, scheduled publish, auto TOC + reading
time), Testimonials, FAQs, Statistics, Industries, Services, Case Studies,
Leads (status workflow + CSV export), Redirects.

**Security:** CSRF on every mutating route, permission middleware on every
admin route, prepared statements throughout, bcrypt password hashing,
hardened sessions (httponly/samesite/secure), hashed single-use expiring
password-reset tokens, rate limiting on login/forgot-password/contact/
newsletter, upload validation (real mime-type check, extension allowlist,
randomized filenames, SVG script/handler stripping), CSV export sanitized
against formula injection. A full audit pass (XSS/SQLi/CSRF/auth/uploads/
sessions/rate-limiting) was run against the whole codebase — see PR history
for the findings and fixes.

## Known gaps (not yet built)

These were requested but are lower-priority and not yet implemented —
flagging them explicitly rather than silently skipping them:
- **Mega menu / nested navigation.** `menu_items.parent_id` exists in the
  schema, but the admin menu builder and front-end nav both only render a
  flat single-level list today.
- **Version history / rollback.** No content type (pages, sections, blog
  posts, etc.) keeps prior revisions — edits overwrite in place.
- **Image crop/resize UI.** Uploads get real mime validation and automatic
  WebP/AVIF conversion, but there's no in-browser cropping or manual resize
  tool in the Media Manager — images are stored and served at their
  as-uploaded dimensions.
- **Bulk actions and a "preview draft" mode** in the admin CRUD screens
  (every module supports create/edit/delete/draft-publish individually,
  just not multi-select bulk operations or previewing unpublished content).
- **Real outbound email:** password-reset and contact-form notifications
  are currently logged, not sent — SMTP settings exist in the admin but
  nothing dispatches through them yet.
- **Backup manager and import/export tooling.**
- **Dark mode toggle** on the public frontend (the design system's color
  choices are dark-mode-compatible in principle; there's no user-facing
  toggle or `prefers-color-scheme` handling wired up).
- **Auto-generated charts/graphs from arbitrary data.** Statistics are
  rendered as icon + number cards; there's no dynamic chart/graph rendering
  engine for admin-entered datasets.
- A dedicated Google News sitemap (not applicable — this is a B2B site, not
  a news publisher, so there's no eligible content to list).
