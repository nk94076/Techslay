<?php

use App\Core\Icon;
use App\Core\View;

/** @var array $content */
$items = $content['items'] ?? [];
?>
<?php if ($items !== []): ?>
<section class="py-20 bg-slate-50/60">
  <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
    <div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900"><?= View::e($content['title'] ?? '') ?></h2>
      <a href="<?= View::url('publishers') ?>" class="mt-6 inline-flex items-center rounded-full bg-slate-900 text-white text-sm font-semibold px-6 py-3 hover:bg-slate-800 transition">Become a Publisher</a>
    </div>
    <div class="space-y-4">
      <?php foreach ($items as $item): ?>
        <div class="group rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-brand-200 transition-all duration-200 p-6 flex items-start gap-4">
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
  </div>
</section>
<?php endif; ?>
