<h1 class="text-2xl font-bold mb-4">Login</h1>
<?php if(!empty($error)): ?><div class="p-3 rounded bg-red-600/20 border border-red-600 mb-4"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="space-y-3 max-w-sm">
  <input class="w-full p-2 rounded bg-slate-900 border border-slate-700" type="email" name="email" placeholder="Email" required>
  <input class="w-full p-2 rounded bg-slate-900 border border-slate-700" type="password" name="password" placeholder="Password" required>
  <button class="px-4 py-2 rounded bg-indigo-500 hover:bg-indigo-600">Login</button>
</form>
<div class="mt-4 space-y-2">
  <div class="text-sm text-slate-400">Or continue with:</div>
  <div class="flex gap-2">
    <a class="px-3 py-2 rounded bg-white/10" href="/oauth/google">Google</a>
    <a class="px-3 py-2 rounded bg-white/10" href="/oauth/discord">Discord</a>
    <a class="px-3 py-2 rounded bg-white/10" href="/oauth/facebook">Facebook</a>
    <a class="px-3 py-2 rounded bg-white/10" href="/oauth/yahoo">Yahoo</a>
  </div>
</div>
