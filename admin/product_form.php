<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role('admin');

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();

$editId  = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit  = $editId > 0;
$errors  = [];

$product = [
    'sku' => '', 'name' => '', 'category_id' => '', 'description' => '',
    'price' => '', 'quantity' => '', 'reorder_level' => 5, 'image_url' => '',
];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$editId]);
    $existing = $stmt->fetch();
    if (!$existing) {
        set_flash('error', 'Product not found.');
        redirect('inventory.php');
    }
    $product = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $product['sku']           = clean_input($_POST['sku'] ?? '');
    $product['name']          = clean_input($_POST['name'] ?? '');
    $product['category_id']   = $_POST['category_id'] !== '' ? (int) $_POST['category_id'] : null;
    $product['description']   = clean_input($_POST['description'] ?? '');
    $product['price']         = $_POST['price'] ?? '';
    $product['quantity']      = $_POST['quantity'] ?? '';
    $product['reorder_level'] = $_POST['reorder_level'] ?? '5';
    $product['image_url']     = clean_input($_POST['image_url'] ?? '');

    // ---- Server-side validation ----
    if ($product['sku'] === '') {
        $errors['sku'] = 'SKU is required.';
    }
    if ($product['name'] === '' || mb_strlen($product['name']) < 2) {
        $errors['name'] = 'Product name must be at least 2 characters.';
    }
    if (!is_numeric($product['price']) || (float) $product['price'] < 0) {
        $errors['price'] = 'Enter a valid, non-negative price.';
    }
    if (!ctype_digit((string) $product['quantity']) || (int) $product['quantity'] < 0) {
        $errors['quantity'] = 'Quantity must be a whole number of 0 or more.';
    }
    if (!ctype_digit((string) $product['reorder_level']) || (int) $product['reorder_level'] < 0) {
        $errors['reorder_level'] = 'Reorder level must be a whole number of 0 or more.';
    }
    if ($product['image_url'] !== '' && !filter_var($product['image_url'], FILTER_VALIDATE_URL)) {
        $errors['image_url'] = 'Image URL must be a valid URL, or left blank.';
    }

    if (empty($errors)) {
        $dupStmt = $pdo->prepare('SELECT id FROM products WHERE sku = ? AND id != ?');
        $dupStmt->execute([$product['sku'], $editId]);
        if ($dupStmt->fetch()) {
            $errors['sku'] = 'That SKU is already used by another product.';
        }
    }

    if (empty($errors)) {
        if ($isEdit) {
            $stmt = $pdo->prepare(
                'UPDATE products SET sku=?, name=?, category_id=?, description=?, price=?, quantity=?, reorder_level=?, image_url=? WHERE id=?'
            );
            $stmt->execute([
                $product['sku'], $product['name'], $product['category_id'], $product['description'],
                $product['price'], (int) $product['quantity'], (int) $product['reorder_level'], $product['image_url'], $editId,
            ]);
            set_flash('success', 'Product updated successfully.');
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO products (sku, name, category_id, description, price, quantity, reorder_level, image_url, created_by)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $product['sku'], $product['name'], $product['category_id'], $product['description'],
                $product['price'], (int) $product['quantity'], (int) $product['reorder_level'], $product['image_url'], $_SESSION['user_id'],
            ]);
            set_flash('success', 'Product added successfully.');
        }
        redirect('inventory.php');
    }
}

$pageTitle  = ($isEdit ? 'Edit Product' : 'Add Product') . ' - StockWise Admin';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1><?= $isEdit ? 'Edit Product' : 'Add New Product' ?></h1>
  <p>Fields marked required must be completed before saving.</p>
</section>

<section>
  <div class="container">

    <nav class="dash-tabs" aria-label="Admin sections">
      <a href="dashboard.php">Overview</a>
      <a href="inventory.php" class="active">Manage Inventory</a>
      <a href="users.php">Manage Users</a>
      <a href="messages.php">Contact Messages</a>
    </nav>

    <div class="contact-form" style="max-width:640px;">
      <?php if (!empty($errors)): ?>
        <div class="error-summary" role="alert">
          <strong>Please fix the following:</strong>
          <ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form method="post" action="product_form.php<?= $isEdit ? '?id=' . (int) $editId : '' ?>" novalidate>
        <?= csrf_field() ?>

        <div class="form-row">
          <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" required value="<?= h($product['sku']) ?>">
            <?php if (isset($errors['sku'])): ?><p class="field-error" style="display:block;"><?= h($errors['sku']) ?></p><?php endif; ?>
          </div>
          <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required minlength="2" value="<?= h($product['name']) ?>">
            <?php if (isset($errors['name'])): ?><p class="field-error" style="display:block;"><?= h($errors['name']) ?></p><?php endif; ?>
          </div>
        </div>

        <div class="form-group">
          <label for="category_id">Category</label>
          <select id="category_id" name="category_id">
            <option value="">-- Uncategorised --</option>
            <?php foreach ($categories as $c): ?>
              <option value="<?= (int) $c['id'] ?>" <?= (int) $product['category_id'] === (int) $c['id'] ? 'selected' : '' ?>><?= h($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="3"><?= h($product['description']) ?></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required value="<?= h($product['price']) ?>">
            <?php if (isset($errors['price'])): ?><p class="field-error" style="display:block;"><?= h($errors['price']) ?></p><?php endif; ?>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity in Stock</label>
            <input type="number" id="quantity" name="quantity" min="0" required value="<?= h($product['quantity']) ?>">
            <?php if (isset($errors['quantity'])): ?><p class="field-error" style="display:block;"><?= h($errors['quantity']) ?></p><?php endif; ?>
          </div>
          <div class="form-group">
            <label for="reorder_level">Reorder Level</label>
            <input type="number" id="reorder_level" name="reorder_level" min="0" required value="<?= h($product['reorder_level']) ?>">
            <?php if (isset($errors['reorder_level'])): ?><p class="field-error" style="display:block;"><?= h($errors['reorder_level']) ?></p><?php endif; ?>
          </div>
        </div>

        <div class="form-group">
          <label for="image_url">Image URL (optional)</label>
          <input type="url" id="image_url" name="image_url" value="<?= h($product['image_url']) ?>" placeholder="https://...">
          <?php if (isset($errors['image_url'])): ?><p class="field-error" style="display:block;"><?= h($errors['image_url']) ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Add Product' ?></button>
        <a href="inventory.php" class="btn btn-outline">Cancel</a>
      </form>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
