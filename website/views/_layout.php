<?php
// Basic layout with Tailwind CDN and Alpine.js for interactivity
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UNO Online</title>
  <link rel="icon" href="/favicon.ico">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    .uno-card { transition: transform .2s, box-shadow .2s; }
    .uno-card:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 12px 30px rgba(0,0,0,.25); }
  </style>
</head>
<body class="bg-slate-900 text-slate-100">
  <header class="px-6 py-4 bg-slate-800/80 backdrop-blur border-b border-slate-700">
    <div class="max-w-6xl mx-auto flex items-center gap-4">
      <a href="/" class="text-2xl font-bold">UNO</a>
      <nav class="ml-auto flex gap-4">
        <a href="/lobbies" class="hover:underline">Lobbies</a>
        <a href="/rules" class="hover:underline">Rules</a>
        <?php if($app->auth->user()): ?>
          <a href="/me" class="hover:underline">Profile</a>
          <a href="/logout" class="hover:underline">Logout</a>
        <?php else: ?>
          <a href="/login" class="hover:underline">Login</a>
          <a href="/register" class="hover:underline">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <main class="max-w-6xl mx-auto p-6">
    <?php include __DIR__ . '/' . $template; ?>
  </main>
  <footer class="max-w-6xl mx-auto p-6 text-sm text-slate-400">© <?php echo date('Y'); ?> uno.augesrob.net</footer>
</body>
</html>
