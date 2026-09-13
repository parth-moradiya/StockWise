<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $userId = (int) ($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($userId === (int) $_SESSION['user_id']) {
        set_flash('error', 'You cannot change your own account here.');
        redirect('users.php');
    }

    if ($action === 'set_role') {
        $newRole = in_array($_POST['role'] ?? '', ['admin', 'staff', 'viewer'], true) ? $_POST['role'] : 'viewer';
        $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
        $stmt->execute([$newRole, $userId]);
        set_flash('success', 'User role updated.');
    } elseif ($action === 'toggle_status') {
        $stmt = $pdo->prepare("UPDATE users SET status = IF(status='active','disabled','active') WHERE id = ?");
        $stmt->execute([$userId]);
        set_flash('success', 'User status updated.');
    }
    redirect('users.php');
}

$users = $pdo->query('SELECT id, full_name, email, role, status, created_at FROM users ORDER BY created_at DESC')->fetchAll();

$pageTitle  = 'Manage Users - StockWise Admin';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1>Manage Users</h1>
  <p>Control who can access the StockWise demo dashboard and what they're allowed to do.</p>
</section>

<section>
  <div class="container">
    <nav class="dash-tabs" aria-label="Admin sections">
      <a href="dashboard.php">Overview</a>
      <a href="inventory.php">Manage Inventory</a>
      <a href="users.php" class="active">Manage Users</a>
      <a href="messages.php">Contact Messages</a>
    </nav>

    <div class="table-wrap">
      <table class="data-table">
        <caption class="sr-only">Registered users and their roles</caption>
        <thead>
          <tr><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Role</th><th scope="col">Status</th><th scope="col">Joined</th><th scope="col">Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= h($u['full_name']) ?><?= (int) $u['id'] === (int) $_SESSION['user_id'] ? ' (you)' : '' ?></td>
              <td><?= h($u['email']) ?></td>
              <td><span class="badge badge-neutral"><?= h(ucfirst($u['role'])) ?></span></td>
              <td><span class="badge badge-<?= $u['status'] === 'active' ? 'success' : 'accent' ?>"><?= h(ucfirst($u['status'])) ?></span></td>
              <td><?= h(date('d M Y', strtotime($u['created_at']))) ?></td>
              <td class="table-actions">
                <?php if ((int) $u['id'] !== (int) $_SESSION['user_id']): ?>
                  <form method="post" action="users.php" style="display:inline-flex;gap:6px;align-items:center;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                    <input type="hidden" name="action" value="set_role">
                    <label class="sr-only" for="role-<?= (int) $u['id'] ?>">Change role for <?= h($u['full_name']) ?></label>
                    <select id="role-<?= (int) $u['id'] ?>" name="role" onchange="this.form.submit()">
                      <option value="viewer" <?= $u['role'] === 'viewer' ? 'selected' : '' ?>>Viewer</option>
                      <option value="staff" <?= $u['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                      <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                  </form>
                  <form method="post" action="users.php" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                    <input type="hidden" name="action" value="toggle_status">
                    <button type="submit" class="link-danger"><?= $u['status'] === 'active' ? 'Disable' : 'Enable' ?></button>
                  </form>
                <?php else: ?>
                  &mdash;
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
