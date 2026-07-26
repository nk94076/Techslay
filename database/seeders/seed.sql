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
('typography', 'heading_font', 'sora', 'text'),
('typography', 'body_font', 'inter', 'text'),
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
-- Draft by default: the hero now shows the same top-4 stats in a floating
-- card of its own, so this full showcase further down the page would repeat
-- them a few scrolls later. Kept in place (not deleted) so it can be
-- republished from the admin if the content changes to something distinct.
(1, 'statistics', JSON_OBJECT('title', 'Our Numbers'), 3, 'draft'),
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
(1, 'analytics_chart', JSON_OBJECT(
    'eyebrow', 'Live Reporting',
    'title', 'Real-Time Analytics for Unmatched Control',
    'subtitle', 'Every click, conversion and payout updates live — no waiting on a weekly report to know what is working.',
    'chart_title', 'Lead Quality Trend',
    'chart_subtitle', 'Last 7 days',
    'chart_type', 'bar',
    'data', JSON_ARRAY(
        JSON_OBJECT('label', 'Mon', 'value', 62),
        JSON_OBJECT('label', 'Tue', 'value', 74),
        JSON_OBJECT('label', 'Wed', 'value', 58),
        JSON_OBJECT('label', 'Thu', 'value', 81),
        JSON_OBJECT('label', 'Fri', 'value', 90),
        JSON_OBJECT('label', 'Sat', 'value', 76),
        JSON_OBJECT('label', 'Sun', 'value', 95)
    ),
    'highlights', JSON_ARRAY(
        JSON_OBJECT('icon', 'chart-bar', 'title', 'Sub-ID Level Reporting', 'description', 'See exactly which source, creative and placement is converting.'),
        JSON_OBJECT('icon', 'clock', 'title', 'Millisecond Attribution', 'description', 'Server-to-server tracking updates dashboards in real time.'),
        JSON_OBJECT('icon', 'shield-check', 'title', 'Verified Before Billed', 'description', 'Every conversion is fraud-checked before it counts.')
    )
), 12, 'published'),
(1, 'process', JSON_OBJECT(
    'title', 'Our Process',
    'items', JSON_ARRAY('Discovery', 'Strategy', 'Integration', 'Optimization', 'Scaling')
), 13, 'published'),
(1, 'testimonials', JSON_OBJECT('title', 'What Our Partners Say'), 14, 'published'),
(1, 'latest_blogs', JSON_OBJECT('title', 'From The Blog'), 15, 'published'),
(1, 'faq', JSON_OBJECT('title', 'Frequently Asked Questions', 'group', 'general'), 16, 'published'),
(1, 'contact_cta', JSON_OBJECT('title', 'Ready to Grow With Techslay?', 'button_text', 'Get In Touch', 'button_url', '/contact'), 17, 'published'),
(1, 'newsletter', JSON_OBJECT('title', 'Stay Updated'), 18, 'published');

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

-- Full service page body copy (services.content), written separately from the
-- INSERT above since MySQL escaping for multi-paragraph text is clearer this way.
UPDATE services SET content = 'Affiliate marketing is the engine behind Techslay: a performance-based partnership model where advertisers pay publishers only after a defined result actually happens — a sale, a qualified lead, or an app install. No result, no cost. That single principle is why performance marketing consistently outperforms traditional advertising on measurable ROI, and it''s the model our entire network is built around.

Techslay runs full-funnel affiliate campaign management across three core pricing structures: Cost Per Sale (CPS) for ecommerce and subscription businesses, Cost Per Lead (CPL) for service businesses that need qualified inquiries, and Cost Per Install (CPI) for mobile and SaaS products that need verified installs and activations. Each model is matched to the advertiser''s actual business goal rather than forcing every campaign into a single format.

Behind every campaign sits the infrastructure that makes affiliate marketing trustworthy at scale: server-to-server (S2S) postback tracking, sub-ID level reporting down to the individual publisher and creative, real-time dashboards for both sides of the network, and a fraud detection layer that screens every click and conversion before it''s billed. Advertisers get a finance team''s favorite kind of marketing spend — one that''s directly tied to revenue. Publishers get transparent attribution and payout terms they can actually plan around.

