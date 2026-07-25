-- =====================================================================
-- Phase 3 content: About / Publishers / Advertisers / Technology / Career /
-- Contact / legal pages, built the same way as Home — as `pages` rows with
-- JSON `page_sections`. Run AFTER schema.sql and seed.sql.
-- =====================================================================

INSERT INTO pages (title, slug, template, status, published_at) VALUES
('About', 'about', 'default', 'published', NOW()),
('Publishers', 'publishers', 'default', 'published', NOW()),
('Advertisers', 'advertisers', 'default', 'published', NOW()),
('Technology', 'technology', 'default', 'published', NOW()),
('Career', 'career', 'default', 'published', NOW()),
('Contact', 'contact', 'default', 'published', NOW()),
('Privacy Policy', 'privacy-policy', 'default', 'published', NOW()),
('Terms of Service', 'terms', 'default', 'published', NOW()),
('Cookie Policy', 'cookie-policy', 'default', 'published', NOW()),
('Disclaimer', 'disclaimer', 'default', 'published', NOW());

-- ---------------------------------------------------------------------
-- About
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'About Techslay',
    'align', 'center',
    'body', 'Techslay is a performance affiliate network built for advertisers and publishers who care about measurable results. We run CPS, CPL and CPI campaigns across ecommerce, education, travel, healthcare, subscription apps, food delivery, SaaS, retail, fashion, beauty and electronics — connecting brands with a vetted network of publishers through transparent, fraud-checked tracking.'
), 1, 'published' FROM pages WHERE slug = 'about';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'statistics', JSON_OBJECT('title', 'Techslay by the Numbers'), 2, 'published' FROM pages WHERE slug = 'about';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'why_choose_us', JSON_OBJECT(
    'title', 'What We Stand For',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'shield-check', 'title', 'Transparency First', 'description', 'Full sub-ID and source-level reporting for every partner, always.'),
        JSON_OBJECT('icon', 'chart-bar', 'title', 'Performance Driven', 'description', 'We only succeed when our advertisers and publishers do.'),
        JSON_OBJECT('icon', 'bolt', 'title', 'Built for Speed', 'description', 'Fast onboarding, fast payouts, fast support.'),
        JSON_OBJECT('icon', 'puzzle-piece', 'title', 'Partnership Mindset', 'description', 'Dedicated account teams who know your business.')
    )
), 3, 'published' FROM pages WHERE slug = 'about';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'testimonials', JSON_OBJECT('title', 'What Our Partners Say'), 4, 'published' FROM pages WHERE slug = 'about';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_cta', JSON_OBJECT('title', 'Want to Work With Us?', 'button_text', 'Get In Touch', 'button_url', '/contact'), 5, 'published' FROM pages WHERE slug = 'about';

