<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if (is_file(__DIR__ . '/.env')) {
  foreach (file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
    [$key, $value] = array_map('trim', explode('=', $line, 2));
    putenv("{$key}={$value}");
  }
}

$allowedStatuses = ['success', 'error', 'invalid'];
$formStatus = in_array($_GET['form'] ?? '', $allowedStatuses, true) ? $_GET['form'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $projectType = trim($_POST['project_type'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if ($name && $phone && filter_var($email, FILTER_VALIDATE_EMAIL) && $projectType && $message) {
    $mail = new PHPMailer(true);

    try {
      $smtpUser = getenv('NOVAFLOW_SMTP_USER') ?: '';
      $smtpPass = getenv('NOVAFLOW_SMTP_PASS') ?: '';

      if (!$smtpUser || !$smtpPass) {
        throw new Exception('Missing SMTP credentials');
      }

      $mail->isSMTP();
      $mail->Host = getenv('NOVAFLOW_SMTP_HOST') ?: 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = $smtpUser;
      $mail->Password = $smtpPass;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = (int) (getenv('NOVAFLOW_SMTP_PORT') ?: 587);

      $mail->setFrom($smtpUser, 'NovaFlow Surfaces');
      $mail->addAddress('novaflowsurfaces@gmail.com');
      $mail->addReplyTo($email, $name);

      $mail->Subject = 'New estimate request - NovaFlow Surfaces';
      $plainBody = implode("\n", [
        "Name: {$name}",
        "Phone: {$phone}",
        "Email: {$email}",
        "Project Type: {$projectType}",
        '',
        'Message:',
        $message,
      ]);
      $mail->isHTML(true);
      $mail->Body = '
        <div style="margin:0;padding:24px;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#061016;">
          <div style="max-width:620px;margin:0 auto;background:#ffffff;border:1px solid #d8e0e8;">
            <div style="padding:22px 24px;background:#061016;color:#ffffff;">
              <h1 style="margin:0;font-size:22px;line-height:1.2;">New Estimate Request</h1>
              <p style="margin:8px 0 0;color:#41a1ff;font-size:14px;">NovaFlow Surfaces</p>
            </div>
            <div style="padding:24px;">
              <table style="width:100%;border-collapse:collapse;font-size:15px;">
                <tr>
                  <td style="width:140px;padding:10px 0;color:#0f5ca8;font-weight:bold;">Name</td>
                  <td style="padding:10px 0;">' . htmlspecialchars($name) . '</td>
                </tr>
                <tr>
                  <td style="padding:10px 0;color:#0f5ca8;font-weight:bold;">Phone</td>
                  <td style="padding:10px 0;"><a style="color:#061016;text-decoration:none;" href="tel:' . htmlspecialchars($phone) . '">' . htmlspecialchars($phone) . '</a></td>
                </tr>
                <tr>
                  <td style="padding:10px 0;color:#0f5ca8;font-weight:bold;">Email</td>
                  <td style="padding:10px 0;"><a style="color:#061016;" href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a></td>
                </tr>
                <tr>
                  <td style="padding:10px 0;color:#0f5ca8;font-weight:bold;">Project Type</td>
                  <td style="padding:10px 0;">' . htmlspecialchars($projectType) . '</td>
                </tr>
              </table>
              <div style="margin-top:22px;padding-top:18px;border-top:1px solid #d8e0e8;">
                <h2 style="margin:0 0 10px;font-size:16px;color:#0f5ca8;">Message</h2>
                <p style="margin:0;font-size:15px;line-height:1.6;white-space:pre-line;">' . htmlspecialchars($message) . '</p>
              </div>
            </div>
          </div>
        </div>';
      $mail->AltBody = $plainBody;

      $mail->send();
      $formStatus = 'success';
    } catch (Exception $exception) {
      $formStatus = 'error';
    }
  } else {
    $formStatus = 'invalid';
  }

  header("Location: {$_SERVER['PHP_SELF']}?form={$formStatus}");
  exit;
}

$colors = [
  [
    'name' => 'Apache',
    'image' => 'assets/images/colors/3.jpg',
    'meaning' => 'Warm natural character with an earthy, welcoming finish.',
    'what' => 'A mixed pebble blend with brown, beige, red and black tones.',
    'use' => 'Ideal for patios, walkways, pool borders and decorative floors.',
  ],
  [
    'name' => 'Black Diamond',
    'image' => 'assets/images/colors/4.jpg',
    'meaning' => 'Modern elegance with a premium high-contrast look.',
    'what' => 'Deep black stones with bright mineral highlights.',
    'use' => 'Best for contemporary interiors, commercial spaces and accents.',
  ],
  [
    'name' => 'Caramel',
    'image' => 'assets/images/colors/5.jpg',
    'meaning' => 'Warmth, comfort and a soft natural feel.',
    'what' => 'Golden, beige and honey-toned pebble blend.',
    'use' => 'Great for residential patios, terraces and pool edges.',
  ],
  [
    'name' => 'Black Pearl',
    'image' => 'assets/images/colors/6.jpg',
    'meaning' => 'Sophisticated depth with a refined natural texture.',
    'what' => 'Dark stones with grey, white and brown accents.',
    'use' => 'Ideal for modern interiors, terraces and commercial floors.',
  ],
  [
    'name' => 'Coral',
    'image' => 'assets/images/colors/1.jpg',
    'meaning' => 'Fresh energy inspired by coastal spaces.',
    'what' => 'Soft coral, peach, beige and light pebble tones.',
    'use' => 'Perfect for pool decks, relaxing patios and outdoor areas.',
  ],
  [
    'name' => 'Dark Brown',
    'image' => 'assets/images/colors/2.jpg',
    'meaning' => 'Stable, grounded and naturally durable.',
    'what' => 'Dark brown, chocolate and amber pebble mix.',
    'use' => 'Strong option for entrances, terraces and high-traffic areas.',
  ],
  [
    'name' => 'Grey Blend',
    'image' => 'assets/images/colors/7.jpg',
    'meaning' => 'Clean balance with a neutral modern profile.',
    'what' => 'Grey, white, beige and charcoal stone mix.',
    'use' => 'Great for minimal patios, pool areas and contemporary spaces.',
  ],
  [
    'name' => 'Multicolor Flint',
    'image' => 'assets/images/colors/8.jpg',
    'meaning' => 'Natural variety, movement and visual character.',
    'what' => 'Red, brown, black, yellow and grey pebble tones.',
    'use' => 'Ideal for rustic exteriors and surfaces that need contrast.',
  ],
  [
    'name' => 'Ozark',
    'image' => 'assets/images/colors/9.jpg',
    'meaning' => 'Strength, durability and a classic natural look.',
    'what' => 'Earth-toned stones with rustic texture.',
    'use' => 'Perfect for walkways, terraces and natural-style projects.',
  ],
  [
    'name' => 'Pearl',
    'image' => 'assets/images/colors/10.jpg',
    'meaning' => 'Bright, clean and refined simplicity.',
    'what' => 'Light stones in white, cream and soft grey tones.',
    'use' => 'Best for interiors, pool areas and bright minimalist spaces.',
  ],
  [
    'name' => 'Mini Pearl',
    'image' => 'assets/images/colors/11.jpg',
    'meaning' => 'Delicate detail with a smooth, even look.',
    'what' => 'Small light stones with fine texture.',
    'use' => 'Ideal for showers, pool borders and anti-slip surfaces.',
  ],
  [
    'name' => 'Razorback Red',
    'image' => 'assets/images/colors/12.jpg',
    'meaning' => 'Bold energy with a distinctive warm finish.',
    'what' => 'Red, terracotta, brown and amber pebble mix.',
    'use' => 'Great for exterior accents, entrances and standout terraces.',
  ],
];

$projects = [
  ['Driveways', 'car', 'assets/images/projects/1.jpg'],
  ['Pool Decks', 'waves', 'assets/images/projects/2.jpg'],
  ['Patios', 'chair', 'assets/images/projects/3.jpg'],
  ['Walkways', 'route', 'assets/images/projects/4.jpg'],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NovaFlow Surfaces</title>
  <link rel="preconnect" href="https://images.unsplash.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="icon" type="image/jpeg" href="assets/images/favicon.jpeg">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="<?= $formStatus ? 'form-modal-open' : '' ?>">
  <header class="site-header">
    <a class="header-logo" href="#home" aria-label="NovaFlow Surfaces">
      <img src="assets/images/logo-site.jpeg" alt="NovaFlow Surfaces">
    </a>

    <button class="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <nav class="main-nav" aria-label="Main navigation">
      <a class="active" href="#home">Home</a>
      <a href="#services">Services</a>
      <a href="#colors">Colors</a>
      <a href="#projects">Projects</a>
      <a href="#about">About Us</a>
      <a href="#contact">Contact</a>
    </nav>

    <div class="header-cta">
      <a class="phone" href="tel:5187207248">518- 720 7248</a>
      <a class="btn btn-primary" href="#contact">Get Free Estimate</a>
    </div>
  </header>

  <main>
    <section class="hero" id="home">
      <div class="hero-content">
        <h1>Resin Bound<span>Surfaces.</span></h1>
        <p class="hero-kicker">Built to Last.</p>
        <p>Premium Resin Bound driveways, patios and pathways built for beauty and durability.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#contact">Get Free Estimate <span class="link-icon" aria-hidden="true"></span></a>
          <a class="btn btn-outline hero-projects" href="#projects">View Projects</a>
        </div>
      </div>
    </section>

    <section class="trust" id="services" aria-label="Services">
      <article>
        <span class="line-icon" aria-hidden="true"><img src="assets/images/1.png" alt=""></span>
        <h2>Fully Insured</h2>
        <p>Complete protection for your peace of mind.</p>
      </article>
      <article>
        <span class="line-icon" aria-hidden="true"><img src="assets/images/2.png" alt=""></span>
        <h2>Premium Materials</h2>
        <p>High performance products that stand the test of time.</p>
      </article>
      <article>
        <span class="line-icon" aria-hidden="true"><img src="assets/images/3.png" alt=""></span>
        <h2>Expert Installation</h2>
        <p>Skilled craftsmanship with exceptional detail.</p>
      </article>
      <article>
        <span class="line-icon" aria-hidden="true"><img src="assets/images/4.png" alt=""></span>
        <h2>Residential & Commercial</h2>
        <p>Beautiful surfaces for homes and businesses.</p>
      </article>
    </section>

    <section class="section colors" id="colors">
      <div class="section-title">
        <h2>Pebble Color Collection</h2>
        <p>Explore our premium pebble flooring color options designed for any space.</p>
      </div>

      <div class="color-carousel">
        <button class="color-arrow color-arrow-left" type="button" aria-label="Previous colors">&lsaquo;</button>
        <div class="color-track" aria-label="Pebble color carousel">
        <?php foreach ($colors as $color) : ?>
          <article class="color-card">
            <button class="color-zoom" type="button" aria-label="Zoom <?= htmlspecialchars($color['name']) ?>">
              <img src="<?= htmlspecialchars($color['image']) ?>" alt="<?= htmlspecialchars($color['name']) ?>">
            </button>
            <div class="color-card-body">
              <h3><?= htmlspecialchars($color['name']) ?></h3>
              <div class="color-detail">
                <span>Meaning</span>
                <p><?= htmlspecialchars($color['meaning']) ?></p>
              </div>
              <div class="color-detail">
                <span>What it is</span>
                <p><?= htmlspecialchars($color['what']) ?></p>
              </div>
              <div class="color-detail">
                <span>Best use</span>
                <p><?= htmlspecialchars($color['use']) ?></p>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
        </div>
        <button class="color-arrow color-arrow-right" type="button" aria-label="Next colors">&rsaquo;</button>
      </div>
    </section>

    <section class="section projects" id="projects">
      <div class="section-heading">
        <h2>Featured Projects</h2>
        <a href="#">View All Projects <span class="link-icon" aria-hidden="true"></span></a>
      </div>

      <div class="project-grid">
        <?php foreach ($projects as [$name, $icon, $image]) : ?>
          <article class="project-card">
            <button class="project-zoom" type="button" aria-label="Zoom <?= htmlspecialchars($name) ?>">
              <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
            </button>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section project-video">
      <div class="section-title">
        <h2>Project Videos</h2>
      </div>

      <div class="video-grid">
        <article class="video-card">
          <video controls preload="metadata">
            <source src="assets/images/projects/video.mp4" type="video/mp4">
          </video>
        </article>
        <article class="video-card">
          <video controls preload="metadata">
            <source src="assets/images/projects/video2.mp4" type="video/mp4">
          </video>
        </article>
      </div>
    </section>

    <section class="section split-section" id="about">
      <div class="before">
        <h2>Before & After</h2>
        <div class="before-grid">
          <article class="compare-card" style="--compare-position: 50%;">
            <div class="compare-image compare-after">
              <img src="assets/images/antes_despues/despues.jpg" alt="After surface transformation">
            </div>
            <div class="compare-image compare-before">
              <img src="assets/images/antes_despues/antes.jpg" alt="Before surface transformation">
            </div>
            <span class="divider"></span>
            <b>Before</b>
            <strong>After</strong>
            <button class="compare-handle" type="button" aria-label="Drag to compare before and after"></button>
          </article>
        </div>
      </div>

      <aside class="serving">
        <h2>Proudly Serving</h2>
        <ul class="serving-list">
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>New York</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>Vermont</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>Massachusetts</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>New Jersey</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>Connecticut</span></li>
          <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s7-6.1 7-13A7 7 0 0 0 5 9c0 6.9 7 13 7 13z"/><circle cx="12" cy="9" r="2.4"/></svg><span>Pennsylvania</span></li>
        </ul>
        <div class="insured-box">
          <span class="insured-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 19 6v5c0 4.6-2.9 8.6-7 10-4.1-1.4-7-5.4-7-10V6l7-3z"/><path d="m8.8 12.1 2.1 2.1 4.3-4.8"/></svg>
          </span>
          <div>
            <h3>Fully Insured</h3>
            <p>Your project is protected from start to finish.</p>
          </div>
        </div>
      </aside>
    </section>

    <section class="contact" id="contact">
      <div class="contact-info">
        <a class="contact-link" href="tel:5187207248">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.7.6 2.5a2 2 0 0 1-.5 2.1L8 9.5a16 16 0 0 0 6.5 6.5l1.2-1.2a2 2 0 0 1 2.1-.5c.8.3 1.6.5 2.5.6A2 2 0 0 1 22 16.9z"/></svg>
          <span><strong>Call Us</strong>518-720-7248</span>
        </a>
        <a class="contact-link" href="mailto:novaflowsurfaces@gmail.com">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="m22 6-10 7L2 6"/></svg>
          <span><strong>Email Us</strong>novaflowsurfaces@gmail.com</span>
        </a>
        <address class="contact-link">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z"/><path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
          <span><strong>Visit Us</strong>950 New Loudon Rd,<br>Latham, NY 12144</span>
        </address>
      </div>

      <form class="contact-form" action="" method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <select name="project_type" required>
          <option value="" disabled selected>Project Type</option>
          <option value="Driveways">Driveways</option>
          <option value="Pool Decks">Pool Decks</option>
          <option value="Patios">Patios</option>
          <option value="Walkways">Walkways</option>
          <option value="Commercial">Commercial</option>
        </select>
        <textarea name="message" placeholder="Tell us about your project..." required></textarea>
        <button class="btn btn-primary form-submit" type="submit">Send Message</button>
      </form>

      <div class="contact-promo">
        <h2>Ready to Transform Your Space?</h2>
        <p>Let's build something beautiful together.</p>
        <a class="btn btn-primary" href="#contact">Request Free Estimate <span class="link-icon" aria-hidden="true"></span></a>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <a class="logo footer-logo" href="#home" aria-label="NovaFlow Surfaces">
      <img src="assets/images/logo-site.jpeg" alt="NovaFlow Surfaces">
    </a>

    <div class="quick-links">
      <h2>Quick Links</h2>
      <a href="#home">Home</a>
      <a href="#services">Services</a>
      <a href="#colors">Colors</a>
      <a href="#projects">Projects</a>
      <a href="#about">About Us</a>
      <a href="#contact">Contact</a>
    </div>

    <div class="social">
      <h2>Follow Us</h2>
      <div>
        <a href="https://www.facebook.com/people/Nova-Flow-Surfaces/61590724014740/?mibextid=wwXIfr&amp;rdid=0z3OPXft2cdhxQv1&amp;share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1Cwt5R5eGb%2F%3Fmibextid%3DwwXIfr" aria-label="Facebook" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3.3 0-5 2-5 5v3H6v4h3v8h4v-8h3.3l.7-4h-4V9c0-.7.3-1 1-1z"/></svg>
        </a>
        <a href="https://www.instagram.com/novaflowsurfaces?igsh=emtvYW1lcnZsZ2Q3&amp;utm_source=qr" aria-label="Instagram" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1.2"/></svg>
        </a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2024 NovaFlow Surfaces. All Rights Reserved.</p>
      <p class="footer-credit">Realizado por <a href="https://www.codecima.com" target="_blank" rel="noopener">Codecima</a></p>
      <nav>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
      </nav>
    </div>
  </footer>

  <div class="image-lightbox" aria-hidden="true">
    <button class="lightbox-close" type="button" aria-label="Close image">&times;</button>
    <img src="" alt="">
  </div>

  <?php if ($formStatus) : ?>
    <div class="form-modal is-open" data-form-modal aria-hidden="false">
      <div class="form-modal-box" role="dialog" aria-modal="true" aria-labelledby="form-modal-title">
        <?php if ($formStatus === 'success') : ?>
          <h2 id="form-modal-title">Message Sent</h2>
          <p>Your request was sent successfully.</p>
        <?php elseif ($formStatus === 'invalid') : ?>
          <h2 id="form-modal-title">Check The Form</h2>
          <p>Please complete all fields correctly.</p>
        <?php else : ?>
          <h2 id="form-modal-title">Message Not Sent</h2>
          <p>Check the mail server settings and try again.</p>
        <?php endif; ?>
        <button class="btn btn-primary form-modal-close" type="button">Accept</button>
      </div>
    </div>
  <?php endif; ?>

  <script src="assets/js/main.js"></script>
</body>
</html>