Our account managers work hands-on with advertisers to structure commission tiers, set up tracking, and recruit the right publisher segments for their vertical — from content and coupon sites to social media influencers and email publishers. On the publisher side, we handle offer curation, creative assets, and compliance review so every campaign a publisher promotes is one they can stand behind.

If you''re evaluating an affiliate network for the first time or replacing one that''s stopped delivering, this is the starting point: transparent tracking, fair attribution, and a team that treats your campaign like it''s the only one we run.' WHERE slug = 'affiliate-marketing';
UPDATE services SET content = 'Techslay''s publisher network is built around one filter: quality traffic that converts, not just traffic that clicks. Every publisher who joins goes through a vetting process that checks traffic sources, historical conversion quality, and compliance history before they''re approved to run live campaigns — which is also why our advertisers trust the network''s volume instead of discounting it.

The network spans content publishers, coupon and deal sites, comparison and review platforms, email marketers, social media and influencer publishers, and mobile app networks — giving advertisers reach across the channels their actual customers use, across ecommerce, education, travel, healthcare, subscription apps, food delivery, SaaS, retail, fashion, beauty, and electronics.

For publishers, network access means more than an offer list. Every approved publisher gets a live dashboard with click, conversion, and earnings data down to the sub-ID, deep-linking support so traffic can land on any page of an advertiser''s site (not just a fixed landing page), and creative assets — banners, email swipe copy, product feeds — supplied directly by advertisers rather than scraped together independently. A dedicated account manager helps match publishers to offers that fit their actual audience instead of the highest-paying offer regardless of fit.

Payout reliability is treated as a first-class feature, not an afterthought: publishers are paid on the schedule they''re promised, with transparent statements that reconcile against their own tracking, and support that responds to payment questions the same way it responds to technical ones.

Whether you''re a publisher choosing where to send your next campaign or an advertiser evaluating who''s driving your funnel, the network is the same one either way — vetted, transparent, and built to keep the trust between advertiser and publisher intact.' WHERE slug = 'publisher-network';
UPDATE services SET content = 'Performance marketing means paying for outcomes — sales, leads, installs, verified actions — instead of paying for impressions, clicks, or "reach" that never converts into revenue. Techslay was built specifically around this model because it aligns the incentives of everyone involved: advertisers only spend when they get a result, and publishers only get paid when they deliver one.

For advertisers, this changes the math on marketing spend entirely. Instead of budgeting for a campaign and hoping it performs, a performance marketing budget scales with actual results — spend goes up because sales are coming in, not on a fixed schedule regardless of outcome. Our team helps structure commission rates and payout models around your margins, so growth through the network is growth you can defend to your finance team.

Execution runs on real-time data. Campaigns are monitored continuously through live dashboards that show conversion rates, publisher-level performance, and spend efficiency as they happen — not in a report that arrives a week later. That visibility is what lets advertisers reallocate budget toward what''s working and pause what isn''t, mid-campaign rather than mid-quarter.

Performance marketing through Techslay also means every conversion is verified before it''s billed. Our fraud detection engine checks click patterns, device fingerprints, and conversion timing against known abuse signatures, so "performance" actually means genuine customer actions — not inflated numbers from bad traffic.

Whether you''re launching customer acquisition for the first time or migrating an existing program that''s underperforming, our team builds the campaign structure, tracking, and publisher mix around the specific outcome you''re trying to buy.' WHERE slug = 'performance-marketing';
UPDATE services SET content = 'Every affiliate and performance marketing program lives or dies on tracking accuracy — if a sale, lead, or install can''t be attributed correctly to the publisher who drove it, nothing else about the program matters. Techslay''s tracking integration is built to remove that risk entirely, with server-to-server (S2S) postback tracking as the default rather than an add-on.

