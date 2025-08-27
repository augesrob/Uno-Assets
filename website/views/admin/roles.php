<h1 class="text-2xl font-bold mb-4">Roles & Permissions</h1>
<form method="post" class="flex gap-2 mb-4">
  <input class="p-2 bg-slate-900 border border-slate-700 rounded" name="name" placeholder="Role Name">
  <input class="p-2 bg-slate-900 border border-slate-700 rounded" name="slug" placeholder="Slug e.g. owner">
  <button class="px-3 py-2 rounded bg-white/10">Save</button>
</form>
<div class="grid md:grid-cols-2 gap-4">
  <div class="p-4 rounded-xl bg-slate-800 border border-slate-700">
    <h2 class="font-semibold mb-2">Roles</h2>
    <ul class="space-y-1">
      <?php foreach($roles as $r): ?><li class="text-sm"><?= htmlspecialchars($r['name']) ?> (<?= $r['slug'] ?>)</li><?php endforeach; ?>
    </ul>
  </div>
  <div class="p-4 rounded-xl bg-slate-800 border border-slate-700">
    <h2 class="font-semibold mb-2">Permissions</h2>
    <ul class="space-y-1">
      <?php foreach($perms as $p): ?><li class="text-sm"><?= htmlspecialchars($p['slug']) ?></li><?php endforeach; ?>
    </ul>
  </div>
</div>
