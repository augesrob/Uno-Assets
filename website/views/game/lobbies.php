<h1 class="text-2xl font-bold mb-4">Lobbies</h1>
<form method="post" class="mb-4 flex gap-2">
  <input name="name" placeholder="Lobby name" class="p-2 rounded bg-slate-900 border border-slate-700">
  <button class="px-4 py-2 rounded bg-indigo-500 hover:bg-indigo-600">Create</button>
</form>
<div class="grid md:grid-cols-2 gap-4">
  <?php foreach($lobbies as $l): ?>
  <a href="/lobbies/<?= $l['id'] ?>" class="p-4 rounded-xl bg-slate-800/60 border border-slate-700 hover:bg-slate-800">
    <div class="font-semibold"><?= htmlspecialchars($l['name']) ?></div>
    <div class="text-sm text-slate-400">Status: <?= $l['status'] ?></div>
  </a>
  <?php endforeach; ?>
</div>
