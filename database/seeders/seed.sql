-- =====================================================================
-- Initial seed data — roles, permissions, default admin, settings,
-- default menus and the Home page built from page_sections (JSON).
-- Run AFTER schema.sql.
-- Default admin login: admin@techslay.com / ChangeMe!123
-- (hash below is password_hash('ChangeMe!123', PASSWORD_BCRYPT) — change immediately)
-- =====================================================================

INSERT INTO roles (id, name, slug, description, is_system) VALUES
(1, 'Super Admin', 'super-admin', 'Full unrestricted access to every module.', 1),
(2, 'Editor', 'editor', 'Can manage content but not users, roles or settings.', 1),
(3, 'Publisher Manager', 'publisher-manager', 'Manages leads and publisher-facing content.', 0);

INSERT INTO permissions (name, slug, `group`) VALUES
('View Dashboard', 'dashboard.view', 'dashboard'),
('Manage Users', 'users.manage', 'users'),
('Manage Roles', 'roles.manage', 'users'),
('Manage Media', 'media.manage', 'media'),
('Manage Menus', 'menus.manage', 'cms'),
('Manage Pages', 'pages.manage', 'cms'),
('Manage Blog', 'blog.manage', 'blog'),
('Manage Services', 'services.manage', 'content'),
('Manage Industries', 'industries.manage', 'content'),
('Manage Case Studies', 'case_studies.manage', 'content'),
('Manage Testimonials', 'testimonials.manage', 'content'),
('Manage FAQs', 'faqs.manage', 'content'),
('Manage Statistics', 'statistics.manage', 'content'),
('Manage Leads', 'leads.manage', 'leads'),
('Manage Settings', 'settings.manage', 'settings'),
('Manage SEO', 'seo.manage', 'seo');

INSERT INTO role_permissions (role_id, permission_id)
SELECT 1, id FROM permissions;

INSERT INTO role_permissions (role_id, permission_id)
SELECT 2, id FROM permissions WHERE slug NOT IN ('users.manage','roles.manage','settings.manage');

-- Default admin user — password: ChangeMe!123
INSERT INTO users (id, role_id, name, email, password, status) VALUES
(1, 1, 'Super Admin', 'admin@techslay.com', '$2y$12$q4MMlZa6/TDqHv0n9acv.OmTpP97T/YFjLS1hWalQqN9/o0OoRfMm', 'active');

-- ---------------------------------------------------------------------
-- Global settings
-- ---------------------------------------------------------------------
INSERT INTO settings (`group`, `key`, `value`, type) VALUES
('general', 'maintenance_mode', 'false', 'boolean'),
('general', 'coming_soon_mode', 'false', 'boolean'),
('general', 'maintenance_message', 'We are currently performing scheduled maintenance. Please check back soon.', 'textarea'),
('general', 'custom_css', '', 'textarea'),
('general', 'custom_js', '', 'textarea'),
('branding', 'site_name', 'Techslay', 'text'),
('branding', 'tagline', 'Performance Affiliate Network', 'text'),
('branding', 'logo', '', 'image'),
('branding', 'favicon', '', 'image'),
('theme', 'primary_color', '#7C3AED', 'color'),
('theme', 'accent_color', '#2563EB', 'color'),
('business', 'company_name', 'Techslay Media Pvt Ltd', 'text'),
('business', 'email', 'hello@techslay.com', 'text'),
('business', 'phone', '+91 00000 00000', 'text'),
('business', 'address', 'Mumbai, India', 'text'),
('social', 'linkedin_url', '', 'text'),
('social', 'twitter_url', '', 'text'),
('social', 'instagram_url', '', 'text'),
('analytics', 'google_analytics_id', '', 'text'),
('analytics', 'gtm_id', '', 'text'),
('analytics', 'meta_pixel_id', '', 'text'),
('analytics', 'clarity_id', '', 'text'),
('smtp', 'host', '', 'text'),
('smtp', 'port', '587', 'text'),
('smtp', 'username', '', 'text'),
('smtp', 'password', '', 'text'),
('smtp', 'from_email', 'no-reply@techslay.com', 'text'),
('recaptcha', 'site_key', '', 'text'),
('recaptcha', 'secret_key', '', 'text'),
('seo', 'default_meta_description', 'Techslay is a performance affiliate network connecting advertisers and publishers across CPS, CPL and CPI campaigns.', 'textarea'),
('seo', 'robots_txt', '', 'textarea'),
('cookie_banner', 'enabled', 'true', 'boolean'),
('cookie_banner', 'message', 'We use cookies to run this site and understand how it is used. See our Cookie Policy for details.', 'textarea'),
('cookie_banner', 'accept_text', 'Accept', 'text'),
('cookie_banner', 'learn_more_text', 'Cookie Policy', 'text');