S2S tracking means conversion data passes directly between your server and ours, without relying on a customer''s browser to fire a pixel that ad blockers, iOS privacy changes, or slow page loads can silently drop. That server-side handshake is what keeps attribution accurate even as browser-based tracking gets less reliable industry-wide.

Integration is designed to fit into your existing stack rather than force a rebuild: our team supports standard postback URL setups, works with major ecommerce platforms and custom checkout flows, and provides sub-ID passthrough so every conversion can be traced back to the exact publisher, creative, and traffic source that generated it. For mobile advertisers, we integrate with leading mobile measurement partners (MMPs) to track installs and in-app events with the same accuracy.

Once integration is live, both sides of the network get real-time visibility: advertisers see conversions as they''re verified, and publishers see their earnings update the same way, instead of waiting on a manual reconciliation at the end of the month. Our technical team handles the setup process directly rather than leaving it to documentation — most integrations are live within days, not weeks.

Accurate tracking is the foundation everything else in performance marketing is built on. We treat it that way.' WHERE slug = 'tracking-integration';
UPDATE services SET content = 'An offer is only as strong as the creative assets publishers have to promote it. Techslay''s creative development team works directly with advertisers to build the banners, landing pages, email copy, and product feeds that publishers actually use to drive conversions — because a technically perfect tracking setup still needs creative that converts.

We start by reviewing what''s already converting for an advertiser (or, for new advertisers, what''s converting in comparable campaigns across the network) and build creative variations sized and formatted for the channels where your publishers are actually active: display banners in standard IAB sizes, native ad formats for content publishers, email swipe files for email marketers, and product data feeds for comparison and deal sites.

For CPL and CPI campaigns specifically, landing page quality has an outsized effect on conversion rate — so our team can build or optimize dedicated landing pages designed around a single, clear call to action, tested against your existing pages where a baseline exists.

Every creative asset goes through the same compliance review the rest of the network runs on: accurate claims, correct disclosures, and brand guideline adherence, so what a publisher promotes matches what your business actually delivers. That consistency protects advertiser brand reputation and keeps publisher trust intact — both of which compound in a network''s favor over time.

Creative isn''t a one-time deliverable in our process. As campaigns run, we monitor which creative variations are converting best across the network and iterate, so the assets your publishers are using keep improving instead of going stale.' WHERE slug = 'creative-development';
UPDATE services SET content = 'Affiliate fraud — fake leads, bot-driven clicks, cookie stuffing, incentivized traffic disguised as organic — is the single biggest reason advertisers lose trust in performance marketing. Techslay''s fraud detection engine exists to make sure that never happens on campaigns running through our network, by screening every click and conversion before it''s ever billed to an advertiser.

Detection runs on multiple layers simultaneously: click pattern analysis flags abnormal frequency or timing from a single source, device and IP fingerprinting catches repeat abuse from the same actor across different accounts, and conversion timing analysis flags leads or sales that complete implausibly fast to be genuine. Suspicious activity is held and reviewed rather than silently billed and refunded later — advertisers only pay for actions that pass verification in the first place.

This protection runs on both sides of the network. Advertisers get traffic quality guarantees that mean the leads and sales they''re paying for are real, not padded. Publishers running legitimate campaigns benefit too, because a network with a reputation for clean traffic attracts advertisers willing to pay competitive rates and trust the network with larger budgets — bad actors polluting a network''s traffic quality hurt every honest publisher''s earning potential along with it.

Every publisher joining the network goes through an initial vetting review, and traffic quality is monitored continuously afterward, not just at onboarding. Publishers found running fraudulent traffic are removed from the network, which keeps the overall trust level — and the payout rates advertisers are willing to offer — higher for everyone who plays it straight.

If fraud is the reason you''ve soured on affiliate marketing before, this is the part of our infrastructure built specifically to fix that.' WHERE slug = 'fraud-detection';

