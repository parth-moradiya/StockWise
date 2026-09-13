<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role('admin');

$totalProducts = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$lowStock      = $pdo->query('SELECT COUNT(*) FROM products WHERE quantity <= reorder_level')->fetchColumn();
$totalUsers    = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$unreadMsgs    = $pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();

$recentMovements = $pdo->query(
    'SELECT m.movement_type, m.quantity, m.note, m.created_at, p.name AS product_name, u.full_name AS user_name
     FROM stock_movements m
     JOIN products p ON p.id = m.product_id
     LEFT JOIN users u ON u.id = m.user_id
     ORDER BY m.created_at DESC LIMIT 6'
)->fetchAll();

$pageTitle  = 'Admin Dashboard - StockWise';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1>Admin Dashboard</h1>
  <p>Welcome back, <?= h($_SESSION['user_name']) ?>. Here's what's happening across your inventory.</p>
</section>

<section>
  <div class="container">

    <nav class="dash-tabs" aria-label="Admin sections">
      <a href="dashboard.php" class="active">Overview</a>
      <a href="inventory.php">Manage Inventory</a>
      <a href="users.php">Manage Users</a>
      <a href="messages.php">Contact Messages<?= $unreadMsgs > 0 ? ' (' . (int) $unreadMsgs . ')' : '' ?></a>
    </nav>

    <div class="stat-grid">
      <div class="stat-card">
        <span class="stat-number"><?= (int) $totalProducts ?></span>
        <span class="stat-label">Products in Catalogue</span>
      </div>
      <div class="stat-card <?= $lowStock > 0 ? 'stat-warning' : '' ?>">
        <span class="stat-number"><?= (int) $lowStock ?></span>
        <span class="stat-label">Low Stock Items</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?= (int) $totalUsers ?></span>
        <span class="stat-label">Registered Users</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?= (int) $unreadMsgs ?></span>
        <span class="stat-label">Unread Messages</span>
      </div>
    </div>

    <div class="section-title" style="margin-top:40px;">
      <h2>Recent Stock Activity</h2>
    </div>

    <div class="table-wrap">
      <table class="data-table">
        <caption class="sr-only">Most recent stock movements</caption>
        <thead>
          <tr><th scope="col">Date</th><th scope="col">Product</th><th scope="col">Type</th><th scope="col">Qty</th><th scope="col">Recorded By</th><th scope="col">Note</th></tr>
        </thead>
        <tbody>
          <?php if (empty($recentMovements)): ?>
            <tr><td colspan="6">No stock movements recorded yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($recentMovements as $m): ?>
            <tr>
              <td><?= h(date('d M Y, g:ia', strtotime($m['created_at']))) ?></td>
              <td><?= h($m['product_name']) ?></td>
              <td><span class="badge badge-<?= $m['movement_type'] === 'in' ? 'success' : 'accent' ?>"><?= h(strtoupper($m['movement_type'])) ?></span></td>
              <td><?= (int) $m['quantity'] ?></td>
              <td><?= h($m['user_name'] ?? 'System') ?></td>
              <td><?= h($m['note']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
