<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'StockWise Retail Solutions - Smart Inventory Management';
$pageDescription = 'StockWise Retail Solutions builds inventory management software for shops and small retail chains.';
$activePage      = 'home';
require __DIR__ . '/includes/header.php';
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "StockWise Retail Solutions",
  "applicationCategory": "BusinessApplication",
  "description": "Inventory management software for shops and small retail chains: barcode scanning, real-time stock tracking, and low-stock alerts.",
  "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }
}
</script>

<section class="hero">
      <div class="container hero-content">
        <h1>Smarter Inventory for Modern Retailers</h1>
        <p>StockWise Retail Solutions helps shops and small retail chains track stock in real time, scan barcodes in seconds, and stop losing sales to empty shelves. One simple system for every store you run.</p>
        <div class="hero-buttons">
          <a href="features.php" class="btn btn-primary">Explore Features</a>
          <a href="contact.php" class="btn btn-outline">Get a Free Demo</a>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="section-title">
          <h2>Why Retailers Choose StockWise</h2>
          <p>Built specifically for busy retail teams who need reliable stock numbers without the guesswork.</p>
        </div>
        <div class="card-grid">
          <article class="card">
            <img src="https://loremflickr.com/500/350/barcode,scanner" alt="Staff member scanning a product barcode with a handheld scanner" loading="lazy">
            <div class="card-body">
              <h3>Barcode Scanning</h3>
              <p>Scan items in and out of stock instantly with any standard barcode scanner or mobile camera.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/warehouse,shelves" alt="Warehouse worker checking stock levels on tall storage shelves" loading="lazy">
            <div class="card-body">
              <h3>Real-Time Stock Tracking</h3>
              <p>See exact stock counts across every store the moment they change, no more spreadsheets.</p>
            </div>
          </article>
          <article class="card">
            <img src="https://loremflickr.com/500/350/supermarket,cashier" alt="Cashier serving a customer at a supermarket checkout counter" loading="lazy">
            <div class="card-body">
              <h3>Low-Stock Alerts</h3>
              <p>Automatic alerts tell you exactly when to reorder, so popular products never run out.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="bg-alt">
      <div class="container">
        <div class="section-title">
          <h2>About StockWise Retail Solutions</h2>
          <p>StockWise Retail Solutions is a retail technology company that designs inventory management software for shops, boutiques, and small retail chains. Our platform combines stock tracking, barcode scanning, and reporting dashboards into one easy system, helping store owners cut waste and keep shelves full.</p>
        </div>
        <div style="text-align:center;">
          <a href="about.php" class="btn btn-secondary">Read Our Story</a>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="section-title">
          <h2>What Our Customers Say</h2>
          <p>A few words from retail owners already using StockWise every day.</p>
        </div>
        <div class="testimonial-row">
          <article class="testimonial-card">
            <p class="quote">"StockWise cut our stock-take time in half. We finally know what's on the shelf without counting by hand."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/woman,portrait" alt="Portrait of Amelia Grant, owner of Grant's Corner Store" loading="lazy">
              <div>
                <h4>Amelia Grant</h4>
                <span>Grant's Corner Store</span>
              </div>
            </div>
          </article>
          <article class="testimonial-card">
            <p class="quote">"The low-stock alerts alone paid for the software. We stopped running out of our best sellers."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/man,portrait" alt="Portrait of David Okafor, manager at Northline Hardware" loading="lazy">
              <div>
                <h4>David Okafor</h4>
                <span>Northline Hardware</span>
              </div>
            </div>
          </article>
          <article class="testimonial-card">
            <p class="quote">"Managing three branches used to be a nightmare. Now every store syncs automatically."</p>
            <div class="testimonial-person">
              <img src="https://loremflickr.com/100/100/woman,face" alt="Portrait of Priya Nair, director of Nair Fashion Retail" loading="lazy">
              <div>
                <h4>Priya Nair</h4>
                <span>Nair Fashion Retail</span>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="bg-alt">
      <div class="container" style="text-align:center;">
        <h2>Ready to Take Control of Your Stock?</h2>
        <p style="max-width:500px;margin:14px auto 26px;">Book a free walkthrough and see how StockWise fits your store.</p>
        <a href="contact.php" class="btn btn-primary">Contact Us Today</a>
      </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
