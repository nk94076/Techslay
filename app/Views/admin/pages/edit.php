<?php

use App\Core\Csrf;
use App\Core\View;

/** @var array $page */
/** @var array $sections */
/** @var array|null $seo */

$knownTypes = [
    'hero', 'trusted_by', 'statistics', 'services_grid', 'campaign_types', 'why_choose_us',
    'how_it_works', 'publisher_benefits', 'advertiser_benefits', 'industries', 'technology',
    'process', 'testimonials', 'latest_blogs', 'faq', 'contact_cta', 'newsletter', 'custom_html',
];
?>
<div class="grid lg:grid-cols-[1fr_320px] gap-6">
  <div>
    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6 mb-6">
      <h3 class="font-semibold text-slate-900 mb-4">Page Details</h3>
      <form action="<?= View::url('admin/pages/' . $page['id']) ?>" method="POST" class="grid sm:grid-cols-2 gap-4">
        <?= View::csrfField() ?>
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
          <input type="text" name="title" value="<?= View::e($page['title']) ?>" required class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Slug</label>
          <input type="text" name="slug" value="<?= View::e($page['slug']) ?>" required class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" <?= $page['is_system'] ? 'readonly' : '' ?>>
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Status</label>
          <select name="status" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <option value="draft" <?= $page['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $page['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>
        <div class="flex items-end">
          <button type="submit" class="w-full rounded-lg bg-slate-900 text-white text-sm font-semibold py-2.5">Save Page Details</button>
        </div>
        <div class="sm:col-span-2">
          <?php View::partial('admin.partials._seo_fields', ['seo' => $seo]); ?>
        </div>
      </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6">
      <h3 class="font-semibold text-slate-900 mb-1">Sections <span class="text-xs text-slate-400 font-normal">(drag to reorder)</span></h3>
      <p class="text-xs text-slate-400 mb-4">Every block on this page is built from these sections. Nothing is hardcoded — add, edit, reorder, publish or remove sections freely.</p>

      <ul id="sections-list" class="space-y-2">
        <?php foreach ($sections as $section): ?>
          <li draggable="true" data-id="<?= (int) $section['id'] ?>"
              class="rounded-lg border border-slate-100 bg-slate-50 px-4 py-3 cursor-move">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <span class="text-slate-300">&#8942;&#8942;</span>
                <div>
                  <div class="text-sm font-medium text-slate-800"><?= View::e($section['component_type']) ?></div>
                  <span class="text-[10px] uppercase tracking-wide rounded-full px-2 py-0.5 <?= $section['status'] === 'published' ? 'bg-green-50 text-green-700' : 'bg-slate-200 text-slate-500' ?>">
                    <?= View::e($section['status']) ?>
                  </span>
                </div>
              </div>
              <div class="flex items-center gap-3 text-xs">
                <button type="button" onclick='openEditSection(<?= json_encode($section, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="text-brand-600 hover:underline">Edit</button>
                <form action="<?= View::url('admin/pages/' . $page['id'] . '/sections/' . $section['id'] . '/toggle') ?>" method="POST">
                  <?= View::csrfField() ?>
                  <button class="text-slate-500 hover:underline"><?= $section['status'] === 'published' ? 'Unpublish' : 'Publish' ?></button>
                </form>
                <form action="<?= View::url('admin/pages/' . $page['id'] . '/sections/' . $section['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Delete this section?');">
                  <?= View::csrfField() ?>
                  <button class="text-red-600 hover:underline">Delete</button>
                </form>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php if ($sections === []): ?>
        <p class="text-sm text-slate-400">No sections yet — add one using the panel on the right.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-6 h-fit">
    <h3 id="section-form-title" class="font-semibold text-slate-900 mb-4">Add Section</h3>
    <form id="section-form" action="<?= View::url('admin/pages/' . $page['id'] . '/sections') ?>" method="POST" class="space-y-3">
      <?= View::csrfField() ?>
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Component Type</label>
        <input list="known-types" id="section-type" name="component_type" required placeholder="e.g. hero"
               class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
        <datalist id="known-types">
          <?php foreach ($knownTypes as $type): ?><option value="<?= $type ?>"><?php endforeach; ?>
        </datalist>
      </div>
      <div>
        <div class="flex items-center justify-between mb-1">
          <label class="block text-xs font-medium text-slate-600">Content (JSON)</label>
          <button type="button" onclick="insertImagePath()" class="text-xs text-brand-600 hover:underline">Insert image path&hellip;</button>
        </div>
        <textarea id="section-content" name="content" rows="10" required
                  class="w-full rounded-lg border border-slate-200 px-3 py-2 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-brand-400">{
  "title": ""
}</textarea>
        <p class="text-[11px] text-slate-400 mt-1">Must be valid JSON. Match the keys the section's template expects (e.g. <code>title</code>, <code>items</code>). For image fields (e.g. an array of <code>{"name":"...","image":"..."}</code> logos), place your cursor where the path should go and click "Insert image path" to browse the Media Library instead of typing it by hand.</p>
      </div>
      <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-brand-500 to-accent-500 text-white text-sm font-semibold py-2.5">Save Section</button>
      <button type="button" onclick="resetSectionForm()" class="w-full text-xs text-slate-400 hover:text-slate-600">Cancel edit</button>
    </form>
  </div>
</div>

<script>
const sectionsBaseUrl = '<?= View::url('admin/pages/' . $page['id'] . '/sections') ?>';

function openEditSection(section) {
  document.getElementById('section-form-title').textContent = 'Edit Section';
  document.getElementById('section-type').value = section.component_type;
  document.getElementById('section-content').value = JSON.stringify(JSON.parse(section.content), null, 2);
  document.getElementById('section-form').action = sectionsBaseUrl + '/' + section.id;
}

function insertImagePath() {
  const textarea = document.getElementById('section-content');
  openMediaPicker((path) => {
    const start = textarea.selectionStart ?? textarea.value.length;
    const end = textarea.selectionEnd ?? textarea.value.length;
    textarea.value = textarea.value.slice(0, start) + path + textarea.value.slice(end);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + path.length;
  });
}

function resetSectionForm() {
  document.getElementById('section-form-title').textContent = 'Add Section';
  document.getElementById('section-type').value = '';
  document.getElementById('section-content').value = '{\n  "title": ""\n}';
  document.getElementById('section-form').action = sectionsBaseUrl;
}

(function () {
  const list = document.getElementById('sections-list');
  if (!list) return;
  let dragged = null;

  list.addEventListener('dragstart', (e) => { dragged = e.target.closest('li'); });

  list.addEventListener('dragover', (e) => {
    e.preventDefault();
    const target = e.target.closest('li');
    if (!target || target === dragged) return;
    const rect = target.getBoundingClientRect();
    const after = (e.clientY - rect.top) / rect.height > 0.5;
    list.insertBefore(dragged, after ? target.nextSibling : target);
  });

  list.addEventListener('drop', () => {
    const ids = Array.from(list.children).map((li) => li.dataset.id);
    const params = new URLSearchParams();
    ids.forEach((id) => params.append('order[]', id));
    params.append('_csrf_token', '<?= View::e(Csrf::token()) ?>');

    fetch('<?= View::url('admin/pages/' . $page['id'] . '/sections/reorder') ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
      body: params.toString(),
    });
  });
})();
</script>
