<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
$old = ['full_name' => '', 'email' => '', 'role' => 'viewer'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $old['full_name'] = clean_input($_POST['full_name'] ?? '');
    $old['email']     = clean_input($_POST['email'] ?? '');
    $old['role']      = clean_input($_POST['role'] ?? 'viewer');
    $password         = (string) ($_POST['password'] ?? '');
    $confirm          = (string) ($_POST['confirm_password'] ?? '');

    // ---- Server-side validation (never trust the client) ----
    if ($old['full_name'] === '' || mb_strlen($old['full_name']) < 2) {
        $errors['full_name'] = 'Please enter your full name (at least 2 characters).';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if (!in_array($old['role'], ['staff', 'viewer'], true)) {
        // Nobody may self-register as admin.
        $old['role'] = 'viewer';
    }
    if (mb_strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Password must be at least 8 characters and include an uppercase letter and a number.';
    }
    if ($password !== $confirm) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$old['email']]);
        if ($stmt->fetch()) {
            $errors['email'] = 'An account with that email already exists.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            'INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$old['full_name'], $old['email'], $hash, $old['role']]);

        set_flash('success', 'Account created successfully! You can now log in.');
        redirect('login.php');
    }
}

$pageTitle       = 'Create an Account - StockWise Retail Solutions';
$pageDescription = 'Register for free to try the StockWise inventory management demo dashboard.';
$activePage      = 'register';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
  <h1>Create Your Account</h1>
  <p>Sign up for a free demo account to explore the StockWise inventory dashboard.</p>
</section>

<section>
  <div class="container form-page">
    <div class="contact-form" style="max-width:520px;margin:0 auto;">

      <?php if (!empty($errors)): ?>
        <div class="error-summary" role="alert">
          <strong>Please fix the following:</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= h($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="register.php" novalidate>
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="full_name">Full Name</label>
          <input type="text" id="full_name" name="full_name" required minlength="2"
                 value="<?= h($old['full_name']) ?>">
          <?php if (isset($errors['full_name'])): ?><p class="field-error" style="display:block;"><?= h($errors['full_name']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required
                 value="<?= h($old['email']) ?>">
          <?php if (isset($errors['email'])): ?><p class="field-error" style="display:block;"><?= h($errors['email']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="role">Account Type</label>
          <select id="role" name="role" required>
            <option value="viewer" <?= $old['role'] === 'viewer' ? 'selected' : '' ?>>Viewer (read-only demo access)</option>
            <option value="staff" <?= $old['role'] === 'staff' ? 'selected' : '' ?>>Staff (can record stock movements)</option>
          </select>
          <p class="field-hint">Admin accounts are created internally and cannot be self-registered.</p>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required minlength="8"
                 aria-describedby="password-hint">
          <p id="password-hint" class="field-hint">At least 8 characters, including one uppercase letter and one number.</p>
          <?php if (isset($errors['password'])): ?><p class="field-error" style="display:block;"><?= h($errors['password']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
          <?php if (isset($errors['confirm_password'])): ?><p class="field-error" style="display:block;"><?= h($errors['confirm_password']) ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">Create Account</button>
      </form>

      <p style="margin-top:16px;text-align:center;">Already have an account? <a href="login.php">Log in</a></p>
      <p class="field-hint" style="text-align:center;">By registering you agree to our <a href="privacy.php">Privacy Notice</a>.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