-- ---------------------------------------------------------------------
-- Menus
-- ---------------------------------------------------------------------
INSERT INTO menus (id, name, slug, location) VALUES
(1, 'Header Menu', 'header-menu', 'header'),
(2, 'Footer Menu', 'footer-menu', 'footer');

INSERT INTO menu_items (menu_id, label, url, sort_order) VALUES
(1, 'Home', '/', 1),
(1, 'About', '/about', 2),
(1, 'Services', '/services', 3),
(1, 'Publishers', '/publishers', 4),
(1, 'Advertisers', '/advertisers', 5),
(1, 'Technology', '/technology', 6),
(1, 'Case Studies', '/case-studies', 7),
(1, 'Blog', '/blog', 8),
(1, 'Contact', '/contact', 9);

-- ---------------------------------------------------------------------
-- Home page (built entirely from page_sections so nothing is hardcoded)
-- ---------------------------------------------------------------------
INSERT INTO pages (id, title, slug, template, is_system, status, published_at) VALUES
(1, 'Home', 'home', 'home', 1, 'published', NOW());

INSERT INTO page_sections (page_id, component_type, content, sort_order, status) VALUES
(1, 'hero', JSON_OBJECT(
    'eyebrow', 'Performance Affiliate Network',
    'title', 'Scale Advertisers. Reward Publishers.',
    'subtitle', 'CPS, CPL and CPI campaigns built on transparent tracking, fraud-free traffic and real-time reporting.',
    'primary_button_text', 'Become an Advertiser',
    'primary_button_url', '/advertisers',
    'secondary_button_text', 'Become a Publisher',
    'secondary_button_url', '/publishers'
), 1, 'published'),
(1, 'trusted_by', JSON_OBJECT(
    'title', 'Trusted By Growing Brands',
    'logos', JSON_ARRAY('Brand One', 'Brand Two', 'Brand Three', 'Brand Four', 'Brand Five', 'Brand Six')
), 2, 'published'),
(1, 'statistics', JSON_OBJECT('title', 'Our Numbers'), 3, 'published'),
(1, 'services_grid', JSON_OBJECT('title', 'Our Services', 'subtitle', 'End-to-end performance marketing infrastructure'), 4, 'published'),
(1, 'campaign_types', JSON_OBJECT(
    'title', 'Campaign Types',
    'items', JSON_ARRAY(
        JSON_OBJECT('code', 'CPS', 'name', 'Cost Per Sale', 'description', 'Pay only when a tracked sale is completed. Ideal for ecommerce and retail partners.'),
        JSON_OBJECT('code', 'CPL', 'name', 'Cost Per Lead', 'description', 'Pay for qualified leads such as sign-ups, applications and demo requests.'),
        JSON_OBJECT('code', 'CPI', 'name', 'Cost Per Install', 'description', 'Pay for verified app installs with fraud-checked attribution.')
    )
), 5, 'published'),
(1, 'why_choose_us', JSON_OBJECT(
    'title', 'Why Choose Techslay',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'shield-check', 'title', 'Fraud-Free Traffic', 'description', 'Real-time fraud detection protects every campaign budget.'),
        JSON_OBJECT('icon', 'chart-bar', 'title', 'Transparent Reporting', 'description', 'Live dashboards with full sub-ID and source-level visibility.'),
        JSON_OBJECT('icon', 'bolt', 'title', 'Fast Payouts', 'description', 'Reliable, on-time publisher payments every cycle.'),
        JSON_OBJECT('icon', 'puzzle-piece', 'title', 'Easy Integration', 'description', 'Plug-and-play tracking with all major platforms.')
    )
), 6, 'published'),
(1, 'how_it_works', JSON_OBJECT(
    'title', 'How It Works',
    'items', JSON_ARRAY(
        JSON_OBJECT('step', '01', 'title', 'Apply', 'description', 'Advertisers and publishers submit an application for review.'),
        JSON_OBJECT('step', '02', 'title', 'Integrate', 'description', 'We set up tracking, postbacks and creatives for your campaign.'),
        JSON_OBJECT('step', '03', 'title', 'Launch', 'description', 'Campaigns go live across our vetted publisher network.'),
        JSON_OBJECT('step', '04', 'title', 'Scale', 'description', 'Optimize and scale based on real-time performance data.')
    )
), 7, 'published'),
(1, 'publisher_benefits', JSON_OBJECT(
    'title', 'Publisher Benefits',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'sparkles', 'title', 'High-Converting Offers', 'description', 'Access exclusive CPS, CPL and CPI offers across 11+ industries.'),
        JSON_OBJECT('icon', 'currency-dollar', 'title', 'Reliable Payouts', 'description', 'Get paid on time, every time, with flexible payout options.'),
        JSON_OBJECT('icon', 'users', 'title', 'Dedicated Support', 'description', 'A dedicated account manager to help you scale faster.')
    )
), 8, 'published'),
(1, 'advertiser_benefits', JSON_OBJECT(
    'title', 'Advertiser Benefits',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'currency-dollar', 'title', 'Pay For Performance', 'description', 'Only pay for verified sales, leads or installs — never impressions.'),
        JSON_OBJECT('icon', 'users', 'title', 'Vetted Publisher Network', 'description', 'Reach thousands of quality-checked publishers instantly.'),
        JSON_OBJECT('icon', 'trending-up', 'title', 'Real-Time Optimization', 'description', 'Adjust budgets and targeting based on live campaign data.')
    )
), 9, 'published'),
(1, 'industries', JSON_OBJECT('title', 'Industries We Serve'), 10, 'published'),
(1, 'technology', JSON_OBJECT(
    'title', 'Our Technology',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'clock', 'title', 'Real-Time Tracking', 'description', 'Millisecond-accurate click and conversion tracking.'),
        JSON_OBJECT('icon', 'shield-check', 'title', 'Fraud Detection Engine', 'description', 'Machine-assisted anomaly detection across every source.'),
        JSON_OBJECT('icon', 'cog', 'title', 'Open API', 'description', 'Full REST API access for custom integrations and reporting.')
    )
), 11, 'published'),
(1, 'process', JSON_OBJECT(
    'title', 'Our Process',
    'items', JSON_ARRAY('Discovery', 'Strategy', 'Integration', 'Optimization', 'Scaling')
), 12, 'published'),
(1, 'testimonials', JSON_OBJECT('title', 'What Our Partners Say'), 13, 'published'),
(1, 'latest_blogs', JSON_OBJECT('title', 'From The Blog'), 14, 'published'),
(1, 'faq', JSON_OBJECT('title', 'Frequently Asked Questions', 'group', 'general'), 15, 'published'),
(1, 'contact_cta', JSON_OBJECT('title', 'Ready to Grow With Techslay?', 'button_text', 'Get In Touch', 'button_url', '/contact'), 16, 'published'),
(1, 'newsletter', JSON_OBJECT('title', 'Stay Updated'), 17, 'published');

