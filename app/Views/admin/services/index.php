<?php

use App\Core\Icon;
use App\Core\View;

/** @var array $services */
/** @var array $iconKeys */
?>
<div class="flex justify-end mb-5">
  <button type="button" onclick="openServiceModal()" class="rounded-full bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold px-6 py-2.5 shadow-lg shadow-brand-500/30">+ Add Service</button>
</div>

<div class="rounded-2xl bg-white border border-slate-100 shadow-sm overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
      <tr><th class="text-left px-5 py-3">Icon</th><th class="text-left px-5 py-3">Title</th><th class="text-left px-5 py-3">Slug</th><th class="text-left px-5 py-3">Status</th><th class="text-right px-5 py-3">Actions</th></tr>
    </thead>
    <tbody class="divide-y divide-slate-50">
      <?php foreach ($services as $service): ?>
        <tr>
          <td class="px-5 py-3">
            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center"><?= Icon::render($service['icon'] ?? null, 'w-4 h-4') ?></div>
          </td>
          <td class="px-5 py-3 font-medium text-slate-800"><?= View::e($service['title']) ?></td>
          <td class="px-5 py-3 text-slate-500">/services/<?= View::e($service['slug']) ?></td>
          <td class="px-5 py-3"><span class="text-xs rounded-full px-2.5 py-1 <?= $service['status'] === 'published' ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-500' ?>"><?= ucfirst($service['status']) ?></span></td>
          <td class="px-5 py-3 text-right text-xs space-x-3">
            <button type="button" onclick='openServiceModal(<?= json_encode($service, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="text-brand-600 hover:underline">Edit</button>
            <form action="<?= View::url('admin/services/' . $service['id'] . '/delete') ?>" method="POST" class="inline" onsubmit="return confirm('Trash this service?');">
              <?= View::csrfField() ?>
              <button class="text-red-600 hover:underline">Trash</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if ($services === []): ?><p class="text-center text-sm text-slate-400 py-10">No services yet.</p><?php endif; ?>
</div>

<div id="service-modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4 overflow-y-auto">
  <div class="bg-white rounded-2xl p-6 w-full max-w-lg my-8">
    <h3 id="service-modal-title" class="font-semibold text-slate-900 mb-4">Add Service</h3>
    <form id="service-form" action="<?= View::url('admin/services') ?>" method="POST" class="space-y-3">
      <?= View::csrfField() ?>
      <input type="text" id="service-title" name="title" placeholder="Title" required class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
      <input type="text" id="service-slug" name="slug" placeholder="Slug (auto if blank)" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Icon</label>
        <select id="service-icon" name="icon" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
          <?php foreach ($iconKeys as $key): ?><option value="<?= $key ?>"><?= ucwords(str_replace('-', ' ', $key)) ?></option><?php endforeach; ?>
        </select>
      </div>
      <textarea id="service-short" name="short_description" placeholder="Short description" rows="2" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"></textarea>
      <textarea id="service-content" name="content" placeholder="Full content (shown on the service page)" rows="5" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"></textarea>
      <div class="grid grid-cols-2 gap-3">
        <input type="number" id="service-sort" name="sort_order" placeholder="Sort order" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
        <select id="service-status" name="status" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
          <option value="published">Published</option>
          <option value="draft">Draft</option>
        </select>
      </div>
      <div class="flex gap-3 pt-2">
        <button type="button" onclick="document.getElementById('service-modal').classList.add('hidden')" class="flex-1 rounded-lg bg-slate-100 text-slate-600 text-sm font-medium py-2.5">Cancel</button>
        <button type="submit" class="flex-1 rounded-lg bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold py-2.5">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
const servicesBaseUrl = '<?= View::url('admin/services') ?>';
function openServiceModal(s) {
  const form = document.getElementById('service-form');
  if (s) {
    document.getElementById('service-modal-title').textContent = 'Edit Service';
    document.getElementById('service-title').value = s.title;
    document.getElementById('service-slug').value = s.slug;
    document.getElementById('service-icon').value = s.icon || '';
    document.getElementById('service-short').value = s.short_description || '';
    document.getElementById('service-content').value = s.content || '';
    document.getElementById('service-sort').value = s.sort_order;
    document.getElementById('service-status').value = s.status;
    form.action = servicesBaseUrl + '/' + s.id;
  } else {
    document.getElementById('service-modal-title').textContent = 'Add Service';
    form.reset();
    form.action = servicesBaseUrl;
  }
  document.getElementById('service-modal').classList.remove('hidden');
}
</script>
