<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role('admin');

// ---- Delete handling (POST + CSRF protected) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    verify_csrf();
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([(int) $_POST['delete_id']]);
    set_flash('success', 'Product deleted.');
    redirect('inventory.php');
}

// ---- Search / filter ----
$search = clean_input($_GET['q'] ?? '');
$sql = 'SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON c.id = p.category_id';
$params = [];
if ($search !== '') {
    $sql .= ' WHERE p.name LIKE ? OR p.sku LIKE ?';
    $params = ["%$search%", "%$search%"];
}
$sql .= ' ORDER BY p.name ASC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$pageTitle  = 'Manage Inventory - StockWise Admin';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1>Manage Inventory</h1>
  <p>Add, edit, or remove products from the StockWise catalogue.</p>
</section>

<section>
  <div class="container">

    <nav class="dash-tabs" aria-label="Admin sections">
      <a href="dashboard.php">Overview</a>
      <a href="inventory.php" class="active">Manage Inventory</a>
      <a href="users.php">Manage Users</a>
      <a href="messages.php">Contact Messages</a>
    </nav>

    <div class="table-toolbar">
      <form method="get" action="inventory.php" role="search" class="search-form">
        <label for="q" class="sr-only">Search products</label>
        <input type="search" id="q" name="q" placeholder="Search by name or SKU..." value="<?= h($search) ?>">
        <button type="submit" class="btn btn-secondary">Search</button>
      </form>
      <a href="product_form.php" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="table-wrap">
      <table class="data-table">
        <caption class="sr-only">Product inventory list</caption>
        <thead>
          <tr>
            <th scope="col">Image</th>
            <th scope="col">SKU</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Qty</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($products)): ?>
            <tr><td colspan="8">No products found.</td></tr>
          <?php endif; ?>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><img src="<?= h($p['image_url'] ?: 'https://loremflickr.com/80/80/product') ?>" alt="" width="48" height="48" style="border-radius:6px;object-fit:cover;" loading="lazy"></td>
              <td><?= h($p['sku']) ?></td>
              <td><?= h($p['name']) ?></td>
              <td><?= h($p['category_name'] ?? 'Uncategorised') ?></td>
              <td>$<?= number_format((float) $p['price'], 2) ?></td>
              <td><?= (int) $p['quantity'] ?></td>
              <td>
                <?php if ($p['quantity'] <= $p['reorder_level']): ?>
                  <span class="badge badge-accent">Low Stock</span>
                <?php else: ?>
                  <span class="badge badge-success">In Stock</span>
                <?php endif; ?>
              </td>
              <td class="table-actions">
                <a href="product_form.php?id=<?= (int) $p['id'] ?>">Edit</a>
                <form method="post" action="inventory.php" onsubmit="return confirm('Delete this product? This cannot be undone.');" style="display:inline;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="delete_id" value="<?= (int) $p['id'] ?>">
                  <button type="submit" class="link-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