-- ---------------------------------------------------------------------
-- Publishers
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'hero', JSON_OBJECT(
    'eyebrow', 'For Publishers',
    'title', 'Monetize Your Traffic With High-Converting Offers',
    'subtitle', 'Access exclusive CPS, CPL and CPI campaigns across 11+ industries, with reliable payouts and a dedicated account manager.',
    'primary_button_text', 'Apply as a Publisher',
    'primary_button_url', '/contact',
    'secondary_button_text', 'See Our Services',
    'secondary_button_url', '/services'
), 1, 'published' FROM pages WHERE slug = 'publishers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'publisher_benefits', JSON_OBJECT(
    'title', 'Why Publish With Techslay',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'sparkles', 'title', 'High-Converting Offers', 'description', 'Access exclusive CPS, CPL and CPI offers across 11+ industries.'),
        JSON_OBJECT('icon', 'currency-dollar', 'title', 'Reliable Payouts', 'description', 'Get paid on time, every time, with flexible payout options.'),
        JSON_OBJECT('icon', 'users', 'title', 'Dedicated Support', 'description', 'A dedicated account manager to help you scale faster.'),
        JSON_OBJECT('icon', 'chart-bar', 'title', 'Real-Time Reporting', 'description', 'Track clicks, conversions and earnings live from your dashboard.')
    )
), 2, 'published' FROM pages WHERE slug = 'publishers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'how_it_works', JSON_OBJECT(
    'title', 'Getting Started is Easy',
    'items', JSON_ARRAY(
        JSON_OBJECT('step', '01', 'title', 'Apply', 'description', 'Submit your publisher application for review.'),
        JSON_OBJECT('step', '02', 'title', 'Get Approved', 'description', 'Our team reviews and approves applications within 48 hours.'),
        JSON_OBJECT('step', '03', 'title', 'Pick Offers', 'description', 'Choose from CPS, CPL and CPI campaigns that fit your traffic.'),
        JSON_OBJECT('step', '04', 'title', 'Get Paid', 'description', 'Track performance live and receive reliable, on-time payouts.')
    )
), 3, 'published' FROM pages WHERE slug = 'publishers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'faq', JSON_OBJECT('title', 'Publisher FAQs', 'group', 'general'), 4, 'published' FROM pages WHERE slug = 'publishers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_cta', JSON_OBJECT('title', 'Ready to Start Earning?', 'button_text', 'Apply Now', 'button_url', '/contact'), 5, 'published' FROM pages WHERE slug = 'publishers';

-- ---------------------------------------------------------------------
-- Advertisers
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'hero', JSON_OBJECT(
    'eyebrow', 'For Advertisers',
    'title', 'Scale Customer Acquisition With Pay-For-Performance Campaigns',
    'subtitle', 'Reach a vetted network of publishers and pay only for verified sales, leads or installs — never impressions.',
    'primary_button_text', 'Start a Campaign',
    'primary_button_url', '/contact',
    'secondary_button_text', 'View Case Studies',
    'secondary_button_url', '/case-studies'
), 1, 'published' FROM pages WHERE slug = 'advertisers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'advertiser_benefits', JSON_OBJECT(
    'title', 'Why Advertise With Techslay',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'currency-dollar', 'title', 'Pay For Performance', 'description', 'Only pay for verified sales, leads or installs — never impressions.'),
        JSON_OBJECT('icon', 'users', 'title', 'Vetted Publisher Network', 'description', 'Reach thousands of quality-checked publishers instantly.'),
        JSON_OBJECT('icon', 'trending-up', 'title', 'Real-Time Optimization', 'description', 'Adjust budgets and targeting based on live campaign data.'),
        JSON_OBJECT('icon', 'shield-check', 'title', 'Fraud-Free Traffic', 'description', 'Every click and conversion is checked by our fraud detection engine.')
    )
), 2, 'published' FROM pages WHERE slug = 'advertisers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'case_studies_grid', JSON_OBJECT('title', 'Results That Speak for Themselves'), 3, 'published' FROM pages WHERE slug = 'advertisers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'industries', JSON_OBJECT('title', 'Industries We Serve'), 4, 'published' FROM pages WHERE slug = 'advertisers';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_cta', JSON_OBJECT('title', 'Ready to Launch a Campaign?', 'button_text', 'Talk to Sales', 'button_url', '/contact'), 5, 'published' FROM pages WHERE slug = 'advertisers';

