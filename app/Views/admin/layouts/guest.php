<?php

use App\Core\View;

/** @var string $content */
$pageTitle = ($pageTitle ?? 'Admin') . ' | ClickNet Admin';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= View::e($pageTitle) ?></title>
<meta name="robots" content="noindex, nofollow">
<?php View::partial('partials.tailwind-config'); ?>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-purple-950 to-slate-900 flex items-center justify-center p-6">
<div class="w-full max-w-md">
  <div class="text-center mb-8">
    <div class="text-2xl font-bold text-white">ClickNet <span class="text-brand-400">Admin</span></div>
  </div>
  <div class="rounded-2xl bg-white shadow-2xl p-8">
    <?php if ($error = \App\Core\Session::getFlash('error')): ?>
      <div class="mb-5 rounded-lg bg-red-50 border border-red-100 text-red-700 text-sm px-4 py-3"><?= View::e($error) ?></div>
    <?php endif; ?>
    <?php if ($success = \App\Core\Session::getFlash('success')): ?>
      <div class="mb-5 rounded-lg bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3"><?= View::e($success) ?></div>
    <?php endif; ?>
    <?= $content ?>
  </div>
</div>
</body>
</html>
