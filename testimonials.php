<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Testimonials - StockWise Retail Solutions';
$pageDescription = 'Read what retail owners and managers say about using StockWise inventory management software.';
$activePage      = 'testimonials';
require __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
      <h1>Customer Testimonials</h1>
      <p>Hear from shop owners and managers who use StockWise every day. All examples below are sample content for demonstration.</p>
    </section>

    <section>
      <div class="container">
        <div class="testimonial-row">
          <article class="testimonial-card">
            <p class="quote">"StockWise cut our stock-take time in half. We finally know what's on the shelf without counting by hand at midnight."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/woman,portrait" alt="Portrait of Amelia Grant, owner of Grant's Corner Store" loading="lazy">
              <div>
                <h4>Amelia Grant</h4>
                <span>Owner, Grant's Corner Store</span>
              </div>
            </div>
          </article>
          <article class="testimonial-card">
            <p class="quote">"The low-stock alerts alone paid for the software within a month. We stopped running out of our best sellers."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/man,portrait" alt="Portrait of David Okafor, manager at Northline Hardware" loading="lazy">
              <div>
                <h4>David Okafor</h4>
                <span>Manager, Northline Hardware</span>
              </div>
            </div>
          </article>
          <article class="testimonial-card">
            <p class="quote">"Managing three branches used to mean three separate spreadsheets. Now every store syncs automatically."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/woman,face" alt="Portrait of Priya Nair, director of Nair Fashion Retail" loading="lazy">
              <div>
                <h4>Priya Nair</h4>
                <span>Director, Nair Fashion Retail</span>
              </div>
            </div>
          </article>
          <article class="testimonial-card">
            <p class="quote">"Setup took less than a day. Our staff picked up the barcode scanning tools almost immediately."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/man,face" alt="Portrait of Marcus Lee, owner of Lee's Electronics Bazaar" loading="lazy">
              <div>
                <h4>Marcus Lee</h4>
                <span>Owner, Lee's Electronics Bazaar</span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="bg-alt">
      <div class="container">
        <div class="section-title">
          <h2>Case Study Highlights</h2>
          <p>A closer look at how two of our customers use StockWise day to day.</p>
        </div>

        <div class="case-study">
          <img src="https://loremflickr.com/300/220/grocery,shelves" alt="Supermarket aisle with fully stocked shelves managed by StockWise" loading="lazy">
          <div>
            <h3>Grant's Corner Store</h3>
            <p>After switching to StockWise, Grant's Corner Store reduced out-of-stock incidents and cut weekly stock-take time significantly.</p>
            <p class="stat">-45% stock-take time</p>
          </div>
        </div>

        <div class="case-study">
          <img src="https://loremflickr.com/300/220/clothing,store" alt="Clothing store rack synced across branches with StockWise" loading="lazy">
          <div>
            <h3>Nair Fashion Retail</h3>
            <p>With three branches now synced on one dashboard, Nair Fashion Retail can move stock between stores in minutes instead of days.</p>
            <p class="stat">3 branches, 1 dashboard</p>
          </div>
        </div>
      </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
