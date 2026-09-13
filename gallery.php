<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Gallery - StockWise Retail Solutions';
$pageDescription = 'Browse photos of retail stock, warehouses, and barcode scanning in action at stores using StockWise.';
$activePage      = 'gallery';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
      <h1>Gallery</h1>
      <p>A look at retail stock rooms, warehouses, and barcode scanning in the real world. Click any photo to view it larger.</p>
    </section>

    <section>
      <div class="container">
        <div class="gallery-grid">
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/supermarket,shelf" data-large="https://loremflickr.com/1200/900/supermarket,shelf" alt="Fully stocked shop shelves in a small retail store" loading="lazy">
            <figcaption>Fully stocked shelves ready for customers.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/warehouse,pallets" data-large="https://loremflickr.com/1200/900/warehouse,pallets" alt="Warehouse storage area with pallets of packaged goods" loading="lazy">
            <figcaption>Warehouse storage area holding incoming stock.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/barcode,warehouse" data-large="https://loremflickr.com/1200/900/barcode,warehouse" alt="Employee scanning a barcode on a product box" loading="lazy">
            <figcaption>Scanning stock in during a delivery.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/tablet,shop" data-large="https://loremflickr.com/1200/900/tablet,shop" alt="Retail staff member checking stock levels on a tablet" loading="lazy">
            <figcaption>Checking live stock levels on a tablet.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/supermarket,checkout" data-large="https://loremflickr.com/1200/900/supermarket,checkout" alt="Supermarket checkout counter with a cashier serving customers" loading="lazy">
            <figcaption>Checkout counter linked to live inventory data.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/boxes,warehouse" data-large="https://loremflickr.com/1200/900/boxes,warehouse" alt="Boxes of retail goods being organised for logistics and delivery" loading="lazy">
            <figcaption>Boxes organised for outgoing store transfers.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/clothing,rack" data-large="https://loremflickr.com/1200/900/clothing,rack" alt="Clothing rack in a retail boutique store" loading="lazy">
            <figcaption>Apparel stock organised by size and style.</figcaption>
          </figure>
          <figure class="gallery-item">
            <img src="https://loremflickr.com/400/300/manager,office" data-large="https://loremflickr.com/1200/900/manager,office" alt="Store manager reviewing a printed stock report near shelves" loading="lazy">
            <figcaption>Reviewing weekly stock reports on the shop floor.</figcaption>
          </figure>
        </div>
      </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
