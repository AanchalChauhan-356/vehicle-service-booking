<?php $title='Home'; require 'includes/header.php';
$svcs = db()->query("SELECT * FROM services ORDER BY id LIMIT 6")->fetchAll();
$n = fn($q) => (int)db()->query($q)->fetchColumn();
$cntS = $n("SELECT COUNT(*) FROM services"); $cntB = $n("SELECT COUNT(*) FROM bookings"); $cntC = $n("SELECT COUNT(*) FROM users WHERE role='customer'"); $cntD = $n("SELECT COUNT(*) FROM bookings WHERE status='Completed'"); ?>
<section class="hero">
  <div><span class="pill">&#9889; Online booking &middot; Live slots &middot; Instant status</span>
    <h1>Your vehicle deserves <em>better care</em>, booked in a minute.</h1>
    <p>Pick a service, choose a date and time slot, and track your booking live. No calls. No queues. No surprises.</p>
    <div class="cta"><?php if (user()): ?><a class="btn" href="book.php">Book a Service</a><a class="btn ghost" href="my_bookings.php">My Bookings</a>
    <?php else: ?><a class="btn" href="register.php">Get Started - It's Free</a><a class="btn ghost" href="services.php">Browse Services</a><?php endif; ?></div></div>
  <div class="hero-art">
    <svg viewBox="0 0 520 330" aria-label="Car illustration">
      <g class="cloud" opacity=".35"><ellipse cx="90" cy="60" rx="46" ry="14" fill="#fff"/><ellipse cx="130" cy="52" rx="30" ry="12" fill="#fff"/></g>
      <g class="cloud" opacity=".25"><ellipse cx="400" cy="90" rx="40" ry="12" fill="#fff"/><ellipse cx="430" cy="82" rx="26" ry="10" fill="#fff"/></g>
      <circle cx="260" cy="170" r="120" fill="rgba(255,255,255,.06)"/>
      <g class="car">
        <path d="M58 205 Q58 175 92 170 L148 165 Q172 122 218 116 L332 116 Q380 122 404 163 L444 172 Q474 180 474 206 L474 228 L58 228 Z" fill="#ff6b2c"/>
        <path d="M58 205 Q58 175 92 170 L148 165 L148 228 L58 228 Z" fill="#e5530f" opacity=".5"/>
        <path d="M168 164 Q188 130 226 128 L276 128 L276 164 Z" fill="#a5d8ff"/><path d="M290 128 L334 128 Q364 136 384 164 L290 164 Z" fill="#a5d8ff"/>
        <rect x="440" y="184" width="26" height="13" rx="6" fill="#ffe066"/><rect x="60" y="186" width="14" height="12" rx="4" fill="#fa5252"/>
        <rect x="270" y="176" width="26" height="5" rx="2.5" fill="#fff" opacity=".75"/>
        <path d="M444 172 L560 232 L444 228 Z" fill="#ffe066" opacity=".13"/>
        <g class="wheel" style="transform-origin:148px 232px"><circle cx="148" cy="232" r="32" fill="#10182f"/><circle cx="148" cy="232" r="15" fill="#ced4da"/><path d="M148 217v30M133 232h30" stroke="#868e96" stroke-width="4"/></g>
        <g class="wheel" style="transform-origin:386px 232px"><circle cx="386" cy="232" r="32" fill="#10182f"/><circle cx="386" cy="232" r="15" fill="#ced4da"/><path d="M386 217v30M371 232h30" stroke="#868e96" stroke-width="4"/></g>
      </g>
      <line class="road" x1="0" y1="278" x2="520" y2="278" stroke="#fff" stroke-opacity=".5" stroke-width="4" stroke-dasharray="24 16"/>
      <rect x="0" y="266" width="520" height="3" fill="#fff" opacity=".12"/>
    </svg></div>
</section>
<div class="strip"><div><b><?= $cntS ?></b><span>Service packages</span></div><div><b><?= max($cntB,1) ?>+</b><span>Bookings made</span></div><div><b><?= max($cntC,1) ?>+</b><span>Happy customers</span></div><div><b><?= max($cntD,1) ?>+</b><span>Jobs completed</span></div></div>

