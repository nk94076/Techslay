<?php

use App\Core\View;

/** @var array $posts */
/** @var array $categories */
/** @var string $activeCategory */
/** @var int $currentPage */
/** @var int $lastPage */
?>
<section class="py-20 bg-gradient-to-b from-brand-50 via-white to-white">
  <div class="max-w-3xl mx-auto px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900">Blog</h1>
    <p class="mt-4 text-slate-600">Performance marketing insights, playbooks and network updates.</p>
  </div>
</section>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6">
    <?php if ($categories !== []): ?>
      <div class="flex flex-wrap justify-center gap-2 mb-10">
        <a href="<?= View::url('blog') ?>" class="px-4 py-2 rounded-full text-sm font-medium <?= $activeCategory === '' ? 'bg-gradient-to-r from-brand-500 to-accent-500 text-white' : 'bg-white border border-slate-200 text-slate-600' ?>">All</a>
        <?php foreach ($categories as $cat): ?>
          <a href="<?= View::url('blog?category=' . $cat['slug']) ?>" class="px-4 py-2 rounded-full text-sm font-medium <?= $activeCategory === $cat['slug'] ? 'bg-gradient-to-r from-brand-500 to-accent-500 text-white' : 'bg-white border border-slate-200 text-slate-600' ?>"><?= View::e($cat['name']) ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($posts === []): ?>
      <p class="text-center text-slate-400">No articles published yet — check back soon.</p>
    <?php else: ?>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($posts as $post): ?>
          <a href="<?= View::url('blog/' . $post['slug']) ?>" class="rounded-2xl overflow-hidden bg-white border border-slate-100 shadow-sm hover:shadow-lg transition block">
            <div class="h-40 bg-gradient-to-br from-brand-200 to-accent-200"></div>
            <div class="p-6">
              <?php if ($post['category_name']): ?><div class="text-xs font-medium text-brand-600 mb-1"><?= View::e($post['category_name']) ?></div><?php endif; ?>
              <h3 class="font-semibold text-slate-900"><?= View::e($post['title']) ?></h3>
              <p class="mt-2 text-sm text-slate-500"><?= View::e($post['excerpt'] ?? '') ?></p>
              <div class="mt-3 text-xs text-slate-400"><?= (int) $post['reading_time_minutes'] ?> min read</div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <?php if ($lastPage > 1): ?>
        <div class="flex justify-center gap-2 mt-12">
          <?php for ($i = 1; $i <= $lastPage; $i++): ?>
            <a href="<?= View::url('blog?page=' . $i . ($activeCategory !== '' ? '&category=' . $activeCategory : '')) ?>"
               class="w-9 h-9 flex items-center justify-center rounded-full text-sm <?= $i === $currentPage ? 'bg-brand-500 text-white' : 'bg-white border border-slate-200 text-slate-600' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
