<?php

use App\Core\View;

/** @var array $post */
/** @var array $tableOfContents */
/** @var array $related */
/** @var array $tags */
?>
<article class="py-20">
  <div class="max-w-3xl mx-auto px-6">
    <?php if ($post['category_name']): ?>
      <a href="<?= View::url('blog?category=' . $post['category_slug']) ?>" class="text-xs font-semibold text-brand-600 uppercase tracking-wide"><?= View::e($post['category_name']) ?></a>
    <?php endif; ?>
    <h1 class="mt-3 text-3xl md:text-5xl font-extrabold text-slate-900"><?= View::e($post['title']) ?></h1>
    <div class="mt-4 flex items-center gap-3 text-sm text-slate-500">
      <?php if ($post['author_name']): ?><span><?= View::e($post['author_name']) ?></span><span>&middot;</span><?php endif; ?>
      <span><?= (int) $post['reading_time_minutes'] ?> min read</span>
      <span>&middot;</span>
      <span><?= (int) $post['views'] ?> views</span>
    </div>

    <?php if ($tableOfContents !== []): ?>
      <div class="mt-8 rounded-2xl bg-slate-50 border border-slate-100 p-6">
        <div class="text-xs font-semibold uppercase text-slate-400 mb-2">Table of Contents</div>
        <ul class="space-y-1 text-sm">
          <?php foreach ($tableOfContents as $item): ?>
            <li><a href="#<?= View::e($item['anchor'] ?? '') ?>" class="text-brand-600 hover:underline"><?= View::e($item['label'] ?? '') ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Admin-authored rich content (not user input) — intentionally unescaped so headings/code blocks/links render. -->
    <div class="mt-10 prose prose-slate max-w-none text-slate-700 leading-relaxed">
      <?= $post['content'] ?>
    </div>

    <?php if ($tags !== []): ?>
      <div class="mt-10 flex flex-wrap gap-2">
        <?php foreach ($tags as $tag): ?>
          <span class="text-xs rounded-full bg-slate-100 text-slate-600 px-3 py-1"><?= View::e($tag['name']) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($post['author_bio']): ?>
      <div class="mt-12 rounded-2xl bg-slate-50 border border-slate-100 p-6">
        <div class="text-sm font-semibold text-slate-900"><?= View::e($post['author_name']) ?></div>
        <p class="mt-1 text-sm text-slate-500"><?= View::e($post['author_bio']) ?></p>
      </div>
    <?php endif; ?>
  </div>
</article>

<?php if ($related !== []): ?>
<section class="py-16 bg-slate-50/60">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-2xl font-bold text-slate-900 mb-8 text-center">Related Articles</h2>
    <div class="grid sm:grid-cols-3 gap-6">
      <?php foreach ($related as $item): ?>
        <a href="<?= View::url('blog/' . $item['slug']) ?>" class="rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-lg transition p-6">
          <h3 class="font-semibold text-slate-900"><?= View::e($item['title']) ?></h3>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
