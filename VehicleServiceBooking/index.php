<?php $title='Home'; require 'includes/header.php';
$svcs = db()->query("SELECT * FROM services ORDER BY id LIMIT 4")->fetchAll(); ?>
<section class="hero"><div>
  <h1>Book your vehicle service in under a minute</h1>
  <p>Choose a service, pick a date and time slot, and we take care of the rest. No calls, no queues.</p>
  <?php if (user()): ?><a class="btn" href="book.php">Book a Service</a>
  <?php else: ?><a class="btn" href="register.php">Get Started</a> &nbsp; <a class="btn ghost" href="login.php">Login</a><?php endif; ?>
</div><div class="car">&#128663;</div></section>
<h2>How it works</h2>
<div class="steps">
  <div class="step"><b>1</b><strong>Register</strong><div class="mut">Create a free account</div></div>
  <div class="step"><b>2</b><strong>Choose Service</strong><div class="mut">Pick from our packages</div></div>
  <div class="step"><b>3</b><strong>Select Slot</strong><div class="mut">Date and time that suits you</div></div>
  <div class="step"><b>4</b><strong>Track Status</strong><div class="mut">Pending &rarr; Completed</div></div>
</div>
<h2>Popular services</h2>
<div class="grid"><?php foreach ($svcs as $s): ?>
  <div class="card"><h3><?= e($s['name']) ?></h3><p class="mut"><?= e($s['description']) ?></p>
  <div class="price">&#8377;<?= number_format($s['price']) ?></div></div><?php endforeach; ?></div>
<p><a class="btn" href="services.php">View all services</a></p>
<?php require 'includes/footer.php'; ?>
