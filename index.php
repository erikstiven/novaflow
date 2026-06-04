<?php
$colors = [
  ['Apache', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=500&q=80'],
  ['Black Diamond', 'https://images.unsplash.com/photo-1518709594023-6eab9bab7b23?auto=format&fit=crop&w=500&q=80'],
  ['Caramel', 'https://images.unsplash.com/photo-1616711906333-23cf8f69d04f?auto=format&fit=crop&w=500&q=80'],
  ['Black Pearl', 'https://images.unsplash.com/photo-1534271057238-c2c170a76672?auto=format&fit=crop&w=500&q=80'],
  ['Coral', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=500&q=80'],
  ['Dark Brown', 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=500&q=80'],
  ['Grey Blend', 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=500&q=80'],
  ['Multicolor Flint', 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=500&q=80'],
  ['Ozark', 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=500&q=80'],
  ['Pearl', 'https://images.unsplash.com/photo-1523413651479-597eb2da0ad6?auto=format&fit=crop&w=500&q=80'],
  ['Mini Pearl', 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=500&q=80'],
  ['Razorback Red', 'https://images.unsplash.com/photo-1516557070061-c3d1653fa646?auto=format&fit=crop&w=500&q=80'],
];

$projects = [
  ['Driveways', 'car', 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80'],
  ['Pool Decks', 'waves', 'https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?auto=format&fit=crop&w=600&q=80'],
  ['Patios', 'chair', 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=600&q=80'],
  ['Walkways', 'route', 'https://images.unsplash.com/photo-1597047084897-51e81819a499?auto=format&fit=crop&w=600&q=80'],
  ['Commercial', 'building', 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=600&q=80'],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NovaFlow Surfaces</title>
  <link rel="preconnect" href="https://images.unsplash.com">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="site-header">
    <a class="logo" href="#" aria-label="NovaFlow Surfaces">
      <span class="logo-mark">NF</span>
      <span class="logo-text">NOVA<span>FLOW</span></span>
      <small>SURFACES</small>
      <em>PREMIUM SURFACE SOLUTIONS</em>
    </a>

    <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <nav class="main-nav" aria-label="Main navigation">
      <a class="active" href="#">Home</a>
      <a href="#services">Services</a>
      <a href="#colors">Colors</a>
      <a href="#projects">Projects</a>
      <a href="#about">About Us</a>
      <a href="#contact">Contact</a>
    </nav>

    <div class="header-cta">
      <a class="phone" href="tel:5187207248">518-720-7248</a>
      <a class="btn btn-primary" href="#contact">Get Free Estimate</a>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="hero-content">
        <h1>Beautiful Surfaces.<span>Built to Last.</span></h1>
        <p>Premium pebble flooring, epoxy coatings & polyaspartic systems for residential and commercial properties.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#contact">Get Free Estimate</a>
          <a class="btn btn-outline" href="#projects">View Our Projects <span>-></span></a>
        </div>
      </div>
    </section>

    <section class="trust" id="services" aria-label="Services">
      <article>
        <span class="line-icon">shield</span>
        <h2>Fully Insured</h2>
        <p>Complete protection for your peace of mind.</p>
      </article>
      <article>
        <span class="line-icon">diamond</span>
        <h2>Premium Materials</h2>
        <p>High performance products that stand the test of time.</p>
      </article>
      <article>
        <span class="line-icon">wrench</span>
        <h2>Expert Installation</h2>
        <p>Skilled craftsmanship with exceptional detail.</p>
      </article>
      <article>
        <span class="line-icon">building</span>
        <h2>Residential & Commercial</h2>
        <p>Beautiful surfaces for homes, businesses and everything in between.</p>
      </article>
    </section>

    <section class="section colors" id="colors">
      <div class="section-title">
        <h2>Pebble Color Collection</h2>
        <p>Explore our premium pebble flooring color options designed for any space.</p>
      </div>

      <div class="color-grid">
        <?php foreach ($colors as [$name, $image]) : ?>
          <article class="color-card">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
            <div>
              <h3><?= htmlspecialchars($name) ?></h3>
              <a href="#projects">View Projects</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section projects" id="projects">
      <div class="section-heading">
        <h2>Featured Projects</h2>
        <a href="#">View All Projects <span>-></span></a>
      </div>

      <div class="project-grid">
        <?php foreach ($projects as [$name, $icon, $image]) : ?>
          <article class="project-card">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
            <h3><span><?= htmlspecialchars($icon) ?></span><?= htmlspecialchars($name) ?></h3>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section split-section" id="about">
      <div class="before">
        <h2>Before & After</h2>
        <div class="before-grid">
          <article class="compare-card">
            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=700&q=80" alt="Driveway before and after">
            <span class="divider"></span>
            <b>Before</b>
            <strong>After</strong>
            <i></i>
          </article>
          <article class="compare-card">
            <img src="https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?auto=format&fit=crop&w=700&q=80" alt="Pool deck before and after">
            <span class="divider"></span>
            <b>Before</b>
            <strong>After</strong>
            <i></i>
          </article>
        </div>
        <a class="btn btn-outline centered" href="#">View More Transformations</a>
      </div>

      <aside class="serving">
        <h2>Proudly Serving</h2>
        <ul>
          <li>New York</li>
          <li>Vermont</li>
          <li>Massachusetts</li>
          <li>New Jersey</li>
          <li>Connecticut</li>
          <li>Pennsylvania</li>
        </ul>
        <div class="insured-box">
          <span class="line-icon">shield</span>
          <div>
            <h3>Fully Insured</h3>
            <p>Your project is protected from start to finish.</p>
          </div>
        </div>
      </aside>
    </section>

    <section class="contact" id="contact">
      <div class="contact-info">
        <a href="tel:5187207248">518-720-7248</a>
        <a href="mailto:novaflowsurfaces@gmail.com">novaflowsurfaces@gmail.com</a>
        <address>950 New Loudon Rd,<br>Latham, NY 12144</address>
      </div>

      <form class="contact-form" action="#" method="post">
        <input type="text" name="name" placeholder="Your Name">
        <input type="tel" name="phone" placeholder="Phone Number">
        <input type="email" name="email" placeholder="Email Address">
        <select name="project_type">
          <option>Project Type</option>
          <option>Driveways</option>
          <option>Pool Decks</option>
          <option>Patios</option>
          <option>Walkways</option>
          <option>Commercial</option>
        </select>
        <textarea name="message" placeholder="Tell us about your project..."></textarea>
      </form>

      <div class="contact-promo">
        <h2>Ready to Transform Your Space?</h2>
        <p>Let's build something beautiful together.</p>
        <a class="btn btn-primary" href="#contact">Request Free Estimate <span>-></span></a>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <a class="logo footer-logo" href="#" aria-label="NovaFlow Surfaces">
      <span class="logo-mark">NF</span>
      <span class="logo-text">NOVA<span>FLOW</span></span>
      <small>SURFACES</small>
      <em>PREMIUM SURFACE SOLUTIONS</em>
    </a>

    <div class="quick-links">
      <h2>Quick Links</h2>
      <a href="#">Home</a>
      <a href="#services">Services</a>
      <a href="#colors">Colors</a>
      <a href="#projects">Projects</a>
      <a href="#about">About Us</a>
      <a href="#contact">Contact</a>
    </div>

    <div class="social">
      <h2>Follow Us</h2>
      <div>
        <a href="#" aria-label="Facebook">f</a>
        <a href="#" aria-label="Instagram">ig</a>
        <a href="#" aria-label="Google">G</a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2024 NovaFlow Surfaces. All Rights Reserved.</p>
      <nav>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
      </nav>
    </div>
  </footer>

  <script src="assets/js/main.js"></script>
</body>
</html>
