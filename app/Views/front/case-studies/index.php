<?php

use App\Core\View;

/** @var array $caseStudies */
?>
<section class="py-20 bg-gradient-to-b from-brand-50 via-white to-white">
  <div class="max-w-3xl mx-auto px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900">Case Studies</h1>
    <p class="mt-4 text-slate-600">Real results from advertisers and publishers on the ClickNet network.</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6">
    <?php if ($caseStudies === []): ?>
      <p class="text-center text-slate-400">Case studies will be published here soon.</p>
    <?php else: ?>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($caseStudies as $case): ?>
          <a href="<?= View::url('case-studies/' . $case['slug']) ?>" class="rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-lg transition p-7 block">
            <h3 class="font-semibold text-slate-900"><?= View::e($case['title']) ?></h3>
            <p class="mt-2 text-sm text-slate-500"><?= View::e($case['summary'] ?? '') ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
