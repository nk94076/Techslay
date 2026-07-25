<?php

use App\Core\View;

/** @var array $content */
?>
<section class="py-20">
  <div class="max-w-5xl mx-auto px-6">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-600 to-accent-600 px-10 py-16 text-center shadow-xl">
      <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full"></div>
      <h2 class="relative text-3xl md:text-4xl font-extrabold text-white"><?= View::e($content['title'] ?? '') ?></h2>
      <a href="<?= View::url(ltrim($content['button_url'] ?? '/contact', '/')) ?>"
         class="relative mt-8 inline-flex items-center rounded-full bg-white text-brand-700 font-semibold px-8 py-3.5 shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <?= View::e($content['button_text'] ?? 'Contact Us') ?>
      </a>
    </div>
  </div>
</section>