-- Structured content for the rich service-detail template: stats bar, "What's
-- Included" highlight grid, and "How It Works" process steps per service.
UPDATE services SET
  stats = '[{"value":"3","label":"Pricing Models — CPS, CPL, CPI"},{"value":"100%","label":"Attribution via S2S Tracking"},{"value":"24/7","label":"Campaign Monitoring"}]',
  highlights = '[{"icon":"chart-bar","title":"Full-Funnel Campaign Management","description":"From launch to payout, every campaign is managed end to end rather than handed off after setup."},{"icon":"users","title":"Publisher Recruitment and Curation","description":"We match campaigns to publisher segments that fit the vertical, not just whoever is available."},{"icon":"puzzle-piece","title":"S2S Tracking Setup","description":"Server-to-server postbacks are configured as the default, so attribution holds up regardless of browser or device."},{"icon":"shield-check","title":"Fraud Screening on Every Conversion","description":"Every click and conversion is checked before it is billed, not after."}]',
  process_steps = '[{"title":"Define Your Goal","description":"We start by matching your business goal to the right pricing model — CPS, CPL or CPI."},{"title":"We Set Up Tracking","description":"S2S postback tracking is configured and tested before any traffic goes live."},{"title":"Publishers Go Live","description":"Matched publishers start sending traffic under agreed commission terms."},{"title":"You Pay for Results","description":"Billing only happens on verified conversions that pass fraud screening."}]'
WHERE slug = 'affiliate-marketing';

UPDATE services SET
  stats = '[{"value":"6+","label":"Publisher Categories"},{"value":"11","label":"Industries Covered"},{"value":"Sub-ID","label":"Level Reporting"}]',
  highlights = '[{"icon":"users","title":"Vetted Publisher Access","description":"Every publisher is reviewed for traffic quality and compliance before going live."},{"icon":"link","title":"Deep-Linking Support","description":"Traffic can land on any page of your site, not just a fixed landing page."},{"icon":"photo","title":"Ready-Made Creative Assets","description":"Banners, email swipe copy and product feeds are supplied directly by advertisers."},{"icon":"currency-dollar","title":"Reliable Payout Schedule","description":"Publishers are paid on the schedule they are promised, with statements that reconcile against their own tracking."}]',
  process_steps = '[{"title":"Apply to the Network","description":"Publishers submit their traffic sources and channels for review."},{"title":"Get Vetted and Approved","description":"We check traffic quality, conversion history and compliance before approval."},{"title":"Pick Offers That Fit","description":"An account manager helps match offers to the publisher’s actual audience."},{"title":"Track Earnings in Real Time","description":"Clicks, conversions and payouts are visible on a live dashboard."}]'
WHERE slug = 'publisher-network';

UPDATE services SET
  stats = '[{"value":"$0","label":"Spend Without a Result"},{"value":"Live","label":"Dashboard Reporting"},{"value":"100%","label":"Verified Before Billing"}]',
  highlights = '[{"icon":"trending-up","title":"Outcome-Based Spend","description":"Budget scales with results instead of running on a fixed schedule regardless of performance."},{"icon":"chart-bar","title":"Real-Time Performance Dashboards","description":"Conversion rates and spend efficiency are visible as they happen."},{"icon":"cog","title":"Commission Structuring by Margin","description":"Payout tiers are built around your margins, not a generic rate card."},{"icon":"shield-check","title":"Fraud-Screened Conversions","description":"Every result billed has already passed fraud verification."}]',
  process_steps = '[{"title":"Set Your Target Outcome","description":"We define what a qualifying sale, lead or install actually looks like for your business."},{"title":"We Structure Commission and Tracking","description":"Payout rates and attribution are configured around your margins."},{"title":"Campaign Goes Live","description":"The campaign runs across matched publishers in the network."},{"title":"Reallocate Using Live Data","description":"Budget shifts toward what is working using real-time dashboards, not a delayed report."}]'
WHERE slug = 'performance-marketing';

