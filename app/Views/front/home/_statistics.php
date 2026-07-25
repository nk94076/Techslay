<?php

use App\Core\Icon;
use App\Core\View;

/** @var array $content */
/** @var array $statistics */
?>
<?php if ($statistics !== []): ?>
<section class="py-16">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <?php foreach ($statistics as $stat): ?>
        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition p-8 text-center">
          <?php if (!empty($stat['icon'])): ?>
            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-4">
              <?= Icon::render($stat['icon'], 'w-5 h-5') ?>
            </div>
          <?php endif; ?>
          <div class="text-3xl md:text-4xl font-extrabold gradient-text">
            <?= View::e($stat['value']) ?><?= View::e($stat['suffix'] ?? '') ?>
          </div>
          <div class="mt-2 text-sm text-slate-500 font-medium"><?= View::e($stat['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