-- ---------------------------------------------------------------------
-- Technology
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'hero', JSON_OBJECT(
    'eyebrow', 'Technology',
    'title', 'Built on Fast, Transparent Tracking Infrastructure',
    'subtitle', 'Millisecond-accurate attribution, open API access and a fraud detection engine that protects every campaign.',
    'primary_button_text', 'Talk to Our Team',
    'primary_button_url', '/contact',
    'secondary_button_text', 'See Our Services',
    'secondary_button_url', '/services'
), 1, 'published' FROM pages WHERE slug = 'technology';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'technology', JSON_OBJECT(
    'title', 'Platform Capabilities',
    'items', JSON_ARRAY(
        JSON_OBJECT('icon', 'clock', 'title', 'Real-Time Tracking', 'description', 'Millisecond-accurate click and conversion tracking.'),
        JSON_OBJECT('icon', 'shield-check', 'title', 'Fraud Detection Engine', 'description', 'Machine-assisted anomaly detection across every source.'),
        JSON_OBJECT('icon', 'cog', 'title', 'Open API', 'description', 'Full REST API access for custom integrations and reporting.'),
        JSON_OBJECT('icon', 'puzzle-piece', 'title', 'Postback & S2S', 'description', 'Seamless server-to-server integrations with all major platforms.'),
        JSON_OBJECT('icon', 'chart-bar', 'title', 'Custom Dashboards', 'description', 'Purpose-built reporting dashboards for advertisers and publishers.'),
        JSON_OBJECT('icon', 'bolt', 'title', 'Automated Optimization', 'description', 'Rules-based automation that reallocates spend to what converts.')
    )
), 2, 'published' FROM pages WHERE slug = 'technology';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_cta', JSON_OBJECT('title', 'See the Platform in Action', 'button_text', 'Request a Demo', 'button_url', '/contact'), 3, 'published' FROM pages WHERE slug = 'technology';

-- ---------------------------------------------------------------------
-- Career
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Careers at Techslay',
    'align', 'center',
    'body', 'We are a small, fast-moving team building performance marketing infrastructure for advertisers and publishers worldwide. We do not have open roles listed right now, but we are always happy to hear from people who care about clean data, fast execution and honest partnerships. Send your resume and a short note about what you would want to work on to the email below.'
), 1, 'published' FROM pages WHERE slug = 'career';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_cta', JSON_OBJECT('title', 'Interested in Joining Us?', 'button_text', 'Get In Touch', 'button_url', '/contact'), 2, 'published' FROM pages WHERE slug = 'career';

-- ---------------------------------------------------------------------
-- Contact
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Contact Techslay',
    'align', 'center',
    'body', 'Whether you are looking to advertise, publish, or just have a question — our team typically responds within one business day.'
), 1, 'published' FROM pages WHERE slug = 'contact';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'contact_form', JSON_OBJECT('title', 'Send Us a Message'), 2, 'published' FROM pages WHERE slug = 'contact';

-- ---------------------------------------------------------------------
-- Legal pages (template copy — review with counsel before going live)
-- ---------------------------------------------------------------------
INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Privacy Policy',
    'align', 'left',
    'body', 'Last updated: [date]\n\nTechslay ("we", "us") respects your privacy. This policy explains what information we collect through this website, how we use it, and the choices you have.\n\nInformation We Collect: contact details you submit through our forms (name, email, phone, company), and standard technical data (IP address, browser, pages visited) via analytics tools.\n\nHow We Use It: to respond to inquiries, operate advertiser and publisher accounts, improve our website and services, and comply with legal obligations.\n\nSharing: we do not sell personal information. We may share data with service providers who help us operate this website (e.g. hosting, analytics, email delivery) under confidentiality obligations.\n\nYour Choices: you may request access to, correction of, or deletion of your personal data by contacting us.\n\nThis is placeholder policy text. Replace it with counsel-reviewed language specific to your jurisdiction before launch.'
), 1, 'published' FROM pages WHERE slug = 'privacy-policy';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Terms of Service',
    'align', 'left',
    'body', 'Last updated: [date]\n\nBy accessing or using the Techslay website and services, you agree to these Terms of Service.\n\nUse of Service: Techslay operates a performance affiliate network connecting advertisers and publishers under CPS, CPL and CPI commercial models. Access to advertiser or publisher accounts is subject to a separate partner agreement.\n\nAcceptable Use: you agree not to use fraudulent, deceptive or automated means to generate clicks, leads, installs or sales.\n\nIntellectual Property: all content on this website is owned by Techslay or its licensors and may not be reproduced without permission.\n\nLimitation of Liability: this website and its content are provided "as is" without warranties of any kind.\n\nThis is placeholder policy text. Replace it with counsel-reviewed language specific to your jurisdiction before launch.'
), 1, 'published' FROM pages WHERE slug = 'terms';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Cookie Policy',
    'align', 'left',
    'body', 'Last updated: [date]\n\nThis website uses cookies and similar technologies to operate correctly, remember your preferences, and understand how visitors use our site.\n\nEssential Cookies: required for core site functionality such as session management and security (CSRF protection).\n\nAnalytics Cookies: help us understand aggregate visitor behavior, if analytics tools are enabled in site settings.\n\nManaging Cookies: you can control or delete cookies through your browser settings at any time.\n\nThis is placeholder policy text. Replace it with counsel-reviewed language specific to your jurisdiction before launch.'
), 1, 'published' FROM pages WHERE slug = 'cookie-policy';

