<?php

use App\Core\View;

/** @var array $stats */
/** @var array $recentLeads */
/** @var array $recentActivity */

$cards = [
    ['label' => 'New Leads', 'value' => $stats['leads'], 'url' => 'admin/leads'],
    ['label' => 'Blog Posts', 'value' => $stats['blog_posts'], 'url' => 'admin/blog'],
    ['label' => 'Media Files', 'value' => $stats['media'], 'url' => 'admin/media'],
    ['label' => 'Admin Users', 'value' => $stats['users'], 'url' => 'admin/users'],
];
?>
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
  <?php foreach ($cards as $card): ?>
    <a href="<?= View::url($card['url']) ?>" class="rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition p-6">
      <div class="text-3xl font-extrabold text-slate-900"><?= (int) $card['value'] ?></div>
      <div class="mt-1 text-sm text-slate-500"><?= View::e($card['label']) ?></div>
    </a>
  <?php endforeach; ?>
</div>

<div class="grid lg:grid-cols-2 gap-6">
  <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6">
    <h2 class="font-semibold text-slate-900 mb-4">Recent Leads</h2>
    <?php if ($recentLeads === []): ?>
      <p class="text-sm text-slate-400">No leads yet.</p>
    <?php else: ?>
      <div class="space-y-3">
        <?php foreach ($recentLeads as $lead): ?>
          <div class="flex items-center justify-between text-sm border-b border-slate-50 pb-3">
            <div>
              <div class="font-medium text-slate-900"><?= View::e($lead['name']) ?></div>
              <div class="text-slate-400"><?= View::e($lead['email']) ?></div>
            </div>
            <span class="rounded-full bg-slate-100 text-slate-600 text-xs px-2.5 py-1"><?= View::e($lead['lead_type']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6">
    <h2 class="font-semibold text-slate-900 mb-4">Recent Activity</h2>
    <?php if ($recentActivity === []): ?>
      <p class="text-sm text-slate-400">No activity recorded yet.</p>
    <?php else: ?>
      <div class="space-y-3">
        <?php foreach ($recentActivity as $activity): ?>
          <div class="text-sm border-b border-slate-50 pb-3">
            <div class="font-medium text-slate-900"><?= View::e($activity['action']) ?></div>
            <div class="text-slate-400"><?= View::e($activity['description'] ?? '') ?> &middot; <?= View::e($activity['created_at']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="mt-8 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6 text-sm text-slate-500">
  This dashboard is a live skeleton on the real schema. Content CRUD modules (Pages, Media, Blog, Services, Leads, SEO, Settings) are built out in Phase 2 of this project.
</div>
