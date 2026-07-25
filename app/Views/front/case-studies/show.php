<?php

use App\Core\View;

/** @var array $case */
/** @var array $metrics */
?>
<section class="py-20 bg-gradient-to-b from-brand-50 via-white to-white">
  <div class="max-w-3xl mx-auto px-6 text-center">
    <span class="inline-block rounded-full bg-white/80 border border-brand-100 px-4 py-1.5 text-xs font-semibold text-brand-600 shadow-sm mb-6">Case Study</span>
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900"><?= View::e($case['title']) ?></h1>
    <p class="mt-4 text-slate-600"><?= View::e($case['summary'] ?? '') ?></p>
  </div>
</section>

<?php if ($metrics !== []): ?>
<section class="py-10">
  <div class="max-w-4xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6">
    <?php foreach ($metrics as $metric): ?>
      <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6 text-center">
        <div class="text-2xl font-extrabold gradient-text"><?= View::e($metric['value'] ?? '') ?></div>
        <div class="mt-1 text-xs text-slate-500"><?= View::e($metric['label'] ?? '') ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section class="py-16">
  <div class="max-w-3xl mx-auto px-6">
    <?php if (!empty($case['content'])): ?>
      <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed whitespace-pre-line">
        <?= nl2br(View::e($case['content'])) ?>
      </div>
    <?php endif; ?>
    <a href="<?= View::url('contact') ?>" class="mt-10 inline-flex items-center rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white font-semibold px-8 py-3.5 shadow-lg shadow-brand-500/30 hover:shadow-xl transition">
      Get Similar Results
    </a>
  </div>
</section>
