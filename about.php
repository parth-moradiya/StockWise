<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'About Us - StockWise Retail Solutions';
$pageDescription = 'Learn about StockWise Retail Solutions, our story, our mission, and why retailers choose our inventory software.';
$activePage      = 'about';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
      <h1>About StockWise Retail Solutions</h1>
      <p>Get to know the team behind the inventory software retailers trust.</p>
    </section>

    <section>
      <div class="container about-flex">
        <div>
          <h2>Our Story</h2>
          <p>StockWise Retail Solutions started in 2016 when our founders, both former shop managers, got tired of counting stock with pen and paper at closing time. They built a simple tool to track products across one small store, and within a year three neighbouring shops asked to use it too.</p>
          <p>Today StockWise supports independent shops and multi-branch retail chains alike, giving every owner the same real-time view of their stock that used to only be available to large supermarket chains.</p>
        </div>
        <img src="https://loremflickr.com/560/400/retail,team" alt="Small retail team reviewing stock reports on a laptop in a shop" loading="lazy">
      </div>
    </section>

    <section class="bg-alt">
      <div class="container">
        <div class="mission-box">
          <h2>Our Mission</h2>
          <p style="color:#e7f3f1;">To give every retailer, no matter the size, the tools to know exactly what stock they have, where it is, and when it needs restocking, so they never lose a sale to an empty shelf.</p>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="section-title">
          <h2>Why Choose Us</h2>
          <p>A few reasons retail owners stick with StockWise after their first month.</p>
        </div>
        <div class="why-grid">
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Built for Retail</h3>
            <p>Every feature is designed around real shop workflows, not generic business software.</p>
          </div>
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Fast Setup</h3>
            <p>Most stores are scanning their first barcode within a day of signing up.</p>
          </div>
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Friendly Support</h3>
            <p>Our support team answers questions from real people, not chatbots.</p>
          </div>
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Fair Pricing</h3>
            <p>Simple plans that scale with the number of stores you run, no hidden fees.</p>
          </div>
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Multi-Store Ready</h3>
            <p>Sync stock across as many branches as you need from a single dashboard.</p>
          </div>
          <div class="why-item">
            <div class="card-icon">✓</div>
            <h3>Trusted by Retailers</h3>
            <p>Hundreds of shops rely on StockWise to manage their day-to-day stock.</p>
          </div>
        </div>
      </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
