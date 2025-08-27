<h1 class="text-2xl font-bold mb-2">Lobby: <?= htmlspecialchars($lobby['name']) ?></h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="md:col-span-2 p-4 rounded-xl bg-slate-800/60 border border-slate-700">
    <canvas id="table" width="900" height="520" class="w-full rounded-lg bg-slate-900"></canvas>
    <div class="mt-3 flex gap-2">
      <form method="post" action="/lobbies/<?= $lobby['id'] ?>/start">
        <button class="px-4 py-2 rounded bg-green-600 hover:bg-green-700">Start Game</button>
      </form>
      <form method="post" action="/lobbies/<?= $lobby['id'] ?>/join">
        <button class="px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700">Join</button>
      </form>
    </div>
  </div>
  <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700">
    <div class="font-semibold mb-2">Lobby Chat</div>
    <div id="chat" class="h-80 overflow-y-auto text-sm p-2 bg-slate-900 rounded border border-slate-700"></div>
    <form id="chatForm" class="mt-2 flex gap-2">
      <input id="chatInput" class="flex-1 p-2 rounded bg-slate-900 border border-slate-700" placeholder="Type message...">
      <button class="px-4 py-2 rounded bg-white/10">Send</button>
    </form>
  </div>
</div>
<script>
// Simple SSE chat stream
const chat = document.getElementById('chat');
const es = new EventSource('/api/chat/<?= $lobby['id'] ?>/stream');
es.addEventListener('tick', e => {
  const msgs = JSON.parse(e.data);
  chat.innerHTML = msgs.reverse().map(m => `[${m.role}] ${m.username}: ${m.message}`).join('\n');
  chat.scrollTop = chat.scrollHeight;
});

document.getElementById('chatForm').addEventListener('submit', async e => {
  e.preventDefault();
  const text = document.getElementById('chatInput').value.trim();
  if(!text) return;
  await fetch('/api/chat/<?= $lobby['id'] ?>', {method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body: 'text=' + encodeURIComponent(text)});
  document.getElementById('chatInput').value='';
});

// Animated table placeholder (cards pop-out)
const canvas = document.getElementById('table');
const ctx = canvas.getContext('2d');
function drawTable(bg='#0f172a'){
  ctx.fillStyle = bg;
  ctx.fillRect(0,0,canvas.width,canvas.height);
  ctx.fillStyle = '#1e293b';
  ctx.fillRect(40,40,canvas.width-80,canvas.height-80);
}
drawTable();

let cards = [];
for(let i=0;i<7;i++){
  cards.push({x:120 + i*80, y:420, r:8, t:0});
}
function tick(){
  drawTable();
  cards.forEach((c,i)=>{
    c.t += 0.02;
    const pop = Math.sin(c.t)*6;
    ctx.fillStyle = '#e11d48';
    const x = c.x, y = c.y-pop;
    ctx.fillRect(x, y, 60, 90);
    ctx.fillStyle = 'white';
    ctx.font = 'bold 20px sans-serif';
    ctx.fillText('UNO', x+8, y+50);
  });
  requestAnimationFrame(tick);
}
tick();
</script>
