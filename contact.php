<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';

$errors = [];
$old = ['full_name' => '', 'email' => '', 'phone' => '', 'reason' => '', 'message' => ''];
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $old['full_name'] = clean_input($_POST['full_name'] ?? '');
    $old['email']     = clean_input($_POST['email'] ?? '');
    $old['phone']     = clean_input($_POST['phone'] ?? '');
    $old['reason']    = clean_input($_POST['reason'] ?? '');
    $old['message']   = clean_input($_POST['message'] ?? '');

    if (mb_strlen($old['full_name']) < 2) {
        $errors['full_name'] = 'Please enter your full name.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if (!preg_match('/^[0-9+\-\s()]{7,15}$/', $old['phone'])) {
        $errors['phone'] = 'Please enter a valid phone number (digits, spaces, + and - only).';
    }
    if (!in_array($old['reason'], ['sales', 'support', 'partnership', 'other'], true)) {
        $errors['reason'] = 'Please choose a reason for contacting us.';
    }
    if (mb_strlen($old['message']) < 10) {
        $errors['message'] = 'Message must be at least 10 characters long.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'INSERT INTO contact_messages (full_name, email, phone, reason, message) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$old['full_name'], $old['email'], $old['phone'], $old['reason'], $old['message']]);
        $sent = true;
        $old = ['full_name' => '', 'email' => '', 'phone' => '', 'reason' => '', 'message' => ''];
    }
}

$pageTitle       = 'Contact Us - StockWise Retail Solutions';
$pageDescription = 'Get in touch with StockWise Retail Solutions for sales, support, or partnership enquiries about our inventory software.';
$activePage      = 'contact';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
  <h1>Contact Us</h1>
  <p>Questions about pricing, setup, or partnerships? Send us a message and our team will get back to you.</p>
</section>

<section>
  <div class="container contact-wrap">

    <div class="contact-info-box">
      <h3>Email</h3>
      <p><a href="mailto:info@stockwiseretail.example">info@stockwiseretail.example</a></p>

      <h3>Phone</h3>
      <p>(555) 214-7788</p>

      <h3>Address</h3>
      <p>48 Market Street, Riverdale, RV 10245</p>

      <h3>Follow Us</h3>
      <div class="social-links">
        <a href="#" aria-label="StockWise on Facebook">FB</a>
        <a href="#" aria-label="StockWise on Instagram">IG</a>
        <a href="#" aria-label="StockWise on LinkedIn">LI</a>
      </div>
    </div>

    <div class="contact-form">
      <h2 style="margin-bottom:20px;">Send Us a Message</h2>

      <?php if ($sent): ?>
        <div class="success-box" aria-live="polite">Thanks &mdash; your message has been sent. We'll be in touch soon.</div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="error-summary" role="alert">
          <strong>Please fix the following:</strong>
          <ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form id="contact-form" method="post" action="contact.php" novalidate>
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="full-name">Full Name</label>
          <input type="text" id="full-name" name="full_name" required minlength="2" value="<?= h($old['full_name']) ?>">
          <?php if (isset($errors['full_name'])): ?><p class="field-error" style="display:block;"><?= h($errors['full_name']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required value="<?= h($old['email']) ?>">
          <?php if (isset($errors['email'])): ?><p class="field-error" style="display:block;"><?= h($errors['email']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" required pattern="^[0-9+\-\s()]{7,15}$" placeholder="e.g. 555-214-7788" value="<?= h($old['phone']) ?>">
          <?php if (isset($errors['phone'])): ?><p class="field-error" style="display:block;"><?= h($errors['phone']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="reason">Reason for Contact</label>
          <select id="reason" name="reason" required>
            <option value="">-- Select a reason --</option>
            <option value="sales" <?= $old['reason'] === 'sales' ? 'selected' : '' ?>>Sales</option>
            <option value="support" <?= $old['reason'] === 'support' ? 'selected' : '' ?>>Support</option>
            <option value="partnership" <?= $old['reason'] === 'partnership' ? 'selected' : '' ?>>Partnership</option>
            <option value="other" <?= $old['reason'] === 'other' ? 'selected' : '' ?>>Other</option>
          </select>
          <?php if (isset($errors['reason'])): ?><p class="field-error" style="display:block;"><?= h($errors['reason']) ?></p><?php endif; ?>
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required minlength="10"><?= h($old['message']) ?></textarea>
          <?php if (isset($errors['message'])): ?><p class="field-error" style="display:block;"><?= h($errors['message']) ?></p><?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
      <p class="field-hint">See our <a href="privacy.php">Privacy Notice</a> for how this information is used.</p>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
