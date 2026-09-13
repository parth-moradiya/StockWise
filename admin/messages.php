<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/db.php';
require_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int) ($_POST['message_id'] ?? 0);
    if (($_POST['action'] ?? '') === 'mark_read') {
        $pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?')->execute([$id]);
    } elseif (($_POST['action'] ?? '') === 'delete') {
        $pdo->prepare('DELETE FROM contact_messages WHERE id = ?')->execute([$id]);
        set_flash('success', 'Message deleted.');
    }
    redirect('messages.php');
}

$messages = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();

$pageTitle  = 'Contact Messages - StockWise Admin';
$activePage = 'dashboard';
$root       = '../';
require __DIR__ . '/../includes/header.php';
?>

<section class="page-banner">
  <h1>Contact Messages</h1>
  <p>Enquiries submitted through the public Contact Us form.</p>
</section>

<section>
  <div class="container">
    <nav class="dash-tabs" aria-label="Admin sections">
      <a href="dashboard.php">Overview</a>
      <a href="inventory.php">Manage Inventory</a>
      <a href="users.php">Manage Users</a>
      <a href="messages.php" class="active">Contact Messages</a>
    </nav>

    <div class="message-list">
      <?php if (empty($messages)): ?>
        <p>No messages yet.</p>
      <?php endif; ?>
      <?php foreach ($messages as $m): ?>
        <article class="message-card <?= $m['is_read'] ? '' : 'message-unread' ?>">
          <header>
            <h3><?= h($m['full_name']) ?> <span class="badge badge-neutral"><?= h(ucfirst($m['reason'])) ?></span></h3>
            <span class="field-hint"><?= h(date('d M Y, g:ia', strtotime($m['created_at']))) ?></span>
          </header>
          <p><a href="mailto:<?= h($m['email']) ?>"><?= h($m['email']) ?></a> <?= $m['phone'] ? '&middot; ' . h($m['phone']) : '' ?></p>
          <p><?= nl2br(h($m['message'])) ?></p>
          <div class="table-actions">
            <?php if (!$m['is_read']): ?>
              <form method="post" action="messages.php" style="display:inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="message_id" value="<?= (int) $m['id'] ?>">
                <input type="hidden" name="action" value="mark_read">
                <button type="submit" class="btn btn-outline btn-sm">Mark as Read</button>
              </form>
            <?php endif; ?>
            <form method="post" action="messages.php" onsubmit="return confirm('Delete this message?');" style="display:inline;">
              <?= csrf_field() ?>
              <input type="hidden" name="message_id" value="<?= (int) $m['id'] ?>">
              <input type="hidden" name="action" value="delete">
              <button type="submit" class="link-danger">Delete</button>
            </form>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>
