<?php $title='Services'; require 'includes/header.php';
$svcs = db()->query("SELECT * FROM services ORDER BY id")->fetchAll(); ?>
<h2>Our Services</h2><p class="mut">Transparent pricing. Approx. duration shown for each package.</p>
<div class="grid"><?php foreach ($svcs as $s): ?>
  <div class="card"><h3><?= e($s['name']) ?></h3><p class="mut"><?= e($s['description']) ?></p>
  <div class="price">&#8377;<?= number_format($s['price']) ?></div>
  <div class="mut">&#9201; ~<?= e($s['duration_hrs']) ?> hr(s)</div><br>
  <a class="btn sm" href="book.php?service=<?= (int)$s['id'] ?>">Book now</a></div><?php endforeach; ?></div>
<?php require 'includes/footer.php'; ?>