<div class="sec"><h2>How it works</h2><p>Four simple steps from sign-up to a freshly serviced vehicle</p></div>
<div class="steps">
  <div class="step"><div class="ic">&#128100;</div><small>STEP 1</small><strong>Create account</strong><div class="mut">Register free in seconds</div></div>
  <div class="step"><div class="ic">&#128295;</div><small>STEP 2</small><strong>Choose service</strong><div class="mut">Transparent pricing</div></div>
  <div class="step"><div class="ic">&#128197;</div><small>STEP 3</small><strong>Pick date &amp; slot</strong><div class="mut">Only free slots shown</div></div>
  <div class="step"><div class="ic">&#9989;</div><small>STEP 4</small><strong>Track status</strong><div class="mut">Pending &rarr; Completed</div></div>
</div>

<div class="sec"><h2>Popular services</h2><p>Everything your car or bike needs, under one roof</p></div>
<div class="grid"><?php foreach ($svcs as $s): ?>
  <div class="card svc"><div class="ic"><?= svc_icon($s['name']) ?></div><h3><?= e($s['name']) ?></h3><p class="mut"><?= e($s['description']) ?></p>
  <div class="meta"><span class="price">&#8377;<?= number_format($s['price']) ?></span><span class="tag">&#9201; <?= e($s['duration_hrs']) ?> hr</span></div></div><?php endforeach; ?></div>
<p style="text-align:center"><a class="btn" href="services.php">View all services &rarr;</a></p>

<div class="sec"><h2>Why choose AutoCare</h2><p>Built to save your time and your money</p></div>
<div class="why">
  <div class="card"><b>&#9889;</b><h4>Instant booking</h4><span class="mut">Live slot check, no phone calls.</span></div>
  <div class="card"><b>&#128176;</b><h4>Clear pricing</h4><span class="mut">See the cost before you confirm.</span></div>
  <div class="card"><b>&#128205;</b><h4>Live tracking</h4><span class="mut">Know your booking status anytime.</span></div>
  <div class="card"><b>&#128274;</b><h4>Safe &amp; secure</h4><span class="mut">Hashed passwords, protected forms.</span></div>
</div>

<div class="sec"><h2>What customers say</h2><p>Sample feedback for demonstration</p></div>
<div class="reviews">
  <div class="card rev"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"Booked my brake service at midnight and got a confirmation by morning. So easy!"</p><div class="who"><span class="av">R</span><div><b>Rahul S.</b><div class="mut">Hyundai Creta</div></div></div></div>
  <div class="card rev"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>"I could see the price and duration before booking. No hidden charges at all."</p><div class="who"><span class="av">P</span><div><b>Priya V.</b><div class="mut">Tata Nexon</div></div></div></div>
  <div class="card rev"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div><p>"Love the status tracking. I knew exactly when my bike was ready."</p><div class="who"><span class="av">A</span><div><b>Amit K.</b><div class="mut">Royal Enfield</div></div></div></div>
</div>

<div class="sec"><h2>Frequently asked questions</h2></div>
<div class="faq">
  <details><summary>How many vehicles can be booked in one slot?</summary><p>Our workshop handles 2 vehicles per time slot. Full slots are rejected automatically so you never get double-booked.</p></details>
  <details><summary>Can I cancel a booking?</summary><p>Yes. Open "My Bookings" and click Cancel while the booking is Pending or Confirmed.</p></details>
  <details><summary>Which days is the workshop open?</summary><p>Monday to Saturday, 9 AM to 6 PM. Sundays are closed and cannot be booked.</p></details>
  <details><summary>Do I pay online?</summary><p>No. Prices shown are estimates and payment is made at the workshop after service.</p></details>
</div>
<div class="banner"><div><h3>Ready to book your next service?</h3><p>Takes less than a minute. Free to join.</p></div>
<a class="btn" href="<?= user() ? 'book.php' : 'register.php' ?>"><?= user() ? 'Book now' : 'Create free account' ?></a></div>
<?php require 'includes/footer.php'; ?>
