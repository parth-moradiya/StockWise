<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Privacy Notice - StockWise Retail Solutions';
$pageDescription = 'How StockWise Retail Solutions collects, uses, and protects your personal information.';
$activePage      = 'privacy';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
  <h1>Privacy Notice</h1>
  <p>Last updated: <?= date('d F Y') ?></p>
</section>

<section>
  <div class="container" style="max-width:800px;">

    <h2>What We Collect</h2>
    <p>When you register for a demo account or submit our Contact Us form, we collect your full name, email address, and (for contact enquiries) your phone number and message. When you use the inventory dashboard, we record the stock actions you perform so other team members can see an accurate history.</p>

    <h2>How We Use It</h2>
    <ul class="policy-list">
      <li>To create and secure your account (your password is never stored in plain text &mdash; it is hashed using industry-standard bcrypt hashing).</li>
      <li>To respond to enquiries submitted through the Contact Us form.</li>
      <li>To keep an accurate audit trail of who made which stock changes, for accountability within a team.</li>
      <li>To keep the demo application secure, including basic rate-limiting on login attempts.</li>
    </ul>

    <h2>How We Protect It</h2>
    <ul class="policy-list">
      <li>Passwords are hashed with PHP's <code>password_hash()</code> (bcrypt) and never stored or logged in plain text.</li>
      <li>All forms are protected against Cross-Site Request Forgery (CSRF) using per-session tokens.</li>
      <li>All database queries use parameterised (prepared) statements to prevent SQL injection.</li>
      <li>Access to inventory data and admin tools is restricted using role-based access control (Admin, Staff, Viewer).</li>
      <li>Session cookies are marked HTTP-only and are regenerated on login to reduce session hijacking risk.</li>
    </ul>

    <h2>Your Choices</h2>
    <p>You may ask us to review, correct, or delete the personal information we hold about you at any time by contacting <a href="mailto:info@stockwiseretail.example">info@stockwiseretail.example</a>. Demo accounts may also be disabled by an administrator on request.</p>

    <h2>Ethical Use of Data</h2>
    <p>This site was built as a university coursework project (KOI ICT726) to demonstrate secure, ethical web development practice. It is a demonstration system only, is not connected to a real retail business, and should not be used to store genuine personal or payment information.</p>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
