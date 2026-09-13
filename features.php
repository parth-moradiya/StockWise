<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Features - StockWise Retail Solutions';
$pageDescription = 'See the core features of the StockWise inventory system: stock tracking, barcode scanning, low-stock alerts, reporting and more.';
$activePage      = 'features';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
      <h1>Features &amp; Services</h1>
      <p>Everything you need to manage stock across one shop or a whole chain.</p>
    </section>

    <section>
      <div class="container">
        <div class="card-grid">
          <article class="card">
            <img src="https://loremflickr.com/500/350/warehouse,inventory" alt="Warehouse shelves stacked with labelled inventory boxes" loading="lazy">
            <div class="card-body">
              <h3>Real-Time Stock Tracking</h3>
              <p>Every sale, delivery, and return updates your stock count instantly across every register and store.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/barcode,label" alt="Close up of a barcode label being scanned on a retail product" loading="lazy">
            <div class="card-body">
              <h3>Barcode Scanning</h3>
              <p>Use handheld scanners or a phone camera to check in deliveries and ring up sales in seconds.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/boxes,storage" alt="Stacked storage boxes ready for restocking in a retail backroom" loading="lazy">
            <div class="card-body">
              <h3>Low-Stock Alerts</h3>
              <p>Set your own reorder thresholds and get notified automatically before a product runs out.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/office,laptop" alt="Manager reviewing sales reporting charts on a desktop screen" loading="lazy">
            <div class="card-body">
              <h3>Sales Reporting Dashboards</h3>
              <p>Clear charts show best sellers, slow movers, and daily revenue so you can plan with confidence.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/delivery,van" alt="Delivery van being loaded with retail stock for multi-store distribution" loading="lazy">
            <div class="card-body">
              <h3>Multi-Store Sync</h3>
              <p>Run two stores or twenty, stock levels and transfers stay in sync across your whole business.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/supplier,warehouse" alt="Supplier staff checking a delivery manifest in a warehouse aisle" loading="lazy">
            <div class="card-body">
              <h3>Supplier Management</h3>
              <p>Keep supplier details, order history, and lead times in one place so reordering stays simple.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="bg-alt">
      <div class="container" style="text-align:center;">
        <h2>See StockWise in Action</h2>
        <p style="max-width:520px;margin:14px auto 26px;">Book a short walkthrough with our team and we will show you how it fits your store.</p>
        <a href="contact.php" class="btn btn-primary">Request a Demo</a>
      </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
