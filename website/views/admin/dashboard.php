<h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="p-4 rounded-xl bg-slate-800 border border-slate-700"><div class="text-slate-400">Users</div><div class="text-3xl font-bold"><?= (int)$stats['users'] ?></div></div>
  <div class="p-4 rounded-xl bg-slate-800 border border-slate-700"><div class="text-slate-400">Lobbies</div><div class="text-3xl font-bold"><?= (int)$stats['lobbies'] ?></div></div>
  <div class="p-4 rounded-xl bg-slate-800 border border-slate-700"><div class="text-slate-400">Version</div><div class="text-3xl font-bold">0.1.0</div></div>
</div>
