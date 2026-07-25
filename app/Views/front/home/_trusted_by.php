<?php

use App\Core\View;

/** @var array $content */
$logos = $content['logos'] ?? [];
?>
<?php if ($logos !== []): ?>
<section class="py-12 border-y border-slate-100 bg-slate-50/50">
  <div class="max-w-6xl mx-auto px-6">
    <p class="text-center text-xs font-semibold tracking-widest text-slate-400 uppercase mb-8">
      <?= View::e($content['title'] ?? '') ?>
    </p>
    <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-70">
      <?php foreach ($logos as $logo): ?>
        <span class="text-slate-400 font-bold text-lg tracking-tight"><?= View::e($logo) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
