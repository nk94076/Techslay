<?php

use App\Core\View;

/** @var array $service */
/** @var array $otherServices */
?>
<section class="py-20 bg-gradient-to-b from-brand-50 via-white to-white">
  <div class="max-w-3xl mx-auto px-6 text-center">
    <span class="inline-block rounded-full bg-white/80 border border-brand-100 px-4 py-1.5 text-xs font-semibold text-brand-600 shadow-sm mb-6">Service</span>
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900"><?= View::e($service['title']) ?></h1>
    <p class="mt-4 text-slate-600"><?= View::e($service['short_description']) ?></p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-3xl mx-auto px-6">
    <?php if (!empty($service['content'])): ?>
      <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed whitespace-pre-line">
        <?= nl2br(View::e($service['content'])) ?>
      </div>
    <?php endif; ?>
    <a href="<?= View::url('contact') ?>" class="mt-10 inline-flex items-center rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white font-semibold px-8 py-3.5 shadow-lg shadow-brand-500/30 hover:shadow-xl transition">
      Talk to Us About This Service
    </a>
  </div>
</section>

<?php if ($otherServices !== []): ?>
<section class="py-16 bg-slate-50/60">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-2xl font-bold text-slate-900 mb-8 text-center">Other Services</h2>
    <div class="grid sm:grid-cols-3 gap-6">
      <?php foreach ($otherServices as $other): ?>
        <a href="<?= View::url('services/' . $other['slug']) ?>" class="rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-lg transition p-6">
          <h3 class="font-semibold text-slate-900"><?= View::e($other['title']) ?></h3>
          <p class="mt-2 text-sm text-slate-500"><?= View::e($other['short_description']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
