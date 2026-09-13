<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role(['staff', 'admin', 'viewer']);

$canEdit = in_array(current_role(), ['staff', 'admin'], true);
$errors  = [];
$old     = ['product_id' => '', 'movement_type' => 'in', 'quantity' => '', 'note' => ''];

// ---- Handle "record stock movement" form (staff/admin only) ----
if ($canEdit && $_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $old['product_id']    = (int) ($_POST['product_id'] ?? 0);
    $old['movement_type'] = in_array($_POST['movement_type'] ?? '', ['in', 'out'], true) ? $_POST['movement_type'] : 'in';
    $old['quantity']      = $_POST['quantity'] ?? '';
    $old['note']          = clean_input($_POST['note'] ?? '');

    $productStmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $productStmt->execute([$old['product_id']]);
    $targetProduct = $productStmt->fetch();

    if (!$targetProduct) {
        $errors['product_id'] = 'Please choose a valid product.';
    }
    if (!ctype_digit((string) $old['quantity']) || (int) $old['quantity'] < 1) {
        $errors['quantity'] = 'Quantity must be a whole number of at least 1.';
    }
    if ($targetProduct && $old['movement_type'] === 'out' && (int) $old['quantity'] > (int) $targetProduct['quantity']) {
        $errors['quantity'] = 'Cannot remove more stock than is currently available (' . $targetProduct['quantity'] . ').';
    }

    if (empty($errors)) {
        $pdo->beginTransaction();
        try {
            $insert = $pdo->prepare(
                'INSERT INTO stock_movements (product_id, user_id, movement_type, quantity, note) VALUES (?, ?, ?, ?, ?)'
            );
            $insert->execute([$old['product_id'], $_SESSION['user_id'], $old['movement_type'], (int) $old['quantity'], $old['note']]);

            $delta = $old['movement_type'] === 'in' ? (int) $old['quantity'] : -1 * (int) $old['quantity'];
            $update = $pdo->prepare('UPDATE products SET quantity = quantity + ? WHERE id = ?');
            $update->execute([$delta, $old['product_id']]);

            $pdo->commit();
            set_flash('success', 'Stock movement recorded and inventory updated.');
            redirect('inventory.php');
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors['general'] = 'Something went wrong recording that movement. Please try again.';
        }
    }
}

$products = $pdo->query(
    'SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON c.id = p.category_id ORDER BY p.name'
)->fetchAll();

$pageTitle  = 'Inventory - StockWise';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1><?= $canEdit ? 'Inventory &amp; Stock Movements' : 'Inventory (Read-Only)' ?></h1>
  <p><?= $canEdit ? 'Review current stock and record new stock in/out movements.' : 'You have read-only access to the current inventory levels.' ?></p>
</section>

<section>
  <div class="container">
    <nav class="dash-tabs" aria-label="Sections">
      <a href="dashboard.php">Overview</a>
      <a href="inventory.php" class="active">View Inventory<?= $canEdit ? ' &amp; Record Stock' : '' ?></a>
    </nav>

    <?php if ($canEdit): ?>
      <div class="contact-form" style="max-width:640px;margin-bottom:32px;">
        <h2 style="margin-bottom:16px;">Record a Stock Movement</h2>

        <?php if (!empty($errors)): ?>
          <div class="error-summary" role="alert">
            <strong>Please fix the following:</strong>
            <ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
          </div>
        <?php endif; ?>

        <form method="post" action="inventory.php" novalidate>
          <?= csrf_field() ?>
          <div class="form-row">
            <div class="form-group">
              <label for="product_id">Product</label>
              <select id="product_id" name="product_id" required>
                <option value="">-- Select product --</option>
                <?php foreach ($products as $p): ?>
                  <option value="<?= (int) $p['id'] ?>" <?= (int) $old['product_id'] === (int) $p['id'] ? 'selected' : '' ?>>
                    <?= h($p['name']) ?> (<?= h($p['sku']) ?>) - currently <?= (int) $p['quantity'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="movement_type">Movement Type</label>
              <select id="movement_type" name="movement_type" required>
                <option value="in" <?= $old['movement_type'] === 'in' ? 'selected' : '' ?>>Stock In (received)</option>
                <option value="out" <?= $old['movement_type'] === 'out' ? 'selected' : '' ?>>Stock Out (sold/removed)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" id="quantity" name="quantity" min="1" required value="<?= h($old['quantity']) ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="note">Note (optional)</label>
            <input type="text" id="note" name="note" maxlength="255" value="<?= h($old['note']) ?>" placeholder="e.g. Sold to Grant's Corner Store">
          </div>
          <button type="submit" class="btn btn-primary">Record Movement</button>
        </form>
      </div>
    <?php endif; ?>

    <div class="table-wrap">
      <table class="data-table">
        <caption class="sr-only">Current inventory levels</caption>
        <thead>
          <tr><th scope="col">SKU</th><th scope="col">Name</th><th scope="col">Category</th><th scope="col">Price</th><th scope="col">Qty</th><th scope="col">Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= h($p['sku']) ?></td>
              <td><?= h($p['name']) ?></td>
              <td><?= h($p['category_name'] ?? 'Uncategorised') ?></td>
              <td>$<?= number_format((float) $p['price'], 2) ?></td>
              <td><?= (int) $p['quantity'] ?></td>
              <td><?php if ($p['quantity'] <= $p['reorder_level']): ?><span class="badge badge-accent">Low Stock</span><?php else: ?><span class="badge badge-success">In Stock</span><?php endif; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