UPDATE services SET
  stats = '[{"value":"S2S","label":"Server-to-Server Default"},{"value":"Days","label":"Not Weeks, to Go Live"},{"value":"Sub-ID","label":"Full Attribution Chain"}]',
  highlights = '[{"icon":"puzzle-piece","title":"Postback URL Setup","description":"Standard postback configuration that fits into your existing stack."},{"icon":"link","title":"Sub-ID Passthrough","description":"Every conversion traces back to the exact publisher, creative and source."},{"icon":"device-phone","title":"MMP Integration for Mobile","description":"Installs and in-app events are tracked through leading mobile measurement partners."},{"icon":"clock","title":"Real-Time Conversion Sync","description":"Both sides of the network see conversions as they are verified, not at month-end."}]',
  process_steps = '[{"title":"Share Your Stack","description":"Tell us how checkout, leads or installs are currently tracked."},{"title":"We Configure Postbacks","description":"S2S postback URLs are set up against your existing platform."},{"title":"Test and Validate","description":"Attribution is tested end to end before any live traffic depends on it."},{"title":"Go Live With Real-Time Sync","description":"Conversions flow in as they happen, on both the advertiser and publisher side."}]'
WHERE slug = 'tracking-integration';

UPDATE services SET
  stats = '[{"value":"IAB","label":"Standard Ad Sizes"},{"value":"100%","label":"Compliance Reviewed"},{"value":"Ongoing","label":"Creative Iteration"}]',
  highlights = '[{"icon":"photo","title":"Banners and Display Creative","description":"Sized and formatted for the channels your publishers actually use."},{"icon":"pencil-square","title":"Landing Page Builds","description":"Dedicated pages built around a single, clear call to action."},{"icon":"envelope","title":"Email Swipe Copy","description":"Ready-to-send copy for email publishers."},{"icon":"document","title":"Product Feed Formatting","description":"Structured feeds for comparison and deal sites."}]',
  process_steps = '[{"title":"Audit What is Converting","description":"We review existing performance before building anything new."},{"title":"Build Channel-Specific Creative","description":"Assets are built for the exact formats each publisher type uses."},{"title":"Compliance and Brand Review","description":"Every asset is checked against claims, disclosures and brand guidelines."},{"title":"Monitor and Iterate","description":"Creative that stops converting gets replaced, not left running on autopilot."}]'
WHERE slug = 'creative-development';

UPDATE services SET
  stats = '[{"value":"3","label":"Detection Layers"},{"value":"Pre-Bill","label":"Screening, Not Refunds"},{"value":"24/7","label":"Continuous Monitoring"}]',
  highlights = '[{"icon":"magnifying-glass","title":"Click Pattern Analysis","description":"Abnormal frequency or timing from a single source is flagged automatically."},{"icon":"device-phone","title":"Device and IP Fingerprinting","description":"Repeat abuse from the same actor is caught across different accounts."},{"icon":"clock","title":"Conversion Timing Checks","description":"Leads or sales that complete implausibly fast are flagged for review."},{"icon":"shield-check","title":"Ongoing Publisher Vetting","description":"Traffic quality is monitored continuously, not just at onboarding."}]',
  process_steps = '[{"title":"Every Click is Logged","description":"Click and conversion data is captured with device and timing signals."},{"title":"Signals Are Cross-Checked","description":"Patterns are compared against known abuse signatures."},{"title":"Suspicious Activity is Held","description":"Flagged conversions are reviewed before they are ever billed."},{"title":"Only Verified Actions Are Billed","description":"Advertisers pay for conversions that have passed every check."}]'
WHERE slug = 'fraud-detection';

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

-- Sample blog content so the blog listing/post templates have real content
-- to render instead of the "no articles published yet" empty state.
INSERT INTO blog_categories (name, slug, description) VALUES
('Playbooks', 'playbooks', 'Practical guides for running better performance marketing campaigns.'),
('Network Updates', 'network-updates', 'What is new across the Techslay publisher and advertiser network.');

INSERT INTO authors (name, slug, bio, job_title, linkedin_url) VALUES
('Alex Rivera', 'alex-rivera', 'Alex leads partnership strategy at Techslay, working directly with advertisers and publishers to structure campaigns that scale.', 'Head of Partnerships', 'https://www.linkedin.com/');

