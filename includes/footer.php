  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <h4>StockWise Retail Solutions</h4>
          <p>Inventory management software built for shops and small retail chains. Track stock, scan barcodes, and stay ahead of demand.</p>
        </div>
        <div>
          <h4>Quick Links</h4>
          <ul>
            <li><a href="<?= h($root) ?>index.php">Home</a></li>
            <li><a href="<?= h($root) ?>about.php">About</a></li>
            <li><a href="<?= h($root) ?>features.php">Features</a></li>
            <li><a href="<?= h($root) ?>gallery.php">Gallery</a></li>
            <li><a href="<?= h($root) ?>privacy.php">Privacy Notice</a></li>
          </ul>
        </div>
        <div>
          <h4>Contact</h4>
          <ul>
            <li><a href="mailto:info@stockwiseretail.example">info@stockwiseretail.example</a></li>
            <li><span>(555) 214-7788</span></li>
            <li><span>48 Market Street, Riverdale</span></li>
          </ul>
        </div>
        <div>
          <h4>Follow Us</h4>
          <div class="footer-social">
            <a href="#" aria-label="StockWise on Facebook">FB</a>
            <a href="#" aria-label="StockWise on Instagram">IG</a>
            <a href="#" aria-label="StockWise on LinkedIn">LI</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> StockWise Retail Solutions. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="<?= h($root) ?>js/script.js"></script>
  <script src="<?= h($root) ?>js/validation.js"></script>
</body>
</html>
