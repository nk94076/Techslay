<?php

use App\Core\View;

/** @var array $content */
$items = $content['items'] ?? [];
?>
<?php if ($items !== []): ?>
<section class="py-20 bg-slate-50/60">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 text-center mb-14"><?= View::e($content['title'] ?? '') ?></h2>
    <div class="flex flex-wrap items-center justify-center gap-4">
      <?php foreach ($items as $index => $item): ?>
        <div class="flex items-center gap-4">
          <div class="rounded-full bg-white border border-slate-200 shadow-sm px-6 py-3 text-sm font-semibold text-slate-700">
            <?= View::e($item) ?>
          </div>
          <?php if ($index < count($items) - 1): ?>
            <span class="text-brand-300 text-xl">&rarr;</span>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