INSERT INTO testimonials (name, designation, company, rating, content, sort_order, status) VALUES
('Aarav Mehta', 'Growth Lead', 'ShopEase', 5, 'Techslay helped us scale CPS campaigns profitably within the first month. Reporting transparency is unmatched.', 1, 'published'),
('Priya Nair', 'Affiliate Manager', 'StudyPath', 5, 'The publisher quality and fraud protection gave us confidence to increase our lead-gen budget significantly.', 2, 'published'),
('Rohan Kapoor', 'Top Publisher', 'RK Media', 5, 'Fast, reliable payouts and a dedicated account manager who actually helps us optimize offers.', 3, 'published');

-- ---------------------------------------------------------------------
-- Sample content so the homepage renders with real data out of the box
-- ---------------------------------------------------------------------
INSERT INTO statistics (label, value, suffix, icon, sort_order) VALUES
('Active Advertisers', '350', '+', 'briefcase', 1),
('Verified Publishers', '2,000', '+', 'users', 2),
('Monthly Conversions', '1.2', 'M+', 'trending-up', 3),
('Countries Served', '40', '+', 'globe', 4);

INSERT INTO services (title, slug, icon, short_description, sort_order, status) VALUES
('Affiliate Marketing', 'affiliate-marketing', 'chart-bar', 'Full-funnel affiliate campaign management across CPS, CPL and CPI models.', 1, 'published'),
('Publisher Network', 'publisher-network', 'users', 'Access a vetted network of high-intent traffic publishers.', 2, 'published'),
('Performance Marketing', 'performance-marketing', 'trending-up', 'Pay only for the outcomes that matter to your business.', 3, 'published'),
('Tracking Integration', 'tracking-integration', 'puzzle-piece', 'Seamless postback and S2S integrations with all major platforms.', 4, 'published'),
('Creative Development', 'creative-development', 'sparkles', 'High-converting ad creatives tailored to each campaign.', 5, 'published'),
('Fraud Detection', 'fraud-detection', 'shield-check', 'Real-time traffic quality monitoring to protect your budget.', 6, 'published');

