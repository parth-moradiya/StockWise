<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role(['staff', 'admin']);

$totalProducts = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$lowStock      = $pdo->query('SELECT COUNT(*) FROM products WHERE quantity <= reorder_level')->fetchColumn();
$myMovements   = $pdo->prepare('SELECT COUNT(*) FROM stock_movements WHERE user_id = ?');
$myMovements->execute([$_SESSION['user_id']]);
$myMovementCount = $myMovements->fetchColumn();

$pageTitle  = 'Staff Dashboard - StockWise';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1>Staff Dashboard</h1>
  <p>Welcome, <?= h($_SESSION['user_name']) ?>. Track and update stock levels below.</p>
</section>

<section>
  <div class="container">
    <nav class="dash-tabs" aria-label="Staff sections">
      <a href="dashboard.php" class="active">Overview</a>
      <a href="inventory.php">View Inventory &amp; Record Stock</a>
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
        <span class="stat-number"><?= (int) $myMovementCount ?></span>
        <span class="stat-label">Movements You've Logged</span>
      </div>
    </div>

    <p style="margin-top:24px;"><a href="inventory.php" class="btn btn-primary">Go to Inventory &rarr;</a></p>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
