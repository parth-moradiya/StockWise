<?php
/**
 * Shared page header / navigation.
 * Expects (all optional) before include:
 *   $pageTitle       string  browser tab title
 *   $pageDescription string  meta description for SEO
 *   $activePage      string  key of the current nav item
 *   $root            string  relative path back to site root ('' or '../')
 */
require_once __DIR__ . '/functions.php';

$pageTitle       = $pageTitle ?? 'StockWise Retail Solutions';
$pageDescription = $pageDescription ?? 'StockWise Retail Solutions builds inventory management software for shops and small retail chains.';
$activePage      = $activePage ?? '';
$root            = $root ?? '';
$flashes         = get_flashes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($pageTitle) ?></title>
  <meta name="description" content="<?= h($pageDescription) ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= h((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '')) ?>">
  <link rel="stylesheet" href="<?= h($root) ?>css/style.css">
  <link rel="stylesheet" href="<?= h($root) ?>css/responsive.css">
  <link rel="stylesheet" href="<?= h($root) ?>css/app.css">
</head>
<body>
  <a href="#main-content" class="skip-link">Skip to main content</a>

  <header class="site-header">
    <nav class="navbar" aria-label="Primary">
      <a href="<?= h($root) ?>index.php" class="logo">Stock<span>Wise</span></a>
      <button class="nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
      <ul class="nav-menu">
        <li><a href="<?= h($root) ?>index.php" <?= $activePage === 'home' ? 'aria-current="page"' : '' ?>>Home</a></li>
        <li><a href="<?= h($root) ?>about.php" <?= $activePage === 'about' ? 'aria-current="page"' : '' ?>>About</a></li>
        <li><a href="<?= h($root) ?>features.php" <?= $activePage === 'features' ? 'aria-current="page"' : '' ?>>Features</a></li>
        <li><a href="<?= h($root) ?>testimonials.php" <?= $activePage === 'testimonials' ? 'aria-current="page"' : '' ?>>Testimonials</a></li>
        <li><a href="<?= h($root) ?>gallery.php" <?= $activePage === 'gallery' ? 'aria-current="page"' : '' ?>>Gallery</a></li>
        <li><a href="<?= h($root) ?>contact.php" <?= $activePage === 'contact' ? 'aria-current="page"' : '' ?>>Contact</a></li>
        <?php if (is_logged_in()): ?>
          <li><a href="<?= h($root) ?>dashboard.php" <?= $activePage === 'dashboard' ? 'aria-current="page"' : '' ?>>Dashboard</a></li>
          <li><a href="<?= h($root) ?>logout.php">Logout (<?= h($_SESSION['user_name'] ?? '') ?>)</a></li>
        <?php else: ?>
          <li><a href="<?= h($root) ?>login.php" <?= $activePage === 'login' ? 'aria-current="page"' : '' ?>>Login</a></li>
          <li><a href="<?= h($root) ?>register.php" class="nav-cta" <?= $activePage === 'register' ? 'aria-current="page"' : '' ?>>Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main id="main-content">

    <?php if (!empty($flashes)): ?>
      <div class="container" style="margin-top:20px;">
        <?php foreach ($flashes as $flash): ?>
          <div class="alert alert-<?= h($flash['type']) ?>" role="alert"><?= h($flash['message']) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
