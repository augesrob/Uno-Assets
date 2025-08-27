<h1 class="text-2xl font-bold mb-4">Users</h1>
<table class="w-full text-left text-sm border-separate border-spacing-y-2">
  <thead class="text-slate-400"><tr><th>ID</th><th>User</th><th>Email</th><th>Wins</th><th>Losses</th><th>Actions</th></tr></thead>
  <tbody>
  <?php foreach($users as $u): ?>
    <tr class="bg-slate-800">
      <td class="p-2"><?= $u['id'] ?></td>
      <td class="p-2"><?= htmlspecialchars($u['username']) ?></td>
      <td class="p-2"><?= htmlspecialchars($u['email']) ?></td>
      <td class="p-2">
        <form method="post" action="/admin/users/<?= $u['id'] ?>" class="flex gap-2 items-center">
          <input class="w-20 p-1 bg-slate-900 border border-slate-700 rounded" name="wins" type="number" value="<?= $u['wins'] ?>">
          <input class="w-20 p-1 bg-slate-900 border border-slate-700 rounded" name="losses" type="number" value="<?= $u['losses'] ?>">
          <button class="px-2 py-1 rounded bg-white/10">Save</button>
        </form>
      </td>
      <td></td>
      <td class="p-2"></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