INSERT INTO blog_posts (category_id, author_id, title, slug, excerpt, featured_image, content, table_of_contents, reading_time_minutes, status, published_at) VALUES
(
  (SELECT id FROM blog_categories WHERE slug = 'playbooks'),
  (SELECT id FROM authors WHERE slug = 'alex-rivera'),
  'How to Choose Between CPS, CPL and CPI for Your Next Campaign',
  'choosing-cps-cpl-cpi',
  'CPS, CPL and CPI all pay for a result, not a click — but picking the wrong one for your funnel can quietly cap your growth. Here is how to choose.',
  NULL,
  '<p>Every performance marketing campaign starts with the same decision: what counts as a result worth paying for? Get this wrong and even a well-run campaign underperforms, not because the traffic was bad, but because the pricing model never matched the business it was funding.</p>
<h2 id="understanding-the-three-models">Understanding the Three Models</h2>
<p>Cost Per Sale (CPS) pays a commission on completed purchases, which makes it the default choice for ecommerce and subscription businesses where revenue is the metric that matters. Cost Per Lead (CPL) pays for a qualified inquiry — a form fill, a demo request — and fits service businesses where the sale itself happens off-platform, often through a sales team. Cost Per Install (CPI) pays for a verified app install or activation, built for mobile and SaaS products where the install is the meaningful first step toward retention.</p>
<h2 id="matching-the-model-to-your-funnel">Matching the Model to Your Funnel</h2>
<p>The right model depends on where your funnel actually converts. If a publisher''s traffic can drive a purchase directly, CPS keeps incentives aligned all the way to revenue. If your sales cycle involves a call or a demo, CPL lets you pay for the handoff point you can actually control. If your product lives in an app store, CPI is the only model that reflects the action that matters.</p>
<p>Some advertisers run more than one model at once — CPL for top-of-funnel lead generation and CPS for a retargeted second touch, for example. There is no rule against mixing models as long as each publisher understands which one applies to their traffic.</p>
<h2 id="common-mistakes-to-avoid">Common Mistakes to Avoid</h2>
<p>The most common mistake is picking a model based on what competitors use rather than what your own funnel supports. The second is setting a commission rate without first mapping it against actual margin — a CPS rate that looks generous on paper can quietly erase margin on lower-ticket items. The third is switching models mid-campaign without re-testing publisher performance, since a publisher optimized for CPL traffic will not automatically perform the same way once the goalpost moves to CPS.</p>
<p>Start with the funnel, not the format. The model should describe how your business already converts customers — not force a new definition of success onto publishers who are already sending you results.</p>',
  '[{"anchor":"understanding-the-three-models","label":"Understanding the Three Models"},{"anchor":"matching-the-model-to-your-funnel","label":"Matching the Model to Your Funnel"},{"anchor":"common-mistakes-to-avoid","label":"Common Mistakes to Avoid"}]',
  6,
  'published',
  NOW()
),
(
  (SELECT id FROM blog_categories WHERE slug = 'playbooks'),
  (SELECT id FROM authors WHERE slug = 'alex-rivera'),
  '5 Signs Your Affiliate Tracking Has a Fraud Problem',
  'signs-of-affiliate-fraud',
  'Fraud rarely announces itself. These are the patterns that usually show up first — before the fraud shows up in your billing.',
  NULL,
  '<p>Affiliate fraud is easiest to catch before it is billed, which means the earliest signals usually show up in data patterns rather than in an obvious spike in complaints. Here are the five patterns worth checking first.</p>
<h2 id="conversion-timing-looks-too-good">Conversion Timing Looks Too Good</h2>
<p>A genuine customer journey — click, browse, decide, convert — takes time. Conversions that complete in a handful of seconds, especially at scale from a single source, are a strong signal of automated or scripted activity rather than a real buying decision.</p>
<h2 id="traffic-spikes-from-a-single-source">Traffic Spikes From a Single Source</h2>
<p>A sudden, disproportionate spike in clicks or conversions from one publisher — particularly one with no matching increase in ad spend or promotional activity to explain it — deserves a manual review before it gets billed, not after.</p>
<h2 id="suspiciously-high-click-to-conversion-consistency">Suspiciously High Click-to-Conversion Consistency</h2>
<p>Real traffic has noise: conversion rates vary by day, device, and audience segment. A publisher whose conversion rate stays implausibly consistent across every batch of traffic is more likely running a script than genuinely engaged users.</p>
<p>None of these signals alone proves fraud — but together, they are exactly what a fraud detection layer should be screening for before a single click or conversion is ever billed to an advertiser.</p>',
  '[{"anchor":"conversion-timing-looks-too-good","label":"Conversion Timing Looks Too Good"},{"anchor":"traffic-spikes-from-a-single-source","label":"Traffic Spikes From a Single Source"},{"anchor":"suspiciously-high-click-to-conversion-consistency","label":"Suspiciously High Click-to-Conversion Consistency"}]',
  4,
  'published',
  NOW()
),
(
  (SELECT id FROM blog_categories WHERE slug = 'network-updates'),
  (SELECT id FROM authors WHERE slug = 'alex-rivera'),
  'Techslay Publisher Network Now Covers 40+ Countries',
  'network-expansion-40-countries',
  'Our publisher network has expanded its geographic coverage, giving advertisers broader reach without adding a single new vendor relationship.',
  NULL,
  '<p>Advertisers running international campaigns have historically needed to manage multiple regional networks to get real coverage. That is no longer necessary on Techslay.</p>
<h2 id="whats-new">What''s New</h2>
<p>The publisher network now spans more than 40 countries across North America, Europe, and Asia-Pacific, with vetted publishers active in ecommerce, SaaS, and mobile app verticals in each region.</p>
<h2 id="why-this-matters-for-advertisers">Why This Matters for Advertisers</h2>
<p>Advertisers expanding into new markets can now launch campaigns against the same tracking infrastructure and account management relationship they already use — no new integration, no new vendor onboarding, and no loss of visibility into cross-market performance.</p>',
  '[{"anchor":"whats-new","label":"What''s New"},{"anchor":"why-this-matters-for-advertisers","label":"Why This Matters for Advertisers"}]',
  3,
  'published',
  NOW()
);