INSERT INTO industries (title, slug, icon, description, sort_order, status) VALUES
('Ecommerce', 'ecommerce', 'shopping-bag', 'Drive qualified purchases with performance-based campaigns.', 1, 'published'),
('Education', 'education', 'academic-cap', 'Generate quality leads for course and program enrollments.', 2, 'published'),
('Travel', 'travel', 'paper-airplane', 'Acquire bookings through high-intent travel publishers.', 3, 'published'),
('Healthcare', 'healthcare', 'heart', 'Compliant lead generation for healthcare providers.', 4, 'published'),
('Subscription Apps', 'subscription-apps', 'device-phone', 'Scale installs and trials with CPI-driven campaigns.', 5, 'published'),
('Food Delivery', 'food-delivery', 'truck', 'Boost app installs and first orders at scale.', 6, 'published'),
('SaaS', 'saas', 'tv', 'Grow sign-ups and demo requests through targeted partners.', 7, 'published'),
('Retail', 'retail', 'building-storefront', 'Drive footfall and online sales through affiliate promotions.', 8, 'published'),
('Fashion', 'fashion', 'sparkles', 'Performance campaigns for fashion and apparel brands.', 9, 'published'),
('Beauty', 'beauty', 'heart', 'Acquire customers for beauty and cosmetics brands.', 10, 'published'),
('Electronics', 'electronics', 'device-phone', 'Scale sales for consumer electronics retailers.', 11, 'published');

INSERT INTO faqs (`group`, question, answer, sort_order, status) VALUES
('general', 'What is Techslay?', 'Techslay is a performance affiliate network connecting advertisers and publishers across CPS, CPL and CPI campaign models.', 1, 'published'),
('general', 'How do I become a publisher?', 'Apply through our Publishers page. Our team reviews every application and onboards approved publishers within 48 hours.', 2, 'published'),
('general', 'How do I become an advertiser?', 'Reach out via our Advertisers page or Contact form. We will scope your campaign goals and set up tracking within days.', 3, 'published'),
('general', 'What campaign types do you support?', 'We support Cost-Per-Sale (CPS), Cost-Per-Lead (CPL) and Cost-Per-Install (CPI) campaigns across multiple industries.', 4, 'published'),
('general', 'How is fraud prevented?', 'Our proprietary fraud detection system monitors traffic quality in real time, flagging and blocking invalid clicks and conversions.', 5, 'published');
