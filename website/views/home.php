<div class="grid md:grid-cols-2 gap-6">
  <div class="p-6 rounded-2xl bg-slate-800/70 border border-slate-700">
    <h1 class="text-3xl font-bold mb-2">Play UNO Online</h1>
    <p class="text-slate-300">Create or join a lobby. Spectate live games. Level up with XP and earn coins via challenges.</p>
    <div class="mt-4 flex gap-3">
      <a href="/lobbies" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20">Find Lobby</a>
      <?php if($user): ?>
        <form method="post" action="/lobbies"><button class="px-4 py-2 rounded-xl bg-indigo-500 hover:bg-indigo-600">Create Lobby</button></form>
      <?php else: ?>
        <a href="/register" class="px-4 py-2 rounded-xl bg-indigo-500 hover:bg-indigo-600">Create Account</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="p-6 rounded-2xl bg-slate-800/70 border border-slate-700">
    <h2 class="text-xl font-semibold mb-3">Leaderboard (Top 10)</h2>
    <div id="leaderboard" class="space-y-2 text-sm"></div>
    <script>
      fetch('/api/leaderboard').then(r=>r.json()).then(rows=>{
        const el = document.getElementById('leaderboard');
        el.innerHTML = rows.slice(0,10).map((r,i)=>`
          <div class="flex items-center justify-between rounded-lg p-2 bg-slate-900/60 border border-slate-700">
            <div class="flex items-center gap-3">
              <div class="w-6 text-right">${i+1}.</div>
              <div class="font-medium">${r.username}</div>
            </div>
            <div class="text-xs text-slate-400">W:${r.wins} • L:${r.losses} • XP:${r.xp} • Lv.${r.level}</div>
          </div>
        `).join('');
      });
    </script>
  </div>
</div>