INSERT INTO page_sections (page_id, component_type, content, sort_order, status)
SELECT id, 'content_block', JSON_OBJECT(
    'title', 'Disclaimer',
    'align', 'left',
    'body', 'The information on this website is provided in good faith for general informational purposes only. Performance figures, statistics and case study results shown on this site reflect specific campaigns and are not a guarantee of future results for any advertiser or publisher. Techslay makes no warranties about the completeness, reliability or accuracy of this information. Any action you take based on the information on this website is strictly at your own risk.\n\nThis is placeholder text. Replace it with counsel-reviewed language specific to your jurisdiction before launch.'
), 1, 'published' FROM pages WHERE slug = 'disclaimer';

-- ---------------------------------------------------------------------
-- Footer menu: add Career + legal links (header menu already seeded in seed.sql)
-- ---------------------------------------------------------------------
INSERT INTO menu_items (menu_id, label, url, sort_order) VALUES
(2, 'Career', '/career', 1),
(2, 'Privacy Policy', '/privacy-policy', 2),
(2, 'Terms of Service', '/terms', 3),
(2, 'Cookie Policy', '/cookie-policy', 4),
(2, 'Disclaimer', '/disclaimer', 5);

-- ---------------------------------------------------------------------
-- Sample case study so /advertisers and /case-studies aren't empty
-- ---------------------------------------------------------------------
INSERT INTO industries (title, slug, description, sort_order, status)
SELECT 'Ecommerce', 'ecommerce', 'Drive qualified purchases with performance-based campaigns.', 1, 'published'
WHERE NOT EXISTS (SELECT 1 FROM industries WHERE slug = 'ecommerce');

INSERT INTO case_studies (industry_id, title, slug, summary, content, metrics, sort_order, status, published_at)
SELECT
    (SELECT id FROM industries WHERE slug = 'ecommerce' LIMIT 1),
    'Scaling a Fashion Retailer''s CPS Program by 160%',
    'fashion-retailer-cps-growth',
    'How a mid-market fashion retailer grew profitable order volume through Techslay''s publisher network.',
    'The brand came to Techslay looking to diversify customer acquisition beyond paid search. Within 90 days of launch, our team onboarded 40+ vetted content and coupon publishers, implemented fraud-checked S2S tracking, and optimized commission tiers weekly based on live conversion data.\n\nThe result was a 160% increase in monthly order volume attributed to the affiliate channel, with a stable blended CPA and a 99.1% clean-traffic rate.',
    JSON_ARRAY(
        JSON_OBJECT('label', 'Order Volume Growth', 'value', '+160%'),
        JSON_OBJECT('label', 'Clean Traffic Rate', 'value', '99.1%'),
        JSON_OBJECT('label', 'Active Publishers', 'value', '40+'),
        JSON_OBJECT('label', 'Time to Launch', 'value', '90 days')
    ),
    1, 'published', NOW()
WHERE NOT EXISTS (SELECT 1 FROM case_studies WHERE slug = 'fashion-retailer-cps-growth');
