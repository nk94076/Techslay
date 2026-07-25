<?php

use App\Core\View;

/** @var array $content */
?>
<section class="relative overflow-hidden bg-gradient-to-b from-brand-50 via-white to-white">
  <div class="absolute -top-40 -right-40 w-[36rem] h-[36rem] bg-gradient-to-br from-brand-300 to-accent-500 opacity-20 blur-3xl rounded-full"></div>
  <div class="absolute -bottom-40 -left-40 w-[30rem] h-[30rem] bg-gradient-to-tr from-accent-500 to-brand-400 opacity-10 blur-3xl rounded-full"></div>

  <div class="relative max-w-5xl mx-auto px-6 pt-24 pb-28 text-center">
    <span class="inline-block rounded-full bg-white/80 border border-brand-100 px-4 py-1.5 text-xs font-semibold text-brand-600 shadow-sm mb-6">
      <?= View::e($content['eyebrow'] ?? '') ?>
    </span>
    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
      <?= View::e($content['title'] ?? '') ?>
    </h1>
    <p class="mt-6 text-lg text-slate-600 max-w-2xl mx-auto">
      <?= View::e($content['subtitle'] ?? '') ?>
    </p>
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="<?= View::url(ltrim($content['primary_button_url'] ?? '/', '/')) ?>"
         class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white font-semibold px-8 py-3.5 shadow-lg shadow-brand-500/30 hover:shadow-xl hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200">
        <?= View::e($content['primary_button_text'] ?? 'Get Started') ?>
      </a>
      <a href="<?= View::url(ltrim($content['secondary_button_url'] ?? '/', '/')) ?>"
         class="inline-flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-700 font-semibold px-8 py-3.5 shadow-sm hover:shadow-md hover:border-brand-200 transition-all duration-200">
        <?= View::e($content['secondary_button_text'] ?? 'Learn More') ?>
      </a>
    </div>
  </div>
</section>
