<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$errors = [];
$email  = '';

// Very small in-session rate limiter to slow down brute-force guessing.
$_SESSION['login_attempts'] = $_SESSION['login_attempts'] ?? 0;
$_SESSION['login_last_try'] = $_SESSION['login_last_try'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $email    = clean_input($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($password === '') {
        $errors[] = 'Please enter your password.';
    }

    if (empty($errors) && $_SESSION['login_attempts'] >= 6 && (time() - $_SESSION['login_last_try']) < 60) {
        $errors[] = 'Too many attempts. Please wait a minute and try again.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, full_name, email, password_hash, role, status FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['status'] === 'active' && password_verify($password, $user['password_hash'])) {
            // Successful login: reset attempts and start a fresh session id.
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['login_attempts'] = 0;

            $redirectTo = $_SESSION['redirect_after_login'] ?? 'dashboard.php';
            unset($_SESSION['redirect_after_login']);

            set_flash('success', 'Welcome back, ' . $user['full_name'] . '!');
            redirect($redirectTo);
        }

        $_SESSION['login_attempts']++;
        $_SESSION['login_last_try'] = time();
        $errors[] = 'Incorrect email or password.';
    }
}

$pageTitle       = 'Log In - StockWise Retail Solutions';
$pageDescription = 'Log in to your StockWise inventory management demo account.';
$activePage      = 'login';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
  <h1>Log In</h1>
  <p>Access your StockWise inventory dashboard.</p>
</section>

<section>
  <div class="container form-page">
    <div class="contact-form" style="max-width:460px;margin:0 auto;">

      <?php if (!empty($errors)): ?>
        <div class="error-summary" role="alert">
          <ul>
            <?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="login.php" novalidate>
        <?= csrf_field() ?>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required value="<?= h($email) ?>">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Log In</button>
      </form>

      <p style="margin-top:16px;text-align:center;">No account yet? <a href="register.php">Sign up</a></p>

      <div class="alert alert-info" style="margin-top:20px;">
        <strong>Demo accounts</strong> (password <code>Passw0rd!</code> for all):<br>
        admin@stockwise.example &middot; staff@stockwise.example &middot; viewer@stockwise.example
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