INSERT INTO blog_tags (name, slug) VALUES
('CPS', 'cps'), ('CPL', 'cpl'), ('CPI', 'cpi'), ('Campaign Strategy', 'campaign-strategy'),
('Fraud Detection', 'fraud-detection-tag'), ('Tracking', 'tracking'),
('Network Updates', 'network-updates-tag'), ('Publishers', 'publishers-tag');

INSERT INTO blog_post_tag (blog_post_id, blog_tag_id)
SELECT p.id, t.id FROM blog_posts p, blog_tags t
WHERE p.slug = 'choosing-cps-cpl-cpi' AND t.slug IN ('cps','cpl','cpi','campaign-strategy');

INSERT INTO blog_post_tag (blog_post_id, blog_tag_id)
SELECT p.id, t.id FROM blog_posts p, blog_tags t
WHERE p.slug = 'signs-of-affiliate-fraud' AND t.slug IN ('fraud-detection-tag','tracking');

INSERT INTO blog_post_tag (blog_post_id, blog_tag_id)
SELECT p.id, t.id FROM blog_posts p, blog_tags t
WHERE p.slug = 'network-expansion-40-countries' AND t.slug IN ('network-updates-tag','publishers-tag');

INSERT INTO blog_related_posts (blog_post_id, related_post_id)
SELECT a.id, b.id FROM blog_posts a, blog_posts b
WHERE a.slug = 'choosing-cps-cpl-cpi' AND b.slug = 'signs-of-affiliate-fraud';

INSERT INTO blog_related_posts (blog_post_id, related_post_id)
SELECT a.id, b.id FROM blog_posts a, blog_posts b
WHERE a.slug = 'signs-of-affiliate-fraud' AND b.slug = 'choosing-cps-cpl-cpi';
