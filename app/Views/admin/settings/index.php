<?php

use App\Core\View;

/** @var array $groups */
/** @var string $activeGroup */
/** @var array $settings */

$labels = [
    'general' => 'General', 'branding' => 'Branding', 'theme' => 'Theme', 'business' => 'Business Info',
    'social' => 'Social Links', 'analytics' => 'Analytics', 'smtp' => 'SMTP',
    'recaptcha' => 'reCAPTCHA', 'seo' => 'SEO Defaults',
];
?>
<div class="flex flex-wrap gap-2 mb-6">
  <?php foreach ($groups as $group): ?>
    <a href="<?= View::url('admin/settings/' . $group) ?>"
       class="px-4 py-2 rounded-full text-sm font-medium <?= $group === $activeGroup ? 'bg-gradient-to-r from-brand-500 to-accent-500 text-white' : 'bg-white border border-slate-200 text-slate-600' ?>">
      <?= View::e($labels[$group] ?? ucfirst($group)) ?>
    </a>
  <?php endforeach; ?>
</div>

<div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6 max-w-2xl">
  <form action="<?= View::url('admin/settings/' . $activeGroup) ?>" method="POST" class="space-y-5">
    <?= View::csrfField() ?>
    <?php if ($settings === []): ?>
      <p class="text-sm text-slate-400">No settings in this group.</p>
    <?php endif; ?>
    <?php foreach ($settings as $setting): ?>
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          <?= View::e(ucwords(str_replace('_', ' ', $setting['key']))) ?>
        </label>
        <?php if ($setting['type'] === 'textarea'): ?>
          <textarea name="settings[<?= View::e($setting['key']) ?>]" rows="3"
                    class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400"><?= View::e($setting['value']) ?></textarea>
        <?php elseif ($setting['type'] === 'color'): ?>
          <div class="flex items-center gap-3">
            <input type="color" name="settings[<?= View::e($setting['key']) ?>]" value="<?= View::e($setting['value'] ?: '#7c3aed') ?>" class="h-10 w-14 rounded border border-slate-200">
            <span class="text-xs text-slate-400"><?= View::e($setting['value']) ?></span>
          </div>
        <?php elseif ($setting['type'] === 'boolean'): ?>
          <select name="settings[<?= View::e($setting['key']) ?>]" class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm">
            <option value="true" <?= $setting['value'] === 'true' ? 'selected' : '' ?>>Enabled</option>
            <option value="false" <?= $setting['value'] === 'false' ? 'selected' : '' ?>>Disabled</option>
          </select>
        <?php else: ?>
          <input type="text" name="settings[<?= View::e($setting['key']) ?>]" value="<?= View::e($setting['value']) ?>"
                 class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400"
                 <?= $setting['type'] === 'image' ? 'placeholder="/uploads/2026/01/logo.png — upload via Media Manager"' : '' ?>>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <?php if ($settings !== []): ?>
      <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold px-6 py-2.5 shadow-lg shadow-brand-500/30 hover:shadow-xl transition">
        Save Changes
      </button>
    <?php endif; ?>
  </form>
</div>
