<h1 class="text-2xl font-bold mb-4">Your Profile</h1>
<form method="post" class="space-y-3 max-w-md">
  <label class="block">Display Name</label>
  <input class="w-full p-2 rounded bg-slate-900 border border-slate-700" type="text" name="display_name" value="<?= htmlspecialchars($user['display_name'] ?? $user['username']) ?>">
  <label class="block">Avatar URL</label>
  <input class="w-full p-2 rounded bg-slate-900 border border-slate-700" type="url" name="avatar_url" value="<?= htmlspecialchars($user['avatar_url'] ?? '') ?>">
  <button class="px-4 py-2 rounded bg-indigo-500 hover:bg-indigo-600">Save</button>
</form>
