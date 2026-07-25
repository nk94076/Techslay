<?php

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
        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6">
          <h3 class="font-semibold text-slate-900"><?= View::e($item['title'] ?? '') ?></h3>
          <p class="mt-1 text-sm text-slate-500"><?= View::e($item['description'] ?? '') ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
