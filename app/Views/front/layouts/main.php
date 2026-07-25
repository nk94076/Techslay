<?php

/** @var string $content */
/** @var array $headerMenu */
/** @var array $footerMenu */

use App\Core\View;
use App\Models\Setting;

$siteName = Setting::get('branding', 'site_name', 'ClickNet');
$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . $siteName : $siteName;
$metaDescription = $metaDescription ?? Setting::get('seo', 'default_meta_description', '');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= View::e($pageTitle) ?></title>
<meta name="description" content="<?= View::e($metaDescription) ?>">
<link rel="canonical" href="<?= View::e(View::url(ltrim($_SERVER['REQUEST_URI'] ?? '/', '/'))) ?>">
<?php View::partial('partials.tailwind-config'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
  .glass { background: rgba(255,255,255,0.6); backdrop-filter: blur(12px); }
  .gradient-text { background: linear-gradient(90deg,#7c3aed,#2563eb); -webkit-background-clip: text; background-clip: text; color: transparent; }
</style>
</head>
<body class="bg-white text-slate-800 antialiased">

<header class="sticky top-0 z-50 glass border-b border-slate-100">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <a href="<?= View::url('/') ?>" class="text-xl font-bold gradient-text"><?= View::e($siteName) ?></a>
    <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
      <?php foreach ($headerMenu ?? [] as $item): ?>
        <a href="<?= View::url(ltrim($item['url'], '/')) ?>" class="hover:text-brand-500 transition"><?= View::e($item['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <a href="<?= View::url('contact') ?>" class="hidden md:inline-flex items-center rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold px-5 py-2.5 shadow-lg shadow-brand-500/20 hover:shadow-brand-500/40 transition">Get Started</a>
  </div>
</header>

<main><?= $content ?></main>

<footer class="bg-slate-950 text-slate-300 mt-24">
  <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">
    <div>
      <div class="text-xl font-bold text-white mb-3"><?= View::e($siteName) ?></div>
      <p class="text-sm text-slate-400"><?= View::e(Setting::get('branding', 'tagline', '')) ?></p>
    </div>
    <div>
      <div class="font-semibold text-white mb-3">Company</div>
      <ul class="space-y-2 text-sm">
        <?php foreach ($footerMenu ?? [] as $item): ?>
          <li><a href="<?= View::url(ltrim($item['url'], '/')) ?>" class="hover:text-white transition"><?= View::e($item['label']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <div class="font-semibold text-white mb-3">Contact</div>
      <ul class="space-y-2 text-sm text-slate-400">
        <li><?= View::e(Setting::get('business', 'email', '')) ?></li>
        <li><?= View::e(Setting::get('business', 'phone', '')) ?></li>
        <li><?= View::e(Setting::get('business', 'address', '')) ?></li>
      </ul>
    </div>
    <div>
      <div class="font-semibold text-white mb-3">Legal</div>
      <ul class="space-y-2 text-sm">
        <li><a href="<?= View::url('privacy-policy') ?>" class="hover:text-white transition">Privacy Policy</a></li>
        <li><a href="<?= View::url('terms') ?>" class="hover:text-white transition">Terms of Service</a></li>
        <li><a href="<?= View::url('cookie-policy') ?>" class="hover:text-white transition">Cookie Policy</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t border-white/10 py-6 text-center text-xs text-slate-500">
    &copy; <?= date('Y') ?> <?= View::e($siteName) ?>. All rights reserved.
  </div>
</footer>

</body>
</html>
