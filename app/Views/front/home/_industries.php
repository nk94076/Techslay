<?php

use App\Core\Icon;
use App\Core\View;

/** @var array $content */
/** @var array $industries */
?>
<?php if ($industries !== []): ?>
<section class="py-20 bg-slate-50/60">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 text-center mb-14"><?= View::e($content['title'] ?? '') ?></h2>
    <div class="flex flex-wrap justify-center gap-3">
      <?php foreach ($industries as $industry): ?>
        <span class="inline-flex items-center gap-2 rounded-full bg-white border border-slate-200 text-slate-700 text-sm font-medium pl-3 pr-5 py-2 shadow-sm hover:border-brand-300 hover:text-brand-600 transition">
          <span class="text-brand-500"><?= Icon::render($industry['icon'] ?? null, 'w-4 h-4') ?></span>
          <?= View::e($industry['title']) ?>
        </span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
