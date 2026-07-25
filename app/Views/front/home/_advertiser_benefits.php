<?php

use App\Core\Icon;
use App\Core\View;

/** @var array $content */
$items = $content['items'] ?? [];
?>
<?php if ($items !== []): ?>
<section class="py-20">
  <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
    <div class="order-2 lg:order-1 space-y-4">
      <?php foreach ($items as $item): ?>
        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6 flex items-start gap-4">
          <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0">
            <?= Icon::render($item['icon'] ?? null, 'w-5 h-5') ?>
          </div>
          <div>
            <h3 class="font-semibold text-slate-900"><?= View::e($item['title'] ?? '') ?></h3>
            <p class="mt-1 text-sm text-slate-500"><?= View::e($item['description'] ?? '') ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="order-1 lg:order-2">
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900"><?= View::e($content['title'] ?? '') ?></h2>
      <a href="<?= View::url('advertisers') ?>" class="mt-6 inline-flex items-center rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold px-6 py-3 shadow-lg shadow-brand-500/30 hover:shadow-xl transition">Become an Advertiser</a>
    </div>
  </div>
</section>
<?php endif; ?>
